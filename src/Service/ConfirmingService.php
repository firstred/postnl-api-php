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

namespace Firstred\PostNL\Service;

use DateInterval;
use DateTimeInterface;
use Firstred\PostNL\Entity\Request\Confirming;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\Service\RequestBuilder\ConfirmingServiceRequestBuilderInterface;
use Firstred\PostNL\Service\RequestBuilder\Rest\ConfirmingServiceRestRequestBuilder;
use Firstred\PostNL\Service\ResponseProcessor\ConfirmingServiceResponseProcessorInterface;
use Firstred\PostNL\Service\ResponseProcessor\ResponseProcessorSettersTrait;
use Firstred\PostNL\Service\ResponseProcessor\Rest\ConfirmingServiceRestResponseProcessor;
use ParagonIE\HiddenString\HiddenString;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use ReflectionException;

/**
 * @since 2.0.0
 *
 * @internal
 */
class ConfirmingService extends AbstractService implements ConfirmingServiceInterface
{
    use ResponseProcessorSettersTrait;

    protected ConfirmingServiceRequestBuilderInterface $requestBuilder;
    protected ConfirmingServiceResponseProcessorInterface $responseProcessor;

    /**
     * @param HiddenString                            $apiKey
     * @param bool                                    $sandbox
     * @param HttpClientInterface                     $httpClient
     * @param RequestFactoryInterface                 $requestFactory
     * @param StreamFactoryInterface                  $streamFactory
     * @param CacheItemPoolInterface|null             $cache
     * @param DateInterval|DateTimeInterface|int|null $ttl
     */
    public function __construct(
        HiddenString $apiKey,
        bool $sandbox,
        HttpClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        CacheItemPoolInterface $cache = null,
        DateInterval|DateTimeInterface|int $ttl = null
    ) {
        parent::__construct(
            apiKey: $apiKey,
            sandbox: $sandbox,
            httpClient: $httpClient,
            requestFactory: $requestFactory,
            streamFactory: $streamFactory,
            cache: $cache,
            ttl: $ttl,
        );

        $this->requestBuilder = new ConfirmingServiceRestRequestBuilder(
            apiKey: $this->apiKey,
            sandbox: $this->isSandbox(),
            requestFactory: $this->getRequestFactory(),
            streamFactory: $this->getStreamFactory(),
        );
        $this->responseProcessor = new ConfirmingServiceRestResponseProcessor();
    }

    /**
     * Confirm a single shipment via REST.
     *
     * @param Confirming $confirming
     *
     * @return ConfirmingResponseShipment
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws DeserializationException
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     * @throws NotSupportedException
     *
     * @since 1.0.0
     */
    public function confirmShipment(Confirming $confirming): ConfirmingResponseShipment
    {
        $response = $this->getHttpClient()->doRequest(
            request: $this->requestBuilder->buildConfirmRequest(confirming: $confirming),
        );

        return $this->responseProcessor->processConfirmResponse(response: $response)[0];
    }

    /**
     * Confirm multiple shipments.
     *
     * @param array<string, Confirming> $confirms ['uuid' => Confirming, ...]
     *
     * @return array<string, ConfirmingResponseShipment>
     *
     * @throws CifDownException
     * @throws CifException
     * @throws DeserializationException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     * @throws NotSupportedException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function confirmShipments(array $confirms): array
    {
        $httpClient = $this->getHttpClient();

        foreach ($confirms as $confirm) {
            $httpClient->addOrUpdateRequest(
                id: $confirm->getId(),
                request: $this->requestBuilder->buildConfirmRequest(confirming: $confirm),
            );
        }

        $confirmingResponses = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            $confirmingResponse = null;
            $objects = $this->responseProcessor->processConfirmResponse(response: $response);
            foreach ($objects as $object) {
                if (!$object instanceof ConfirmingResponseShipment) {
                    throw new ResponseException(message: 'Invalid API Response', code: $response->getStatusCode(), previous: null, response: $response);
                }

                $confirmingResponse = $object;
            }

            $confirmingResponses[$uuid] = $confirmingResponse;
        }

        return $confirmingResponses;
    }

    /**
     * @param HiddenString $apiKey
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setApiKey(HiddenString $apiKey): static
    {
        $this->requestBuilder->setApiKey(apiKey: $apiKey);

        return parent::setApiKey(apiKey: $apiKey);
    }

    /**
     * @param bool $sandbox
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setSandbox(bool $sandbox): static
    {
        $this->requestBuilder->setSandbox(sandbox: $sandbox);

        return parent::setSandbox(sandbox: $sandbox);
    }

    /**
     * @param RequestFactoryInterface $requestFactory
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setRequestFactory(RequestFactoryInterface $requestFactory): static
    {
        $this->requestBuilder->setRequestFactory(requestFactory: $requestFactory);

        return parent::setRequestFactory(requestFactory: $requestFactory);
    }

    /**
     * @param StreamFactoryInterface $streamFactory
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setStreamFactory(StreamFactoryInterface $streamFactory): static
    {
        $this->requestBuilder->setStreamFactory(streamFactory: $streamFactory);

        return parent::setStreamFactory(streamFactory: $streamFactory);
    }
}
