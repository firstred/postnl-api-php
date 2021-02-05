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

use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\DTO\Request\GenerateBarcodeRequestDTO;
use Firstred\PostNL\DTO\Request\GenerateBarcodesRequestDTO;
use Firstred\PostNL\DTO\Response\GenerateBarcodeResponseDTO;
use Firstred\PostNL\DTO\Response\GenerateBarcodesByCountryCodesResponseDTO;
use Firstred\PostNL\DTO\Response\GenerateBarcodesResponseDTO;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Exception\ApiClientException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\InvalidApiKeyException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidBarcodeException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotAvailableException;
use Firstred\PostNL\Exception\ParseError;
use Firstred\PostNL\Gateway\BarcodeServiceGatewayInterface;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\Misc\Util;
use JetBrains\PhpStorm\Pure;
use function explode;
use function in_array;
use function strlen;
use function strtoupper;

/**
 * Class BarcodeService.
 */
class BarcodeService extends ServiceBase implements BarcodeServiceInterface
{
    use ServiceLoggerTrait;

    #[Pure]
    /**
     * BarcodeService constructor.
     *
     * @param Customer                       $customer
     * @param string                         $apiKey
     * @param bool                           $sandbox
     * @param BarcodeServiceGatewayInterface $gateway
     */
    public function __construct(
        protected Customer $customer,
        protected string $apiKey,
        protected bool $sandbox,
        protected BarcodeServiceGatewayInterface $gateway,
    ) {
        parent::__construct(customer: $customer, apiKey: $apiKey, sandbox: $sandbox);
    }

