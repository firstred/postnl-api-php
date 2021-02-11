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

namespace Firstred\PostNL;

use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\DTO\Request\CalculateDeliveryDateRequestDTO;
use Firstred\PostNL\DTO\Request\CalculateShippingDateRequestDTO;
use Firstred\PostNL\DTO\Request\CalculateTimeframesRequestDTO;
use Firstred\PostNL\DTO\Request\GetLocationsInAreaRequestDTO;
use Firstred\PostNL\DTO\Request\GetNearestLocationsGeocodeRequestDTO;
use Firstred\PostNL\DTO\Request\GetNearestLocationsRequestDTO;
use Firstred\PostNL\DTO\Request\LookupLocationRequestDTO;
use Firstred\PostNL\DTO\Response\CalculateDeliveryDateResponseDTO;
use Firstred\PostNL\DTO\Response\CalculateShippingDateResponseDTO;
use Firstred\PostNL\DTO\Response\CalculateTimeframesResponseDTO;
use Firstred\PostNL\DTO\Response\GenerateBarcodeResponseDTO;
use Firstred\PostNL\DTO\Response\GenerateBarcodesByCountryCodesResponseDTO;
use Firstred\PostNL\DTO\Response\GetLocationResponseDTO;
use Firstred\PostNL\DTO\Response\GetLocationsResponseDTO;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Gateway\BarcodeServiceGateway;
use Firstred\PostNL\Gateway\CheckoutServiceGateway;
use Firstred\PostNL\Gateway\DeliveryDateServiceGateway;
use Firstred\PostNL\Gateway\LocationServiceGateway;
use Firstred\PostNL\Gateway\TimeframeServiceGateway;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\HttpClient\HTTPlugHttpClient;
use Firstred\PostNL\RequestBuilder\BarcodeServiceRequestBuilder;
use Firstred\PostNL\RequestBuilder\CheckoutServiceRequestBuilder;
use Firstred\PostNL\RequestBuilder\DeliveryDateServiceRequestBuilder;
use Firstred\PostNL\RequestBuilder\LocationServiceRequestBuilder;
use Firstred\PostNL\RequestBuilder\TimeframeServiceRequestBuilder;
use Firstred\PostNL\ResponseProcessor\BarcodeServiceResponseProcessor;
use Firstred\PostNL\ResponseProcessor\CheckoutServiceResponseProcessor;
use Firstred\PostNL\ResponseProcessor\DeliveryDateServiceResponseProcessor;
use Firstred\PostNL\ResponseProcessor\LocationServiceResponseProcessor;
use Firstred\PostNL\ResponseProcessor\TimeframeServiceResponseProcessor;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use Firstred\PostNL\Service\CheckoutService;
use Firstred\PostNL\Service\CheckoutServiceInterface;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\ConfirmingServiceInterface;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\DeliveryDateServiceInterface;
use Firstred\PostNL\Service\LabellingServiceInterface;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\LocationServiceInterface;
use Firstred\PostNL\Service\ShippingService;
use Firstred\PostNL\Service\ShippingServiceInterface;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\ShippingStatusServiceInterface;
use Firstred\PostNL\Service\TimeframeService;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\ExpectedValues;
use Psr\Log\LoggerInterface;

/**
 * Class PostNL.
 */
