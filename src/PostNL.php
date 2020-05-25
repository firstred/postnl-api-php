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

namespace Firstred\PostNL;

use Exception;
use Firstred\PostNL\Entity\AddressInterface;
use Firstred\PostNL\Entity\CustomerInterface;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\CutOffTimeInterface;
use Firstred\PostNL\Entity\Label;
use Firstred\PostNL\Entity\LocationInterface;
use Firstred\PostNL\Entity\Request\CalculateDeliveryDateRequest;
use Firstred\PostNL\Entity\Request\CalculateShippingDateRequest;
use Firstred\PostNL\Entity\Request\CalculateTimeframesRequest;
use Firstred\PostNL\Entity\Request\CalculateTimeframesRequestInterface;
use Firstred\PostNL\Entity\Request\ConfirmShipmentRequest;
use Firstred\PostNL\Entity\Request\FindDeliveryInfoRequest;
use Firstred\PostNL\Entity\Request\FindLocationsInAreaRequest;
use Firstred\PostNL\Entity\Request\FindNearestLocationsGeocodeRequest;
use Firstred\PostNL\Entity\Request\FindNearestLocationsRequest;
use Firstred\PostNL\Entity\Request\GenerateBarcodeRequestEntityInterface;
use Firstred\PostNL\Entity\Request\GenerateShipmentLabelRequest;
use Firstred\PostNL\Entity\Request\LookupLocationRequest;
use Firstred\PostNL\Entity\Request\PostalCodeCheckRequest;
use Firstred\PostNL\Entity\Request\RetrieveShipmentByBarcodeRequest;
use Firstred\PostNL\Entity\Request\RetrieveShipmentByReferenceRequest;
use Firstred\PostNL\Entity\Request\RetrieveSignatureByBarcodeRequest;
use Firstred\PostNL\Entity\Response\CalculateDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\CalculateShippingDateResponse;
use Firstred\PostNL\Entity\Response\CalculateTimeframesResponse;
use Firstred\PostNL\Entity\Response\ConfirmShipmentResponse;
use Firstred\PostNL\Entity\Response\FindDeliveryInfoResponse;
use Firstred\PostNL\Entity\Response\FindLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\FindNearestLocationsGeocodeResponse;
use Firstred\PostNL\Entity\Response\FindNearestLocationsResponse;
use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Entity\ShipmentInterface;
use Firstred\PostNL\Entity\SignatureInterface;
use Firstred\PostNL\Entity\ValidatedAddressInterface;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifErrorException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidBarcodeException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\PostNLClientException;
use Firstred\PostNL\Factory\EntityFactoryInterface;
use Firstred\PostNL\Misc\Message as UtilMessage;
use Firstred\PostNL\Misc\Misc;
use Firstred\PostNL\Misc\RFPdi;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use Http\Client\Exception as HttpClientException;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use setasign\Fpdi\PdfParser\StreamReader;

/**
 * Class PostNL.
 */
class PostNL
{
    const VERSION = '2.0.0';

    /**
     * The PostNL Customer to be used for requests.
     *
     * @var CustomerInterface
     */
    private $customer;

    /**
     * Entity factory.
     *
     * @var EntityFactoryInterface
     */
    private $entityFactory;

    /**
     * Barcode service.
     *
     * @var BarcodeServiceInterface
     */
    private $barcodeService;

    /** @var LoggerInterface */
    private $logger;

    /**
     * The PostNL API key to be used for requests.
     *
     * @var string
     */
    private $apiKey;

    /**
     * Sandbox mode.
     *
     * @var bool
     */
    private $sandbox;

    /**
     * 3S countries.
     *
     * @var array
     */
    private $threeSCountries;

    private $barcodeTypes;

    /**
     * PostNL constructor.
     *
     * @since 1.0.0
     */
    public function __construct(
        CustomerInterface $customer,
        EntityFactoryInterface $entityFactory,
        BarcodeServiceInterface $barcodeService,
        LoggerInterface $logger,
        string $apiKey,
        bool $sandbox,
        array $threeSCountries,
        array $barcodeTypes
    ) {
        $this->customer = $customer;
        $this->entityFactory = $entityFactory;
        $this->barcodeService = $barcodeService;
        $this->logger = $logger;
        $this->apiKey = $apiKey;
        $this->sandbox = $sandbox;
        $this->threeSCountries = $threeSCountries;
        $this->barcodeTypes = $barcodeTypes;
    }

