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

namespace Firstred\PostNL;

use Exception;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Label;
use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Entity\Request\BasicNationalAddressCheckRequest;
use Firstred\PostNL\Entity\Request\CalculateDeliveryDateRequest;
use Firstred\PostNL\Entity\Request\CalculateShippingDateRequest;
use Firstred\PostNL\Entity\Request\CalculateTimeframesRequest;
use Firstred\PostNL\Entity\Request\ConfirmShipmentRequest;
use Firstred\PostNL\Entity\Request\FindNearestLocationsGeocodeRequest;
use Firstred\PostNL\Entity\Request\FindNearestLocationsRequest;
use Firstred\PostNL\Entity\Request\GenerateBarcodeRequest;
use Firstred\PostNL\Entity\Request\GenerateShipmentLabelRequest;
use Firstred\PostNL\Entity\Request\InternationalAddressCheckRequest;
use Firstred\PostNL\Entity\Request\LookupLocationRequest;
use Firstred\PostNL\Entity\Request\NationalAddressCheckRequest;
use Firstred\PostNL\Entity\Request\NationalGeoAddressCheckRequest;
use Firstred\PostNL\Entity\Request\RetrieveShipmentByBarcodeRequest;
use Firstred\PostNL\Entity\Request\RetrieveShipmentByKgidRequest;
use Firstred\PostNL\Entity\Request\RetrieveShipmentByReferenceRequest;
use Firstred\PostNL\Entity\Request\RetrieveSignatureByBarcodeRequest;
use Firstred\PostNL\Entity\Response\BasicNationalAddressCheckResponse;
use Firstred\PostNL\Entity\Response\CalculateDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\CalculateShippingDateResponse;
use Firstred\PostNL\Entity\Response\CalculateTimeframesResponse;
use Firstred\PostNL\Entity\Response\ConfirmShipmentResponse;
use Firstred\PostNL\Entity\Response\FindNearestLocationsGeocodeResponse;
use Firstred\PostNL\Entity\Response\FindNearestLocationsResponse;
use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Entity\Signature;
use Firstred\PostNL\Entity\ValidatedAddress;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifErrorException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidBarcodeException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\PostNLClientException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\Misc\Message as UtilMessage;
use Firstred\PostNL\Misc\Misc;
use Firstred\PostNL\Misc\RFPdi;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\BasicNationalAddressCheckService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\InternationalAddressCheckService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\NationalAddressCheckService;
use Firstred\PostNL\Service\NationalGeoAddressCheckService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;
use Http\Client\Exception as HttpClientException;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use setasign\Fpdi\PdfParser\StreamReader;

/**
 * Class PostNL
 */
class PostNL implements LoggerAwareInterface
{
    /**
     * 3S (or EU Pack Special) countries + China
     *
     * @var array
     */
    public static $threeSCountries = ['AT', 'BE', 'BG', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GB', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'NL', 'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'EE', 'CN'];

    /**
     * Labels positions on an A4
     * (index = amount of a6 left on the page)
     *
     * @var array
     *
     * @since 1.0.0 Named `$a6Positions`
     * @since 2.0.0 Renamed to `$labelPositions`
     */
    public static $labelPositions = [
        4 => [-276, 2],
        3 => [-132, 2],
        2 => [-276, 110],
        1 => [-132, 110],
    ];

    /**
     * The PostNL API key to be used for requests.
     *
     * @var string $apiKey
     */
    protected $apiKey;

    /**
     * The PostNL Customer to be used for requests.
     *
     * @var Customer $customer
     */
    protected $customer;

    /**
     * Sandbox mode
     *
     * @var bool $sandbox
     */
    protected $sandbox = false;

    /** @var LoggerInterface $logger */
    protected $logger;

    /** @var BarcodeService $barcodeService */
    protected $barcodeService;

    /** @var LabellingService $labellingService */
    protected $labellingService;

    /** @var ConfirmingService $confirmingService */
    protected $confirmingService;

    /** @var ShippingStatusService $shippingStatusService */
    protected $shippingStatusService;

    /** @var DeliveryDateService $deliveryDateService */
    protected $deliveryDateService;

    /** @var TimeframeService $timeframeService */
    protected $timeframeService;

    /** @var LocationService $locationService */
    protected $locationService;

    /** @var BasicNationalAddressCheckService $basicNationalAddressCheckService */
    protected $basicNationalAddressCheckService;

    /** @var NationalAddressCheckService $nationalAddressCheckService */
    protected $nationalAddressCheckService;

    /** @var NationalGeoAddressCheckService $nationalGeoAddressCheckService */
    protected $nationalGeoAddressCheckService;

    /** @var InternationalAddressCheckService $internationalAddressCheckService */
    protected $internationalAddressCheckService;

    /**
     * PostNL constructor.
     *
     * @param Customer $customer Customer object
     * @param string   $apiKey   API key
     * @param bool     $sandbox  Sandbox mode
     *
     * @since 1.0.0
     * @since 2.0.0 Removed mode
     */
    public function __construct(Customer $customer, string $apiKey, bool $sandbox)
    {
        $this->setCustomer($customer);
        $this->setApiKey($apiKey);
        $this->setSandbox((bool) $sandbox);
    }

    /**
     * Get REST API Key
     *
     * @return string REST API Key
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    /**
     * Get sandbox mode
     *
     * @return bool
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getSandbox(): bool
    {
        return $this->sandbox;
    }

    /**
     * Set sandbox mode
     *
     * @param bool $sandbox
     *
     * @return PostNL
     *
     * @since 1.0.0
     * @since 2.0.0 Return `self`
     */
    public function setSandbox(bool $sandbox): PostNL
    {
        $this->sandbox = $sandbox;

        return $this;
    }