class PostNL
{
    /**
     * PostNL constructor.
     *
     * @param Customer                            $customer
     * @param string                              $apiKey
     * @param bool                                $sandbox
     * @param BarcodeServiceInterface|null        $barcodeService
     * @param CheckoutServiceInterface|null       $checkoutService
     * @param ConfirmingServiceInterface|null     $confirmingService
     * @param DeliveryDateServiceInterface|null   $deliveryDateService
     * @param LabellingServiceInterface|null      $labellingService
     * @param LocationServiceInterface|null       $locationService
     * @param ShippingServiceInterface|null       $shippingService
     * @param ShippingStatusServiceInterface|null $shippingStatusService
     * @param TimeframeServiceInterface|null      $timeframeService
     * @param HttpClientInterface|null            $httpClient
     * @param LoggerInterface|null                $logger
     */
    public function __construct(
        protected Customer $customer,
        protected string $apiKey,
        protected bool $sandbox,
        protected BarcodeServiceInterface|null $barcodeService = null,
        protected CheckoutServiceInterface|null $checkoutService = null,
        protected ConfirmingServiceInterface|null $confirmingService = null,
        protected DeliveryDateServiceInterface|null $deliveryDateService = null,
        protected LabellingServiceInterface|null $labellingService = null,
        protected LocationServiceInterface|null $locationService = null,
        protected ShippingServiceInterface|null $shippingService = null,
        protected ShippingStatusServiceInterface|null $shippingStatusService = null,
        protected TimeframeServiceInterface|null $timeframeService = null,
        protected HttpClientInterface|null $httpClient = null,
        protected LoggerInterface|null $logger = null,
    ) {
    }

//    /**
//     * @param Shipment $shipment
//     * @param string   $printertype
//     * @param bool     $confirm
//     *
//     * @return GenerateShippingResponse
//     */
//    public function generateShipping(
//        Shipment $shipment,
//        string $printertype = 'GraphicFile|PDF',
//        bool $confirm = true
//    ): GenerateShippingResponse {
//        return static->getShippingService()->generateShipping(
//            generateShipping: new Shipping(
//            shipments: [$shipment],
//            message: new LabellingMessage(printerType: $printertype),
//            customer: static->customer
//        ),
//            confirm: $confirm);
//    }

//    /**
//     * @param Shipment[] $shipments     Array of shipments
//     * @param string     $printertype   Printer type, see PostNL dev docs for available types
//     * @param bool       $confirm       Immediately confirm the shipments
//     * @param bool       $merge         Merge the PDFs and return them in a MyParcel way
//     * @param int        $format        A4 or A6
//     * @param array      $positions     Set the positions of the A6s on the first A4
//     *                                  The indices should be the position number, marked with `true` or `false`
//     *                                  These are the position numbers:
//     *                                  ```
//     *                                  +-+-+
//     *                                  |2|4|
//     *                                  +-+-+
//     *                                  |1|3|
//     *                                  +-+-+
//     *                                  ```
//     *                                  So, for
//     *                                  ```
//     *                                  +-+-+
//     *                                  |x|✔|
//     *                                  +-+-+
//     *                                  |✔|x|
//     *                                  +-+-+
//     *                                  ```
//     *                                  you would have to pass:
//     *                                  ```php
//     *                                  [
//     *                                  1 => true,
//     *                                  2 => false,
//     *                                  3 => false,
//     *                                  4 => true,
//     *                                  ]
//     *                                  ```
//     * @param string     $a6Orientation A6 orientation (P or L)
//     *
//     * @return GenerateShippingResponse|string
//     *
//     * @throws AbstractException
//     * @throws NotSupportedException
//     * @throws PdfReaderException
//     * @throws \setasign\Fpdi\PdfParser\PdfParserException
//     */
//    public function generateShippings(
//        array $shipments,
//        string $printertype = 'GraphicFile|PDF',
//        bool $confirm = true,
//        bool $merge = false,
//        int $format = Label::FORMAT_A4,
//        array $positions = [
//            1 => true,
//            2 => true,
//            3 => true,
//            4 => true,
//        ],
//        string $a6Orientation = 'P'
//    ): GenerateShippingResponse {
//        if ($merge) {
//            if ('GraphicFile|PDF' !== $printertype) {
//                throw new NotSupportedException('Labels with the chosen printer type cannot be merged');
//            }
//            foreach ([1, 2, 3, 4] as $i) {
//                if (!array_key_exists(key: $i, array: $positions)) {
//                    throw new NotSupportedException('All label positions need to be passed for merge mode');
//                }
//            }
//        }
//
//        $responseShipments = static->getShippingService()->generateShipping(
//            generateShipping: new Shipping(
//            shipments: $shipments,
//            message: new LabellingMessage(printerType: $printertype),
//            customer: static->customer
//        ),
//            confirm: $confirm
//        );
//
//        if (!$merge) {
//            return $responseShipments;
//        }
//
//        // Disable header and footer
//        $pdf = new RFPdi('P', 'mm', Label::FORMAT_A4 === $format ? [210, 297] : [105, 148]);
//        $deferred = [];
//        $firstPage = true;
//        if (Label::FORMAT_A6 === $format) {
//            foreach ($responseShipments->getResponseShipments() as $responseShipment) {
//                foreach ($responseShipment->getLabels() as $label) {
//                    $pdfContent = base64_decode(string: $label->getContent());
//                    $sizes = Util::getPdfSizeAndOrientation(pdf: $pdfContent);
//                    if ('A6' === $sizes['iso']) {
//                        $pdf->addPage(orientation: $a6Orientation);
//                        $correction = [0, 0];
//                        if ('L' === $a6Orientation && 'P' === $sizes['orientation']) {
//                            $correction[0] = -84;
//                            $correction[1] = -0.5;
//                            $pdf->rotateCounterClockWise();
//                        } elseif ('P' === $a6Orientation && 'L' === $sizes['orientation']) {
//                            $pdf->rotateCounterClockWise();
//                        }
//                        $pdf->setSourceFile(file: StreamReader::createByString(content: $pdfContent));
//                        $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: $correction[0], y: $correction[1]);
//                    } else {
//                        // Assuming A4 here (could be multi-page) - defer to end
//                        $stream = StreamReader::createByString(content: $pdfContent);
//                        $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
//                    }
//                }
//            }
//        } else {
//            $a6s = 4; // Amount of A6s available
//            foreach ($responseShipments->getResponseShipments() as $label) {
//                $pdfContent = base64_decode(string: $label->getLabels()[0]->getContent());
//                $sizes = Util::getPdfSizeAndOrientation(pdf: $pdfContent);
//                if ('A6' === $sizes['iso']) {
//                    if ($firstPage) {
//                        $pdf->addPage(orientation: 'P', size: [297, 210], rotation: 90);
//                    }
//                    $firstPage = false;
//                    while (empty($positions[5 - $a6s]) && $a6s >= 1) {
//                        $positions[5 - $a6s] = true;
//                        --$a6s;
//                    }
//                    if ($a6s < 1) {
//                        $pdf->addPage(orientation: 'P', size: [297, 210], rotation: 90);
//                        $a6s = 4;
//                    }
//                    $pdf->rotateCounterClockWise();
//                    $pdf->setSourceFile(file: StreamReader::createByString(content: $pdfContent));
//                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: static::$a6positions[$a6s][0], y: static::$a6positions[$a6s][1]);
//                    --$a6s;
//                    if ($a6s < 1) {
//                        if ($label !== end(array: $responseShipments)) {
//                            $pdf->addPage(orientation: 'P', size: [297, 210], rotation: 90);
//                        }
//                        $a6s = 4;
//                    }
//                } else {
//                    // Assuming A4 here (could be multi-page) - defer to end
//                    if (count(value: $label->getLabels()) > 1) {
//                        $stream = [];
//                        foreach ($label->getResponseShipments()[0]->getLabels() as $labelContent) {
//                            $stream[] = StreamReader::createByString(content: base64_decode(string: $labelContent->getContent()));
//                        }
//                        $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
//                    } else {
//                        $stream = StreamReader::createByString(content: base64_decode(string: $pdfContent));
//                        $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
//                    }
//                }
//            }
//        }
//        foreach ($deferred as $defer) {
//            $sizes = $defer['sizes'];
//            $pdf->addPage(orientation: $sizes['orientation'], size: 'A4');
//            $pdf->rotateCounterClockWise();
//            if (is_array(value: $defer['stream']) && count(value: $defer['stream']) > 1) {
//                // Multilabel
//                if (2 === count(value: $deferred['stream'])) {
//                    $pdf->setSourceFile(file: $defer['stream'][0]);
//                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190);
//                    $pdf->setSourceFile(file: $defer['stream'][1]);
//                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 148);
//                } else {
//                    $pdf->setSourceFile(file: $defer['stream'][0]);
//                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190);
//                    $pdf->setSourceFile(file: $defer['stream'][1]);
//                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 148);
//                    for ($i = 2; $i < count(value: $defer['stream']); ++$i) {
//                        $pages = $pdf->setSourceFile(file: $defer['stream'][$i]);
//                        for ($j = 1; $j < $pages + 1; ++$j) {
//                            $pdf->addPage(orientation: $sizes['orientation'], size: 'A4');
//                            $pdf->rotateCounterClockWise();
//                            $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190);
//                        }
//                    }
//                }
//            } else {
//                if (is_resource(value: $defer['stream']) || $defer['stream'] instanceof StreamReader) {
//                    $pdf->setSourceFile(file: $defer['stream']);
//                } else {
//                    $pdf->setSourceFile(file: $defer['stream'][0]);
//                }
//                $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190);
//            }
//        }
//
//        return $pdf->output(name: 'S');
//    }

    /**
     * Generate a single barcode.
     *
     * @param string      $type
     * @param string|null $range
     * @param string|null $serie
     * @param bool        $eps
     *
     * @return GenerateBarcodeResponseDTO The barcode as a stringable response object
     *
     * @throws Exception\ApiClientException
     * @throws Exception\ApiException
     * @throws Exception\InvalidApiKeyException
     * @throws Exception\InvalidArgumentException
     * @throws Exception\InvalidBarcodeException
     * @throws Exception\NotAvailableException
     * @throws Exception\ParseError
     */
    public function generateBarcode(
        string $type = '3S',
        string|null $range = null,
        string|null $serie = null,
        bool $eps = false,
    ): GenerateBarcodeResponseDTO {
        return $this->getBarcodeService()->generateBarcode(
            type: $type,
            range: $range,
            serie: $serie,
            eps: $eps,
        );
    }

    /**
     * Generate a single barcode by country code.
     *
     * @param string $iso 2-letter Country ISO Code
     *
     * @return GenerateBarcodeResponseDTO The Barcode as a stringable response object
     *
     * @throws Exception\ApiClientException
     * @throws Exception\ApiException
     * @throws Exception\InvalidApiKeyException
     * @throws Exception\InvalidArgumentException
     * @throws Exception\InvalidBarcodeException
     * @throws Exception\InvalidConfigurationException
     * @throws Exception\NotAvailableException
     * @throws Exception\ParseError
     */
    public function generateBarcodeByCountryCode(string $iso): GenerateBarcodeResponseDTO
    {
        return $this->getBarcodeService()->generateBarcodeByCountryCode(iso: $iso);
    }

