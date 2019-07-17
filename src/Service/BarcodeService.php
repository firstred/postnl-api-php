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

use Firstred\PostNL\Entity\Request\GenerateBarcode;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\PostNL;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BarcodeService
 */
class BarcodeService extends AbstractService
{
    const VERSION = '1.1';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v1_1/barcode';
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v1_1/barcode';

    /** @var PostNL $postnl */
    protected $postnl;

    /**
     * Generate a single barcode
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return string|null Barcode
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     */
    public function generateBarcode(GenerateBarcode $generateBarcode)
    {
        /** @var ResponseInterface $response */
        $response = Client::getInstance()->doRequest($this->buildGenerateBarcodeRequest($generateBarcode));

        $json = $this->processGenerateBarcodeResponse($response);

        return $json['Barcode'];
    }

    /**
     * Build the `generateBarcode` HTTP request for the REST API
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return RequestInterface
     */
    public function buildGenerateBarcodeRequest(GenerateBarcode $generateBarcode): RequestInterface
    {
        /** @var RequestFactory $factory */
        $factory = Psr17FactoryDiscovery::findRequestFactory();

        return $factory->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).'?'.http_build_query(
                [
                    'CustomerCode'   => $generateBarcode->getCustomer()->getCustomerCode(),
                    'CustomerNumber' => $generateBarcode->getCustomer()->getCustomerNumber(),
                    'Type'           => $generateBarcode->getBarcode()->getType(),
                    'Serie'          => $generateBarcode->getBarcode()->getSerie(),
                ]
            ),
            [
                'Accept' => 'application/json',
                'apikey' => $this->postnl->getApiKey(),
            ]
        );
    }

    /**
     * Process GenerateBarcode REST response
     *
     * @param mixed $response
     *
     * @return array
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     */
    public function processGenerateBarcodeResponse($response)
    {
        static::validateResponse($response);

        $json = json_decode(static::getResponseText($response), true);

        if (!isset($json['Barcode'])) {
            throw new ResponseException('Invalid API Response', 0, null, $response);
        }

        return $json;
    }

    /**
     * Generate multiple barcodes at once
     *
     * @param GenerateBarcode[] $generateBarcodes
     *
     * @return string[]|ResponseException[]|ApiException[]|CifDownException[]|CifException[] Barcodes
     */
    public function generateBarcodes(array $generateBarcodes): array
    {
        $httpClient = Client::getInstance();

        foreach ($generateBarcodes as $generateBarcode) {
            $httpClient->addOrUpdateRequest(
                $generateBarcode->getId(),
                $this->buildGenerateBarcodeRequest($generateBarcode)
            );
        }

        $barcodes = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            try {
                $json = $this->processGenerateBarcodeResponse($response);
                $barcode = $json['Barcode'];
            } catch (ResponseException $e) {
                $barcode = $e;
            } catch (ApiException $e) {
                $barcode = $e;
            } catch (CifDownException $e) {
                $barcode = $e;
            } catch (CifException $e) {
                $barcode = $e;
            }

            $barcodes[$uuid] = $barcode;
        }

        return $barcodes;
    }
}
