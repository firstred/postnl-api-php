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

use Firstred\PostNL\Entity\Request\CalculateTimeframesRequest;
use Firstred\PostNL\Entity\Response\CalculateTimeframesResponse;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifErrorException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\Misc\Message;
use Http\Client\Exception as HttpClientException;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use TypeError;

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
     * @param CalculateTimeframesRequest $getTimeframes
     *
     * @return CalculateTimeframesResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getTimeframes(CalculateTimeframesRequest $getTimeframes)
    {
        $item = $this->retrieveCachedItem($getTimeframes->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (TypeError $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $request = $this->buildCalculateTimeframesRequest($getTimeframes);
            $response = Client::getInstance()->doRequest($request);
            static::validateResponse($response);
        }

        $object = $this->processGetTimeframesResponse($response);
        if ($object instanceof CalculateTimeframesResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && $response->getStatusCode() === 200
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new CifDownException('Unable to retrieve timeframes', 0, null, isset($request) && $request instanceof RequestInterface ? $request : null, $response);
    }

    /**
     * Build the GetTimeframes request for the REST API
     *
     * @param CalculateTimeframesRequest $calculateTimeframes
     *
     * @return RequestInterface
     */
    public function buildCalculateTimeframesRequest(CalculateTimeframesRequest $calculateTimeframes): RequestInterface
    {
        $query = [
            'AllowSundaySorting' => $calculateTimeframes->getAllowSundaySorting() ? 'true' : 'false',
            'CountryCode'        => $calculateTimeframes->getCountryCode(),
            'StartDate'          => $calculateTimeframes->getStartDate(),
            'EndDate'            => $calculateTimeframes->getEndDate(),
            'PostalCode'         => $calculateTimeframes->getPostalCode(),
            'HouseNumber'        => $calculateTimeframes->getHouseNumber(),
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
        $request = $request->withHeader('apikey', $this->postnl->getApiKey());

        return $request;
    }

    /**
     * Process GetTimeframes Response REST
     *
     * @param ResponseInterface $response
     *
     * @return CalculateTimeframesResponse
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     */
    public function processGetTimeframesResponse(ResponseInterface $response): CalculateTimeframesResponse
    {
        $body = json_decode((string) $response->getBody(), true);

        return CalculateTimeframesResponse::jsonDeserialize(['CalculateTimeframesResponse' => $body]);
    }
}
