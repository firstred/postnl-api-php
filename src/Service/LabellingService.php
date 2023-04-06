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
use Firstred\PostNL\Entity\Request\GenerateBarcode;
use Firstred\PostNL\Entity\Request\GenerateLabel;
use Firstred\PostNL\Entity\Response\GenerateBarcodeResponse;
use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\NotFoundException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\RequestBuilder\LabellingServiceRequestBuilderInterface;
use Firstred\PostNL\Service\RequestBuilder\Rest\LabellingServiceRestRequestBuilder;
use Firstred\PostNL\Service\RequestBuilder\Soap\LabellingServiceSoapRequestBuilder;
use Firstred\PostNL\Service\ResponseProcessor\LabellingServiceResponseProcessorInterface;
use Firstred\PostNL\Service\ResponseProcessor\ResponseProcessorSettersTrait;
use Firstred\PostNL\Service\ResponseProcessor\Rest\LabellingServiceRestResponseProcessor;
use Firstred\PostNL\Service\ResponseProcessor\Soap\LabellingServiceSoapResponseProcessor;
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
 * @internal
 */
class LabellingService extends AbstractService implements LabellingServiceInterface
{
    // SOAP API specific
    public const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/LabellingWebService/';
    public const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/LabellingWebService/';

    use ResponseProcessorSettersTrait;

    protected LabellingServiceRequestBuilderInterface $requestBuilder;
    protected LabellingServiceResponseProcessorInterface $responseProcessor;

    private static array $insuranceProductCodes = [3534, 3544, 3087, 3094];

    /**
     * @param HiddenString                            $apiKey
     * @param bool                                    $sandbox
     * @param HttpClientInterface                     $httpClient
     * @param RequestFactoryInterface                 $requestFactory
     * @param StreamFactoryInterface                  $streamFactory
     * @param int                                     $apiMode
     * @param CacheItemPoolInterface|null             $cache
     * @param DateInterval|DateTimeInterface|int|null $ttl
     */
    public function __construct(
        HiddenString                       $apiKey,
        bool                               $sandbox,
        HttpClientInterface                $httpClient,
        RequestFactoryInterface            $requestFactory,
        StreamFactoryInterface             $streamFactory,
        int                                $apiMode = PostNL::MODE_REST,
        CacheItemPoolInterface             $cache = null,
        DateInterval|DateTimeInterface|int $ttl = null,
    ) {
        parent::__construct(
            apiKey: $apiKey,
            sandbox: $sandbox,
            httpClient: $httpClient,
            requestFactory: $requestFactory,
            streamFactory: $streamFactory,
            apiMode: $apiMode,
            cache: $cache,
            ttl: $ttl,
        );
    }

    /**
     * Generate a single barcode.
     *
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @since 1.0.0
     */
    public function generateLabel(GenerateLabel $generateLabel, bool $confirm = true): GenerateLabelResponse
    {
        $item = $this->retrieveCachedItem(uuid: $generateLabel->getId());
        $response = null;
        if ($item instanceof CacheItemInterface && $item->isHit()) {
            $response = $item->get();
            try {
                $response = PsrMessage::parseResponse(message: $response);
            } catch (InvalidArgumentException) {
                // Invalid item in cache, skip
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->getHttpClient()->doRequest(
                request: $this->requestBuilder->buildGenerateLabelRequest(generateLabel: $generateLabel, confirm: $confirm),
            );
        }

        $object = $this->responseProcessor->processGenerateLabelResponse(response: $response);
        if ($item instanceof CacheItemInterface
            && $response instanceof ResponseInterface
            && 200 === $response->getStatusCode()
        ) {
            $item->set(value: PsrMessage::toString(message: $response));
            $this->cacheItem(item: $item);
        }

        return $object;
    }

    /**
     * Generate multiple labels at once.
     *
     * @param array<int|string, array<GenerateBarcode, bool>> $generateLabels
     *
     * @return array<int|string, GenerateBarcodeResponse>
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     * @since 1.0.0
     */
    public function generateLabels(array $generateLabels): array
    {
        $httpClient = $this->getHttpClient();

        $responses = [];
        foreach ($generateLabels as $uuid => $generateLabel) {
            $uuid = (string) $uuid;
            $item = $this->retrieveCachedItem(uuid: $uuid);
            $response = null;
            if ($item instanceof CacheItemInterface && $item->isHit()) {
                $response = $item->get();
                $response = PsrMessage::parseResponse(message: $response);
                $responses[$uuid] = $response;
            }

            $httpClient->addOrUpdateRequest(
                id: $uuid,
                request: $this->requestBuilder->buildGenerateLabelRequest(generateLabel: $generateLabel[0], confirm: $generateLabel[1])
            );
        }
        $newResponses = $httpClient->doRequests();
        foreach ($newResponses as $uuid => $newResponse) {
            $uuid = (string) $uuid;
            if ($newResponse instanceof ResponseInterface
                && 200 === $newResponse->getStatusCode()
            ) {
                $item = $this->retrieveCachedItem(uuid: $uuid);
                if ($item instanceof CacheItemInterface) {
                    $item->set(value: PsrMessage::toString(message: $newResponse));
                    $this->getCache()->saveDeferred(item: $item);
                }
            }
        }
        if ($this->getCache() instanceof CacheItemPoolInterface) {
            $this->getCache()->commit();
        }

        $labels = [];
        foreach ($responses + $newResponses as $uuid => $response) {
            $generateLabelResponse = $this->responseProcessor->processGenerateLabelResponse(response: $response);
            $labels[$uuid] = $generateLabelResponse;
        }

        return $labels;
    }

    /**
     * @since 2.0.0
     */
    public function setAPIMode(int $mode): void
    {
        if (PostNL::MODE_REST === $mode) {
            $this->requestBuilder = new LabellingServiceRestRequestBuilder(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            );
            $this->responseProcessor = new LabellingServiceRestResponseProcessor(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            );
        } else {
            $this->requestBuilder = new LabellingServiceSoapRequestBuilder(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            );
            $this->responseProcessor = new LabellingServiceSoapResponseProcessor(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            );
        }
    }
}