    /**
     * Generate a single barcode by country code.
     *
     * @param array $isos key = iso code, value = amount of barcodes requested
     *
     * @return GenerateBarcodesByCountryCodesResponseDTO Country isos with stringable barcode response objects
     *
     * @throws Exception\ApiClientException
     * @throws Exception\ApiException
     * @throws Exception\InvalidApiKeyException
     * @throws Exception\InvalidArgumentException
     * @throws Exception\InvalidBarcodeException
     * @throws Exception\InvalidConfigurationException
     * @throws Exception\NotAvailableException
     * @throws Exception\ParseError
     */
    public function generateBarcodesByCountryCodes(array $isos): GenerateBarcodesByCountryCodesResponseDTO
    {
        return $this->getBarcodeService()->generateBarcodesByCountryCodes(isos: $isos);
    }

//    /**
//     * @param Shipment $shipment
//     * @param string   $printertype
//     * @param bool     $confirm
//     *
//     * @return GenerateLabelResponse
//     */
//    public function generateLabel(
//        Shipment $shipment,
//        $printertype = 'GraphicFile|PDF',
//        $confirm = true
//    ): GenerateLabelResponse {
//        return static->getLabellingService()->generateLabel(
//            generateLabel: new LabellingResponseDto(
//            shipments: [$shipment],
//            message: new LabellingMessage(printerType: $printertype),
//            customer: static->customer
//        ),
//            confirm: $confirm
//        );
//    }
//
//    /**
//     * Generate or retrieve multiple labels.
//     *
//     * Note that instead of returning a GenerateLabelResponse this function can merge the labels and return a
//     * string which contains the PDF with the merged pages as well.
//     *
//     * @param Shipment[] $shipments     (key = ID) Shipments
//     * @param string     $printertype   Printer type, see PostNL dev docs for available types
//     * @param bool       $confirm       Immediately confirm the shipments
//     * @param bool       $merge         Merge the PDFs and return them in a MyParcel way
//     * @param int        $format        A4 or A6
//     * @param array      $positions     Set the positions of the A6s on the first A4
//     *                                  The indices should be the position number, marked with `true` or `false`
//     *                                  These are the position numbers:
//     *                                  ```
//     *                                  +-+-+
//     *                                  |2|4|
//     *                                  +-+-+
//     *                                  |1|3|
//     *                                  +-+-+
//     *                                  ```
//     *                                  So, for
//     *                                  ```
//     *                                  +-+-+
//     *                                  |x|✔|
//     *                                  +-+-+
//     *                                  |✔|x|
//     *                                  +-+-+
//     *                                  ```
//     *                                  you would have to pass:
//     *                                  ```php
//     *                                  [
//     *                                  1 => true,
//     *                                  2 => false,
//     *                                  3 => false,
//     *                                  4 => true,
//     *                                  ]
//     *                                  ```
//     * @param string     $a6Orientation A6 orientation (P or L)
//     *
//     * @return GenerateLabelResponse[]|string
//     *
//     * @throws AbstractException
//     * @throws NotSupportedException
//     * @throws PdfReaderException
//     */
//    public function generateLabels(
//        array $shipments,
//        $printertype = 'GraphicFile|PDF',
//        $confirm = true,
//        $merge = false,
//        $format = Label::FORMAT_A4,
//        $positions = [
//            1 => true,
//            2 => true,
//            3 => true,
//            4 => true,
//        ],
//        $a6Orientation = 'P'
//    ): array|string {
//        if ($merge) {
//            if ('GraphicFile|PDF' !== $printertype) {
//                throw new NotSupportedException('Labels with the chosen printer type cannot be merged');
//            }
//            foreach ([1, 2, 3, 4] as $i) {
//                if (!array_key_exists(key: $i, array: $positions)) {
//                    throw new NotSupportedException('All label positions need to be passed for merge mode');
//                }
//            }
//        }
//
//        $generateLabels = [];
//        foreach ($shipments as $uuid => $shipment) {
//            $generateLabels[$uuid] = [(new LabellingResponseDto(shipments: [$shipment], message: new LabellingMessage(printerType: $printertype), customer: static->customer))->setId(id: $uuid), $confirm];
//        }
//        $responseShipments = static->getLabellingService()->generateLabels($generateLabels, $confirm);
//
//        if (!$merge) {
//            return $responseShipments;
//        } else {
//            foreach ($responseShipments as $responseShipment) {
//                if (!$responseShipment instanceof GenerateLabelResponse) {
//                    return $responseShipments;
//                }
//            }
//        }
//
//        // Disable header and footer
//        $pdf = new RFPdi('P', 'mm', Label::FORMAT_A4 === $format ? [210, 297] : [105, 148]);
//        $deferred = [];
//        $firstPage = true;
//        if (Label::FORMAT_A6 === $format) {
//            foreach ($responseShipments as $responseShipment) {
//                foreach ($responseShipment->getResponseShipments()[0]->getLabels() as $label) {
//                    $pdfContent = base64_decode(string: $label->getContent());
//                    $sizes = Util::getPdfSizeAndOrientation(pdf: $pdfContent);
//                    if ('A6' === $sizes['iso']) {
//                        $pdf->addPage(orientation: $a6Orientation);
//                        $correction = [0, 0];
//                        if ('L' === $a6Orientation && 'P' === $sizes['orientation']) {
//                            $correction[0] = -84;
//                            $correction[1] = -0.5;
//                            $pdf->rotateCounterClockWise();
//                        } elseif ('P' === $a6Orientation && 'L' === $sizes['orientation']) {
//                            $pdf->rotateCounterClockWise();
//                        }
//                        $pdf->setSourceFile(file: StreamReader::createByString(content: $pdfContent));
//                        $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: $correction[0], y: $correction[1]);
//                    } else {
//                        // Assuming A4 here (could be multi-page) - defer to end
//                        $stream = StreamReader::createByString(content: $pdfContent);
//                        $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
//                    }
//                }
//            }
//        } else {
//            $a6s = 4; // Amount of A6s available
//            foreach ($responseShipments as $responseShipment) {
//                if ($responseShipment instanceof AbstractException) {
//                    throw $responseShipment;
//                }
//                $pdfContent = base64_decode(string: $responseShipment->getResponseShipments()[0]->getLabels()[0]->getContent());
//                $sizes = Util::getPdfSizeAndOrientation(pdf: $pdfContent);
//                if ('A6' === $sizes['iso']) {
//                    if ($firstPage) {
//                        $pdf->addPage(orientation: 'P', size: [297, 210], rotation: 90);
//                    }
//                    $firstPage = false;
//                    while (empty($positions[5 - $a6s]) && $a6s >= 1) {
//                        $positions[5 - $a6s] = true;
//                        --$a6s;
//                    }
//                    if ($a6s < 1) {
//                        $pdf->addPage(orientation: 'P', size: [297, 210], rotation: 90);
//                        $a6s = 4;
//                    }
//                    $pdf->rotateCounterClockWise();
//                    $pdf->setSourceFile(file: StreamReader::createByString(content: $pdfContent));
//                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: static::$a6positions[$a6s][0], y: static::$a6positions[$a6s][1]);
//                    --$a6s;
//                    if ($a6s < 1) {
//                        if ($responseShipment !== end(array: $responseShipments)) {
//                            $pdf->addPage(orientation: 'P', size: [297, 210], rotation: 90);
//                        }
//                        $a6s = 4;
//                    }
//                } else {
//                    // Assuming A4 here (could be multi-page) - defer to end
//                    if (count(value: $responseShipment->getResponseShipments()[0]->getLabels()) > 1) {
//                        $stream = [];
//                        foreach ($responseShipment->getResponseShipments()[0]->getLabels() as $labelContent) {
//                            $stream[] = StreamReader::createByString(content: base64_decode(string: $labelContent->getContent()));
//                        }
//                        $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
//                    } else {
//                        $stream = StreamReader::createByString(content: base64_decode(string: $pdfContent));
//                        $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
//                    }
//                }
//            }
//        }
//        foreach ($deferred as $defer) {
//            $sizes = $defer['sizes'];
//            $pdf->addPage(orientation: $sizes['orientation'], size: 'A4');
//            $pdf->rotateCounterClockWise();
//            if (is_array(value: $defer['stream']) && count(value: $defer['stream']) > 1) {
//                // Multilabel
//                if (2 === count(value: $deferred['stream'])) {
//                    $pdf->setSourceFile(file: $defer['stream'][0]);
//                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 0);
//                    $pdf->setSourceFile(file: $defer['stream'][1]);
//                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 148);
//                } else {
//                    $pdf->setSourceFile(file: $defer['stream'][0]);
//                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 0);
//                    $pdf->setSourceFile(file: $defer['stream'][1]);
//                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 148);
//                    for ($i = 2; $i < count(value: $defer['stream']); ++$i) {
//                        $pages = $pdf->setSourceFile(file: $defer['stream'][$i]);
//                        for ($j = 1; $j < $pages + 1; ++$j) {
//                            $pdf->addPage(orientation: $sizes['orientation'], size: 'A4');
//                            $pdf->rotateCounterClockWise();
//                            $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 0);
//                        }
//                    }
//                }
//            } else {
//                if (is_resource(value: $defer['stream']) || $defer['stream'] instanceof StreamReader) {
//                    $pdf->setSourceFile(file: $defer['stream']);
//                } else {
//                    $pdf->setSourceFile(file: $defer['stream'][0]);
//                }
//                $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 0);
//            }
//        }
//
//        return $pdf->output(dest: '', name: 'S');
//    }
//
//    /**
//     * Confirm a single shipment.
//     *
//     * @param Shipment $shipment
//     *
//     * @return ConfirmingResponseShipment
//     */
//    public function confirmShipment(Shipment $shipment): ConfirmingResponseShipment
//    {
//        return static->getConfirmingService()->confirmShipment(confirming: new ConfirmingResponseDto(shipments: [$shipment], customer: static->customer));
//    }
//
//    /**
//     * Confirm multiple shipments.
//     *
//     * @param array $shipments
//     *
//     * @return ConfirmingResponseShipment[]
//     */
//    public function confirmShipments(array $shipments): array
//    {
//        $confirmings = [];
//        foreach ($shipments as $uuid => $shipment) {
//            $confirmings[$uuid] = (new ConfirmingResponseDto(shipments: [$shipment], customer: static->customer))->setId(id: $uuid);
//        }
//
//        return static->getConfirmingService()->confirmShipments(confirms: $confirmings);
//    }
//
//    /**
//     * Get the current status of a shipment.
//     *
//     * This is a combi-function, supporting the following:
//     * - CurrentStatus (by barcode):
//     *   - Fill the Shipment->Barcode property. Leave the rest empty.
//     * - CurrentStatusByReference:
//     *   - Fill the Shipment->Reference property. Leave the rest empty.
//     * - CurrentStatusByPhase:
//     *   - Fill the Shipment->PhaseCode property, do not pass Barcode or Reference.
//     *     Optionally add DateFrom and/or DateTo.
//     * - CurrentStatusByStatus:
//     *   - Fill the Shipment->StatuCode property. Leave the rest empty.
//     *
//     * @param CurrentStatus|CurrentStatusByStatus|CurrentStatusByReference|CurrentStatusByPhase $currentStatus
//     *
//     * @return CurrentStatusResponse
//     */
//    public function getCurrentStatus(CurrentStatus|CurrentStatusByStatus|CurrentStatusByReference|CurrentStatusByPhase $currentStatus): CurrentStatusResponse
//    {
//        $fullCustomer = static->getCustomer();
//        $currentStatus->setCustomer((new Customer())
//            ->setCustomerCode(CustomerCode: $fullCustomer->getCustomerCode())
//            ->setCustomerNumber(CustomerNumber: $fullCustomer->getCustomerNumber())
//        );
//        if (!$currentStatus->getMessage()) {
//            $currentStatus->setMessage(new Message());
//        }
//
//        return static->getShippingStatusService()->currentStatus(currentStatus: $currentStatus);
//    }
//
//    /**
//     * Get the complete status of a shipment.
//     *
//     * This is a combi-function, supporting the following:
//     * - CurrentStatus (by barcode):
//     *   - Fill the Shipment->Barcode property. Leave the rest empty.
//     * - CurrentStatusByReference:
//     *   - Fill the Shipment->Reference property. Leave the rest empty.
//     * - CurrentStatusByPhase:
//     *   - Fill the Shipment->PhaseCode property, do not pass Barcode or Reference.
//     *     Optionally add DateFrom and/or DateTo.
//     * - CurrentStatusByStatus:
//     *   - Fill the Shipment->StatuCode property. Leave the rest empty.
//     *
//     * @param CompleteStatus|CompleteStatusByStatus|CompleteStatusByReference|CompleteStatusByPhase $completeStatus
//     *
//     * @return CompleteStatusResponse
//     */
//    public function getCompleteStatus(CompleteStatus|CompleteStatusByStatus|CompleteStatusByReference|CompleteStatusByPhase $completeStatus): CompleteStatusResponse
//    {
//        $fullCustomer = static->getCustomer();
//
//        $completeStatus->setCustomer((new Customer())
//            ->setCustomerCode(CustomerCode: $fullCustomer->getCustomerCode())
//            ->setCustomerNumber(CustomerNumber: $fullCustomer->getCustomerNumber())
//        );
//        if (!$completeStatus->getMessage()) {
//            $completeStatus->setMessage(new Message());
//        }
//
//        return static->getShippingStatusService()->completeStatus(completeStatus: $completeStatus);
//    }
//
//    /**
//     * Get the signature of a shipment.
//     *
//     * @param GetSignature $signature
//     *
//     * @return GetSignature
//     */
//    public function getSignature(GetSignature $signature): GetSignature
//    {
//        $signature->setCustomer(static->getCustomer());
//        if (!$signature->getMessage()) {
//            $signature->setMessage(new Message());
//        }
//
//        return static->getShippingStatusService()->getSignature(getSignature: $signature);
//    }

