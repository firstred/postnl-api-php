<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service;

use Firstred\PostNL\Entity\Request\GenerateBarcodeRequestEntity;
use Firstred\PostNL\Entity\Request\GenerateBarcodeRequestEntityInterface;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifErrorException;
use Firstred\PostNL\Method\Barcode\GenerateBarcodeMethodInterface;
use Http\Client\Exception as HttpClientException;

/**
 * Class BarcodeService.
 */
class BarcodeService extends AbstractService implements BarcodeServiceInterface
{
    // API Version
    const VERSION = '1.1';

    // Endpoints
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v1_1/barcode';
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v1_1/barcode';

    /** @var GenerateBarcodeMethodInterface */
    private $generateBarcodeMethod;

    /**
     * Set the generate barcode method.
     *
     * @param GenerateBarcodeMethodInterface $generateBarcodeMethod
     *
     * @since 2.0.0
     */
    public function setGenerateBarcodeMethod(GenerateBarcodeMethodInterface $generateBarcodeMethod)
    {
        $this->generateBarcodeMethod = $generateBarcodeMethod;

        $this->generateBarcodeMethod->setApiKey($this->apiKey);
        $this->generateBarcodeMethod->setEndpoint($this->sandbox ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT);
        $this->generateBarcodeMethod->setCustomer($this->customer);
    }

    /**
     * Generate a single barcode.
     *
     * @param GenerateBarcodeRequestEntityInterface $generateBarcodeRequest
     *
     * @return string
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     *
     * @since 2.0.0
     */
    public function generateBarcode(GenerateBarcodeRequestEntityInterface $generateBarcodeRequest): string
    {
        $response = $this->httpClient->doRequest($this->generateBarcodeMethod->buildRequest($generateBarcodeRequest));
        static::validateResponse($response);
        $json = $this->generateBarcodeMethod->processResponse($response);

        return $json['Barcode'];
    }

    /**
     * Generate multiple barcodes at once.
     *
     * @param GenerateBarcodeRequestEntity[] $generateBarcodes
     *
     * @return string[] Barcodes
     *
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws CifDownException
     */
    public function generateBarcodes(array $generateBarcodes): array
    {
        foreach ($generateBarcodes as $generateBarcode) {
            /* @var GenerateBarcodeRequestEntity $generateBarcode */
            $this->httpClient->addOrUpdateRequest(
                $generateBarcode->getId(),
                $this->generateBarcodeMethod->buildRequest($generateBarcode)
            );
        }

        $barcodes = [];
        foreach ($this->httpClient->doRequests() as $uuid => $response) {
            static::validateResponse($response);
            $json = $this->generateBarcodeMethod->processResponse($response);
            $barcode = $json['Barcode'];

            $barcodes[$uuid] = $barcode;
        }

        return $barcodes;
    }
}
