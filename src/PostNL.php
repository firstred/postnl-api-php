<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * *Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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

use Firstred\PostNL\Entity\Barcode;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Label;
use Firstred\PostNL\Entity\Message\LabellingMessage;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Request\CompleteStatus;
use Firstred\PostNL\Entity\Request\CompleteStatusByPhase;
use Firstred\PostNL\Entity\Request\CompleteStatusByReference;
use Firstred\PostNL\Entity\Request\CompleteStatusByStatus;
use Firstred\PostNL\Entity\Request\Confirming;
use Firstred\PostNL\Entity\Request\CurrentStatus;
use Firstred\PostNL\Entity\Request\CurrentStatusByPhase;
use Firstred\PostNL\Entity\Request\CurrentStatusByReference;
use Firstred\PostNL\Entity\Request\CurrentStatusByStatus;
use Firstred\PostNL\Entity\Request\GenerateBarcode;
use Firstred\PostNL\Entity\Request\GenerateLabel;
use Firstred\PostNL\Entity\Request\GetDeliveryDate;
use Firstred\PostNL\Entity\Request\GetLocation;
use Firstred\PostNL\Entity\Request\GetLocationsInArea;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Entity\Request\GetSentDateRequest;
use Firstred\PostNL\Entity\Request\GetSignature;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Response\CompleteStatusResponse;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Entity\Response\CurrentStatusResponse;
use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Entity\Response\GetDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\GetLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Entity\Response\GetSentDateResponse;
use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Exception\AbstractException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidBarcodeException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\HttpClient\ClientInterface;
use Firstred\PostNL\HttpClient\CurlClient;
use Firstred\PostNL\HttpClient\GuzzleClient;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;
use Firstred\PostNL\Util\RFPdi;
use Firstred\PostNL\Util\Util;
use GuzzleHttp\Psr7\Response;
use Psr\Cache\CacheItemInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use setasign\Fpdi\PdfParser\StreamReader;

/**
 * Class PostNL
 */
class PostNL implements LoggerAwareInterface
{
    // REST API
    const MODE_REST = 1;
    // SOAP API
    const MODE_SOAP = 2;

    /**
     * 3S (or EU Pack Special) countries
     *
     * @var array
     */
    public static $threeSCountries = [
        'AT',
        'BE',
        'BG',
        'CZ',
        'DK',
        'EE',
        'FI',
        'FR',
        'DE',
        'GB',
        'GR',
        'HU',
        'IE',
        'IT',
        'LV',
        'LT',
        'LU',
        'NL',
        'PL',
        'PT',
        'RO',
        'SK',
        'SI',
        'ES',
        'EE',
        'CN',
    ];

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
     * Verify SSL certificate of the PostNL API
     *
     * @var bool $verifySslCerts
     */
    public $verifySslCerts = true;

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

    /** @var ClientInterface $httpClient */
    protected $httpClient;

    /** @var LoggerInterface $logger */
    protected $logger;

    /**
     * This is the current mode
     *
     * @var int $mode
     */
    protected $mode;

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

    /**
     * PostNL constructor.
     *
     * @param Customer $customer Customer object
     * @param string   $apiKey   API key
     * @param bool     $sandbox  Sandbox mode
     * @param int      $mode     Set the preferred connection strategy.
     *                           Valid options are:
     *                           - `MODE_REST`: New REST API
     *                           - `MODE_SOAP`: New SOAP API
     *
     * @throws InvalidArgumentException
     */
    public function __construct(Customer $customer, string $apiKey, bool $sandbox, int $mode = self::MODE_REST)
    {
        $this->setCustomer($customer);
        $this->setApiKey($apiKey);
        $this->setSandbox((bool) $sandbox);
        $this->setMode((int) $mode);
    }

    /**
     * Get REST API Key
     *
     * @return string REST API Key
     *
     * @since 2.0.0
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Get sandbox mode
     *
     * @return bool
     *
     * @since 1.0.0
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
    public function setSandbox(bool $sandbox): self
    {
        $this->sandbox = $sandbox;

        return $this;
    }

    /**
     * Get the current mode
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function getMode(): int
    {
        return $this->mode;
    }

    /**
     * Set current mode
     *
     * @param int $mode
     *
     * @return self
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 Return `self`
     */
    public function setMode(int $mode): self
    {
        if (!in_array(
            $mode,
            [
                static::MODE_REST,
                static::MODE_SOAP,
            ]
        )) {
            throw new InvalidArgumentException('Mode not supported');
        }

        $this->mode = $mode;

        return $this;
    }