    /**
     * Calculate the delivery date.
     *
     * @param string      $shippingDate
     * @param int         $shippingDuration
     * @param string      $cutOffTime
     * @param string      $postalCode
     * @param string|null $countryCode
     * @param string|null $originCountryCode
     * @param string|null $city
     * @param string|null $street
     * @param int|null    $houseNumber
     * @param string|null $houseNrExt
     * @param array|null  $options
     * @param string|null $cutOffTimeMonday
     * @param bool|null   $availableMonday
     * @param string|null $cutOffTimeTuesday
     * @param bool|null   $availableTuesday
     * @param string|null $cutOffTimeWednesday
     * @param bool|null   $availableWednesday
     * @param string|null $cutOffTimeThursday
     * @param bool|null   $availableThursday
     * @param string|null $cutOffTimeFriday
     * @param bool|null   $availableFriday
     * @param string|null $cutOffTimeSaturday
     * @param bool|null   $availableSaturday
     * @param string|null $cutOffTimeSunday
     * @param bool|null   $availableSunday
     * @param array|null  $cutOffTimes
     *
     * @return CalculateDeliveryDateResponseDTO
     *
     * @throws Exception\ApiClientException
     * @throws Exception\ApiException
     * @throws Exception\InvalidApiKeyException
     * @throws Exception\InvalidArgumentException
     * @throws Exception\NotAvailableException
     * @throws Exception\ParseError
     */
    public function calculateDeliveryDate(
        string $shippingDate,
        int $shippingDuration,
        string $cutOffTime,
        string $postalCode,
        string|null $countryCode = null,
        string|null $originCountryCode = null,
        string|null $city = null,
        string|null $street = null,
        int|null $houseNumber = null,
        string|null $houseNrExt = null,
        array|null $options = null,
        string|null $cutOffTimeMonday = null,
        bool|null $availableMonday = null,
        string|null $cutOffTimeTuesday = null,
        bool|null $availableTuesday = null,
        string|null $cutOffTimeWednesday = null,
        bool|null $availableWednesday = null,
        string|null $cutOffTimeThursday = null,
        bool|null $availableThursday = null,
        string|null $cutOffTimeFriday = null,
        bool|null $availableFriday = null,
        string|null $cutOffTimeSaturday = null,
        bool|null $availableSaturday = null,
        string|null $cutOffTimeSunday = null,
        bool|null $availableSunday = null,
        #[ArrayShape(shape: CalculateDeliveryDateRequestDTO::CUTOFF_TIME_ARRAY_SHAPE)]
        array|null $cutOffTimes = null,
    ): CalculateDeliveryDateResponseDTO {
        return $this->getDeliveryDateService()->calculateDeliveryDate(
            calculateDeliveryDateRequestDTO: new CalculateDeliveryDateRequestDTO(
                service: DeliveryDateServiceInterface::class,
                propType: RequestProp::class,

                ShippingDate: $shippingDate,
                ShippingDuration: $shippingDuration,
                CutOffTime: $cutOffTime,
                PostalCode: $postalCode,
                CountryCode: $countryCode,
                OriginCountryCode: $originCountryCode,
                City: $city,
                Street: $street,
                HouseNumber: $houseNumber,
                HouseNrExt: $houseNrExt,
                Options: $options,
                CutOffTimeMonday: $cutOffTimeMonday,
                AvailableMonday: $availableMonday,
                CutOffTimeTuesday: $cutOffTimeTuesday,
                AvailableTuesday: $availableTuesday,
                CutOffTimeWednesday: $cutOffTimeWednesday,
                AvailableWednesday: $availableWednesday,
                CutOffTimeThursday: $cutOffTimeThursday,
                AvailableThursday: $availableThursday,
                CutOffTimeFriday: $cutOffTimeFriday,
                AvailableFriday: $availableFriday,
                CutOffTimeSaturday: $cutOffTimeSaturday,
                AvailableSaturday: $availableSaturday,
                CutOffTimeSunday: $cutOffTimeSunday,
                AvailableSunday: $availableSunday,
                cutOffTimes: $cutOffTimes,
            )
        );
    }