    /**
     * Get the logger
     *
     * @return LoggerInterface
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    /**
     * Set the logger
     *
     * @param LoggerInterface $logger
     *
     * @return self
     *
     * @since 1.0.0
     * @since 2.0.0 Return `self`
     */
    public function setLogger(?LoggerInterface $logger = null): PostNL
    {
        $this->logger = $logger;
        Client::getInstance()->setLogger($logger);

        return $this;
    }

    /**
     * Get PostNL Customer
     *
     * @return Customer
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * Set PostNL Customer
     *
     * @param Customer $customer
     *
     * @return PostNL
     *
     * @since 1.0.0
     * @since 2.0.0 Return `self`
     */
    public function setCustomer(Customer $customer): PostNL
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Set PostNL Customer
     *
     * @param string $apiKey
     *
     * @return self
     *
     * @since 1.0.0
     * @since 2.0.0 Return `self`
     */
    public function setApiKey(string $apiKey): PostNL
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * GenerateBarcodeRequest service
     *
     * Automatically load the barcode service
     *
     * @return BarcodeService
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getBarcodeService(): BarcodeService
    {
        if (!$this->barcodeService) {
            $this->setBarcodeService(new BarcodeService($this));
        }

        return $this->barcodeService;
    }

    /**
     * Set the barcode service
     *
     * @param BarcodeService $service
     *
     * @return self
     *
     * @since 1.0.0
     * @since 2.0.0 Return `self` / strict typing
     */
    public function setBarcodeService(BarcodeService $service): PostNL
    {
        $this->barcodeService = $service;

        return $this;
    }

    /**
     * Labelling service
     *
     * Automatically load the labelling service
     *
     * @return LabellingService
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getLabellingService(): LabellingService
    {
        if (!$this->labellingService) {
            $this->setLabellingService(new LabellingService($this));
        }

        return $this->labellingService;
    }

    /**
     * Set the labelling service
     *
     * @param LabellingService $service
     *
     * @since 1.0.0
     * @since 2.0.0 Return `self`
     *
     * @return self
     */
    public function setLabellingService(LabellingService $service): PostNL
    {
        $this->labellingService = $service;

        return $this;
    }

    /**
     * ConfirmShipmentRequest service
     *
     * Automatically load the confirming service
     *
     * @return ConfirmingService
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getConfirmingService(): ConfirmingService
    {
        if (!$this->confirmingService) {
            $this->setConfirmingService(new ConfirmingService($this));
        }

        return $this->confirmingService;
    }

    /**
     * Set the confirming service
     *
     * @param ConfirmingService $service
     *
     * @return self
     *
     * @since 1.0.0
     * @since 2.0.0 Return `self`
     */
    public function setConfirmingService(ConfirmingService $service): PostNL
    {
        $this->confirmingService = $service;

        return $this;
    }

    /**
     * Shipping status service
     *
     * Automatically load the shipping status service
     *
     * @return ShippingStatusService
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getShippingStatusService(): ShippingStatusService
    {
        if (!$this->shippingStatusService) {
            $this->setShippingStatusService(new ShippingStatusService($this));
        }

        return $this->shippingStatusService;
    }

    /**
     * Set the shipping status service
     *
     * @param ShippingStatusService $service
     *
     * @return self
     *
     * @since 1.0.0
     * @since 2.0.0 Return `self`
     */
    public function setShippingStatusService(ShippingStatusService $service): PostNL
    {
        $this->shippingStatusService = $service;

        return $this;
    }

    /**
     * Delivery date service
     *
     * Automatically load the delivery date service
     *
     * @return DeliveryDateService
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getDeliveryDateService(): DeliveryDateService
    {
        if (!$this->deliveryDateService) {
            $this->setDeliveryDateService(new DeliveryDateService($this));
        }

        return $this->deliveryDateService;
    }

    /**
     * Set the delivery date service
     *
     * @param DeliveryDateService $service
     *
     * @return self
     *
     * @since 1.0.0
     * @since 2.0.0 Return `self`
     */
    public function setDeliveryDateService(DeliveryDateService $service): PostNL
    {
        $this->deliveryDateService = $service;

        return $this;
    }

    /**
     * Timeframe service
     *
     * Automatically load the timeframe service
     *
     * @return TimeframeService
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getTimeframeService(): TimeframeService
    {
        if (!$this->timeframeService) {
            $this->setTimeframeService(new TimeframeService($this));
        }

        return $this->timeframeService;
    }

    /**
     * Set the timeframe service
     *
     * @param TimeframeService $service
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Return `self`
     */
    public function setTimeframeService(TimeframeService $service): PostNL
    {
        $this->timeframeService = $service;

        return $this;
    }

    /**
     * Location service
     *
     * Automatically load the location service
     *
     * @return LocationService
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getLocationService(): LocationService
    {
        if (!$this->locationService) {
            $this->setLocationService(new LocationService($this));
        }

        return $this->locationService;
    }

    /**
     * Set the location service
     *
     * @param LocationService $service
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Return `self`
     */
    public function setLocationService(LocationService $service): PostNL
    {
        $this->locationService = $service;

        return $this;
    }

    /**
     * Get Basic National Address Check service
     *
     * @return BasicNationalAddressCheckService
     *
     * @since 2.0.0
     */
    public function getBasicNationalAddressCheckService(): BasicNationalAddressCheckService
    {
        if (!$this->basicNationalAddressCheckService) {
            $this->setBasicNationalAddressCheckService(new BasicNationalAddressCheckService($this));
        }

        return $this->basicNationalAddressCheckService;
    }

