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
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\RequestBuilder\BarcodeServiceRequestBuilderInterface;
use Firstred\PostNL\Service\RequestBuilder\Rest\BarcodeServiceRestRequestBuilder;
use Firstred\PostNL\Service\RequestBuilder\Soap\BarcodeServiceSoapRequestBuilder;
use Firstred\PostNL\Service\ResponseProcessor\BarcodeServiceResponseProcessorInterface;
use Firstred\PostNL\Service\ResponseProcessor\ResponseProcessorSettersTrait;
use Firstred\PostNL\Service\ResponseProcessor\Rest\BarcodeServiceRestResponseProcessor;
use Firstred\PostNL\Service\ResponseProcessor\Soap\BarcodeServiceSoapResponseProcessor;
use ParagonIE\HiddenString\HiddenString;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @since 2.0.0
 * @internal
 */
class BarcodeService extends AbstractService implements BarcodeServiceInterface
{
    // SOAP API specific
    /** @deprecated */
    public const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/BarcodeWebService/';
    /** @deprecated */
    public const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/BarcodeWebService/';

    use ResponseProcessorSettersTrait;

    protected BarcodeServiceRequestBuilderInterface $requestBuilder;
    protected BarcodeServiceResponseProcessorInterface $responseProcessor;

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
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws InvalidConfigurationException
     * @since 1.0.0
     */
    public function generateBarcode(GenerateBarcode $generateBarcode): string
    {
        $response = $this
            ->getHttpClient()
            ->doRequest(request: $this->requestBuilder->buildGenerateBarcodeRequest(generateBarcode: $generateBarcode));

        return $this->responseProcessor->processGenerateBarcodeResponse(response: $response);
    }

    /**
     * Generate multiple barcodes at once.
     *
     * @param GenerateBarcode[] $generateBarcodes
     *
     * @return string[] Barcodes
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws InvalidConfigurationException
     * @since 1.0.0
     */
    public function generateBarcodes(array $generateBarcodes): array
    {
        $httpClient = $this->getHttpClient();

        foreach ($generateBarcodes as $generateBarcode) {
            $httpClient->addOrUpdateRequest(
                id: $generateBarcode->getId(),
                request: $this->requestBuilder->buildGenerateBarcodeRequest(generateBarcode: $generateBarcode),
            );
        }

        $barcodes = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            $barcode = $this->responseProcessor->processGenerateBarcodeResponse(response: $response);
            $barcodes[$uuid] = $barcode;
        }

        return $barcodes;
    }

    /**
     * @since 2.0.0
     */
    public function setAPIMode(int $mode): void
    {
        if (PostNL::MODE_REST === $mode) {
            $this->requestBuilder = new BarcodeServiceRestRequestBuilder(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            );
            $this->responseProcessor = new BarcodeServiceRestResponseProcessor(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            );
        } else {
            $this->requestBuilder = new BarcodeServiceSoapRequestBuilder(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            );
            $this->responseProcessor = new BarcodeServiceSoapResponseProcessor(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            );
        }
    }
}