    /**
     * Calculate the shipping date.
     *
     * @param string|null $deliveryDate
     * @param int|null    $shippingDuration
     * @param string|null $postalCode
     * @param string|null $countryCode
     * @param string|null $originCountryCode
     * @param string|null $city
     * @param string|null $street
     * @param int|null    $houseNumber
     * @param string|null $houseNrExt
     *
     * @return CalculateShippingDateResponseDTO
     *
     * @throws Exception\ApiClientException
     * @throws Exception\ApiException
     * @throws Exception\InvalidApiKeyException
     * @throws Exception\InvalidArgumentException
     * @throws Exception\NotAvailableException
     * @throws Exception\ParseError
     */
    public function calculateShippingDate(
        string|null $deliveryDate,
        int|null $shippingDuration,
        string|null $postalCode,
        string|null $countryCode = null,
        string|null $originCountryCode = null,
        string|null $city = null,
        string|null $street = null,
        int|null $houseNumber = null,
        string|null $houseNrExt = null,
    ): CalculateShippingDateResponseDTO {
        return $this->getDeliveryDateService()->getShippingDate(
            getShippingDateRequestDTO: new CalculateShippingDateRequestDTO(
                service: DeliveryDateServiceInterface::class,
                propType: RequestProp::class,

                DeliveryDate: $deliveryDate,
                ShippingDuration: $shippingDuration,
                PostalCode: $postalCode,
                CountryCode: $countryCode,
                OriginCountryCode: $originCountryCode,
                City: $city,
                Street: $street,
                HouseNumber: $houseNumber,
                HouseNrExt: $houseNrExt
            ),
        );
    }

    /**
     * Calculate timeframes.
     *
     * @param string      $startDate
     * @param string      $endDate
     * @param array       $options
     * @param string      $postalCode
     * @param int         $houseNumber
     * @param string      $countryCode
     * @param bool        $allowSundaySorting
     * @param string|null $city
     * @param string|null $street
     * @param string|null $houseNrExt
     * @param int|null    $interval
     * @param string|null $timeframeRange
     *
     * @return CalculateTimeframesResponseDTO
     *
     * @throws Exception\ApiClientException
     * @throws Exception\ApiException
     * @throws Exception\InvalidApiKeyException
     * @throws Exception\InvalidArgumentException
     * @throws Exception\NotAvailableException
     * @throws Exception\ParseError
     */
    public function calculateTimeframes(
        string $startDate,
        string $endDate,
        array $options,
        string $postalCode,
        int $houseNumber,
        string $countryCode = 'NL',
        bool $allowSundaySorting = false,
        string|null $city = null,
        string|null $street = null,
        string|null $houseNrExt = null,
        int|null $interval = null,
        string|null $timeframeRange = null,
    ): CalculateTimeframesResponseDTO {
        return $this->getTimeframeService()->calculateTimeframes(calculateTimeframesRequestDTO: new CalculateTimeframesRequestDTO(
            service: TimeframeServiceInterface::class,
            propType: RequestProp::class,

            StartDate: $startDate,
            EndDate: $endDate,
            Options: $options,
            AllowSundaySorting: $allowSundaySorting,
            CountryCode: $countryCode,
            City: $city,
            PostalCode: $postalCode,
            Street: $street,
            HouseNumber: $houseNumber,
            HouseNrExt: $houseNrExt,
            Interval: $interval,
            TimeframeRange: $timeframeRange,
        ));
    }

