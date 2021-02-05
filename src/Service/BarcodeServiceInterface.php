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

namespace Firstred\PostNL\Service;

use Firstred\PostNL\DTO\Request\GenerateBarcodesRequestDTO;
use Firstred\PostNL\DTO\Response\GenerateBarcodeResponseDTO;
use Firstred\PostNL\DTO\Response\GenerateBarcodesByCountryCodesResponseDTO;
use Firstred\PostNL\DTO\Response\GenerateBarcodesResponseDTO;
use Firstred\PostNL\Exception\ApiClientException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\InvalidApiKeyException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidBarcodeException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotAvailableException;
use Firstred\PostNL\Exception\ParseError;
use Firstred\PostNL\Gateway\BarcodeServiceGatewayInterface;

/**
 * Interface BarcodeServiceInterface.
 */
interface BarcodeServiceInterface extends ServiceInterface
{
    /**
     * @param string      $type
     * @param string|null $range
     * @param string|null $serie
     * @param bool        $eps
     *
     * @return GenerateBarcodeResponseDTO
     *
     * @throws InvalidArgumentException
     * @throws InvalidBarcodeException
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function generateBarcode(
        string $type = '3S',
        string|null $range = null,
        string|null $serie = null,
        bool $eps = false,
    ): GenerateBarcodeResponseDTO;

    /**
     * @param GenerateBarcodesRequestDTO $generateBarcodesRequestDTO
     *
     * @return GenerateBarcodesResponseDTO
     *
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function generateBarcodes(GenerateBarcodesRequestDTO $generateBarcodesRequestDTO): GenerateBarcodesResponseDTO;

    /**
     * @param string $iso
     *
     * @return GenerateBarcodeResponseDTO
     *
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws InvalidBarcodeException
     * @throws InvalidConfigurationException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function generateBarcodeByCountryCode(string $iso): GenerateBarcodeResponseDTO;

    /**
     * @param array $isos
     *
     * @return GenerateBarcodesByCountryCodesResponseDTO
     *
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws InvalidBarcodeException
     * @throws InvalidConfigurationException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function generateBarcodesByCountryCodes(array $isos): GenerateBarcodesByCountryCodesResponseDTO;

    /**
     * @param BarcodeServiceGatewayInterface $gateway
     *
     * @return static
     */
    public function setGateway(BarcodeServiceGatewayInterface $gateway): static;

    /**
     * @return BarcodeServiceGatewayInterface
     */
    public function getGateway(): BarcodeServiceGatewayInterface;

    /**
     * Find a suitable serie for the barcode.
     *
     * @param string $type
     * @param string $range
     * @param bool   $eps
     *
     * @return string
     *
     * @throws InvalidBarcodeException
     */
    public function findBarcodeSerie(string $type, string $range, bool $eps): string;
}
