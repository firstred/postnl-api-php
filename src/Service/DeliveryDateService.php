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

use Exception;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\Request\GetDeliveryDate;
use Firstred\PostNL\Entity\Request\GetSentDateRequest;
use Firstred\PostNL\Entity\Response\GetDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\GetSentDateResponse;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\Util\Message;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\RequestFactory;
use InvalidArgumentException;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return GetDeliveryDateResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws Exception
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getDeliveryDate(GetDeliveryDate $getDeliveryDate): GetDeliveryDateResponse
    {
        $item = $this->retrieveCachedItem($getDeliveryDate->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = Client::getInstance()->doRequest(
                $this->buildGetDeliveryDateRequest($getDeliveryDate)
            );
            static::validateResponse($response);
        }

        $object = $this->processGetDeliveryDateResponse($response);
        if ($object instanceof GetDeliveryDateResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && $response->getStatusCode() === 200
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve the delivery date');
    }

    /**
     * Build the GetDeliveryDate request for the REST API
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function buildGetDeliveryDateRequest(GetDeliveryDate $getDeliveryDate): RequestInterface
    {
        $deliveryDate = $getDeliveryDate->getGetDeliveryDate();

        $query = [
            'ShippingDate' => $deliveryDate->getShippingDate(),
            'Options'      => 'Daytime',
        ];
        if ($shippingDuration = $deliveryDate->getShippingDuration()) {
            $query['ShippingDuration'] = $shippingDuration;
        }

        $times = $deliveryDate->getCutOffTimes();
        if (!is_array($times)) {
            $times = [];
        }

        $key = array_search(
            '00',
            array_map(
                function (CutOffTime $time) {
                    return $time->getDay();
                },
                $times
            )
        );
        if (false !== $key) {
            $query['CutOffTime'] = date('H:i:s', strtotime($times[$key]->getTime()));
        } else {
            $query['CutOffTime'] = '15:30:00';
        }

        // There need to be more cut off times besides the default 00 one in order to override
        if (count($times) > 1) {
            foreach (range(1, 7) as $day) {
                $dayName = date('l', strtotime("Sunday +{$day} days"));
                $key = array_search(
                    str_pad($day, 2, '0', STR_PAD_LEFT),
                    array_map(
                        function (CutOfftime $time) {
                            return $time->getDay();
                        },
                        $times
                    )
                );
                if (false !== $key) {
                    $query["CutOffTime{$dayName}"] = date('H:i:s', strtotime($times[$key]->getTime()));
                    $query["Available{$dayName}"] = 'true';
                } else {
                    $query["CutOffTime{$dayName}"] = '00:00:00';
                    $query["Available{$dayName}"] = 'false';
                }
            }
        }

        if ($postcode = $deliveryDate->getPostalCode()) {
            $query['PostalCode'] = $postcode;
        }
        $query['CountryCode'] = $deliveryDate->getCountryCode();
        if ($originCountryCode = $deliveryDate->getOriginCountryCode()) {
            $query['OriginCountryCode'] = $originCountryCode;
        }
        if ($city = $deliveryDate->getCity()) {
            $query['City'] = $city;
        }
        if ($houseNr = $deliveryDate->getHouseNr()) {
            $query['HouseNr'] = $houseNr;
        }
        if ($houseNrExt = $deliveryDate->getHouseNrExt()) {
            $query['HouseNrExt'] = $houseNrExt;
        }
        if (is_array($deliveryDate->getOptions())) {
            foreach ($deliveryDate->getOptions() as $option) {
                if ('Daytime' === $option) {
                    continue;
                }

                $query['Options'] .= ",$option";
            }
        }

        $endpoint = '/delivery?'.http_build_query($query);

        /** @var RequestFactory $factory */
        $factory = Psr17FactoryDiscovery::findRequestFactory();

        return $factory->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
                'apikey'       => $this->postnl->getApiKey(),
            ]
        );
    }

    /**
     * Process GetDeliveryDate REST Response
     *
     * @param mixed $response
     *
     * @return null|GetDeliveryDateResponse
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function processGetDeliveryDateResponse($response): ?GetDeliveryDateResponse
    {
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['DeliveryDate'])) {
            /** @var GetDeliveryDateResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GetDeliveryDateResponse' => $body]);

            return $object;
        }

        return null;
    }

    /**
     * Get the sent date via REST
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return GetSentDateResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getSentDate(GetSentDateRequest $getSentDate): GetSentDateResponse
    {
        $item = $this->retrieveCachedItem($getSentDate->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = Client::getInstance()->doRequest($this->buildGetSentDateRequest($getSentDate));
            static::validateResponse($response);
        }

        $object = $this->processGetSentDateResponse($response);
        if ($object instanceof GetSentDateResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && $response->getStatusCode() === 200
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve shipping date');
    }

    /**
     * Build the GetSentDate request for the REST API
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return RequestInterface
     */
    public function buildGetSentDateRequest(GetSentDateRequest $getSentDate): RequestInterface
    {
        $sentDate = $getSentDate->getGetSentDate();
        $query = [
            'ShippingDate' => $sentDate->getDeliveryDate(),
        ];
        $query['CountryCode'] = $sentDate->getCountryCode();
        if ($duration = $sentDate->getShippingDuration()) {
            $query['ShippingDuration'] = $duration;
        }
        if ($postcode = $sentDate->getPostalCode()) {
            $query['PostalCode'] = $postcode;
        }
        if ($city = $sentDate->getCity()) {
            $query['City'] = $city;
        }
        if ($houseNr = $sentDate->getHouseNr()) {
            $query['HouseNr'] = $houseNr;
        }
        if ($houseNrExt = $sentDate->getHouseNrExt()) {
            $query['HouseNrExt'] = $houseNrExt;
        }

        $endpoint = '/shipping?'.http_build_query($query);

        /** @var RequestFactory $factory */
        $factory = Psr17FactoryDiscovery::findRequestFactory();

        return $factory->createRequest(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT.$endpoint,
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
                'apikey'       => $this->postnl->getApiKey(),
            ]
        );
    }

    /**
     * Process GetSentDate REST Response
     *
     * @param mixed $response
     *
     * @return null|GetSentDateResponse
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function processGetSentDateResponse($response): ?GetSentDateResponse
    {
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['SentDate'])) {


            /** @var GetSentDateResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GetSentDateResponse' => $body]);

            return $object;
        }

        return null;
    }
}