    /**
     * Generate a single barcode.
     *
     * @param string      $type
     * @param string|null $range
     * @param string|null $serie
     * @param bool        $eps
     *
     * @return string The barcode as a string
     *
     * @throws InvalidBarcodeException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function generateBarcode(string $type = '3S', ?string $range = null, ?string $serie = null, bool $eps = false): string
    {
        if (!in_array($type, $this->barcodeTypes)) {
            throw new InvalidBarcodeException("GenerateBarcodeRequest type `$type` is invalid");
        }

        if (!$range) {
            if (in_array($type, ['2S', '3S'])) {
                $range = $this->customer->getCustomerCode();
            } else {
                $range = $this->customer->getGlobalPackCustomerCode();
            }
        }
        if (!$range) {
            throw new InvalidBarcodeException('Unable to find a valid range');
        }

        if (!$serie) {
            $serie = static::findBarcodeSerie($type, $range, $eps);
        }

        /** @var GenerateBarcodeRequestEntityInterface $generateBarcodeRequest */
        $generateBarcodeRequest = $this->entityFactory->create(
            GenerateBarcodeRequestEntityInterface::class,
            [
                'Type'  => $type,
                'Range' => $range,
                'Serie' => $serie,
            ]
        );

        return $this->barcodeService->generateBarcode($generateBarcodeRequest);
    }

    /**
     * Find a suitable serie for the barcode.
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
    public static function findBarcodeSerie(string $type, string $range, bool $eps): string
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
                $serie = (4 === mb_strlen($range) ? '987000000-987600000' : '0000000-9999999');

                break;
            default:
                // GlobalPack
                $serie = '0000-9999';

                break;
        }

        return $serie;
    }

    /**
     * Generate a single barcode by country code.
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
        if (in_array(strtoupper($iso), $this->threeSCountries)) {
            $range = $this->customer->getCustomerCode();
            $type = '3S';
        } else {
            $range = $this->customer->getGlobalPackCustomerCode();
            $type = $this->customer->getGlobalPackBarcodeType();

            if (!$range) {
                throw new InvalidConfigurationException('GlobalPack customer code has not been set for the current customer');
            }
            if (!$type) {
                throw new InvalidConfigurationException('GlobalPack barcode type has not been set for the current customer');
            }
        }

        $serie = $this->findBarcodeSerie(
            $type,
            $range,
            'NL' !== strtoupper($iso) && in_array(strtoupper($iso), $this->threeSCountries)
        );

        /** @var GenerateBarcodeRequestEntityInterface $generateBarcodeRequest */
        $generateBarcodeRequest = $this->entityFactory->create(
            GenerateBarcodeRequestEntityInterface::class,
            [
                'Type'  => $type,
                'Range' => $range,
                'Serie' => $serie,
            ]
        );

        return $this->barcodeService->generateBarcode($generateBarcodeRequest);
    }

    /**
     * Generate a single barcode by country code.
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
                    throw new InvalidConfigurationException('GlobalPack customer code has not been set for the current customer');
                }
                if (!$type) {
                    throw new InvalidConfigurationException('GlobalPack barcode type has not been set for the current customer');
                }
            }

            $serie = $this->findBarcodeSerie(
                $type,
                $range,
                'NL' !== strtoupper($iso) && in_array(strtoupper($iso), static::$threeSCountries)
            );

            for ($i = 0; $i < $qty; ++$i) {
                $generateBarcodes[] = (new GenerateBarcodeRequest($type, $range, $serie))->setId("$iso-$index");
                ++$index;
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
     * @param ShipmentInterface $shipment
     * @param string            $printerType
     * @param bool              $confirm
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
    public function generateLabel(ShipmentInterface $shipment, ?string $printerType = 'GraphicFile|PDF', ?bool $confirm = true): GenerateLabelResponse
    {
        return $this->getLabellingService()->generateLabel(new GenerateShipmentLabelRequest([$shipment]), $printerType, $confirm);
    }

    /**
     * Generate or retrieve multiple labels.
     *
     * Note that instead of returning a GenerateLabelResponse this function can merge the labels and return a
     * string which contains the PDF with the merged pages as well.
     *
     * @param ShipmentInterface[] $shipments     (key = ID) Shipments
     * @param string              $printerType   Printer type, see PostNL dev docs for available types
     * @param bool                $confirm       Immediately confirm the shipments
     * @param bool                $merge         Merge the PDFs and return them in a MyParcel way
     * @param int                 $format        A4 or A6
     * @param array               $positions     Set the positions of the A6s on the first A4
     *                                           The indices should be the position number, marked with `true` or `false`
     *                                           These are the position numbers:
     *                                           ```
     *                                           +-+-+
     *                                           |2|4|
     *                                           +-+-+
     *                                           |1|3|
     *                                           +-+-+
     *                                           ```
     *                                           So, for
     *                                           ```
     *                                           +-+-+
     *                                           |x|✔|
     *                                           +-+-+
     *                                           |✔|x|
     *                                           +-+-+
     *                                           ```
     *                                           you would have to pass:
     *                                           ```php
     *                                           [
     *                                           1 => true,
     *                                           2 => false,
     *                                           3 => false,
     *                                           4 => true,
     *                                           ]
     *                                           ```
     * @param string              $a6Orientation A6 orientation (P or L)
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
            $pdf = new RFPdi('P', 'mm', Label::FORMAT_A4 === $format ? [210, 297] : [105, 148]);
            $deferred = [];
            $firstPage = true;
            if (Label::FORMAT_A6 === $format) {
                foreach ($labels as $label) {
                    $pdfContent = base64_decode($label->getResponseShipments()[0]->getLabels()[0]->getContent());
                    $sizes = Misc::getPdfSizeAndOrientation($pdfContent);
                    if ('A6' === $sizes['iso']) {
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
                    if ('A6' === $sizes['iso']) {
                        if ($firstPage) {
                            $pdf->addPage('P', [297, 210], 90);
                        }
                        $firstPage = false;
                        while (empty($positions[5 - $a6s]) && $a6s >= 1) {
                            $positions[5 - $a6s] = true;
                            --$a6s;
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
                        --$a6s;
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
                    if (2 === count($deferred['stream'])) {
                        $pdf->setSourceFile($defer['stream'][0]);
                        $pdf->useTemplate($pdf->importPage(1), -190, 0);
                        $pdf->setSourceFile($defer['stream'][1]);
                        $pdf->useTemplate($pdf->importPage(1), -190, 148);
                    } else {
                        $pdf->setSourceFile($defer['stream'][0]);
                        $pdf->useTemplate($pdf->importPage(1), -190, 0);
                        $pdf->setSourceFile($defer['stream'][1]);
                        $pdf->useTemplate($pdf->importPage(1), -190, 148);
                        for ($i = 2; $i < count($defer['stream']); ++$i) {
                            $pages = $pdf->setSourceFile($defer['stream'][$i]);
                            for ($j = 1; $j < $pages + 1; ++$j) {
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
     * Confirm a single shipment.
     *
     * @param ShipmentInterface $shipment
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
    public function confirmShipment(ShipmentInterface $shipment): ConfirmShipmentResponse
    {
        return $this->getConfirmingService()->confirmShipment(new ConfirmShipmentRequest([$shipment]));
    }

    /**
     * Confirm multiple shipments.
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
     * Retrieves a shipment by barcode.
     *
     * @param string   $barcode
     * @param bool     $detail
     * @param string   $language
     * @param int|null $maxDays
     *
     * @return ShipmentInterface
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     * @see   https://developer.postnl.nl/browse-apis/send-and-track/shippingstatus-webservice/testtool-rest/#/default/get_v2_status_barcode__barcode_
     */
    public function retrieveShipmentByBarcode(string $barcode, bool $detail = false, string $language = 'NL', ?int $maxDays = null): ShipmentInterface
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
     * Retrieves a shipment by reference.
     *
     * @param string   $reference
     * @param bool     $detail
     * @param string   $language
     * @param int|null $maxDays
     *
     * @return ShipmentInterface
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     * @see   https://developer.postnl.nl/browse-apis/send-and-track/shippingstatus-webservice/testtool-rest/#/default/get_v2_status_reference__referenceId_
     */
    public function retrieveShipmentByReference(string $reference, bool $detail = false, string $language = 'NL', ?int $maxDays = null): ShipmentInterface
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
     * Retrieves a shipment by kennisgeving ID.
     *
     * @param string   $kgid
     * @param bool     $detail
     * @param string   $language
     * @param int|null $maxDays
     *
     * @return ShipmentInterface
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     * @see   https://developer.postnl.nl/browse-apis/send-and-track/shippingstatus-webservice/testtool-rest/#/default/get_v2_status_lookup__kgid_
     */
    public function retrieveShipmentByKgid(string $kgid, bool $detail = false, string $language = 'NL', ?int $maxDays = null): ShipmentInterface
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
     * Retrieve a signature by barcode.
     *
     * @param string $barcode
     *
     * @return SignatureInterface
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     * @see   https://developer.postnl.nl/browse-apis/send-and-track/shippingstatus-webservice/testtool-rest/#/default/get_v2_status_signature__barcode_
     */
    public function retrieveSignatureByBarcode(string $barcode): SignatureInterface
    {
        return $this->getShippingStatusService()->retrieveSignature(
            (new RetrieveSignatureByBarcodeRequest())
                ->setBarcode($barcode)
        );
    }

    /**
     * Get a delivery date.
     *
     * @param string                $shippingDate
     * @param int                   $shippingDuration
     * @param string                $cutOffTime
     * @param string                $postalCode
     * @param string|null           $countryCode
     * @param string|null           $originCountryCode
     * @param string|null           $city
     * @param string|null           $street
     * @param array|null            $options
     * @param CutOffTimeInterface[] $cutOffTimes
     *
     * @return CalculateDeliveryDateResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     * @see   https://developer.postnl.nl/browse-apis/delivery-options/deliverydate-webservice/testtool-rest/#/DeliveryDate/get_v2_2_calculate_date_delivery
     */
    public function calculateDeliveryDate(string $shippingDate, int $shippingDuration, string $cutOffTime, string $postalCode, ?string $countryCode = null, ?string $originCountryCode = null, ?string $city = null, ?string $street = null, ?array $options = ['Daytime'], ?array $cutOffTimes = []): CalculateDeliveryDateResponse
    {
        $deliveryDateRequest = (new CalculateDeliveryDateRequest())
            ->setShippingDate($shippingDate)
            ->setShippingDuration($shippingDuration)
            ->setCutOffTime($cutOffTime)
            ->setCountryCode($countryCode)
            ->setOriginCountryCode($originCountryCode)
            ->setPostalCode($postalCode)
            ->setCity($city)
            ->setStreet($street)
            ->setOptions($options);
        foreach ($cutOffTimes as $cutOffTime) {
            switch ($cutOffTime->getDay()) {
                case CutOffTime::MONDAY:
                    $deliveryDateRequest
                        ->setAvailableMonday($cutOffTime->getAvailable())
                        ->setCutOffTimeMonday($cutOffTime->getTime());
                    break;
                case CutOffTime::TUESDAY:
                    $deliveryDateRequest
                        ->setAvailableTuesday($cutOffTime->getAvailable())
                        ->setCutOffTimeTuesday($cutOffTime->getTime());
                    break;
                case CutOffTime::WEDNESDAY:
                    $deliveryDateRequest
                        ->setAvailableWednesday($cutOffTime->getAvailable())
                        ->setCutOffTimeWednesday($cutOffTime->getTime());
                    break;
                case CutOffTime::THURSDAY:
                    $deliveryDateRequest
                        ->setAvailableThursday($cutOffTime->getAvailable())
                        ->setCutOffTimeThursday($cutOffTime->getTime());
                    break;
                case CutOffTime::FRIDAY:
                    $deliveryDateRequest
                        ->setAvailableFriday($cutOffTime->getAvailable())
                        ->setCutOffTimeFriday($cutOffTime->getTime());
                    break;
                case CutOffTime::SATURDAY:
                    $deliveryDateRequest
                        ->setAvailableSaturday($cutOffTime->getAvailable())
                        ->setCutOffTimeSaturday($cutOffTime->getTime());
                    break;
                case CutOffTime::SUNDAY:
                    $deliveryDateRequest
                        ->setAvailableSunday($cutOffTime->getAvailable())
                        ->setCutOffTimeSunday($cutOffTime->getTime());
                    break;
            }
        }

        return $this->getDeliveryDateService()->calculateDeliveryDate($deliveryDateRequest);
    }

    /**
     * Get a shipping date.
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
     * @see   https://developer.postnl.nl/browse-apis/delivery-options/deliverydate-webservice/testtool-rest/#/ShippingDate/get_v2_2_calculate_date_shipping
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
     * Get timeframes.
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
     * @see   https://developer.postnl.nl/browse-apis/delivery-options/timeframe-webservice/
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
     * Find nearest locations.
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
     * @see   https://developer.postnl.nl/browse-apis/delivery-options/location-webservice/testtool-rest/#/default/get_v2_1_locations_nearest
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
     * Find nearest locations by coordinates.
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
     * @see   https://developer.postnl.nl/browse-apis/delivery-options/location-webservice/testtool-rest/#/default/get_v2_1_locations_nearest_geocode
     */
    public function findNearestLocationsGeocode($latitude, $longitude, string $countryCode, array $deliveryOptions = ['PG'], ?string $deliveryDate = null, ?string $openingTime = null): FindNearestLocationsGeocodeResponse
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
     * - delivery date.
     *
     * @param CalculateTimeframesRequestInterface $calculateTimeframes
     * @param FindNearestLocationsRequest         $getNearestLocations
     * @param CalculateDeliveryDateRequest        $getDeliveryDate
     *
     * @return array [uuid => CalculateTimeframesResponse, uuid => FindNearestLocationsResponse, uuid => CalculateDeliveryDateResponse]
     *
     * @throws InvalidArgumentException
     * @throws Exception
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   https://developer.postnl.nl/browse-apis/delivery-options/
     */
    public function getTimeframesAndNearestLocations(CalculateTimeframesRequestInterface $calculateTimeframes, FindNearestLocationsRequest $getNearestLocations, CalculateDeliveryDateRequest $getDeliveryDate): array
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
            } elseif (200 === $response->getStatusCode()) {
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
     * Get locations in area.
     *
     * @param FindLocationsInAreaRequest $findLocations
     *
     * @return FindLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   https://developer.postnl.nl/browse-apis/delivery-options/location-webservice/testtool-rest/#/default/get_v2_1_locations_area
     */
    public function getLocationsInArea(FindLocationsInAreaRequest $findLocations): FindLocationsInAreaResponse
    {
        return $this->getLocationService()->findLocationsInArea($findLocations);
    }

    /**
     * Get locations in area.
     *
     * @param LookupLocationRequest $getLocation
     *
     * @return LocationInterface
     *
     * @throws Exception
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   https://developer.postnl.nl/browse-apis/delivery-options/location-webservice/testtool-rest/#/default/get_v2_1_locations_lookup
     */
    public function getLocation(LookupLocationRequest $getLocation): LocationInterface
    {
        return $this->getLocationService()->lookupLocation($getLocation);
    }

    /**
     * Basic national address check.
     *
     * @param string      $postalCode  Must be 6P format, e.g. 1234AB
     * @param string|null $houseNumber House number is optional
     *
     * @return BasicNationalAddressCheckResponse
     *
     * @throws CifDownException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws CifErrorException
     *
     * @since 2.0.0
     * @see   https://developer.postnl.nl/browse-apis/addresses/adrescheck-basis-nationaal/
     */
    public function basicNationalAddressCheck(string $postalCode, $houseNumber = null): BasicNationalAddressCheckResponse
    {
        return $this->getBasicNationalAddressCheckService()->checkAddress(
            (new BasicNationalAddressCheckRequest())
                ->setPostalCode($postalCode)
                ->setHouseNumber($houseNumber)
        );
    }

    /**
     * Check national address.
     *
     * @param string|null $street
     * @param string|null $houseNumber
     * @param string|null $addition
     * @param string|null $postalCode
     * @param string|null $city
     *
     * @return ValidatedAddressInterface
     *
     * @throws CifDownException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     * @see   https://developer.postnl.nl/browse-apis/addresses/adrescheck-nationaal/
     */
    public function nationalAddressCheck(?string $street = null, ?string $houseNumber = null, ?string $addition = null, ?string $postalCode = null, ?string $city = null): ValidatedAddressInterface
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
     * Geo check national address.
     *
     * @param string|null $street
     * @param string|null $houseNumber
     * @param string|null $addition
     * @param string|null $postalCode
     * @param string|null $city
     *
     * @return ValidatedAddressInterface
     *
     * @throws CifDownException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws CifErrorException
     *
     * @since 2.0.0
     * @see   https://developer.postnl.nl/browse-apis/addresses/geo-adrescheck-nationaal/
     */
    public function nationalGeoAddressCheck(?string $street = null, ?string $houseNumber = null, ?string $addition = null, ?string $postalCode = null, ?string $city = null): ValidatedAddressInterface
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
     * Check international address.
     *
     * @param string|null       $country              ISO 3166-1 alpha 3 country code
     * @param string|array|null $streetOrAddressLines Street name or full address lines
     * @param string|null       $houseNumber
     * @param string|null       $postalCode
     * @param string|null       $city
     * @param string|null       $building
     * @param string|null       $subBuilding
     *
     * @return ValidatedAddressInterface
     *
     * @throws CifDownException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     * @see   https://developer.postnl.nl/browse-apis/addresses/adrescheck-internationaal/
     */
    public function internationalAddressCheck($country = null, ?string $streetOrAddressLines = null, ?string $houseNumber = null, ?string $postalCode = null, ?string $city = null, ?string $building = null, ?string $subBuilding = null): ValidatedAddressInterface
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

    /**
     * Check a Dutch postal code and retrieve address information when found.
     *
     * @param string      $postalCode          Postal code
     * @param int         $houseNumber         House number
     * @param string|null $houseNumberAddition House number addition
     *
     * @return ValidatedAddressInterface
     *
     * @throws CifDownException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     * @see   https://developer.postnl.nl/browse-apis/checkout/checkout-postalcode-check/
     */
    public function checkPostalCode(string $postalCode, int $houseNumber, ?string $houseNumberAddition): ValidatedAddressInterface
    {
        return $this->getPostalCodeCheckService()->checkPostalCode(
            (new PostalCodeCheckRequest())
                ->setPostalCode($postalCode)
                ->setHouseNumber($houseNumber)
                ->setHouseNumberAddition($houseNumberAddition)
        );
    }

    /**
     * Find delivery information (experimental).
     *
     * This is part of the new Checkout API which, at the time of writing, is in the BETA phase
     *
     * @param string           $orderDate
     * @param AddressInterface $shippingAddress
     * @param AddressInterface $deliveryAddress
     * @param array            $cutOffTimes
     * @param int              $shippingDuration
     * @param bool             $holidaySorting
     * @param array            $options
     * @param int              $days
     * @param int              $locations
     *
     * @return FindDeliveryInfoResponse
     *
     * @throws CifDownException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     * @see   https://developer.postnl.nl/browse-apis/checkout/checkout-api/
     */
    public function findDeliveryInfo(string $orderDate, AddressInterface $shippingAddress, AddressInterface $deliveryAddress, array $cutOffTimes, int $shippingDuration = 1, bool $holidaySorting = false, array $options = ['Daytime'], int $days = 9, int $locations = 3): FindDeliveryInfoResponse
    {
        return $this->getCheckoutService()->findDeliveryInformation(
            (new FindDeliveryInfoRequest())
                ->setOrderDate($orderDate)
                ->setCutOffTimes($cutOffTimes)
                ->setHolidaySorting($holidaySorting)
                ->setShippingDuration($shippingDuration)
                ->setOptions($options)
                ->setDays($days)
                ->setLocations($locations)
                ->setAddresses([$shippingAddress, $deliveryAddress])
        );
    }

    /**
     * Search for company information.
     *
     * METHOD 1
     *
     * @param string $kvkNumber         kvK Number
     *                                  10 digits and tolerating additional brackets, a hyphen and a minus sign
     * @param string $branchNumber      Branch number
     * @param string $rsin              RSIN
     * @param bool   $includeInactive   Include inactive organizations
     * @param bool   $mainBranch        Include main branches
     * @param bool   $branch            Include branches
     * @param int    $maxResultsPerPage Max results per page (between 1 - 50)
     * @param int    $requestedPage     Request a certain page, used for pagination
     *
     * @return NationalBusinessCheckResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotSupportedException
     *
     * @see https://developer.postnl.nl/browse-apis/customer-overview/bedrijfscheck-nationaal/documentation/
     */
    public function checkCompany(string $kvkNumber = '', string $branchNumber = '', string $rsin = '', bool $includeInactive = false, bool $mainBranch = true, bool $branch = true, int $maxResultsPerPage = 50, int $requestedPage = 1): NationalBusinessCheckResponse
    {
        return $this->getNationalBusinessCheckService()->searchCompany(
            $kvkNumber,
            $branchNumber,
            $rsin,
            $includeInactive,
            $mainBranch,
            $branch,
            $maxResultsPerPage,
            $requestedPage
        );
    }

    /**
     * Search for a company by name and address.
     *
     * METHOD 2
     *
     * @param string $companyName
     * @param string $branchStreetName
     * @param string $branchHouseNumber
     * @param string $branchHouseNumberAddition
     * @param string $branchPostalCode
     * @param string $branchCity
     * @param bool   $includeBranchAddress
     * @param bool   $includeMailingAddress
     * @param bool   $includeActive
     * @param bool   $mainBranch
     * @param bool   $branch
     * @param int    $maxResultsPerPage
     * @param int    $requestedPage
     *
     * @return NationalBusinessCheckResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotSupportedException
     *
     * @see https://developer.postnl.nl/browse-apis/customer-overview/bedrijfscheck-nationaal/documentation/
     */
    public function checkCompanyByCompanyNameAndAddress(string $companyName = '', string $branchStreetName = '', string $branchHouseNumber = '', string $branchHouseNumberAddition = '', string $branchPostalCode = '', string $branchCity = '', bool $includeBranchAddress = true, bool $includeMailingAddress = true, bool $includeActive = false, bool $mainBranch = true, bool $branch = true, int $maxResultsPerPage = 50, int $requestedPage = 1): NationalBusinessCheckResponse
    {
        return $this->getNationalBusinessCheckService()->searchCompanyByNameAndAddress(
            $companyName,
            $branchStreetName,
            $branchHouseNumber,
            $branchHouseNumberAddition,
            $branchPostalCode,
            $branchCity,
            $includeBranchAddress,
            $includeMailingAddress,
            $includeActive,
            $mainBranch,
            $branch,
            $maxResultsPerPage,
            $requestedPage
        );
    }

    /**
     * Search for a company by address.
     *
     * METHOD 3
     *
     * @param string $branchStreetName
     * @param string $branchHouseNumber
     * @param string $branchHouseNumberAddition
     * @param string $branchPostalCode
     * @param string $branchCity
     * @param bool   $includeBranchAddress
     * @param bool   $includeMailingAddress
     * @param bool   $includeInactive
     * @param bool   $mainBranch
     * @param bool   $branch
     * @param int    $maxResultsPerPage
     * @param int    $requestedPage
     *
     * @return NationalBusinessCheckResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotSupportedException
     *
     * @see https://developer.postnl.nl/browse-apis/customer-overview/bedrijfscheck-nationaal/documentation/
     */
    public function checkCompanyByAddress(string $branchStreetName = '', string $branchHouseNumber = '', string $branchHouseNumberAddition = '', string $branchPostalCode = '', string $branchCity = '', bool $includeBranchAddress = true, bool $includeMailingAddress = true, bool $includeInactive = false, bool $mainBranch = true, bool $branch = true, int $maxResultsPerPage = 50, int $requestedPage = 1): NationalBusinessCheckResponse
    {
        return $this->getNationalBusinessCheckService()->searchCompanyByAddress(
            $branchStreetName,
            $branchHouseNumber,
            $branchHouseNumberAddition,
            $branchPostalCode,
            $branchCity,
            $includeBranchAddress,
            $includeMailingAddress,
            $includeInactive,
            $mainBranch,
            $branch,
            $maxResultsPerPage,
            $requestedPage
        );
    }

    /**
     * Search for a company by phone number.
     *
     * METHOD 4
     *
     * @param string $phoneNumber
     * @param bool   $includeInactive
     * @param bool   $mainBranch
     * @param bool   $branch
     * @param int    $maxResultsPerPage
     * @param int    $requestedPage
     *
     * @return NationalBusinessCheckResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotSupportedException
     *
     * @see https://developer.postnl.nl/browse-apis/customer-overview/bedrijfscheck-nationaal/documentation/
     */
    public function checkCompanyByPhone(string $phoneNumber, bool $includeInactive = false, bool $mainBranch = true, bool $branch = true, int $maxResultsPerPage = 50, int $requestedPage = 1): NationalBusinessCheckResponse
    {
        return $this->getNationalBusinessCheckService()->searchCompanyByPhone(
            $phoneNumber,
            $includeInactive,
            $mainBranch,
            $branch,
            $maxResultsPerPage,
            $requestedPage
        );
    }

    /**
     * Check for a company by providing some company details.
     *
     * METHOD 5&6
     *
     * @param string $kvkNumber    KvK number
     * @param string $branchNumber Branch number
     * @param string $postnlKey    PostNL number
     * @param bool   $detailed     Return detailed information
     *
     * @return NationalBusinessCheckResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotSupportedException
     *
     * @see https://developer.postnl.nl/browse-apis/customer-overview/bedrijfscheck-nationaal/documentation/
     */
    public function checkCompanyByDetails(string $kvkNumber = '', string $branchNumber = '', string $postnlKey = '', bool $detailed = false): NationalBusinessCheckResponse
    {
        return $this->getNationalBusinessCheckService()->getCompanyDetails(
            $kvkNumber,
            $branchNumber,
            $postnlKey,
            $detailed ? NationalBusinessCheckService::METHOD_COMPANY_DETAILS_EXTRA : NationalBusinessCheckService::METHOD_COMPANY_DETAILS
        );
    }

    /**
     * Check business authorized signatory.
     *
     * METHOD 7
     *
     * @param string $kvkNumber
     * @param string $branchNumber
     * @param string $postnlKey
     *
     * @return NationalBusinessCheckResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotSupportedException
     *
     * @see https://developer.postnl.nl/browse-apis/customer-overview/bedrijfscheck-nationaal/documentation/
     */
    public function checkCompanyAuthorizedSignatory(string $kvkNumber, string $branchNumber, string $postnlKey)
    {
        return $this->getNationalBusinessCheckService()->getCompanyDetails(
            $kvkNumber,
            $branchNumber,
            $postnlKey,
            NationalBusinessCheckService::METHOD_COMPANY_AUTHORIZED_SIGNATORY
        );
    }

    /**
     * Retrieve a company extract.
     *
     * METHOD 8
     *
     * @return void
     *
     * @throws NotSupportedException
     *
     * @see https://developer.postnl.nl/browse-apis/customer-overview/bedrijfscheck-nationaal/documentation/
     */
    public function checkCompanyExtract(): void
    {
        throw new NotSupportedException('Not available, yet');
    }

    public function companySearch()
    {
    }
}