    /**
     * Set Basic National Address Check service
     *
     * @param BasicNationalAddressCheckService $basicNationalAddressCheckService
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setBasicNationalAddressCheckService(BasicNationalAddressCheckService $basicNationalAddressCheckService): PostNL
    {
        $this->basicNationalAddressCheckService = $basicNationalAddressCheckService;

        return $this;
    }

    /**
     * Get National Address Check service
     *
     * @return NationalAddressCheckService
     *
     * @since 2.0.0
     */
    public function getNationalAddressCheckService(): NationalAddressCheckService
    {
        if (!$this->nationalAddressCheckService) {
            $this->setNationalAddressCheckService(new NationalAddressCheckService($this));
        }

        return $this->nationalAddressCheckService;
    }

    /**
     * Set National Address Check service
     *
     * @param NationalAddressCheckService $nationalAddressCheckService
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setNationalAddressCheckService(NationalAddressCheckService $nationalAddressCheckService): PostNL
    {
        $this->nationalAddressCheckService = $nationalAddressCheckService;

        return $this;
    }

    /**
     * Get National Geo Address Check service
     *
     * @return NationalGeoAddressCheckService
     *
     * @since 2.0.0
     */
    public function getNationalGeoAddressCheckService(): NationalGeoAddressCheckService
    {
        return $this->nationalGeoAddressCheckService;
    }

    /**
     * Set National Geo Address Check service
     *
     * @param NationalGeoAddressCheckService $nationalGeoAddressCheckService
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setNationalGeoAddressCheckService(NationalGeoAddressCheckService $nationalGeoAddressCheckService): PostNL
    {
        $this->nationalGeoAddressCheckService = $nationalGeoAddressCheckService;

        return $this;
    }

    /**
     * Set International Address Check service
     *
     * @return InternationalAddressCheckService
     *
     * @since 2.0.0
     */
    public function getInternationalAddressCheckService(): InternationalAddressCheckService
    {
        return $this->internationalAddressCheckService;
    }

