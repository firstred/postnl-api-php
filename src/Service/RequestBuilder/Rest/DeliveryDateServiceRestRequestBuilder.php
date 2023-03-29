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

namespace Firstred\PostNL\Service\RequestBuilder\Rest;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\Request\GetDeliveryDate;
use Firstred\PostNL\Entity\Request\GetSentDateRequest;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\DeliveryDateServiceInterface;
use Firstred\PostNL\Service\RequestBuilder\DeliveryDateServiceRequestBuilderInterface;
use Psr\Http\Message\RequestInterface;
use ReflectionException;
use function strcasecmp;
use const PHP_QUERY_RFC3986;

/**
 * @since 2.0.0
 * @internal
 */
class DeliveryDateServiceRestRequestBuilder extends AbstractRestRequestBuilder implements DeliveryDateServiceRequestBuilderInterface
{
    // Endpoints
    private const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_2/calculate/date';
    private const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_2/calculate/date';

    /**
     * Build the GetDeliveryDate request for the REST API.
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return RequestInterface
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @since 2.0.0
     */
    public function buildGetDeliveryDateRequest(GetDeliveryDate $getDeliveryDate): RequestInterface
    {
        $this->setService(entity: $getDeliveryDate);

        $deliveryDate = $getDeliveryDate->getGetDeliveryDate();

        $query = [
            'ShippingDate' => $deliveryDate->getShippingDate()->format(format: 'd-m-Y H:i:s'),
            'Options'      => 'Daytime',
        ];
        if ($shippingDuration = $deliveryDate->getShippingDuration()) {
            $query['ShippingDuration'] = $shippingDuration;
        }

        $times = $deliveryDate->getCutOffTimes();
        if (!is_array(value: $times)) {
            $times = [];
        }

        $key = array_search(needle: '00', haystack: array_map(callback: function ($time) {
            /* @var CutOffTime $time */
            return $time->getDay();
        }, array: $times));
        if (false !== $key) {
            $query['CutOffTime'] = date(format: 'H:i:s', timestamp: strtotime(datetime: $times[$key]->getTime()));
        } else {
            $query['CutOffTime'] = '15:30:00';
        }

        // There need to be more cut off times besides the default 00 one in order to override
        if (count(value: $times) > 1) {
            foreach (range(start: 1, end: 7) as $day) {
                $dayName = date(format: 'l', timestamp: strtotime(datetime: "Sunday +{$day} days"));
                $key = array_search(needle: str_pad(string: $day, length: 2, pad_string: '0', pad_type: STR_PAD_LEFT), haystack: array_map(callback: function ($time) {
                    /* @var CutOffTime $time */
                    return $time->getDay();
                }, array: $times));
                if (false !== $key) {
                    $query["CutOffTime$dayName"] = date(format: 'H:i:s', timestamp: strtotime(datetime: $times[$key]->getTime()));
                    $query["Available$dayName"] = 'true';
                } else {
                    $query["CutOffTime$dayName"] = '00:00:00';
                    $query["Available$dayName"] = 'false';
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
        if (is_array(value: $deliveryDate->getOptions())) {
            foreach ($deliveryDate->getOptions() as $option) {
                if (strcasecmp(string1: 'Daytime', string2: $option) === 0) {
                    continue;
                }

                $query['Options'] .= ",$option";
            }
        }

        $endpoint = '/delivery?'.http_build_query(data: $query, numeric_prefix: '', arg_separator: '&', encoding_type: PHP_QUERY_RFC3986);

        return $this->getRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('apikey', value: $this->getApiKey()->getString())
            ->withHeader('Accept', value: 'application/json');
    }

    /**
     * Build the GetSentDate request for the REST API.
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return RequestInterface
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @since 2.0.0
     */
    public function buildGetSentDateRequest(GetSentDateRequest $getSentDate): RequestInterface
    {
        $this->setService(entity: $getSentDate);

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

        $endpoint = '/shipping?'.http_build_query(data: $query, numeric_prefix: '', arg_separator: '&', encoding_type: PHP_QUERY_RFC3986);

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
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @since 2.0.0
     */
    protected function setService(AbstractEntity $entity): void
    {
        $entity->setCurrentService(currentService: DeliveryDateServiceInterface::class);

        parent::setService(entity: $entity);
    }
}
