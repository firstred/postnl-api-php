<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Request\CalculateDeliveryDateRequest;
use Firstred\PostNL\Entity\Request\CalculateShippingDateRequest;
use Firstred\PostNL\Entity\Response\CalculateDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\CalculateShippingDateResponse;
use Firstred\PostNL\Exception\CifErrorException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\Misc\Message;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use TypeError;

/**
 * Class DeliveryDateService
 */
class DeliveryDateService extends AbstractService
{
    // API Version
    const VERSION = '2.2';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_2/calculate/date';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_2/calculate/date';

    /**
     * Get a delivery date via REST
     *
     * @param CalculateDeliveryDateRequest $calculateDeliveryDate
     *
     * @return CalculateDeliveryDateResponse
     *
     * @throws CifErrorException
     * @throws \Exception
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     */
    public function calculateDeliveryDate(CalculateDeliveryDateRequest $calculateDeliveryDate): CalculateDeliveryDateResponse
    {
        $item = $this->retrieveCachedItem($calculateDeliveryDate->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (InvalidArgumentException | TypeError $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $request = $this->buildCalculateDeliveryDateRequest($calculateDeliveryDate);
            $response = Client::getInstance()->doRequest($request);
            static::validateResponse($response);
        }

        $object = $this->processCalculateDeliveryDateResponse($response);
        if ($object instanceof CalculateDeliveryDateResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && $response->getStatusCode() === 200
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new CifErrorException('Unable to retrieve the delivery date', 0, null, isset($request) && $request instanceof RequestInterface ? $request : null, $response);
    }

    /**
     * Build the CalculateDeliveryDateRequest request for the REST API
     *
     * @param CalculateDeliveryDateRequest $calculateDeliveryDate
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function buildCalculateDeliveryDateRequest(CalculateDeliveryDateRequest $calculateDeliveryDate): RequestInterface
    {
        $query = [
            'ShippingDate' => $calculateDeliveryDate->getShippingDate(),
            'CutOffTime'   => $calculateDeliveryDate->getCutOffTime(),
            'Options'      => 'Daytime',
        ];
        if ($shippingDuration = $calculateDeliveryDate->getShippingDuration()) {
            $query['ShippingDuration'] = $shippingDuration;
        }
        foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day) {
            if (!is_null($calculateDeliveryDate->{"getAvailable{$day}"}())) {
                $query["Available{$day}"] = $calculateDeliveryDate->{"getAvailable{$day}"}() ? 'true' : 'false';
            }
            if (!is_null($calculateDeliveryDate->{"getCutOffTime{$day}"}())) {
                $query["CutOffTime{$day}"] = $calculateDeliveryDate->{"getCutOffTime{$day}"}();
            }
        }
        if ($postcode = $calculateDeliveryDate->getPostalCode()) {
            $query['PostalCode'] = $postcode;
        }
        $query['CountryCode'] = $calculateDeliveryDate->getCountryCode();
        if ($originCountryCode = $calculateDeliveryDate->getOriginCountryCode()) {
            $query['OriginCountryCode'] = $originCountryCode;
        }
        if ($city = $calculateDeliveryDate->getCity()) {
            $query['City'] = $city;
        }
        if ($houseNr = $calculateDeliveryDate->getHouseNumber()) {
            $query['HouseNumber'] = $houseNr;
        }
        if ($houseNrExt = $calculateDeliveryDate->getHouseNrExt()) {
            $query['HouseNrExt'] = $houseNrExt;
        }
        if (is_array($calculateDeliveryDate->getOptions())) {
            foreach ($calculateDeliveryDate->getOptions() as $option) {
                if ('Daytime' === $option) {
                    continue;
                }

                $query['Options'] .= ",$option";
            }
        }

        $endpoint = '/delivery?'.http_build_query($query);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withHeader('apikey', $this->postnl->getApiKey())
        ;
    }

    /**
     * Process CalculateDeliveryDateRequest REST Response
     *
     * @param ResponseInterface $response
     *
     * @return null|CalculateDeliveryDateResponse
     *
     * @throws CifErrorException
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     */
    public function processCalculateDeliveryDateResponse(ResponseInterface $response): CalculateDeliveryDateResponse
    {
        $body = json_decode((string) $response->getBody(), true);
        if (isset($body['DeliveryDate'])) {
            /** @var CalculateDeliveryDateResponse $object */
            $object = AbstractEntity::jsonDeserialize(['CalculateDeliveryDateResponse' => $body]);

            return $object;
        }

        throw new CifErrorException('Unable to process get delivery date response', 0, null, null, $response);
    }

    /**
     * Get the sent date via REST
     *
     * @param CalculateShippingDateRequest $calculateShippingDate
     *
     * @return CalculateShippingDateResponse
     *
     * @throws CifErrorException
     * @throws \Exception
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function calculateShippingDate(CalculateShippingDateRequest $calculateShippingDate): CalculateShippingDateResponse
    {
        $item = $this->retrieveCachedItem($calculateShippingDate->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (InvalidArgumentException | TypeError $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $request = $this->buildCalculateShippingDateRequest($calculateShippingDate);
            $response = Client::getInstance()->doRequest($request);
            static::validateResponse($response);
        }

        $object = $this->processCalculateShippingDateResponse($response);
        if ($object instanceof CalculateShippingDateResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && $response->getStatusCode() === 200
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new CifErrorException('Unable to retrieve shipping date', 0, null, isset($request) && $request instanceof RequestInterface ? $request : null, $response);
    }

    /**
     * Build the CalculateShippingDateRequest request for the REST API
     *
     * @param CalculateShippingDateRequest $calculateShippingDate
     *
     * @return RequestInterface
     */
    public function buildCalculateShippingDateRequest(CalculateShippingDateRequest $calculateShippingDate): RequestInterface
    {
        $query = [
            'ShippingDate' => $calculateShippingDate->getDeliveryDate(),
        ];
        $query['CountryCode'] = $calculateShippingDate->getCountryCode();
        if ($duration = $calculateShippingDate->getShippingDuration()) {
            $query['ShippingDuration'] = $duration;
        }
        if ($postcode = $calculateShippingDate->getPostalCode()) {
            $query['PostalCode'] = $postcode;
        }
        if ($city = $calculateShippingDate->getCity()) {
            $query['City'] = $city;
        }
        if ($houseNr = $calculateShippingDate->getHouseNumber()) {
            $query['HouseNumber'] = $houseNr;
        }
        if ($houseNrExt = $calculateShippingDate->getHouseNrExt()) {
            $query['HouseNrExt'] = $houseNrExt;
        }

        $endpoint = '/shipping?'.http_build_query($query);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT.$endpoint
        )
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withHeader('apikey', $this->postnl->getApiKey())
        ;
    }

    /**
     * Process CalculateShippingDateRequest REST Response
     *
     * @param ResponseInterface $response
     *
     * @return CalculateShippingDateResponse
     *
     * @throws CifErrorException
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     */
    public function processCalculateShippingDateResponse(ResponseInterface $response): CalculateShippingDateResponse
    {
        $body = json_decode((string) $response->getBody(), true);
        if (isset($body['SentDate'])) {
            /** @var CalculateShippingDateResponse $object */
            $object = AbstractEntity::jsonDeserialize(['CalculateShippingDateResponse' => $body]);

            return $object;
        }

        throw new CifErrorException('Unable to process calculate shipping date response', 0, null, null, $response);
    }
}