    /**
     * Get International Address Check service
     *
     * @param InternationalAddressCheckService $internationalAddressCheckService
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setInternationalAddressCheckService(InternationalAddressCheckService $internationalAddressCheckService): PostNL
    {
        $this->internationalAddressCheckService = $internationalAddressCheckService;

        return $this;
    }

    /**
     * Generate a single barcode
     *
     * @param string      $type
     * @param string|null $range
     * @param string|null $serie
     * @param bool        $eps
     *
     * @return string The barcode as a string
     *
     * @throws InvalidBarcodeException
     * @throws Exception
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function generateBarcode(string $type = '3S', ?string $range = null, ?string $serie = null, bool $eps = false): string
    {
        if (!in_array($type, ['2S', '3S']) || mb_strlen($type) !== 2) {
            throw new InvalidBarcodeException("GenerateBarcodeRequest type `$type` is invalid");
        }

        if (!$range) {
            if (in_array($type, ['2S', '3S'])) {
                $range = $this->getCustomer()->getCustomerCode();
            } else {
                $range = $this->getCustomer()->getGlobalPackCustomerCode();
            }
        }
        if (!$range) {
            throw new InvalidBarcodeException('Unable to find a valid range');
        }

        if (!$serie) {
            $serie = $this->findBarcodeSerie($type, $range, $eps);
        }

        return $this->getBarcodeService()->generateBarcode(new GenerateBarcodeRequest($type, $range, $serie));
    }

    /**
     * Find a suitable serie for the barcode
     *
     * @param string $type
     * @param string $range
     * @param bool   $eps   Indicates whether it is an EPS Shipment
     *
     * @return string
     *
     * @throws InvalidBarcodeException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function findBarcodeSerie(string $type, string $range, bool $eps): string
    {
        switch ($type) {
            case '2S':
                $serie = '0000000-9999999';

                break;
            case '3S':
                if ($eps) {
                    switch (mb_strlen($range)) {
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
                            throw new InvalidBarcodeException('Invalid range');

                            break;
                    }
                }
                // Regular domestic codes
                $serie = (mb_strlen($range) === 4 ? '987000000-987600000' : '0000000-9999999');

                break;
            default:
                // GlobalPack
                $serie = '0000-9999';

                break;
        }

        return $serie;
    }

    /**
     * Generate a single barcode by country code
     *
     * @param string $iso 2-letter Country ISO Code
     *
     * @return string The GenerateBarcodeRequest as a string
     *
     * @throws CifErrorException
     * @throws CifDownException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws InvalidBarcodeException
     * @throws InvalidConfigurationException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function generateBarcodeByCountryCode(string $iso): string
    {
        if (in_array(strtoupper($iso), static::$threeSCountries)) {
            $range = $this->getCustomer()->getCustomerCode();
            $type = '3S';
        } else {
            $range = $this->getCustomer()->getGlobalPackCustomerCode();
            $type = $this->getCustomer()->getGlobalPackBarcodeType();

            if (!$range) {
                throw new InvalidConfigurationException(
                    'GlobalPack customer code has not been set for the current customer'
                );
            }
            if (!$type) {
                throw new InvalidConfigurationException(
                    'GlobalPack barcode type has not been set for the current customer'
                );
            }
        }

        $serie = $this->findBarcodeSerie(
            $type,
            $range,
            strtoupper($iso) !== 'NL' && in_array(strtoupper($iso), static::$threeSCountries)
        );

        return $this->getBarcodeService()->generateBarcode(new GenerateBarcodeRequest($type, $range, $serie));
    }

    /**
     * Generate a single barcode by country code
     *
     * @param array $isos key = iso code, value = amount of barcodes requested
     *
     * @return array Country isos with the barcode as string
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws InvalidBarcodeException
     * @throws InvalidConfigurationException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function generateBarcodesByCountryCodes(array $isos): array
    {
        $customerCode = $this->getCustomer()->getCustomerCode();
        $globalPackRange = $this->getCustomer()->getGlobalPackCustomerCode();
        $globalPackType = $this->getCustomer()->getGlobalPackBarcodeType();

        $generateBarcodes = [];
        $index = 0;
        foreach ($isos as $iso => $qty) {
            if (in_array(strtoupper($iso), static::$threeSCountries)) {
                $range = $customerCode;
                $type = '3S';
            } else {
                $range = $globalPackRange;
                $type = $globalPackType;

                if (!$range) {
                    throw new InvalidConfigurationException(
                        'GlobalPack customer code has not been set for the current customer'
                    );
                }
                if (!$type) {
                    throw new InvalidConfigurationException(
                        'GlobalPack barcode type has not been set for the current customer'
                    );
                }
            }

            $serie = $this->findBarcodeSerie(
                $type,
                $range,
                strtoupper($iso) !== 'NL' && in_array(strtoupper($iso), static::$threeSCountries)
            );

            for ($i = 0; $i < $qty; $i++) {
                $generateBarcodes[] = (new GenerateBarcodeRequest($type, $range, $serie))->setId("$iso-$index");
                $index++;
            }
        }

        $results = $this->getBarcodeService()->generateBarcodes($generateBarcodes);

        $barcodes = [];
        foreach ($results as $id => $barcode) {
            list($iso) = explode('-', $id);
            if (!isset($barcodes[$iso])) {
                $barcodes[$iso] = [];
            }
            $barcodes[$iso][] = $barcode;
        }

        return $barcodes;
    }

    /**
     * @param Shipment $shipment
     * @param string   $printerType
     * @param bool     $confirm
     *
     * @return GenerateLabelResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function generateLabel(Shipment $shipment, ?string $printerType = 'GraphicFile|PDF', ?bool $confirm = true): GenerateLabelResponse
    {
        return $this->getLabellingService()->generateLabel(new GenerateShipmentLabelRequest([$shipment]), $printerType, $confirm);
    }

    /**
     * Generate or retrieve multiple labels
     *
     * Note that instead of returning a GenerateLabelResponse this function can merge the labels and return a
     * string which contains the PDF with the merged pages as well.
     *
     * @param Shipment[] $shipments     (key = ID) Shipments
     * @param string     $printerType   Printer type, see PostNL dev docs for available types
     * @param bool       $confirm       Immediately confirm the shipments
     * @param bool       $merge         Merge the PDFs and return them in a MyParcel way
     * @param int        $format        A4 or A6
     * @param array      $positions     Set the positions of the A6s on the first A4
     *                                  The indices should be the position number, marked with `true` or `false`
     *                                  These are the position numbers:
     *                                  ```
     *                                  +-+-+
     *                                  |2|4|
     *                                  +-+-+
     *                                  |1|3|
     *                                  +-+-+
     *                                  ```
     *                                  So, for
     *                                  ```
     *                                  +-+-+
     *                                  |x|✔|
     *                                  +-+-+
     *                                  |✔|x|
     *                                  +-+-+
     *                                  ```
     *                                  you would have to pass:
     *                                  ```php
     *                                  [
     *                                  1 => true,
     *                                  2 => false,
     *                                  3 => false,
     *                                  4 => true,
     *                                  ]
     *                                  ```
     *
     * @param string     $a6Orientation A6 orientation (P or L)
     *
     * @return GenerateLabelResponse[]|string
     *
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotSupportedException
     * @throws PostNLClientException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function generateLabels(array $shipments, ?string $printerType = 'GraphicFile|PDF', ?bool $confirm = true, ?bool $merge = false, ?int $format = Label::FORMAT_A4, ?array $positions = [1 => true, 2 => true, 3 => true, 4 => true], ?string $a6Orientation = 'P')
    {
        if ($merge) {
            if ('GraphicFile|PDF' !== $printerType) {
                throw new NotSupportedException('Labels with the chosen printer type cannot be merged');
            }
            foreach ([1, 2, 3, 4] as $i) {
                if (!array_key_exists($i, $positions)) {
                    throw new NotSupportedException('All label positions need to be passed for merge mode');
                }
            }
        }

        $generateLabels = [];
        foreach ($shipments as $uuid => $shipment) {
            $generateLabels[(string) $uuid] = [
                (new GenerateShipmentLabelRequest([$shipment]))->setId((string) $uuid),
                $confirm,
            ];
        }
        $labels = $this->getLabellingService()->generateLabels($generateLabels, $printerType);

        if (!$merge) {
            return $labels;
        }

        foreach ($labels as $label) {
            if (!$label instanceof GenerateLabelResponse) {
                return $labels;
            }
        }

        try {
            // Disable header and footer
            $pdf = new RFPdi('P', 'mm', $format === Label::FORMAT_A4 ? [210, 297] : [105, 148]);
            $deferred = [];
            $firstPage = true;
            if (Label::FORMAT_A6 === $format) {
                foreach ($labels as $label) {
                    $pdfContent = base64_decode($label->getResponseShipments()[0]->getLabels()[0]->getContent());
                    $sizes = Misc::getPdfSizeAndOrientation($pdfContent);
                    if ($sizes['iso'] === 'A6') {
                        $pdf->addPage($a6Orientation);
                        $correction = [0, 0];
                        if ('L' === $a6Orientation && 'P' === $sizes['orientation']) {
                            $correction[0] = -84;
                            $correction[1] = -0.5;
                            $pdf->rotateCounterClockWise();
                        } elseif ('P' === $a6Orientation && 'L' === $sizes['orientation']) {
                            $pdf->rotateCounterClockWise();
                        }
                        $pdf->setSourceFile(StreamReader::createByString($pdfContent));
                        $pdf->useTemplate($pdf->importPage(1), $correction[0], $correction[1]);
                    } else {
                        // Assuming A4 here (could be multi-page) - defer to end
                        $stream = StreamReader::createByString($pdfContent);
                        $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
                    }
                }
            } else {
                $a6s = 4; // Amount of A6s available
                foreach ($labels as $label) {
                    if ($label instanceof PostNLClientException) {
                        throw $label;
                    }
                    $pdfContent = base64_decode($label->getResponseShipments()[0]->getLabels()[0]->getContent());
                    $sizes = Misc::getPdfSizeAndOrientation($pdfContent);
                    if ($sizes['iso'] === 'A6') {
                        if ($firstPage) {
                            $pdf->addPage('P', [297, 210], 90);
                        }
                        $firstPage = false;
                        while (empty($positions[5 - $a6s]) && $a6s >= 1) {
                            $positions[5 - $a6s] = true;
                            $a6s--;
                        }
                        if ($a6s < 1) {
                            $pdf->addPage('P', [297, 210], 90);
                            $a6s = 4;
                        }
                        $pdf->rotateCounterClockWise();
                        $pdf->setSourceFile(StreamReader::createByString($pdfContent));
                        $pdf->useTemplate(
                            $pdf->importPage(1),
                            static::$labelPositions[$a6s][0],
                            static::$labelPositions[$a6s][1]
                        );
                        $a6s--;
                        if ($a6s < 1) {
                            if (end($labels) !== $label) {
                                $pdf->addPage('P', [297, 210], 90);
                            }
                            $a6s = 4;
                        }
                    } else {
                        // Assuming A4 here (could be multi-page) - defer to end
                        if (count($label->getResponseShipments()[0]->getLabels()) > 1) {
                            $stream = [];
                            foreach ($label->getResponseShipments()[0]->getLabels() as $labelContent) {
                                $stream[] = StreamReader::createByString(base64_decode($labelContent->getContent()));
                            }
                            $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
                        } else {
                            $stream = StreamReader::createByString(base64_decode($pdfContent));
                            $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
                        }
                    }
                }
            }
            foreach ($deferred as $defer) {
                $sizes = $defer['sizes'];
                $pdf->addPage($sizes['orientation'], 'A4');
                $pdf->rotateCounterClockWise();
                if (is_array($defer['stream']) && count($defer['stream']) > 1) {
                    // Multi-label
                    if (count($deferred['stream']) === 2) {
                        $pdf->setSourceFile($defer['stream'][0]);
                        $pdf->useTemplate($pdf->importPage(1), -190, 0);
                        $pdf->setSourceFile($defer['stream'][1]);
                        $pdf->useTemplate($pdf->importPage(1), -190, 148);
                    } else {
                        $pdf->setSourceFile($defer['stream'][0]);
                        $pdf->useTemplate($pdf->importPage(1), -190, 0);
                        $pdf->setSourceFile($defer['stream'][1]);
                        $pdf->useTemplate($pdf->importPage(1), -190, 148);
                        for ($i = 2; $i < count($defer['stream']); $i++) {
                            $pages = $pdf->setSourceFile($defer['stream'][$i]);
                            for ($j = 1; $j < $pages + 1; $j++) {
                                $pdf->addPage($sizes['orientation'], 'A4');
                                $pdf->rotateCounterClockWise();
                                $pdf->useTemplate($pdf->importPage(1), -190, 0);
                            }
                        }
                    }
                } else {
                    if (is_resource($defer['stream'])) {
                        $pdf->setSourceFile($defer['stream']);
                    } else {
                        $pdf->setSourceFile($defer['stream'][0]);
                    }
                    $pdf->useTemplate($pdf->importPage(1), -190, 0);
                }
            }

            return $pdf->output('', 'S');
        } catch (Exception $e) {
            throw new PostNLClientException('Unable to generate PDF file', 0, $e);
        }
    }

    /**
     * Confirm a single shipment
     *
     * @param Shipment $shipment
     *
     * @return ConfirmShipmentResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function confirmShipment(Shipment $shipment): ConfirmShipmentResponse
    {
        return $this->getConfirmingService()->confirmShipment(new ConfirmShipmentRequest([$shipment]));
    }

    /**
     * Confirm multiple shipments
     *
     * @param array $shipments
     *
     * @return ConfirmShipmentResponse[]
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function confirmShipments(array $shipments): array
    {
        $confirmations = [];
        foreach ($shipments as $uuid => $shipment) {
            $confirmations[$uuid] = (new ConfirmShipmentRequest([$shipment]))->setId((string) $uuid);
        }

        return $this->getConfirmingService()->confirmShipments($confirmations);
    }

    /**
     * Retrieves a shipment by barcode
     *
     * @param string   $barcode
     *
     * @param bool     $detail
     * @param string   $language
     * @param int|null $maxDays
     *
     * @return Shipment
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function retrieveShipmentByBarcode(string $barcode, bool $detail = false, string $language = 'NL', ?int $maxDays = null): Shipment
    {
        return $this->getShippingStatusService()->retrieveShipment(
            (new RetrieveShipmentByBarcodeRequest())
                ->setBarcode($barcode)
                ->setDetail($detail)
                ->setLanguage($language)
                ->setMaxDays($maxDays)
        );
    }

    /**
     * Retrieves a shipment by reference
     *
     * @param string   $reference
     *
     * @param bool     $detail
     * @param string   $language
     * @param int|null $maxDays
     *
     * @return Shipment
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function retrieveShipmentByReference(string $reference, bool $detail = false, string $language = 'NL', ?int $maxDays = null): Shipment
    {
        return $this->getShippingStatusService()->retrieveShipment(
            (new RetrieveShipmentByReferenceRequest())
                ->setReference($reference)
                ->setDetail($detail)
                ->setLanguage($language)
                ->setMaxDays($maxDays)
        );
    }

    /**
     * Retrieves a shipment by kennisgeving ID
     *
     * @param string   $kgid
     *
     * @param bool     $detail
     * @param string   $language
     * @param int|null $maxDays
     *
     * @return Shipment
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function retrieveShipmentByKgid(string $kgid, bool $detail = false, string $language = 'NL', ?int $maxDays = null): Shipment
    {
        return $this->getShippingStatusService()->retrieveShipment(
            (new RetrieveShipmentByKgidRequest())
                ->setKgid($kgid)
                ->setDetail($detail)
                ->setLanguage($language)
                ->setMaxDays($maxDays)
        );
    }

    /**
     * Retrieve a signature by barcode
     *
     * @param string $barcode
     *
     * @return Signature
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function retrieveSignatureByBarcode(string $barcode): Signature
    {
        return $this->getShippingStatusService()->retrieveSignature(
            (new RetrieveSignatureByBarcodeRequest())
                ->setBarcode($barcode)
        );
    }

    /**
     * Get a delivery date
     *
     * @param string      $shippingDate
     * @param int         $shippingDuration
     * @param string      $cutOffTime
     * @param string      $postalCode
     * @param string|null $countryCode
     * @param string|null $originCountryCode
     * @param string|null $city
     * @param string|null $street
     * @param array|null  $options
     * @param array|null  $cutOffTimes
     *
     * @return CalculateDeliveryDateResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function calculateDeliveryDate(string $shippingDate, int $shippingDuration, string $cutOffTime, string $postalCode, ?string $countryCode = null, ?string $originCountryCode = null, ?string $city = null, ?string $street = null, ?array $options = ['Daytime'], ?array $cutOffTimes = null): CalculateDeliveryDateResponse
    {
        return $this->getDeliveryDateService()->calculateDeliveryDate(
            (new CalculateDeliveryDateRequest())
                ->setShippingDate($shippingDate)
                ->setShippingDuration($shippingDuration)
                ->setCutOffTime($cutOffTime)
                ->setCountryCode($countryCode)
                ->setOriginCountryCode($originCountryCode)
                ->setPostalCode($postalCode)
                ->setCity($city)
                ->setStreet($street)
                ->setOptions($options)
                ->setAvailableMonday($cutOffTimes[1][0] ?: null)
                ->setCutOffTimeMonday($cutOffTimes[1][1] ?: null)
                ->setAvailableTuesday($cutOffTimes[2][0] ?: null)
                ->setCutOffTimeTuesday($cutOffTimes[2][1] ?: null)
                ->setAvailableWednesday($cutOffTimes[3][0] ?: null)
                ->setCutOffTimeWednesday($cutOffTimes[3][1] ?: null)
                ->setAvailableThursday($cutOffTimes[4][0] ?: null)
                ->setCutOffTimeThursday($cutOffTimes[4][1] ?: null)
                ->setAvailableFriday($cutOffTimes[5][0] ?: null)
                ->setCutOffTimeFriday($cutOffTimes[5][1] ?: null)
                ->setAvailableSaturday($cutOffTimes[6][0] ?: null)
                ->setCutOffTimeSaturday($cutOffTimes[6][1] ?: null)
                ->setAvailableSunday($cutOffTimes[0][0] ?: null)
                ->setCutOffTimeSunday($cutOffTimes[0][1] ?: null)
        );
    }

    /**
     * Get a shipping date
     *
     * @param string      $deliveryDate
     * @param int         $shippingDuration
     * @param string      $postalCode
     * @param string|null $countryCode
     * @param string|null $originCountryCode
     * @param string|null $city
     * @param string|null $street
     * @param int|null    $houseNumber
     * @param string|null $houseNumberExtension
     *
     * @return CalculateShippingDateResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function calculateShippingDate(string $deliveryDate, int $shippingDuration, string $postalCode, ?string $countryCode = null, ?string $originCountryCode = null, ?string $city = null, ?string $street = null, ?int $houseNumber = null, ?string $houseNumberExtension = null): CalculateShippingDateResponse
    {
        return $this->getDeliveryDateService()->calculateShippingDate(
            (new CalculateShippingDateRequest())
                ->setDeliveryDate($deliveryDate)
                ->setShippingDuration($shippingDuration)
                ->setPostalCode($postalCode)
                ->setCountryCode($countryCode)
                ->setOriginCountryCode($originCountryCode)
                ->setCity($city)
                ->setStreet($street)
                ->setHouseNumber($houseNumber)
                ->setHouseNrExt($houseNumberExtension)
        );
    }

    /**
     * Get timeframes
     *
     * @param string      $startDate
     * @param string      $endDate
     * @param string      $postalCode
     * @param int         $houseNumber
     * @param string|null $houseNumberExtension
     * @param string      $countryCode
     * @param string|null $street
     * @param string|null $city
     * @param bool        $allowSundaySorting
     * @param array       $options
     * @param int|null    $interval
     * @param string|null $timeframeRange
     *
     * @return CalculateTimeframesResponse
     *
     * @throws InvalidArgumentException
     * @throws Exception
     * @throws HttpClientException
     *
     * @since 2.0.0
     */
    public function calculateTimeframes(string $startDate, string $endDate, string $postalCode, int $houseNumber, ?string $houseNumberExtension = null, string $countryCode = 'NL', ?string $street = null, ?string $city = null, bool $allowSundaySorting = false, array $options = ['Daytime'], ?int $interval = null, ?string $timeframeRange = null)
    {
        return $this->getTimeframeService()->getTimeframes(
            (new CalculateTimeframesRequest())
                ->setStartDate($startDate)
                ->setEndDate($endDate)
                ->setPostalCode($postalCode)
                ->setHouseNumber($houseNumber)
                ->setHouseNrExt($houseNumberExtension)
                ->setStreet($street)
                ->setCity($city)
                ->setCountryCode($countryCode)
                ->setAllowSundaySorting($allowSundaySorting)
                ->setOptions($options)
                ->setInterval($interval)
                ->setTimeframeRange($timeframeRange)
        );
    }

