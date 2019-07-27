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
use Firstred\PostNL\Entity\Request\CalculateTimeframes;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\ClientException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\Misc\Message;
use Http\Discovery\Psr17FactoryDiscovery;
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

    /**
     * Get timeframes via REST
     *
     * @param CalculateTimeframes $getTimeframes
     *
     * @return ResponseTimeframes
     *
     * @throws ClientException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getTimeframes(CalculateTimeframes $getTimeframes)
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
            $request = $this->buildGetTimeframesRequest($getTimeframes);
            $response = Client::getInstance()->doRequest($request);
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

        throw new ClientException('Unable to retrieve timeframes', 0, null, isset($request) && $request instanceof RequestInterface ? $request : null, $response);
    }

    /**
     * Build the GetTimeframes request for the REST API
     *
     * @param CalculateTimeframes $calculateTimeframes
     *
     * @return RequestInterface
     */
    public function buildGetTimeframesRequest(CalculateTimeframes $calculateTimeframes): RequestInterface
    {
        $query = [
            'AllowSundaySorting'        => $calculateTimeframes->getAllowSundaySorting() ? 'true' : 'false',
            'CountryCode'        => $calculateTimeframes->getCountryCode(),
            'StartDate'          => $calculateTimeframes->getStartDate(),
            'EndDate'            => $calculateTimeframes->getEndDate(),
            'PostalCode'         => $calculateTimeframes->getPostalCode(),
            'HouseNumber'        => $calculateTimeframes->getHouseNr(),
            'Options'            => '',
        ];
        if ($interval = $calculateTimeframes->getInterval()) {
            $query['Interval'] = $interval;
        }
        if ($houseNrExt = $calculateTimeframes->getHouseNrExt()) {
            $query['HouseNrExt'] = $houseNrExt;
        }
        if ($timeframeRange = $calculateTimeframes->getTimeframeRange()) {
            $query['TimeframeRange'] = $timeframeRange;
        }
        if ($street = $calculateTimeframes->getStreet()) {
            $query['Street'] = $street;
        }
        if ($city = $calculateTimeframes->getCity()) {
            $query['City'] = $city;
        }
        foreach ($calculateTimeframes->getOptions() as $option) {
            if ('PG' === $option) {
                continue;
            }
            $query['Options'] .= ",$option";
        }
        $query['Options'] = ltrim($query['Options'], ',');
        $endpoint = '?'.http_build_query($query);

        $factory = Psr17FactoryDiscovery::findRequestFactory();

        /** @var RequestInterface $request */
        $request = $factory->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        );
        $request = $request->withHeader('Accept', 'application/json');
        $request = $request->withHeader('Content-Type', 'application/json;charset=UTF-8');
        $request = $request->withHeader('apikey', $this->postnl->getApiKey());

        return $request;
    }

    /**
     * Process GetTimeframes Response REST
     *
     * @param ResponseInterface $response
     *
     * @return null|ResponseTimeframes
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function processGetTimeframesResponse(ResponseInterface $response): ?ResponseTimeframes
    {
        $body = json_decode((string) $response->getBody(), true);
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
