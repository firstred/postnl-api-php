<?php
declare(strict_types=1);
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

namespace Firstred\PostNL\Service\Adapter\Rest;

use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Coordinates;
use Firstred\PostNL\Entity\OpeningHours;
use Firstred\PostNL\Entity\Request\GetLocation;
use Firstred\PostNL\Entity\Request\GetLocationsInArea;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Entity\Response\GetLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Entity\Response\ResponseLocation;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\Adapter\LocationServiceAdapterInterface;
use Firstred\PostNL\Util\Util;
use Psr\Http\Message\RequestInterface;
use const PHP_QUERY_RFC3986;

/**
 * @since 2.0.0
 * @internal
 */
class LocationServiceRestAdapter extends AbstractRestAdapter implements LocationServiceAdapterInterface
{
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/${VERSION}/locations';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/${VERSION}/locations';

    /**
     * Build the GenerateLabel request for the REST API.
     *
     * @since 2.0.0
     */
    public function buildGetNearestLocationsRequest(GetNearestLocations $getNearestLocations): RequestInterface
    {
        $endpoint = '/nearest';
        $location = $getNearestNearestLocations->getLocation();
        $query = [
            'CountryCode' => $getNearestNearestLocations->getCountrycode(),
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
                if ($option === 'PGE') {
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
     * Process GetNearestLocations Response REST.
     *
     * @param mixed $response
     *
     * @return GetNearestLocationsResponse|null
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws ResponseException
     * @since 2.0.0
     */
    public function processGetNearestLocationsResponse(mixed $response): ?GetNearestLocationsResponse
    {
        $body = json_decode(json: static::getResponseText(response: $response));

        $object = GetNearestLocationsResponse::jsonDeserialize(json: (object) ['GetNearestLocationsResponse' => $body]);

        return $object;
    }


    /**
     * Build the GetLocationsInArea request for the REST API.
     *
     * @since 2.0.0
     */
    public function buildGetLocationsInAreaRequest(GetLocationsInArea $getLocations): RequestInterface
    {
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
            uri: Util::versionStringToURLString(
                version: $this->getVersion(),
                url: ($this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
            ))
            ->withHeader('apikey', value: $this->getApiKey()->getString())
            ->withHeader('Accept', value: 'application/json');
    }

    /**
     * Process GetLocationsInArea Response REST.
     *
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse|null
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws ResponseException
     * @since 2.0.0
     */
    public function processGetLocationsInAreaResponse(mixed $response): ?GetLocationsInAreaResponse
    {
        $body = json_decode(json: static::getResponseText(response: $response));

        /** @var GetLocationsInAreaResponse $object */
        $object = GetLocationsInAreaResponse::jsonDeserialize(
            json: (object) ['GetLocationsInAreaResponse' => $body]
        );

        return $object;
    }


    /**
     * Build the GetLocation request for the REST API.
     *
     * @since 2.0.0
     */
    public function buildGetLocationRequest(GetLocation $getLocation): RequestInterface
    {
        $query = [
            'LocationCode' => $getLocation->getLocationCode(),
        ];
        if ($id = $getLocation->getRetailNetworkID()) {
            $query['RetailNetworkID'] = $id;
        }
        $endpoint = '/lookup?'.http_build_query(data: $query, numeric_prefix: '', arg_separator: '&', encoding_type: PHP_QUERY_RFC3986);

        return $this->getRequestFactory()->createRequest(
            method: 'GET',
            uri: Util::versionStringToURLString(
                version: $this->getVersion(),
                url: ($this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            ))
            ->withHeader('apikey', value: $this->getApiKey()->getString())
            ->withHeader('Accept', value: 'application/json');
    }

    /**
     * Process GetLocation Response REST.
     *
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse|null
     * @throws DeserializationException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @throws EntityNotFoundException
     * @since 2.0.0
     */
    public function processGetLocationResponse(mixed $response): ?GetLocationsInAreaResponse
    {
        $body = json_decode(json: static::getResponseText(response: $response));

        if (!is_array(value: $body->GetLocationsResult->ResponseLocation)) {
            $body->GetLocationsResult->ResponseLocation = [$body->GetLocationsResult->ResponseLocation];
        }

        $newLocations = [];
        foreach ($body->GetLocationsResult->ResponseLocation as $location) {
            if (isset($location->Address)) {
                $location->Address = Address::jsonDeserialize(json: (object) ['Address' => $location->Address]);
            }

            if (isset($location->DeliveryOptions->string)) {
                $location->DeliveryOptions = $location->DeliveryOptions->string;
            }

            if (isset($location->OpeningHours)) {
                foreach ($location->OpeningHours as $day => $hour) {
                    if (isset($hour->string)) {
                        $location->OpeningHours->$day = $hour->string;
                    }
                }

                $location->OpeningHours = OpeningHours::jsonDeserialize(
                    json: (object) ['OpeningHours' => $location->OpeningHours]
                );
            }

            $newLocations[] = ResponseLocation::jsonDeserialize(
                json: (object) ['ResponseLocation' => $location]
            );
        }
        $body->GetLocationsResult->ResponseLocation = $newLocations;

        /** @var GetLocationsInAreaResponse $object */
        $object = GetLocationsInAreaResponse::jsonDeserialize(json: (object) ['GetLocationsInAreaResponse' => $body]);

        return $object;
    }
}
