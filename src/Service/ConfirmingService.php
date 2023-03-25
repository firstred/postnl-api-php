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
use Firstred\PostNL\Entity\Request\Confirming;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Enum\PostNLApiMode;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\NotFoundException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\Service\Adapter\ConfirmingServiceAdapterInterface;
use Firstred\PostNL\Service\Adapter\Rest\ConfirmingServiceRestAdapter;
use Firstred\PostNL\Service\Adapter\ServiceAdapterSettersTrait;
use Firstred\PostNL\Service\Adapter\Soap\ConfirmingServiceSoapAdapter;
use ParagonIE\HiddenString\HiddenString;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @since 2.0.0
 */
class ConfirmingService extends AbstractService implements ConfirmingServiceInterface
{
    use ServiceAdapterSettersTrait;

    protected ConfirmingServiceAdapterInterface $adapter;

    public function __construct(
        HiddenString $apiKey,
        PostNLApiMode $apiMode,
        bool $sandbox,
        HttpClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        string $version = ConfirmingServiceInterface::DEFAULT_VERSION,
        CacheItemPoolInterface $cache = null,
        DateInterval|DateTimeInterface|int $ttl = null
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
     * Confirm a single shipment via REST.
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotFoundException
     *
     * @since 1.0.0
     */
    public function confirmShipment(Confirming $confirming): ConfirmingResponseShipment
    {
        $response = $this->getHttpClient()->doRequest(request: $this->adapter->buildConfirmRequest(confirming: $confirming));
        $objects = $this->adapter->processConfirmResponse(response: $response);

        if (!empty($objects) && $objects[0] instanceof ConfirmingResponseShipment) {
            return $objects[0];
        }

        if (200 === $response->getStatusCode()) {
            throw new ResponseException(message: 'Invalid API Response', response: $response);
        }

        throw new NotFoundException(message: 'Unable to confirm');
    }

    /**
     * Confirm multiple shipments.
     *
     * @param Confirming[] $confirms ['uuid' => Confirming, ...]
     * @phpstan-param array<string, Confirming> $confirms
     *
     * @return ConfirmingResponseShipment[]
     * @phpstan-return array<string, ConfirmingResponseShipment>
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
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
                request: $this->adapter->buildConfirmRequest(confirming: $confirm),
            );
        }

        $confirmingResponses = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            $confirmingResponse = null;
            $objects = $this->adapter->processConfirmResponse(response: $response);
            foreach ($objects as $object) {
                if (!$object instanceof ConfirmingResponseShipment) {
                    throw new ResponseException(
                        message: 'Invalid API Response',
                        code: $response->getStatusCode(),
                        previous: null,
                        response: $response,
                    );
                }

                $confirmingResponse = $object;
            }

            $confirmingResponses[$uuid] = $confirmingResponse;
        }

        return $confirmingResponses;
    }

    /**
     * @since 2.0.0
     */
    public function setAPIMode(PostNLApiMode $mode): void
    {
        $this->adapter = $mode == PostNLApiMode::Rest
            ? new ConfirmingServiceRestAdapter(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
                version: $this->getVersion(),
            )
            : new ConfirmingServiceSoapAdapter(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
                version: $this->getVersion(),
            );
    }
}