    /**
     * Lookup a single location.
     *
     * @param int|string $LocationCode
     * @param string     $RetailNetworkID
     *
     * @return GetLocationResponseDTO
     *
     * @throws Exception\ApiClientException
     * @throws Exception\ApiException
     * @throws Exception\InvalidApiKeyException
     * @throws Exception\InvalidArgumentException
     * @throws Exception\NotAvailableException
     * @throws Exception\ParseError
     */
    public function lookupLocation(
        int|string $LocationCode,
        #[ExpectedValues(values: Location::AVAILABLE_NETWORKS)]
        string $RetailNetworkID,
    ): GetLocationResponseDTO {
        return $this->getLocationService()->lookupLocation(lookupLocationRequestDTO: new LookupLocationRequestDTO(
            service: LocationServiceInterface::class,
            propType: RequestProp::class,

            LocationCode: $LocationCode,
            RetailNetworkID: $RetailNetworkID,
        ));
    }

    /**
     * Get nearest location by postcode.
     *
     * @param string          $CountryCode
     * @param string|null     $PostalCode
     * @param array|null      $DeliveryOptions
     * @param string|null     $City
     * @param string|null     $Street
     * @param int|string|null $HouseNumber
     * @param string|null     $DeliveryDate
     * @param string|null     $OpeningTime
     *
     * @return GetLocationsResponseDTO
     *
     * @throws Exception\ApiClientException
     * @throws Exception\ApiException
     * @throws Exception\InvalidApiKeyException
     * @throws Exception\InvalidArgumentException
     * @throws Exception\NotAvailableException
     * @throws Exception\ParseError
     */
    public function getNearestLocations(
        string $CountryCode = 'NL',
        string $PostalCode = null,
        array $DeliveryOptions = null,
        string|null $City = null,
        string|null $Street = null,
        int|string|null $HouseNumber = null,
        string|null $DeliveryDate = null,
        string|null $OpeningTime = null,
    ): GetLocationsResponseDTO {
        return $this->getLocationService()->getNearestLocations(getNearestLocationsRequestDTO: new GetNearestLocationsRequestDTO(
            service: LocationServiceInterface::class,
            propType: RequestProp::class,

            CountryCode: $CountryCode,
            PostalCode: $PostalCode,
            City: $City,
            Street: $Street,
            HouseNumber: $HouseNumber,
            DeliveryDate: $DeliveryDate,
            OpeningTime: $OpeningTime,
            DeliveryOptions: $DeliveryOptions,
        ));
    }

    /**
     * Get nearest locations near the given coordinates.
     *
     * @param string      $CountryCode
     * @param float|null  $Latitude
     * @param float|null  $Longitude
     * @param array|null  $DeliveryOptions
     * @param string|null $DeliveryDate
     * @param string|null $OpeningTime
     *
     * @return GetLocationsResponseDTO
     *
     * @throws Exception\ApiClientException
     * @throws Exception\ApiException
     * @throws Exception\InvalidApiKeyException
     * @throws Exception\InvalidArgumentException
     * @throws Exception\NotAvailableException
     * @throws Exception\ParseError
     */
    public function getNearestLocationsByGeolocation(
        string $CountryCode = 'NL',
        float|null $Latitude = null,
        float|null $Longitude = null,
        array $DeliveryOptions = null,
        string|null $DeliveryDate = null,
        string|null $OpeningTime = null,
    ): GetLocationsResponseDTO {
        return $this->getLocationService()->getNearestLocationsGeocode(getNearestLocationsGeocodeRequestDTO: new GetNearestLocationsGeocodeRequestDTO(
            service: LocationServiceInterface::class,
            propType: RequestProp::class,

            Latitude: $Latitude,
            Longitude: $Longitude,
            CountryCode: $CountryCode,
            DeliveryDate: $DeliveryDate,
            OpeningTime: $OpeningTime,
            DeliveryOptions: $DeliveryOptions,
        ));
    }

