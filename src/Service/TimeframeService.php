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
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\Util\Message;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\RequestFactory;
use InvalidArgumentException;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class TimeframeService
 */
class TimeframeService extends AbstractService
{
    // API Version
    const VERSION = '2.1';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_1/calculate/timeframes';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_1/calculate/timeframes';
    const LEGACY_SANDBOX_ENDPOINT = 'https://testservice.postnl.com/CIF_SB/TimeframeWebService/2_0/TimeframeWebService.svc';
    const LEGACY_LIVE_ENDPOINT = 'https://service.postnl.com/CIF/TimeframeWebService/2_0/TimeframeWebService.svc';

    /**
     * Get timeframes via REST
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return ResponseTimeframes
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getTimeframes(GetTimeframes $getTimeframes)
    {
        $item = $this->retrieveCachedItem($getTimeframes->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = Client::getInstance()->doRequest($this->buildGetTimeframesRequest($getTimeframes));
            static::validateResponse($response);
        }

        $object = $this->processGetTimeframesResponse($response);
        if ($object instanceof ResponseTimeframes) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && $response->getStatusCode() === 200
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve timeframes');
    }

    /**
     * Build the GetTimeframes request for the REST API
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return RequestInterface
     */
    public function buildGetTimeframesRequest(GetTimeframes $getTimeframes): RequestInterface
    {
        $timeframe = $getTimeframes->getTimeframe()[0];
        $query = [
            'AllowSundaySorting' => in_array($timeframe->getSundaySorting(), [true, 'true', 1], true),
            'StartDate'          => $timeframe->getStartDate(),
            'EndDate'            => $timeframe->getEndDate(),
            'PostalCode'         => $timeframe->getPostalCode(),
            'HouseNumber'        => $timeframe->getHouseNr(),
            'CountryCode'        => $timeframe->getCountryCode(),
            'Options'            => '',
        ];
        if ($interval = $timeframe->getInterval()) {
            $query['Interval'] = $interval;
        }
        if ($houseNrExt = $timeframe->getHouseNrExt()) {
            $query['HouseNrExt'] = $houseNrExt;
        }
        if ($timeframeRange = $timeframe->getTimeframeRange()) {
            $query['TimeframeRange'] = $timeframeRange;
        }
        if ($street = $timeframe->getStreet()) {
            $query['Street'] = $street;
        }
        if ($city = $timeframe->getCity()) {
            $query['City'] = $city;
        }
        foreach ($timeframe->getOptions() as $option) {
            if ('PG' === $option) {
                continue;
            }
            $query['Options'] .= ",$option";
        }
        $query['Options'] = ltrim($query['Options'], ',');
        $endpoint = '?'.http_build_query($query);

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
     * Process GetTimeframes Response REST
     *
     * @param mixed $response
     *
     * @return null|ResponseTimeframes
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function processGetTimeframesResponse($response): ?ResponseTimeframes
    {
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['Timeframes'])) {
            // Standardize the object here
            if (isset($body['ReasonNotimeframes']['ReasonNoTimeframe'])) {
                if (isset($body['ReasonNotimeframes']['ReasonNoTimeframe']['Code'])) {
                    $body['ReasonNotimeframes']['ReasonNoTimeframe'] = [$body['ReasonNotimeframes']['ReasonNoTimeframe']];
                }

                $newNotimeframes = [];
                foreach ($body['ReasonNotimeframes']['ReasonNoTimeframe'] as &$reasonNotimeframe) {
                    $newNotimeframes[] = AbstractEntity::jsonDeserialize(['ReasonNoTimeFrame' => $reasonNotimeframe]);
                }
                $body['ReasonNotimeframes'] = $newNotimeframes;
            }

            if (isset($body['Timeframes']['Timeframe'])) {
                if (isset($body['Timeframes']['Timeframe']['Date'])) {
                    $body['Timeframes']['Timeframe'] = [$body['Timeframes']['Timeframe']];
                }

                $newTimeframes = [];
                foreach ($body['Timeframes']['Timeframe'] as $timeframe) {
                    $newTimeframeTimeframe = [];
                    if (isset($timeframe['Timeframes']['TimeframeTimeFrame']['From'])) {
                        $timeframe['Timeframes']['TimeframeTimeFrame'] = [$timeframe['Timeframes']['TimeframeTimeFrame']];
                    }
                    foreach ($timeframe['Timeframes']['TimeframeTimeFrame'] as $timeframetimeframe) {
                        $newTimeframeTimeframe[] = AbstractEntity::jsonDeserialize(
                            ['TimeframeTimeFrame' => $timeframetimeframe]
                        );
                    }
                    $timeframe['Timeframes'] = $newTimeframeTimeframe;

                    $newTimeframes[] = AbstractEntity::jsonDeserialize(['Timeframe' => $timeframe]);
                }
                $body['Timeframes'] = $newTimeframes;
            }

            /** @var ResponseTimeframes $object */
            $object = AbstractEntity::jsonDeserialize(['ResponseTimeframes' => $body]);

            return $object;
        }

        return null;
    }
}
