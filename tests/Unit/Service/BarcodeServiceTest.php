<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Tests\Unit\Service;

use Exception;
use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\DTO\Request\GenerateBarcodeRequestDTO;
use Firstred\PostNL\DTO\Response\GenerateBarcodeResponseDTO;
use Firstred\PostNL\DTO\Response\GenerateBarcodesByCountryCodesResponseDTO;
use Firstred\PostNL\DTO\Response\GenerateBarcodesResponseDTO;
use Firstred\PostNL\Exception\ApiClientException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidApiKeyException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidBarcodeException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotAvailableException;
use Firstred\PostNL\Exception\ParseError;
use Firstred\PostNL\HttpClient\HTTPlugHttpClient;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use JetBrains\PhpStorm\Pure;
use function json_encode;

/**
 * Class BarcodeServiceTest.
 *
 * @testdox The BarcodeService (REST)
 */
class BarcodeServiceTest extends ServiceTestBase
{
    /**
     * @testdox Creates a valid 3S barcode request
     *
     * @throws InvalidBarcodeException
     * @throws Exception
     */
    public function testCreatesAValid3SBarcodeRequest()
    {
        $type = '3S';
        $range = $this->getRange(type: '3S');
        $serie = $this->postnl->getBarcodeService()->findBarcodeSerie(type: '3S', range: $range, eps: false);

        $this->lastRequest = $request = $this->postnl->getBarcodeService()->getGateway()->getRequestBuilder()->buildGenerateBarcodeRequest(
            generateBarcodeRequestDTO: new GenerateBarcodeRequestDTO(
                service: BarcodeServiceInterface::class,
                propType: RequestProp::class,

                Type: $type,
                Serie: $serie,
                Range: $range,
            ),
        );

        $query = [];
        parse_str(string: $request->getUri()->getQuery(), result: $query);

        $this->assertEqualsCanonicalizing(
            expected: [
                'CustomerCode'   => 'DEVC',
                'CustomerNumber' => '11223344',
                'Type'           => $type,
                'Serie'          => $serie,
                'Range'          => $range,
            ],
            actual: $query,
        );
        $this->assertEmpty(actual: (string) $request->getBody());
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: '', actual: $request->getHeaderLine('Content-Type'));
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Returns a valid single barcode
     *
     * @throws InvalidArgumentException
     * @throws InvalidBarcodeException
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws NotAvailableException
     * @throws ParseError
     * @throws HttpClientException
     */
    public function testSingleBarcodeRest()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(json_encode(value: ['Barcode' => '3SDEVC816223392'])));
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $mockClient->addResponse($response);
        $this->postnl->getBarcodeService()->getGateway()->setHttpClient(
            httpClient: new HTTPlugHttpClient(client: $mockClient),
        );

        $response = $this->postnl->generateBarcode();
        $this->assertTrue(condition: $response->isValid());
        $this->assertEquals(expected: '3SDEVC816223392', actual: $response->getBarcode());
        $this->assertEquals(expected: '3SDEVC816223392', actual: (string) $response);
    }

    /**
     * @testdox Returns a valid single barcode for a country
     *
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws InvalidBarcodeException
     * @throws NotAvailableException
     * @throws ParseError
     * @throws InvalidConfigurationException
     * @throws HttpClientException
     */
    public function testSingleBarCodeByCountryRest()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(json_encode(value: ['Barcode' => '3SDEVC816223392'])));
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $mockClient->addResponse($response);
        $this->postnl->getBarcodeService()->getGateway()->setHttpClient(
            httpClient: new HTTPlugHttpClient(client: $mockClient),
        );

        $response = $this->postnl->generateBarcodeByCountryCode(iso: 'NL');
        $this->assertEquals(expected: '3SDEVC816223392', actual: $response->getBarcode());
        $this->assertEquals(expected: '3SDEVC816223392', actual: (string) $response);
    }

    /**
     * @testdox Returns several barcodes
     *
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws InvalidBarcodeException
     * @throws InvalidConfigurationException
     * @throws NotAvailableException
     * @throws ParseError
     * @throws HttpClientException
     */
    public function testMultipleNLBarcodesRest()
    {
        $mockClient = new Client();

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $mockClient->addResponse(
            $responseFactory->createResponse(200, 'OK')
                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
                ->withBody($streamFactory->createStream(json_encode(value: ['Barcode' => '3SDEVC816223392'])))
        );
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $mockClient->addResponse(
            $responseFactory->createResponse(200, 'OK')
                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
                ->withBody($streamFactory->createStream(json_encode(value: ['Barcode' => '3SDEVC816223393'])))
        );
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $mockClient->addResponse(
            $responseFactory->createResponse(200, 'OK')
                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
                ->withBody($streamFactory->createStream(json_encode(value: ['Barcode' => '3SDEVC816223394'])))
        );
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $mockClient->addResponse(
            $responseFactory->createResponse(200, 'OK')
                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
                ->withBody($streamFactory->createStream(json_encode(value: ['Barcode' => '3SDEVC816223395'])))
        );
        $this->postnl->getBarcodeService()->getGateway()->setHttpClient(
            httpClient: new HTTPlugHttpClient(client: $mockClient),
        );

        $barcodes = $this->postnl->generateBarcodesByCountryCodes(isos: ['NL' => 4]);

        /** @noinspection PhpExpectedValuesShouldBeUsedInspection */
        $this->assertEquals(
            expected: new GenerateBarcodesByCountryCodesResponseDTO(
                service: BarcodeServiceInterface::class,
                propType: ResponseProp::class,
                countries: [
                'NL' => new GenerateBarcodesResponseDTO(responses: [
                    new GenerateBarcodeResponseDTO(Barcode: '3SDEVC816223392'),
                    new GenerateBarcodeResponseDTO(Barcode: '3SDEVC816223393'),
                    new GenerateBarcodeResponseDTO(Barcode: '3SDEVC816223394'),
                    new GenerateBarcodeResponseDTO(Barcode: '3SDEVC816223395'),
                ]),
            ]),
            actual: $barcodes
        );
    }

    #[Pure]
    protected function getRange(string $type): string
    {
        if (in_array(needle: $type, haystack: ['2S', '3S'])) {
            return $this->postnl->getCustomer()->getCustomerCode();
        }

        return $this->postnl->getCustomer()->getGlobalPackCustomerCode();
    }
}
