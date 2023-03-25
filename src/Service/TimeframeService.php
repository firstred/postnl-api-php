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

namespace Firstred\PostNL\Service;

use DateInterval;
use DateTimeInterface;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Enum\PostNLApiMode;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\NotFoundException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\Service\Adapter\Rest\LocationServiceRestAdapter;
use Firstred\PostNL\Service\Adapter\Rest\TimeframeServiceRestAdapter;
use Firstred\PostNL\Service\Adapter\ServiceAdapterSettersTrait;
use Firstred\PostNL\Service\Adapter\Soap\LocationServiceSoapAdapter;
use Firstred\PostNL\Service\Adapter\Soap\TimeframeServiceSoapAdapter;
use Firstred\PostNL\Service\Adapter\TimeframeServiceAdapterInterface;
use GuzzleHttp\Psr7\Message as PsrMessage;
use InvalidArgumentException;
use ParagonIE\HiddenString\HiddenString;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @since 2.0.0
 */
class TimeframeService extends AbstractService implements TimeframeServiceInterface
{
    use ServiceAdapterSettersTrait;

    protected TimeframeServiceAdapterInterface $adapter;

    public function __construct(
        HiddenString $apiKey,
        PostNLApiMode $apiMode,
        bool $sandbox,
        HttpClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        string $version = TimeframeServiceInterface::DEFAULT_VERSION,
        CacheItemPoolInterface $cache = null,
        DateInterval|DateTimeInterface|int $ttl = null,
    ) {
        parent::__construct(
            apiKey: $apiKey,
            apiMode: $apiMode,
            sandbox: $sandbox,
            httpClient: $httpClient,
            requestFactory: $requestFactory,
            streamFactory: $streamFactory,
            version: $version,
            cache: $cache,
            ttl: $ttl,
        );
    }

    /**
     * Get timeframes via REST.
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return ResponseTimeframes
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws PsrCacheInvalidArgumentException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @throws NotFoundException
     *
     * @since 1.0.0
     */
    public function getTimeframes(GetTimeframes $getTimeframes): ResponseTimeframes
    {
        $item = $this->retrieveCachedItem(uuid: $getTimeframes->getId());
        $response = null;
        if ($item instanceof CacheItemInterface && $item->isHit()) {
            $response = $item->get();
            try {
                $response = PsrMessage::parseResponse(message: $response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->getHttpClient()->doRequest(request: $this->adapter->buildGetTimeframesRequest(getTimeframes: $getTimeframes));
        }

        $object = $this->adapter->processGetTimeframesResponse(response: $response);
        if ($object instanceof ResponseTimeframes) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(value: PsrMessage::toString(message: $response));
                $this->cacheItem(item: $item);
            }

            return $object;
        }

        throw new NotFoundException(message: 'Unable to retrieve timeframes');
    }

    /**
     * @since 2.0.0
     */
    public function setAPIMode(PostNLApiMode $mode): void
    {
        $this->adapter = $mode == PostNLApiMode::Rest
            ? new TimeframeServiceRestAdapter(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
                version: $this->getVersion(),
            )
            : new TimeframeServiceSoapAdapter(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
                version: $this->getVersion(),
            );
    }
}