    /**
     * Find nearest locations
     *
     * @param string      $postalCode
     * @param string      $countryCode
     * @param array       $deliveryOptions
     * @param string|null $city
     * @param string|null $street
     * @param int|null    $houseNumber
     * @param string|null $deliveryDate
     * @param string|null $openingTime
     *
     * @return FindNearestLocationsResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws InvalidArgumentException
     * @throws HttpClientException
     *
     * @since 2.0.0
     */
    public function findNearestLocations(string $postalCode, string $countryCode, array $deliveryOptions, ?string $city = null, ?string $street = null, ?int $houseNumber = null, ?string $deliveryDate = null, ?string $openingTime = null)
    {
        return $this->getLocationService()->findNearestLocations(
            (new FindNearestLocationsRequest())
                ->setPostalCode($postalCode)
                ->setCountrycode($countryCode)
                ->setDeliveryOptions($deliveryOptions)
                ->setCity($city)
                ->setStreet($street)
                ->setHouseNumber($houseNumber)
                ->setDeliveryDate($deliveryDate)
                ->setOpeningTime($openingTime)
        );
    }

    /**
     * Find nearest locations by coordinates
     *
     * @param float|string $latitude
     * @param float|string $longitude
     * @param string       $countryCode
     * @param array        $deliveryOptions
     * @param string|null  $deliveryDate
     * @param string|null  $openingTime
     *
     * @return FindNearestLocationsGeocodeResponse
     *
     * @throws InvalidArgumentException
     * @throws Exception
     * @throws HttpClientException
     *
     * @since 2.0.0
     */
    public function findNearestLocationsGeocode($latitude, $longitude, string $countryCode, array $deliveryOptions = ['PG'], ?string $deliveryDate = null, ?string $openingTime = null)
    {
        return $this->getLocationService()->findNearestLocationsGeocode(
            (new FindNearestLocationsGeocodeRequest())
                ->setLatitude($latitude)
                ->setLongitude($longitude)
                ->setCountrycode($countryCode)
                ->setDeliveryOptions($deliveryOptions)
                ->setDeliveryDate($deliveryDate)
                ->setOpeningTime($openingTime)
        );
    }