    /**
     * @param string      $type
     * @param string|null $range
     * @param string|null $serie
     * @param bool        $eps
     *
     * @return GenerateBarcodeResponseDTO
     *
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws InvalidBarcodeException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function generateBarcode(
        string $type = '3S',
        string|null $range = null,
        string|null $serie = null,
        bool $eps = false,
    ): GenerateBarcodeResponseDTO {
        if (!in_array(needle: $type, haystack: ['2S', '3S']) || 2 !== strlen(string: $type)) {
            throw new InvalidBarcodeException(mesage: "Barcode type `$type` is invalid");
        }

        if (!$range) {
            if (in_array(needle: $type, haystack: ['2S', '3S'])) {
                $range = $this->customer->getCustomerCode();
            } else {
                $range = $this->customer->getGlobalPackCustomerCode();
            }
        }
        if (!$range) {
            throw new InvalidBarcodeException(message: 'Unable to find a valid range');
        }

        if (!$serie) {
            $serie = $this->findBarcodeSerie(type: $type, range: $range, eps: $eps);
        }

        return $this->getGateway()->doGenerateBarcodeRequest(generateBarcodeRequestDTO: new GenerateBarcodeRequestDTO(
            service: BarcodeServiceInterface::class,
            propType: RequestProp::class,

            Type: $type,
            Serie: $serie,
            Range: $range,
        ));
    }

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
    public function generateBarcodes(GenerateBarcodesRequestDTO $generateBarcodesRequestDTO): GenerateBarcodesResponseDTO
    {
        return $this->gateway->doGenerateBarcodesRequest(generateBarcodesRequestDTO: $generateBarcodesRequestDTO);
    }

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
    public function generateBarcodeByCountryCode(string $iso): GenerateBarcodeResponseDTO
    {
        if (in_array(needle: strtoupper(string: $iso), haystack: Util::$threeSCountries)) {
            $range = (string) $this->getCustomer()->getCustomerCode();
            $type = '3S';
        } else {
            $range = (string) $this->getCustomer()->getGlobalPackCustomerCode();
            $type = (string) $this->getCustomer()->getGlobalPackBarcodeType();

            if (!$range) {
                throw new InvalidConfigurationException(message: 'GlobalPack customer code has not been set for the current customer');
            }
            if (!$type) {
                throw new InvalidConfigurationException(message: 'GlobalPack barcode type has not been set for the current customer');
            }
        }

        $serie = $this->findBarcodeSerie(
            type: $type,
            range: $range,
            eps: 'NL' !== strtoupper(string: $iso) && in_array(needle: strtoupper(string: $iso), haystack: Util::$threeSCountries)
        );

        return $this->getGateway()->doGenerateBarcodeRequest(generateBarcodeRequestDTO: new GenerateBarcodeRequestDTO(
            service: BarcodeServiceInterface::class,
            propType: RequestProp::class,
            Type: $type,
            Serie: $serie,
            Range: $range,
        ));
    }

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
    public function generateBarcodesByCountryCodes(array $isos): GenerateBarcodesByCountryCodesResponseDTO
    {
        $customerCode = (string) $this->getCustomer()->getCustomerCode();
        $globalPackRange = (string) $this->getCustomer()->getGlobalPackCustomerCode();
        $globalPackType = (string) $this->getCustomer()->getGlobalPackBarcodeType();

        $generateBarcodes = new GenerateBarcodesRequestDTO();
        $index = 0;
        foreach ($isos as $iso => $qty) {
            if (in_array(needle: strtoupper(string: $iso), haystack: Util::$threeSCountries)) {
                $range = $customerCode;
                $type = '3S';
            } else {
                $range = $globalPackRange;
                $type = $globalPackType;

                if (!$range) {
                    throw new InvalidConfigurationException(message: 'GlobalPack customer code has not been set for the current customer');
                }
                if (!$type) {
                    throw new InvalidConfigurationException(message: 'GlobalPack barcode type has not been set for the current customer');
                }
            }

            $serie = $this->findBarcodeSerie(
                type: $type,
                range: $range,
                eps: 'NL' !== strtoupper(string: $iso) && in_array(needle: strtoupper(string: $iso), haystack: Util::$threeSCountries)
            );

            for ($i = 0; $i < $qty; ++$i) {
                $generateBarcodes["$iso-$index"] = new GenerateBarcodeRequestDTO(
                    service: BarcodeServiceInterface::class,
                    propType: RequestProp::class,
                    Type: $type,
                    Serie: $serie,
                    Range: $range,
                );
                ++$index;
            }
        }

        $results = $this->getGateway()->doGenerateBarcodesRequest(generateBarcodesRequestDTO: $generateBarcodes);

        $barcodes = new GenerateBarcodesByCountryCodesResponseDTO(
            service: BarcodeServiceInterface::class,
            propType: ResponseProp::class,
        );
        foreach ($results as $id => $barcode) {
            if (!$id) {
                continue;
            }
            list($iso) = explode(separator: '-', string: $id);
            if (!isset($barcodes[$iso])) {
                $barcodes[$iso] = new GenerateBarcodesResponseDTO(
                    service: BarcodeServiceInterface::class,
                    propType: ResponseProp::class,
                );
            }
            $barcodes[$iso]->add(generateBarcodeResponseDTO: $barcode);
        }

        return $barcodes;
    }

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
    public function findBarcodeSerie(string $type, string $range, bool $eps): string
    {
        switch ($type) {
            case '2S':
                $serie = '0000000-9999999';

                break;
            case '3S':
                if ($eps) {
                    switch (strlen(string: $range)) {
                        case 4:
                            $serie = '0000000-9999999';

                            break 2;
                        case 3:
                            $serie = '10000000-20000000';

                            break 2;
                        case 1:
                            $serie = '5210500000-5210600000';

                            break 2;
                        default:
                            throw new InvalidBarcodeException(message: 'Invalid range');
                    }
                }
                // Regular domestic codes
                $serie = (4 === strlen(string: $range) ? '987000000-987600000' : '0000000-9999999');

                break;
            default:
                // GlobalPack
                $serie = '0000-9999';

                break;
        }

        return $serie;
    }

    /**
     * @return BarcodeServiceGatewayInterface
     */
    public function getGateway(): BarcodeServiceGatewayInterface
    {
        return $this->gateway;
    }

    /**
     * @param BarcodeServiceGatewayInterface $gateway
     *
     * @return static
     */
    public function setGateway(BarcodeServiceGatewayInterface $gateway): static
    {
        $this->gateway = $gateway;

        return $this;
    }

    /**
     * @return HttpClientInterface
     */
    public function getHttpClient(): HttpClientInterface
    {
        return $this->getGateway()->getHttpClient();
    }

    /**
     * @param HttpClientInterface $httpClient
     *
     * @return static
     */
    public function setHttpClient(HttpClientInterface $httpClient): static
    {
        $this->getGateway()->setHttpClient(httpClient: $httpClient);

        return $this;
    }
}
