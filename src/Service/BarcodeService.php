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
use Firstred\PostNL\Enum\PostNLApiMode;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\Service\Adapter\BarcodeServiceAdapterInterface;
use Firstred\PostNL\Service\Adapter\Rest\BarcodeServiceRestAdapter;
use Firstred\PostNL\Service\Adapter\ServiceAdapterSettersTrait;
use Firstred\PostNL\Service\Adapter\Soap\BarcodeServiceSoapAdapter;
use ParagonIE\HiddenString\HiddenString;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @since 2.0.0
 */
class BarcodeService extends AbstractService implements BarcodeServiceInterface
{
    use ServiceAdapterSettersTrait;

    protected BarcodeServiceAdapterInterface $adapter;

    public function __construct(
        HiddenString $apiKey,
        PostNLApiMode $apiMode,
        bool $sandbox,
        HttpClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        string $version = self::DEFAULT_VERSION,
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
     * Generate a single barcode.
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws InvalidConfigurationException
     *
     * @since 1.0.0
     */
    public function generateBarcode(GenerateBarcode $generateBarcode): string
    {
        $response = $this
            ->getHttpClient()
            ->doRequest(request: $this->adapter->buildGenerateBarcodeRequest(generateBarcode: $generateBarcode));

        return $this->adapter->processGenerateBarcodeResponse(response: $response);
    }

    /**
     * Generate multiple barcodes at once.
     *
     * @param GenerateBarcode[] $generateBarcodes
     *
     * @return string[] Barcodes
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws InvalidConfigurationException
     *
     * @since 1.0.0
     */
    public function generateBarcodes(array $generateBarcodes): array
    {
        $httpClient = $this->getHttpClient();

        foreach ($generateBarcodes as $generateBarcode) {
            $httpClient->addOrUpdateRequest(
                id: $generateBarcode->getId(),
                request: $this->adapter->buildGenerateBarcodeRequest(generateBarcode: $generateBarcode),
            );
        }

        $barcodes = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            $barcode = $this->adapter->processGenerateBarcodeResponse(response: $response);
            $barcodes[$uuid] = $barcode;
        }

        return $barcodes;
    }

    /**
     * @since 2.0.0
     */
    public function setAPIMode(PostNLApiMode $mode): void
    {
        $this->adapter = $mode == PostNLApiMode::Rest
            ? new BarcodeServiceRestAdapter(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
                version: $this->getVersion(),
            )
            : new BarcodeServiceSoapAdapter(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
                version: $this->getVersion(),
            );
    }
}