    /**
     * Get locations in area.
     *
     * @param float|null  $LatitudeNorth
     * @param float|null  $LongitudeWest
     * @param float|null  $LatitudeSouth
     * @param float|null  $LongitudeEast
     * @param string|null $CountryCode
     * @param string|null $DeliveryDate
     * @param string|null $OpeningTime
     * @param array|null  $DeliveryOptions
     *
     * @return GetLocationsResponseDTO
     *
     * @throws Exception\ApiClientException
     * @throws Exception\ApiException
     * @throws Exception\InvalidApiKeyException
     * @throws Exception\InvalidArgumentException
     * @throws Exception\NotAvailableException
     * @throws Exception\ParseError
     */
    public function getLocationsInArea(
        float|null $LatitudeNorth = null,
        float|null $LongitudeWest = null,
        float|null $LatitudeSouth = null,
        float|null $LongitudeEast = null,
        string|null $CountryCode = null,
        string|null $DeliveryDate = null,
        string|null $OpeningTime = null,
        array|null $DeliveryOptions = null,
    ): GetLocationsResponseDTO {
        return $this->getLocationService()->getLocationsInArea(getLocationsInAreaRequestDTO: new GetLocationsInAreaRequestDTO(
            LatitudeNorth: $LatitudeNorth,
            LongitudeWest: $LongitudeWest,
            LatitudeSouth: $LatitudeSouth,
            LongitudeEast: $LongitudeEast,
            CountryCode: $CountryCode,
            DeliveryDate: $DeliveryDate,
            OpeningTime: $OpeningTime,
            DeliveryOptions: $DeliveryOptions,
        ));
    }

//
//    /**
//     * All-in-one function for checkout widgets. It retrieves and returns the
//     * - timeframes
//     * - locations
//     * - delivery date.
//     *
//     * @param GetTimeframes       $getTimeframes
//     * @param GetNearestLocations $getNearestLocations
//     * @param CalculateDeliveryDate     $calculateDeliveryDate
//     *
//     * @return array [uuid => ResponseTimeframes, uuid => GetNearestLocationsResponse, uuid => CalculateDeliveryDateResponse]
//     *
//     * @throws InvalidArgumentException
//     */
//    public function getTimeframesAndNearestLocations(
//        GetTimeframes $getTimeframes,
//        GetNearestLocations $getNearestLocations,
//        CalculateDeliveryDate $calculateDeliveryDate
//    ): array {
//        $results = [];
//        $itemTimeframe = static->getTimeframeService()->retrieveCachedItem(uuid: $getTimeframes->getId());
//        if ($itemTimeframe instanceof CacheItemInterface && $itemTimeframe->get()) {
//            $results['timeframes'] = parse_response(message: $itemTimeframe->get());
//        }
//        $itemLocation = static->getLocationService()->retrieveCachedItem(uuid: $getNearestLocations->getId());
//        if ($itemLocation instanceof CacheItemInterface && $itemLocation->get()) {
//            $results['locations'] = parse_response(message: $itemLocation->get());
//        }
//        $itemDeliveryDate = static->getDeliveryDateService()->retrieveCachedItem(uuid: $calculateDeliveryDate->getId());
//        if ($itemDeliveryDate instanceof CacheItemInterface && $itemDeliveryDate->get()) {
//            $results['delivery_date'] = parse_response(message: $itemDeliveryDate->get());
//        }
//
//        static->getHttpClient()->addOrUpdateRequest(
//            id: 'timeframes',
//            request: static->getTimeframeService()->buildGetTimeframesRequest($getTimeframes)
//        );
//        static->getHttpClient()->addOrUpdateRequest(
//            id: 'locations',
//            request: static->getLocationService()->buildGetNearestLocationsRequest(getNearestLocations: $getNearestLocations)
//        );
//        static->getHttpClient()->addOrUpdateRequest(
//            id: 'delivery_date',
//            request: static->getDeliveryDateService()->buildCalculateDeliveryDateRequest(calculateDeliveryDate: $calculateDeliveryDate)
//        );
//
//        $responses = static->getHttpClient()->doRequests();
//        foreach ($responses as $uuid => $response) {
//            if ($response instanceof Response) {
//                $results[$uuid] = $response;
//            } else {
//                if ($response instanceof Exception) {
//                    throw $response;
//                }
//                throw new InvalidArgumentException('Invalid multi-request');
//            }
//        }
//
//        foreach ($responses as $type => $response) {
//            if (!$response instanceof Response) {
//                if ($response instanceof Exception) {
//                    throw $response;
//                }
//                throw new InvalidArgumentException('Invalid multi-request');
//            } elseif (200 === $response->getStatusCode()) {
//                switch ($type) {
//                    case 'timeframes':
//                        if ($itemTimeframe instanceof CacheItemInterface) {
//                            $itemTimeframe->set(value: str(message: $response));
//                            static->getTimeframeService()->cacheItem(item: $itemTimeframe);
//                        }
//
//                        break;
//                    case 'locations':
//                        if ($itemTimeframe instanceof CacheItemInterface) {
//                            $itemLocation->set(value: str(message: $response));
//                            static->getLocationService()->cacheItem(item: $itemLocation);
//                        }
//
//                        break;
//                    case 'delivery_date':
//                        if ($itemTimeframe instanceof CacheItemInterface) {
//                            $itemDeliveryDate->set(value: str(message: $response));
//                            static->getDeliveryDateService()->cacheItem(item: $itemDeliveryDate);
//                        }
//
//                        break;
//                }
//            }
//        }
//
//        return [
//            'timeframes'    => static->getTimeframeService()->processGetTimeframesResponse(response: $results['timeframes']),
//            'locations'     => static->getLocationService()->processGetNearestLocationsResponse(response: $results['locations']),
//            'delivery_date' => static->getDeliveryDateService()->processCalculateDeliveryDateResponse(response: $results['delivery_date']),
//        ];
//    }
//
//    /**
//     * Get locations in area.
//     *
//     * @param GetLocationsInArea $getLocationsInArea
//     *
//     * @return GetLocationsInAreaResponse
//     */
//    public function getLocationsInArea(GetLocationsInArea $getLocationsInArea): GetLocationsInAreaResponse
//    {
//        return static->getLocationService()->getLocationsInArea(getLocations: $getLocationsInArea);
//    }
//
//    /**
//     * Get locations in area.
//     *
//     * @param GetLocation $getLocation
//     *
//     * @return GetLocationsInAreaResponse
//     */
//    public function getLocation(GetLocation $getLocation): GetLocationsInAreaResponse
//    {
//        return static->getLocationService()->getLocation(getLocation: $getLocation);
//    }

    /**
     * Barcode service.
     *
     * Automatically load the barcode service
     */
    public function getBarcodeService(): BarcodeServiceInterface
    {
        if (!$this->barcodeService) {
            $this->setBarcodeService(service: new BarcodeService(
                customer: $this->getCustomer(),
                apiKey: $this->getApiKey(),
                sandbox: $this->getSandbox(),
                gateway: new BarcodeServiceGateway(
                    httpClient: $this->getHttpClient(),
                    cache: null,
                    ttl: null,
                    requestBuilder: new BarcodeServiceRequestBuilder(
                        customer: $this->getCustomer(),
                        apiKey: $this->getApiKey(),
                        sandbox: $this->getSandbox(),
                    ),
                    responseProcessor: new BarcodeServiceResponseProcessor(),
                ),
            ));
        }

        return $this->barcodeService;
    }

    /**
     * Set the barcode service.
     *
     * @param BarcodeServiceInterface $service
     */
    public function setBarcodeService(BarcodeServiceInterface $service): void
    {
        $this->barcodeService = $service;
    }

    /**
     * Checkout service.
     *
     * Automatically load the checkout service
     *
     * @return CheckoutServiceInterface
     */
    public function getCheckoutService(): CheckoutServiceInterface
    {
        if (!$this->checkoutService) {
            $this->setCheckoutService(
                service: new CheckoutService(
                    customer: $this->getCustomer(),
                    apiKey: $this->getApiKey(),
                    sandbox: $this->getSandbox(),
                    gateway: new CheckoutServiceGateway(
                        httpClient: $this->getHttpClient(),
                        cache: null,
                        ttl: null,
                        requestBuilder: new CheckoutServiceRequestBuilder(
                            customer: $this->getCustomer(),
                            apiKey: $this->getApiKey(),
                            sandbox: $this->getSandbox(),
                        ),
                        responseProcessor: new CheckoutServiceResponseProcessor(),
                    ),
                )
            );
        }

        return $this->checkoutService;
    }

    /**
     * Set the checkout service.
     *
     * @param CheckoutServiceInterface $service
     */
    public function setCheckoutService(CheckoutServiceInterface $service): void
    {
        $this->checkoutService = $service;
    }

    /**
     * Labelling service.
     *
     * Automatically load the labelling service
     *
     * @return LabellingServiceInterface
     */
    public function getLabellingService(): LabellingServiceInterface
    {
        return $this->labellingService;
    }

    /**
     * Set the labelling service.
     *
     * @param LabellingServiceInterface $service
     */
    public function setLabellingService(LabellingServiceInterface $service): void
    {
        $this->labellingService = $service;
    }

    /**
     * Confirming service.
     *
     * Automatically load the confirming service
     *
     * @return ConfirmingServiceInterface
     */
    public function getConfirmingService(): ConfirmingServiceInterface
    {
        if (!$this->confirmingService) {
            $this->setConfirmingService(service: new ConfirmingService($this));
        }

        return $this->confirmingService;
    }

    /**
     * Set the confirming service.
     *
     * @param ConfirmingServiceInterface $service
     */
    public function setConfirmingService(ConfirmingServiceInterface $service): void
    {
        $this->confirmingService = $service;
    }

    /**
     * Shipping status service.
     *
     * Automatically load the shipping status service
     *
     * @return ShippingStatusServiceInterface
     */
    public function getShippingStatusService(): ShippingStatusServiceInterface
    {
        if (!$this->shippingStatusService) {
            $this->setShippingStatusService(service: new ShippingStatusService(
                customer: $this->getCustomer,
            ));
        }

        return $this->shippingStatusService;
    }

    /**
     * Set the shipping status service.
     *
     * @param ShippingStatusServiceInterface $service
     */
    public function setShippingStatusService(ShippingStatusServiceInterface $service): void
    {
        $this->shippingStatusService = $service;
    }