    /**
     * Get the logger
     *
     * @return LoggerInterface
     *
     * @since 1.0.0
     */
    public function getLogger(): LoggerInterface
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
    public function setLogger(LoggerInterface $logger = null): self
    {
        $this->logger = $logger;
        if ($this->getHttpClient() instanceof ClientInterface) {
            $this->getHttpClient()->setLogger($logger);
        }

        return $this;
    }

    /**
     * HttpClient
     *
     * Automatically load Guzzle when available
     *
     * @return ClientInterface
     *
     * @since 1.0.0
     */
    public function getHttpClient(): ClientInterface
    {
        // @codeCoverageIgnoreStart
        if (!$this->httpClient) {
            if (interface_exists('\\GuzzleHttp\\ClientInterface')
                && version_compare(
                    \GuzzleHttp\ClientInterface::VERSION,
                    '6.0.0',
                    '>='
                )) {
                $this->httpClient = GuzzleClient::getInstance();
            } else {
                $this->httpClient = CurlClient::getInstance();
            }
        }

        // @codeCoverageIgnoreEnd

        return $this->httpClient;
    }

    /**
     * Set the HttpClient
     *
     * @param ClientInterface $client
     *
     * @return self
     *
     * @since 1.0.0
     * @since 2.0.0 Return `self`
     */
    public function setHttpClient(ClientInterface $client): self
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * Generate a single barcode
     *
     * @param string $type
     * @param string $range
     * @param string $serie
     * @param bool   $eps
     *
     * @return string The barcode as a string
     *
     * @throws InvalidBarcodeException
     * @throws \Exception
     *
     * @since 1.0.0
     */
    public function generateBarcode($type = '3S', $range = null, $serie = null, $eps = false): string
    {
        if (!in_array($type, ['2S', '3S']) || strlen($type) !== 2) {
            throw new InvalidBarcodeException("Barcode type `$type` is invalid");
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

        return $this->getBarcodeService()->generateBarcode(
            new GenerateBarcode(new Barcode($type, $range, $serie), $this->customer)
        );
    }

    /**
     * Get PostNL Customer
     *
     * @return Customer
     *
     * @since 1.0.0
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
    public function setCustomer(Customer $customer): self
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
     * @since 2.0.0 Return `self`
     */
    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
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
     */
    public function findBarcodeSerie($type, $range, $eps)
    {
        switch ($type) {
            case '2S':
                $serie = '0000000-9999999';

                break;
            case '3S':
                if ($eps) {
                    switch (strlen($range)) {
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
                $serie = (strlen($range) === 4 ? '987000000-987600000' : '0000000-9999999');

                break;
            default:
                // GlobalPack
                $serie = '0000-9999';

                break;
        }

        return $serie;
    }

    /**
     * Barcode service
     *
     * Automatically load the barcode service
     *
     * @return BarcodeService
     *
     * @since 1.0.0
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
     * @since 2.0.0 Return `self`
     */
    public function setBarcodeService(BarcodeService $service): self
    {
        $this->barcodeService = $service;

        return $this;
    }

    /**
     * Generate a single barcode by country code
     *
     * @param string $iso 2-letter Country ISO Code
     *
     * @return string The Barcode as a string
     *
     * @throws InvalidConfigurationException
     * @throws InvalidBarcodeException
     * @throws \Exception
     *
     * @since 1.0.0
     */
    public function generateBarcodeByCountryCode($iso): string
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

        return $this->getBarcodeService()->generateBarcode(
            new GenerateBarcode(new Barcode($type, $range, $serie), $this->customer)
        );
    }

    /**
     * Generate a single barcode by country code
     *
     * @param  array $isos key = iso code, value = amount of barcodes requested
     *
     * @return array Country isos with the barcode as string
     *
     * @throws InvalidConfigurationException
     * @throws InvalidBarcodeException
     * @throws \Exception
     *
     * @since 1.0.0
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
                $generateBarcodes[] = (new GenerateBarcode(new Barcode($type, $range, $serie), $this->customer))->setId(
                    "$iso-$index"
                );
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
     * @throws \Exception
     *
     * @since 1.0.0
     */
    public function generateLabel(Shipment $shipment, ?string $printerType = 'GraphicFile|PDF', ?bool $confirm = true): GenerateLabelResponse
    {
        return $this->getLabellingService()->generateLabel(
            new GenerateLabel(
                [$shipment],
                new LabellingMessage($printerType),
                $this->customer
            ),
            $confirm
        );
    }

    /**
     * Labelling service
     *
     * Automatically load the labelling service
     *
     * @return LabellingService
     *
     * @since 1.0.0
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
    public function setLabellingService(LabellingService $service): self
    {
        $this->labellingService = $service;

        return $this;
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
     * @throws AbstractException
     * @throws NotSupportedException
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \setasign\Fpdi\PdfParser\Filter\FilterException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     * @throws \Exception
     *
     * @since 1.0.0
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
            $generateLabels[$uuid] = [
                (new GenerateLabel(
                    [$shipment],
                    new LabellingMessage($printerType),
                    $this->customer
                ))->setId($uuid),
                $confirm,
            ];
        }
        $labels = $this->getLabellingService()->generateLabels($generateLabels, $confirm);

        if (!$merge) {
            return $labels;
        }

        foreach ($labels as $label) {
            if (!$label instanceof GenerateLabelResponse) {
                return $labels;
            }
        }

        // Disable header and footer
        $pdf = new RFPdi('P', 'mm', $format === Label::FORMAT_A4 ? [210, 297] : [105, 148]);
        $deferred = [];
        $firstPage = true;
        if (Label::FORMAT_A6 === $format) {
            foreach ($labels as $label) {
                $pdfContent = base64_decode($label->getResponseShipments()[0]->getLabels()[0]->getContent());
                $sizes = Util::getPdfSizeAndOrientation($pdfContent);
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
                if ($label instanceof AbstractException) {
                    throw $label;
                }
                $pdfContent = base64_decode($label->getResponseShipments()[0]->getLabels()[0]->getContent());
                $sizes = Util::getPdfSizeAndOrientation($pdfContent);
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
    }

    /**
     * Confirm a single shipment
     *
     * @param Shipment $shipment
     *
     * @return ConfirmingResponseShipment
     *
     * @throws \Exception
     *
     * @since 1.0.0
     */
    public function confirmShipment(Shipment $shipment): ConfirmingResponseShipment
    {
        return $this->getConfirmingService()->confirmShipment(new Confirming([$shipment], $this->customer));
    }

    /**
     * Confirming service
     *
     * Automatically load the confirming service
     *
     * @return ConfirmingService
     *
     * @since 1.0.0
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
    public function setConfirmingService(ConfirmingService $service): self
    {
        $this->confirmingService = $service;

        return $this;
    }

    /**
     * Confirm multiple shipments
     *
     * @param array $shipments
     *
     * @return ConfirmingResponseShipment[]
     *
     * @throws \Exception
     *
     * @since 1.0.0
     */
    public function confirmShipments(array $shipments): array
    {
        $confirmations = [];
        foreach ($shipments as $uuid => $shipment) {
            $confirmations[$uuid] = (new Confirming([$shipment], $this->customer))->setId($uuid);
        }

        return $this->getConfirmingService()->confirmShipments($confirmations);
    }

    /**
     * Get the current status of a shipment
     *
     * This is a combined function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     * - CurrentStatusByPhase:
     *   - Fill the Shipment->PhaseCode property, do not pass Barcode or Reference.
     *     Optionally add DateFrom and/or DateTo.
     * - CurrentStatusByStatus:
     *   - Fill the Shipment->StatusCode property. Leave the rest empty.
     *
     * @param CurrentStatus|CurrentStatusByStatus|CurrentStatusByReference|CurrentStatusByPhase $currentStatus
     *
     * @return CurrentStatusResponse
     *
     * @throws \Exception
     *
     * @since 1.0.0
     */
    public function getCurrentStatus($currentStatus): CurrentStatusResponse
    {
        $fullCustomer = $this->getCustomer();
        $currentStatus->setCustomer(
            (new Customer())
                ->setCustomerCode($fullCustomer->getCustomerCode())
                ->setCustomerNumber($fullCustomer->getCustomerNumber())
        );
        if (!$currentStatus->getMessage()) {
            $currentStatus->setMessage(new Message());
        }

        return $this->getShippingStatusService()->currentStatus($currentStatus);
    }

    /**
     * Shipping status service
     *
     * Automatically load the shipping status service
     *
     * @return ShippingStatusService
     *
     * @since 1.0.0
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
    public function setShippingStatusService(ShippingStatusService $service): self
    {
        $this->shippingStatusService = $service;

        return $this;
    }

    /**
     * Get the complete status of a shipment
     *
     * This is a combined function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     * - CurrentStatusByPhase:
     *   - Fill the Shipment->PhaseCode property, do not pass Barcode or Reference.
     *     Optionally add DateFrom and/or DateTo.
     * - CurrentStatusByStatus:
     *   - Fill the Shipment->StatusCode property. Leave the rest empty.
     *
     * @param CompleteStatus|CompleteStatusByStatus|CompleteStatusByReference|CompleteStatusByPhase $completeStatus
     *
     * @return CompleteStatusResponse
     *
     * @throws \Exception
     *
     * @since 1.0.0
     */
    public function getCompleteStatus($completeStatus): CompleteStatusResponse
    {
        $fullCustomer = $this->getCustomer();

        $completeStatus->setCustomer(
            (new Customer())
                ->setCustomerCode($fullCustomer->getCustomerCode())
                ->setCustomerNumber($fullCustomer->getCustomerNumber())
        );
        if (!$completeStatus->getMessage()) {
            $completeStatus->setMessage(new Message());
        }

        return $this->getShippingStatusService()->completeStatus($completeStatus);
    }

    /**
     * Get the signature of a shipment
     *
     * @param GetSignature $signature
     *
     * @return GetSignatureResponseSignature
     *
     * @throws \Exception
     *
     * @since 1.0.0
     */
    public function getSignature(GetSignature $signature): GetSignatureResponseSignature
    {
        $signature->setCustomer($this->getCustomer());
        if (!$signature->getMessage()) {
            $signature->setMessage(new Message());
        }

        return $this->getShippingStatusService()->getSignature($signature);
    }

    /**
     * Get a delivery date
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return GetDeliveryDateResponse
     */
    public function getDeliveryDate(GetDeliveryDate $getDeliveryDate): GetDeliveryDateResponse
    {
        return $this->getDeliveryDateService()->getDeliveryDate($getDeliveryDate);
    }

    /**
     * Delivery date service
     *
     * Automatically load the delivery date service
     *
     * @return DeliveryDateService
     *
     * @since 1.0.0
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
    public function setDeliveryDateService(DeliveryDateService $service): self
    {
        $this->deliveryDateService = $service;

        return $this;
    }

    /**
     * Get a shipping date
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return GetSentDateResponse
     */
    public function getSentDate(GetSentDateRequest $getSentDate): GetSentDateResponse
    {
        return $this->getDeliveryDateService()->getSentDate($getSentDate);
    }

    /**
     * Get timeframes
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return ResponseTimeframes
     */
    public function getTimeframes(GetTimeframes $getTimeframes)
    {
        return $this->getTimeframeService()->getTimeframes($getTimeframes);
    }

    /**
     * Timeframe service
     *
     * Automatically load the timeframe service
     *
     * @return TimeframeService
     *
     * @since 1.0.0
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
     * @return self
     *
     * @since 1.0.0
     * @since 2.0.0 Return `self`
     */
    public function setTimeframeService(TimeframeService $service): self
    {
        $this->timeframeService = $service;

        return $this;
    }

    /**
     * Get nearest locations
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return GetNearestLocationsResponse
     */
    public function getNearestLocations(GetNearestLocations $getNearestLocations)
    {
        return $this->getLocationService()->getNearestLocations($getNearestLocations);
    }

    /**
     * Location service
     *
     * Automatically load the location service
     *
     * @return LocationService
     *
     * @since 1.0.0
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
     * @return self
     *
     * @since 1.0.0
     * @since 2.0.0 Return `self`
     */
    public function setLocationService(LocationService $service)
    {
        $this->locationService = $service;

        return $this;
    }

    /**
     * All-in-one function for checkout widgets. It retrieves and returns the
     * - timeframes
     * - locations
     * - delivery date
     *
     * @param GetTimeframes       $getTimeframes
     * @param GetNearestLocations $getNearestLocations
     * @param GetDeliveryDate     $getDeliveryDate
     *
     * @return array [uuid => ResponseTimeframes, uuid => GetNearestLocationsResponse, uuid => GetDeliveryDateResponse]
     *
     * @throws InvalidArgumentException
     * @throws \Exception
     *
     * @since 1.0.0
     */
    public function getTimeframesAndNearestLocations(GetTimeframes $getTimeframes, GetNearestLocations $getNearestLocations, GetDeliveryDate $getDeliveryDate)
    {
        $results = [];
        $itemTimeframe = $this->getTimeframeService()->retrieveCachedItem($getTimeframes->getId());
        if ($itemTimeframe instanceof CacheItemInterface && $itemTimeframe->get()) {
            $results['timeframes'] = \GuzzleHttp\Psr7\parse_response($itemTimeframe->get());
        }
        $itemLocation = $this->getLocationService()->retrieveCachedItem($getNearestLocations->getId());
        if ($itemLocation instanceof CacheItemInterface && $itemLocation->get()) {
            $results['locations'] = \GuzzleHttp\Psr7\parse_response($itemLocation->get());
        }
        $itemDeliveryDate = $this->getDeliveryDateService()->retrieveCachedItem($getDeliveryDate->getId());
        if ($itemDeliveryDate instanceof CacheItemInterface && $itemDeliveryDate->get()) {
            $results['delivery_date'] = \GuzzleHttp\Psr7\parse_response($itemDeliveryDate->get());
        }

        $this->getHttpClient()->addOrUpdateRequest(
            'timeframes',
            $this->getTimeframeService()->buildGetTimeframesRequest($getTimeframes)
        );
        $this->getHttpClient()->addOrUpdateRequest(
            'locations',
            $this->getLocationService()->buildGetNearestLocationsRequest($getNearestLocations)
        );
        $this->getHttpClient()->addOrUpdateRequest(
            'delivery_date',
            $this->getDeliveryDateService()->buildGetDeliveryDateRequest($getDeliveryDate)
        );

        $responses = $this->getHttpClient()->doRequests();
        foreach ($responses as $uuid => $response) {
            if ($response instanceof Response) {
                $results[$uuid] = $response;
            } else {
                if ($response instanceof \Exception) {
                    throw $response;
                }
                throw new InvalidArgumentException('Invalid multi-request');
            }
        }

        foreach ($responses as $type => $response) {
            if (!$response instanceof Response) {
                if ($response instanceof \Exception) {
                    throw $response;
                }
                throw new InvalidArgumentException('Invalid multi-request');
            } elseif ($response->getStatusCode() === 200) {
                switch ($type) {
                    case 'timeframes':
                        if ($itemTimeframe instanceof CacheItemInterface) {
                            $itemTimeframe->set(\GuzzleHttp\Psr7\str($response));
                            $this->getTimeframeService()->cacheItem($itemTimeframe);
                        }

                        break;
                    case 'locations':
                        if ($itemTimeframe instanceof CacheItemInterface) {
                            $itemLocation->set(\GuzzleHttp\Psr7\str($response));
                            $this->getLocationService()->cacheItem($itemLocation);
                        }

                        break;
                    case 'delivery_date':
                        if ($itemTimeframe instanceof CacheItemInterface) {
                            $itemDeliveryDate->set(\GuzzleHttp\Psr7\str($response));
                            $this->getDeliveryDateService()->cacheItem($itemDeliveryDate);
                        }

                        break;
                }
            }
        }

        return [
            'timeframes'    => $this->getTimeframeService()->processGetTimeframesResponse($results['timeframes']),
            'locations'     => $this->getLocationService()->processGetNearestLocationsResponse($results['locations']),
            'delivery_date' => $this->getDeliveryDateService()->processGetDeliveryDateResponse(
                $results['delivery_date']
            ),
        ];
    }

    /**
     * Get locations in area
     *
     * @param GetLocationsInArea $getLocationsInArea
     *
     * @return GetLocationsInAreaResponse
     */
    public function getLocationsInArea(GetLocationsInArea $getLocationsInArea)
    {
        return $this->getLocationService()->getLocationsInArea($getLocationsInArea);
    }

    /**
     * Get locations in area
     *
     * @param GetLocation $getLocation
     *
     * @return GetLocationsInAreaResponse
     */
    public function getLocation(GetLocation $getLocation)
    {
        return $this->getLocationService()->getLocation($getLocation);
    }
}
