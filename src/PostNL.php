<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker
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
 * @copyright 2017-2019 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL;

use GuzzleHttp\Psr7\Response;
use Psr\Cache\CacheItemInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use setasign\Fpdi\PdfParser\StreamReader;
use Firstred\PostNL\Entity\Barcode;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Label;
use Firstred\PostNL\Entity\Message\LabellingMessage;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Request\CompleteStatus;
use Firstred\PostNL\Entity\Request\Confirming;
use Firstred\PostNL\Entity\Request\CurrentStatus;
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
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Entity\SOAP\UsernameToken;
use Firstred\PostNL\Exception\AbstractException;
use Firstred\PostNL\Exception\HttpClientException;
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

/**
 * Class PostNL
 *
 * @package Firstred\PostNL
 */
class PostNL implements LoggerAwareInterface
{
    // New REST API
    const MODE_REST = 1;
    // New SOAP API
    const MODE_SOAP = 2;
    // Old SOAP API
    const MODE_LEGACY = 5;

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
    ];

    /**
     * A6 positions
     * (index = amount of a6 left on the page)
     *
     * @var array
     */
    public static $a6positions = [
        4 => [-276, 2  ],
        3 => [-132, 2  ],
        2 => [-276, 110],
        1 => [-132, 110],
    ];

    /**
     * Verify SSL certificate of the PostNL REST API
     *
     * @var bool $verifySslCerts
     */
    public $verifySslCerts = true;

    /**
     * The PostNL REST API key or SOAP username/password to be used for requests.
     *
     * In case of REST the API key is the `Password` property of the `UsernameToken`
     * In case of SOAP this has to be a `UsernameToken` object, with the following requirements:
     *   - When using the legacy API, the username has to be given.
     *     The password has to be plain text.
     *   - When using the newer API (launched August 2017), do not pass a username (`null`)
     *     And pass the plaintext password.
     *
     * @var string $apiKey
     */
    protected $token;

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
     * @param Customer             $customer
     * @param UsernameToken|string $token
     * @param bool                 $sandbox
     * @param int                  $mode     Set the preferred connection strategy.
     *                                       Valid options are:
     *                                         - `MODE_REST`: New REST API
     *                                         - `MODE_SOAP`: New SOAP API
     *                                         - `MODE_LEGACY`: Use the legacy API (the plug can
     *                                            be pulled at any time)
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        Customer $customer,
        $token,
        $sandbox,
        $mode = self::MODE_REST
    ) {
        $this->setCustomer($customer);
        $this->setToken($token);
        $this->setSandbox((bool) $sandbox);
        $this->setMode((int) $mode);
    }

    /**
     * Set the token
     *
     * @param string|UsernameToken $token
     *
     * @return PostNL
     * @throws InvalidArgumentException
     */
    public function setToken($token)
    {
        if ($token instanceof UsernameToken) {
            $this->token = $token;

            return $this;
        } elseif (is_string($token)) {
            $this->token = new UsernameToken(null, $token);

            return $this;
        }

        throw new InvalidArgumentException('Invalid username/token');
    }

    /**
     * Get REST API Key
     *
     * @return bool|string
     */
    public function getRestApiKey()
    {
        if ($this->token instanceof UsernameToken) {
            return $this->token->getPassword();
        }

        return false;
    }

    /**
     * Get UsernameToken object (for SOAP)
     *
     * @return bool|UsernameToken
     */
    public function getToken()
    {
        if ($this->token instanceof UsernameToken) {
            return $this->token;
        }

        return false;
    }

    /**
     * Get PostNL Customer
     *
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set PostNL Customer
     *
     * @param Customer $customer
     *
     * @return PostNL
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get sandbox mode
     *
     * @return bool
     */
    public function getSandbox()
    {
        return $this->sandbox;
    }

    /**
     * Set sandbox mode
     *
     * @param bool $sandbox
     *
     * @return PostNL
     */
    public function setSandbox($sandbox)
    {
        $this->sandbox = (bool) $sandbox;

        return $this;
    }

    /**
     * Get the current mode
     *
     * @return int
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set current mode
     *
     * @param int $mode
     *
     * @return PostNL
     *
     * @throws InvalidArgumentException
     */
    public function setMode($mode)
    {
        if (!in_array($mode, [
            static::MODE_REST,
            static::MODE_SOAP,
            static::MODE_LEGACY,
        ])) {
            throw new InvalidArgumentException('Mode not supported');
        }

        $this->mode = (int) $mode;

        return $this;
    }

    /**
     * HttpClient
     *
     * Automatically load Guzzle when available
     *
     * @return ClientInterface
     */
    public function getHttpClient()
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
     */
    public function setHttpClient(ClientInterface $client)
    {
        $this->httpClient = $client;
    }

    /**
     * Get the logger
     *
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Set the logger
     *
     * @param LoggerInterface $logger
     *
     * @return PostNL
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
        if ($this->getHttpClient() instanceof ClientInterface) {
            $this->getHttpClient()->setLogger($logger);
        }

        return $this;
    }

    /**
     * Barcode service
     *
     * Automatically load the barcode service
     *
     * @return BarcodeService
     */
    public function getBarcodeService()
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
     */
    public function setBarcodeService(BarcodeService $service)
    {
        $this->barcodeService = $service;
    }

    /**
     * Labelling service
     *
     * Automatically load the labelling service
     *
     * @return LabellingService
     */
    public function getLabellingService()
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
     */
    public function setLabellingService(LabellingService $service)
    {
        $this->labellingService = $service;
    }

    /**
     * Confirming service
     *
     * Automatically load the confirming service
     *
     * @return ConfirmingService
     */
    public function getConfirmingService()
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
     */
    public function setConfirmingService(ConfirmingService $service)
    {
        $this->confirmingService = $service;
    }

    /**
     * Shipping status service
     *
     * Automatically load the shipping status service
     *
     * @return ShippingStatusService
     */
    public function getShippingStatusService()
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
     */
    public function setShippingStatusService(ShippingStatusService $service)
    {
        $this->shippingStatusService = $service;
    }

    /**
     * Delivery date service
     *
     * Automatically load the delivery date service
     *
     * @return DeliveryDateService
     */
    public function getDeliveryDateService()
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
     */
    public function setDeliveryDateService(DeliveryDateService $service)
    {
        $this->deliveryDateService = $service;
    }

    /**
     * Timeframe service
     *
     * Automatically load the timeframe service
     *
     * @return TimeframeService
     */
    public function getTimeframeService()
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
     */
    public function setTimeframeService(TimeframeService $service)
    {
        $this->timeframeService = $service;
    }

    /**
     * Location service
     *
     * Automatically load the location service
     *
     * @return LocationService
     */
    public function getLocationService()
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
     */
    public function setLocationService(LocationService $service)
    {
        $this->locationService = $service;
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
     * @throws InvalidBarcodeException
     */
    public function generateBarcode($type = '3S', $range = null, $serie = null, $eps = false)
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

        return $this->getBarcodeService()->generateBarcode(new GenerateBarcode(new Barcode($type, $range, $serie), $this->customer));
    }

    /**
     * Generate a single barcode by country code
     *
     * @param string $iso 2-letter Country ISO Code
     *
     * @return string The Barcode as a string
     * @throws InvalidConfigurationException
     * @throws InvalidBarcodeException
     */
    public function generateBarcodeByCountryCode($iso)
    {
        if (in_array(strtoupper($iso), static::$threeSCountries)) {
            $range = $this->getCustomer()->getCustomerCode();
            $type = '3S';
        } else {
            $range = $this->getCustomer()->getGlobalPackCustomerCode();
            $type = $this->getCustomer()->getGlobalPackBarcodeType();

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
            strtoupper($iso) !== 'NL' && in_array(strtoupper($iso), static::$threeSCountries)
        );

        return $this->getBarcodeService()->generateBarcode(new GenerateBarcode(new Barcode($type, $range, $serie), $this->customer));
    }

    /**
     * Generate a single barcode by country code
     *
     * @param  array $isos key = iso code, value = amount of barcodes requested
     *
     * @return array Country isos with the barcode as string
     * @throws InvalidConfigurationException
     * @throws InvalidBarcodeException
     */
    public function generateBarcodesByCountryCodes(array $isos)
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
                strtoupper($iso) !== 'NL' && in_array(strtoupper($iso), static::$threeSCountries)
            );

            for ($i = 0; $i < $qty; $i++) {
                $generateBarcodes[] = (new GenerateBarcode(new Barcode($type, $range, $serie), $this->customer))->setId("$iso-$index");
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
     * @param string   $printertype
     * @param bool     $confirm
     *
     * @return GenerateLabelResponse
     */
    public function generateLabel(
        Shipment $shipment,
        $printertype = 'GraphicFile|PDF',
        $confirm = true
    ) {
        return $this->getLabellingService()->generateLabel(
            new GenerateLabel(
                [$shipment],
                new LabellingMessage($printertype),
                $this->customer
            ),
            $confirm
        );
    }

    /**
     * Generate or retrieve multiple labels
     *
     * Note that instead of returning a GenerateLabelResponse this function can merge the labels and return a
     * string which contains the PDF with the merged pages as well.
     *
     * @param Shipment[] $shipments     (key = ID) Shipments
     * @param string     $printertype   Printer type, see PostNL dev docs for available types
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
     * @throws AbstractException
     * @throws NotSupportedException
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     */
    public function generateLabels(
        array $shipments,
        $printertype = 'GraphicFile|PDF',
        $confirm = true,
        $merge = false,
        $format = Label::FORMAT_A4,
        $positions = [
            1 => true,
            2 => true,
            3 => true,
            4 => true,
        ],
        $a6Orientation = 'P'
    ) {
        if ($merge) {
            if ($printertype !== 'GraphicFile|PDF') {
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
            $generateLabels[$uuid] = [(new GenerateLabel([$shipment], new LabellingMessage($printertype), $this->customer))->setId($uuid), $confirm];
        }
        $labels = $this->getLabellingService()->generateLabels($generateLabels, $confirm);

        if (!$merge) {
            return $labels;
        } else {
            foreach ($labels as $label) {
                if (!$label instanceof GenerateLabelResponse) {
                    return $labels;
                }
            }
        }

        // Disable header and footer
        $pdf = new RFPdi('P', 'mm', $format === Label::FORMAT_A4 ? [210, 297] : [105, 148]);
        $deferred = [];
        $firstPage = true;
        if ($format === Label::FORMAT_A6) {
            foreach ($labels as $label) {
                $pdfContent = base64_decode($label->getResponseShipments()[0]->getLabels()[0]->getContent());
                $sizes = Util::getPdfSizeAndOrientation($pdfContent);
                if ($sizes['iso'] === 'A6') {
                    $pdf->addPage($a6Orientation);
                    $correction = [0, 0];
                    if ($a6Orientation === 'L' && $sizes['orientation'] === 'P') {
                        $correction[0] = -84;
                        $correction[1] = -0.5;
                        $pdf->rotateCounterClockWise();
                    } elseif ($a6Orientation === 'P' && $sizes['orientation'] === 'L') {
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
                    $pdf->useTemplate($pdf->importPage(1), static::$a6positions[$a6s][0], static::$a6positions[$a6s][1]);
                    $a6s--;
                    if ($a6s < 1) {
                        if ($label !== end($labels)) {
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
                // Multilabel
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
     */
    public function confirmShipment(Shipment $shipment)
    {
        return $this->getConfirmingService()->confirmShipment(new Confirming([$shipment], $this->customer));
    }

    /**
     * Confirm multiple shipments
     *
     * @param array $shipments
     *
     * @return ConfirmingResponseShipment[]
     */
    public function confirmShipments(array $shipments)
    {
        $confirmings = [];
        foreach ($shipments as $uuid => $shipment) {
            $confirmings[$uuid] = (new Confirming([$shipment], $this->customer))->setId($uuid);
        }

        return $this->getConfirmingService()->confirmShipments($confirmings);
    }

    /**
     * Get the current status of a shipment
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     * - CurrentStatusByPhase:
     *   - Fill the Shipment->PhaseCode property, do not pass Barcode or Reference.
     *     Optionally add DateFrom and/or DateTo.
     * - CurrentStatusByStatus:
     *   - Fill the Shipment->StatuCode property. Leave the rest empty.
     *
     * @param CurrentStatus|CurrentStatusByStatus|CurrentStatusByReference|CurrentStatusByPhase $currentStatus
     *
     * @return CurrentStatusResponse
     */
    public function getCurrentStatus($currentStatus)
    {
        $fullCustomer = $this->getCustomer();
        $currentStatus->setCustomer((new Customer())
            ->setCustomerCode($fullCustomer->getCustomerCode())
            ->setCustomerNumber($fullCustomer->getCustomerNumber())
        );
        if (!$currentStatus->getMessage()) {
            $currentStatus->setMessage(new Message());
        }

        return $this->getShippingStatusService()->currentStatus($currentStatus);
    }

    /**
     * Get the complete status of a shipment
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     * - CurrentStatusByPhase:
     *   - Fill the Shipment->PhaseCode property, do not pass Barcode or Reference.
     *     Optionally add DateFrom and/or DateTo.
     * - CurrentStatusByStatus:
     *   - Fill the Shipment->StatuCode property. Leave the rest empty.
     *
     * @param CompleteStatus|CompleteStatusByStatus|CompleteStatusByReference|CompleteStatusByPhase $completeStatus
     *
     * @return CompleteStatusResponse
     */
    public function getCompleteStatus($completeStatus)
    {
        $fullCustomer = $this->getCustomer();

        $completeStatus->setCustomer((new Customer)
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
     * @return GetSignature
     */
    public function getSignature(GetSignature $signature)
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
    public function getDeliveryDate(GetDeliveryDate $getDeliveryDate)
    {
        return $this->getDeliveryDateService()->getDeliveryDate($getDeliveryDate);
    }

    /**
     * Get a shipping date
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return GetSentDateResponse
     */
    public function getSentDate(GetSentDateRequest $getSentDate)
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
     * @throws HttpClientException
     * @throws InvalidArgumentException
     */
    public function getTimeframesAndNearestLocations(
        GetTimeframes $getTimeframes,
        GetNearestLocations $getNearestLocations,
        GetDeliveryDate $getDeliveryDate
    ) {
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
            'delivery_date' => $this->getDeliveryDateService()->processGetDeliveryDateResponse($results['delivery_date']),
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

    /**
     * Find a suitable serie for the barcode
     *
     * @param string $type
     * @param string $range
     * @param bool   $eps   Indicates whether it is an EPS Shipment
     *
     * @return string
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
}