    /**
     * All-in-one function for checkout widgets. It retrieves and returns the
     * - timeframes
     * - locations
     * - delivery date
     *
     * @param CalculateTimeframesRequest   $calculateTimeframes
     * @param FindNearestLocationsRequest  $getNearestLocations
     * @param CalculateDeliveryDateRequest $getDeliveryDate
     *
     * @return array [uuid => CalculateTimeframesResponse, uuid => FindNearestLocationsResponse, uuid => CalculateDeliveryDateResponse]
     *
     * @throws InvalidArgumentException
     * @throws Exception
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getTimeframesAndNearestLocations(CalculateTimeframesRequest $calculateTimeframes, FindNearestLocationsRequest $getNearestLocations, CalculateDeliveryDateRequest $getDeliveryDate)
    {
        $results = [];
        $itemTimeframe = $this->getTimeframeService()->retrieveCachedItem($calculateTimeframes->getId());
        if ($itemTimeframe instanceof CacheItemInterface && $itemTimeframe->get()) {
            $results['timeframes'] = UtilMessage::parseResponse($itemTimeframe->get());
        }
        $itemLocation = $this->getLocationService()->retrieveCachedItem($getNearestLocations->getId());
        if ($itemLocation instanceof CacheItemInterface && $itemLocation->get()) {
            $results['locations'] = UtilMessage::parseResponse($itemLocation->get());
        }
        $itemDeliveryDate = $this->getDeliveryDateService()->retrieveCachedItem($getDeliveryDate->getId());
        if ($itemDeliveryDate instanceof CacheItemInterface && $itemDeliveryDate->get()) {
            $results['delivery_date'] = UtilMessage::parseResponse($itemDeliveryDate->get());
        }

        $client = Client::getInstance();
        $client->addOrUpdateRequest(
            'timeframes',
            $this->getTimeframeService()->buildCalculateTimeframesRequest($calculateTimeframes)
        );
        $client->addOrUpdateRequest(
            'locations',
            $this->getLocationService()->buildFindNearestLocationsRequest($getNearestLocations)
        );
        $client->addOrUpdateRequest(
            'delivery_date',
            $this->getDeliveryDateService()->buildCalculateDeliveryDateRequest($getDeliveryDate)
        );

        $responses = $client->doRequests();
        foreach ($responses as $uuid => $response) {
            if ($response instanceof ResponseInterface) {
                $results[$uuid] = $response;
            } else {
                if ($response instanceof Exception) {
                    throw $response;
                }
                throw new InvalidArgumentException('Invalid multi-request');
            }
        }

        foreach ($responses as $type => $response) {
            if (!$response instanceof ResponseInterface) {
                if ($response instanceof Exception) {
                    throw $response;
                }
                throw new InvalidArgumentException('Invalid multi-request');
            } elseif ($response->getStatusCode() === 200) {
                switch ($type) {
                    case 'timeframes':
                        if ($itemTimeframe instanceof CacheItemInterface) {
                            $itemTimeframe->set(UtilMessage::str($response));
                            $this->getTimeframeService()->cacheItem($itemTimeframe);
                        }

                        break;
                    case 'locations':
                        if ($itemTimeframe instanceof CacheItemInterface) {
                            $itemLocation->set(UtilMessage::str($response));
                            $this->getLocationService()->cacheItem($itemLocation);
                        }

                        break;
                    case 'delivery_date':
                        if ($itemTimeframe instanceof CacheItemInterface) {
                            $itemDeliveryDate->set(UtilMessage::str($response));
                            $this->getDeliveryDateService()->cacheItem($itemDeliveryDate);
                        }

                        break;
                }
            }
        }

        return [
            'timeframes'    => $this->getTimeframeService()->processGetTimeframesResponse($results['timeframes']),
            'locations'     => $this->getLocationService()->processFindNearestLocationsResponse($results['locations']),
            'delivery_date' => $this->getDeliveryDateService()->processCalculateDeliveryDateResponse($results['delivery_date']),
        ];
    }

    /**
     * Get locations in area
     *
     * @param FindNearestLocationsGeocodeRequest $getLocationsInArea
     *
     * @return FindNearestLocationsGeocodeResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getLocationsInArea(FindNearestLocationsGeocodeRequest $getLocationsInArea)
    {
        return $this->getLocationService()->findNearestLocationsGeocode($getLocationsInArea);
    }

    /**
     * Get locations in area
     *
     * @param LookupLocationRequest $getLocation
     *
     * @return Location
     *
     * @throws Exception
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getLocation(LookupLocationRequest $getLocation)
    {
        return $this->getLocationService()->lookupLocation($getLocation);
    }

    /**
     * Basic national address check
     *
     * @param string      $postalCode  Must be 6P format, e.g. 1234AB
     * @param string|null $houseNumber House number is optional
     *
     * @return BasicNationalAddressCheckResponse
     *
     * @throws CifDownException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function basicNationalAddressCheck(string $postalCode, ?string $houseNumber = null): BasicNationalAddressCheckResponse
    {
        return $this->getBasicNationalAddressCheckService()->checkAddress(
            (new BasicNationalAddressCheckRequest())
                ->setPostalCode($postalCode)
                ->setHouseNumber($houseNumber)
        );
    }

    /**
     * Check national address
     *
     * @param string|null $street
     * @param string|null $houseNumber
     * @param string|null $addition
     * @param string|null $postalCode
     * @param string|null $city
     *
     * @return ValidatedAddress
     *
     * @throws CifDownException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function nationalAddressCheck(?string $street = null, ?string $houseNumber = null, ?string $addition = null, ?string $postalCode = null, ?string $city = null): ValidatedAddress
    {
        return $this->getNationalAddressCheckService()->checkAddress(
            (new NationalAddressCheckRequest())
                ->setStreet($street)
                ->setHouseNumber($houseNumber)
                ->setAddition($addition)
                ->setPostalCode($postalCode)
                ->setCity($city)
        );
    }

    /**
     * Geo check national address
     *
     * @param string|null $street
     * @param string|null $houseNumber
     * @param string|null $addition
     * @param string|null $postalCode
     * @param string|null $city
     *
     * @return ValidatedAddress
     *
     * @throws CifDownException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function nationalGeoAddressCheck(?string $street = null, ?string $houseNumber = null, ?string $addition = null, ?string $postalCode = null, ?string $city = null): ValidatedAddress
    {
        return $this->getNationalGeoAddressCheckService()->checkAddress(
            (new NationalGeoAddressCheckRequest())
                ->setStreet($street)
                ->setHouseNumber($houseNumber)
                ->setAddition($addition)
                ->setPostalCode($postalCode)
                ->setCity($city)
        );
    }

    /**
     * Check international address
     *
     * @param string|null       $country              ISO 3166-1 alpha 3 country code
     * @param string|array|null $streetOrAddressLines Street name or full address lines
     * @param string|null       $houseNumber
     * @param string|null       $postalCode
     * @param string|null       $city
     * @param string|null       $building
     * @param string|null       $subBuilding
     *
     * @return ValidatedAddress
     *
     * @throws CifDownException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function internationalAddressCheck($country = null, ?string $streetOrAddressLines = null, ?string $houseNumber = null, ?string $postalCode = null, ?string $city = null, ?string $building = null, ?string $subBuilding = null): ValidatedAddress
    {
        if (is_array($streetOrAddressLines)) {
            return $this->getInternationalAddressCheckService()->checkAddress((new InternationalAddressCheckRequest($country, $streetOrAddressLines)));
        }

        return $this->getInternationalAddressCheckService()->checkAddress(
            (new InternationalAddressCheckRequest())
                ->setCountry($country)
                ->setStreet($streetOrAddressLines)
                ->setHouseNumber($houseNumber)
                ->setPostalCode($postalCode)
                ->setCity($city)
                ->setBuilding($building)
                ->setSubBuilding($subBuilding)
        );
    }
}
