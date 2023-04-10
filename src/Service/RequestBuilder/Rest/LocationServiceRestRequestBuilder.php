<?php

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
 * associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software
 * is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or
 * substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
 * NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author    Michael Dekker <git@michaeldekker.nl>
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Service\RequestBuilder\Rest;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Coordinates;
use Firstred\PostNL\Entity\Request\GetLocation;
use Firstred\PostNL\Entity\Request\GetLocationsInArea;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Service\LocationServiceInterface;
use Firstred\PostNL\Service\RequestBuilder\LocationServiceRequestBuilderInterface;
use Psr\Http\Message\RequestInterface;
use const PHP_QUERY_RFC3986;

/**
 * @since 2.0.0
 *
 * @internal
 */
class LocationServiceRestRequestBuilder extends AbstractRestRequestBuilder implements LocationServiceRequestBuilderInterface
{
    // Endpoints
    private const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_1/locations';
    private const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_1/locations';

    /**
     * Build the GenerateLabel request for the REST API.
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     * @since 2.0.0
     */
    public function buildGetNearestLocationsRequest(GetNearestLocations $getNearestLocations): RequestInterface
    {
        $this->setService(entity: $getNearestLocations);

        $endpoint = '/nearest';
        $location = $getNearestLocations->getLocation();
        $query = [
            'CountryCode' => $getNearestLocations->getCountrycode(),
            'PostalCode'  => $location->getPostalcode(),
        ];
        if ($city = $location->getCity()) {
            $query['City'] = $city;
        }
        if ($street = $location->getStreet()) {
            $query['Street'] = $street;
        }
        if ($houseNumber = $location->getHouseNr()) {
            $query['HouseNumber'] = $houseNumber;
        }
        if ($deliveryDate = $location->getDeliveryDate()) {
            $query['DeliveryDate'] = $deliveryDate->format(format: 'd-m-Y');
        }
        if ($openingTime = $location->getOpeningTime()) {
            $query['OpeningTime'] = date(format: 'H:i:00', timestamp: strtotime(datetime: $openingTime));
        }
        if ($location->getCoordinates() instanceof Coordinates) {
            $endpoint .= '/geocode';
            unset($query['Street']);
            unset($query['PostalCode']);
            unset($query['City']);
            unset($query['HouseNumber']);
            $query['Latitude'] = $location->getCoordinates()->getLatitude();
            $query['Longitude'] = $location->getCoordinates()->getLongitude();
        }
        if ($deliveryOptions = $location->getDeliveryOptions()) {
            foreach ($deliveryOptions as $option) {
                if ('PGE' === $option) {
                    continue; // No longer supported
                }

                if (!array_key_exists(key: 'DeliveryOptions', array: $query)) {
                    $query['DeliveryOptions'] = $option;
                } else {
                    $query['DeliveryOptions'] .= ','.$option;
                }
            }
            if (!isset($query['DeliveryOptions'])) {
                $query['DeliveryOptions'] = 'PG';
            }
        } else {
            $query['DeliveryOptions'] = 'PG';
        }

        $endpoint .= '?'.http_build_query(data: $query, numeric_prefix: '', arg_separator: '&', encoding_type: PHP_QUERY_RFC3986);

        return $this->getRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('apikey', value: $this->getApiKey()->getString())
            ->withHeader('Accept', value: 'application/json');
    }

    /**
     * Build the GetLocationsInArea request for the REST API.
     *
     * @since 2.0.0
     *
     * @throws InvalidConfigurationException
     * @throws InvalidArgumentException
     */
    public function buildGetLocationsInAreaRequest(GetLocationsInArea $getLocations): RequestInterface
    {
        $this->setService(entity: $getLocations);

        $location = $getLocations->getLocation();
        $query = [
            'LatitudeNorth' => $location->getCoordinatesNorthWest()->getLatitude(),
            'LongitudeWest' => $location->getCoordinatesNorthWest()->getLongitude(),
            'LatitudeSouth' => $location->getCoordinatesSouthEast()->getLatitude(),
            'LongitudeEast' => $location->getCoordinatesSouthEast()->getLongitude(),
        ];
        if ($countryCode = $getLocations->getCountryCode()) {
            $query['CountryCode'] = $countryCode;
        }
        if ($deliveryDate = $location->getDeliveryDate()) {
            $query['DeliveryDate'] = $deliveryDate->format(format: 'd-m-Y');
        }
        if ($openingTime = $location->getOpeningTime()) {
            $query['OpeningTime'] = date(format: 'H:i:00', timestamp: strtotime(datetime: $openingTime));
        }
        if ($deliveryOptions = $location->getDeliveryOptions()) {
            foreach ($deliveryOptions as $option) {
                if (!array_key_exists(key: 'DeliveryOptions', array: $query)) {
                    $query['DeliveryOptions'] = $option;
                } else {
                    $query['DeliveryOptions'] .= ','.$option;
                }
            }
        } else {
            $query['DeliveryOptions'] = 'PG';
        }
        $endpoint = '/area?'.http_build_query(data: $query, numeric_prefix: '', arg_separator: '&', encoding_type: PHP_QUERY_RFC3986);

        return $this->getRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
        )
            ->withHeader('apikey', value: $this->getApiKey()->getString())
            ->withHeader('Accept', value: 'application/json');
    }

    /**
     * Build the GetLocation request for the REST API.
     *
     * @throws InvalidConfigurationException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function buildGetLocationRequest(GetLocation $getLocation): RequestInterface
    {
        $this->setService(entity: $getLocation);

        $query = [
            'LocationCode' => $getLocation->getLocationCode(),
        ];
        if ($id = $getLocation->getRetailNetworkID()) {
            $query['RetailNetworkID'] = $id;
        }
        $endpoint = '/lookup?'.http_build_query(data: $query, numeric_prefix: '', arg_separator: '&', encoding_type: PHP_QUERY_RFC3986);

        return $this->getRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
        )
            ->withHeader('apikey', value: $this->getApiKey()->getString())
            ->withHeader('Accept', value: 'application/json');
    }

    /**
     * @param AbstractEntity $entity
     *
     * @return void
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     *
     * @since 2.0.0
     */
    protected function setService(AbstractEntity $entity): void
    {
        $entity->setCurrentService(currentService: LocationServiceInterface::class);

        parent::setService(entity: $entity);
    }
}