    /**
     * Delivery date service.
     *
     * Automatically load the delivery date service
     *
     * @return DeliveryDateServiceInterface
     */
    public function getDeliveryDateService(): DeliveryDateServiceInterface
    {
        if (!$this->deliveryDateService) {
            $this->setDeliveryDateService(service: new DeliveryDateService(
                customer: $this->getCustomer(),
                apiKey: $this->getApiKey(),
                sandbox: $this->getSandbox(),
                gateway: new DeliveryDateServiceGateway(httpClient: $this->getHttpClient(),
                    cache: null,
                    ttl: null,
                    requestBuilder: new DeliveryDateServiceRequestBuilder(
                        customer: $this->getCustomer(),
                        apiKey: $this->getApiKey(),
                        sandbox: $this->getSandbox(),
                    ),
                    responseProcessor: new DeliveryDateServiceResponseProcessor(),
                ),
            ));
        }

        return $this->deliveryDateService;
    }

    /**
     * Set the delivery date service.
     *
     * @param DeliveryDateServiceInterface $service
     */
    public function setDeliveryDateService(DeliveryDateServiceInterface $service): void
    {
        $this->deliveryDateService = $service;
    }

    /**
     * Timeframe service.
     *
     * Automatically load the timeframe service
     *
     * @return TimeframeServiceInterface
     */
    public function getTimeframeService(): TimeframeServiceInterface
    {
        if (!$this->timeframeService) {
            $this->setTimeframeService(service: new TimeframeService(
                customer: $this->getCustomer(),
                apiKey: $this->getApiKey(),
                sandbox: $this->getSandbox(),
                gateway: new TimeframeServiceGateway(httpClient: $this->getHttpClient(),
                cache: null,
                ttl: null,
                    requestBuilder: new TimeframeServiceRequestBuilder(
                        customer: $this->getCustomer(),
                        apiKey: $this->getApiKey(),
                        sandbox: $this->getSandbox(),
                    ),
                    responseProcessor: new TimeframeServiceResponseProcessor(),
                ),
            ));
        }

        return $this->timeframeService;
    }

    /**
     * Set the timeframe service.
     *
     * @param TimeframeServiceInterface $service
     */
    public function setTimeframeService(TimeframeServiceInterface $service): void
    {
        $this->timeframeService = $service;
    }

    /**
     * Location service.
     *
     * Automatically load the location service
     *
     * @return LocationServiceInterface
     */
    public function getLocationService(): LocationServiceInterface
    {
        if (!$this->locationService) {
            $this->setLocationService(service: new LocationService(
                customer: $this->getCustomer(),
                apiKey: $this->getApiKey(),
                sandbox: $this->getSandbox(),
                gateway: new LocationServiceGateway(httpClient: $this->getHttpClient(),
                    cache: null,
                    ttl: null,
                    requestBuilder: new LocationServiceRequestBuilder(
                        customer: $this->getCustomer(),
                        apiKey: $this->getApiKey(),
                        sandbox: $this->getSandbox(),
                    ),
                    responseProcessor: new LocationServiceResponseProcessor(),
                ),
            ));
        }

        return $this->locationService;
    }

    /**
     * Set the location service.
     *
     * @param LocationServiceInterface $service
     */
    public function setLocationService(LocationServiceInterface $service): void
    {
        $this->locationService = $service;
    }

    /**
     * Shipping service.
     *
     * Automatically load the shipping service
     *
     * @return ShippingServiceInterface
     */
    public function getShippingService(): ShippingServiceInterface
    {
        if (!$this->shippingService) {
            $this->setShippingService(service: new ShippingService($this));
        }

        return $this->shippingService;
    }

    /**
     * Set the shipping service.
     *
     * @param ShippingService $service
     */
    public function setShippingService(ShippingService $service): void
    {
        $this->shippingService = $service;
    }

    #[ArrayShape(shape: [
        BarcodeServiceInterface::class        => BarcodeServiceInterface::class,
        CheckoutServiceInterface::class       => CheckoutServiceInterface::class,
        ConfirmingServiceInterface::class     => ConfirmingServiceInterface::class,
        DeliveryDateServiceInterface::class   => DeliveryDateServiceInterface::class,
        LabellingServiceInterface::class      => LabellingServiceInterface::class,
        LocationServiceInterface::class       => LocationServiceInterface::class,
        ShippingServiceInterface::class       => ShippingServiceInterface::class,
        ShippingStatusServiceInterface::class => ShippingStatusServiceInterface::class,
        TimeframeServiceInterface::class      => TimeframeServiceInterface::class,
    ])]
    public function getAllServices(): array
    {
        return [
            BarcodeServiceInterface::class        => $this->getBarcodeService(),
            CheckoutService::class                => $this->getConfirmingService(),
            ConfirmingServiceInterface::class     => $this->getConfirmingService(),
            DeliveryDateServiceInterface::class   => $this->getDeliveryDateService(),
            LabellingServiceInterface::class      => $this->getLabellingService(),
            LocationServiceInterface::class       => $this->getLocationService(),
            ShippingServiceInterface::class       => $this->getShippingService(),
            ShippingStatusServiceInterface::class => $this->getShippingStatusService(),
            TimeframeServiceInterface::class      => $this->getTimeframeService(),
        ];
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): static
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getSandbox(): bool
    {
        return $this->sandbox;
    }

    public function setSandbox(bool $sandbox): static
    {
        $this->sandbox = $sandbox;

        return $this;
    }

    public function getHttpClient(): HttpClientInterface
    {
        if (!$this->httpClient) {
            $this->httpClient = new HTTPlugHttpClient(logger: $this->getLogger());
        }

        return $this->httpClient;
    }

    public function setHttpClient(HttpClientInterface $httpClient): static
    {
        $this->httpClient = $httpClient;

        $this->getBarcodeService()->setHttpClient(httpClient: $httpClient);
        $this->getCheckoutService()->setHttpClient(httpClient: $httpClient);
        $this->getConfirmingService()->setHttpClient(httpClient: $httpClient);
        $this->getDeliveryDateService()->setHttpClient(httpClient: $httpClient);
        $this->getLabellingService()->setHttpClient(httpClient: $httpClient);
        $this->getLocationService()->setHttpClient(httpClient: $httpClient);
        $this->getShippingService()->setHttpClient(httpClient: $httpClient);
        $this->getShippingStatusService()->setHttpClient(httpClient: $httpClient);
        $this->getTimeframeService()->setHttpClient(httpClient: $httpClient);

        return $this;
    }

    public function getLogger(): LoggerInterface|null
    {
        return $this->logger;
    }

    public function setLogger(LoggerInterface|null $logger = null): static
    {
        $this->logger = $logger;

        $this->getBarcodeService()->setLogger(logger: $logger);
        $this->getCheckoutService()->setLogger(logger: $logger);
        $this->getConfirmingService()->setLogger(logger: $logger);
        $this->getDeliveryDateService()->setLogger(logger: $logger);
        $this->getLabellingService()->setLogger(logger: $logger);
        $this->getLocationService()->setLogger(logger: $logger);
        $this->getShippingService()->setLogger(logger: $logger);
        $this->getShippingStatusService()->setLogger(logger: $logger);
        $this->getTimeframeService()->setLogger(logger: $logger);

        return $this;
    }
}
