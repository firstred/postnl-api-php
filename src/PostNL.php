<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
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
 * @author    Michael Dekker <michael@thirtybees.com>
 * @copyright 2017-2018 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL;

use setasign\Fpdi\PdfParser\StreamReader;
use ThirtyBees\PostNL\Entity\Barcode;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\Label;
use ThirtyBees\PostNL\Entity\Message\LabellingMessage;
use ThirtyBees\PostNL\Entity\Message\Message;
use ThirtyBees\PostNL\Entity\Request\Confirming;
use ThirtyBees\PostNL\Entity\Request\CurrentStatus;
use ThirtyBees\PostNL\Entity\Request\GenerateBarcode;
use ThirtyBees\PostNL\Entity\Request\GenerateLabel;
use ThirtyBees\PostNL\Entity\Response\ConfirmingResponseShipment;
use ThirtyBees\PostNL\Entity\Response\CurrentStatusResponse;
use ThirtyBees\PostNL\Entity\Response\GenerateLabelResponse;
use ThirtyBees\PostNL\Entity\Shipment;
use ThirtyBees\PostNL\Entity\SOAP\UsernameToken;
use ThirtyBees\PostNL\Exception\AbstractException;
use ThirtyBees\PostNL\Exception\InvalidArgumentException;
use ThirtyBees\PostNL\Exception\InvalidBarcodeException;
use ThirtyBees\PostNL\Exception\InvalidConfigurationException;
use ThirtyBees\PostNL\Exception\NotSupportedException;
use ThirtyBees\PostNL\HttpClient\ClientInterface;
use ThirtyBees\PostNL\HttpClient\CurlClient;
use ThirtyBees\PostNL\HttpClient\GuzzleClient;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Util\RFPdi;
use ThirtyBees\PostNL\Util\Util;

/**
 * Class PostNL
 *
 * @package ThirtyBees\PostNL
 */
class PostNL
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
        'NL', 'BE', 'AT', 'BG', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GB', 'GR', 'HU', 'IE', 'IT',
        'LV', 'LT', 'LU', 'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'SE', 'MC', 'AL', 'AD', 'BA', 'IC',
        'FO', 'GI', 'GL', 'GG', 'IS', 'JE', 'HR', 'LI', 'MK', 'MD', 'ME', 'NO', 'UA', 'SM', 'RS',
        'TR', 'VA', 'BY', 'CH',
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

        return $this;
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
     * Barcode client
     *
     * Automatically load the barcode service
     *
     * @return BarcodeService
     */
    public function getBarcodeService()
    {
        if (!$this->barcodeService) {
            $this->barcodeService = new BarcodeService($this);
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
            $this->labellingService = new LabellingService($this);
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
     * Automatically load the barcode service
     *
     * @return ConfirmingService
     */
    public function getConfirmingService()
    {
        if (!$this->confirmingService) {
            $this->confirmingService = new ConfirmingService($this);
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
     * Confirming service
     *
     * Automatically load the barcode service
     *
     * @return ConfirmingService
     */
    public function getShippingStatusService()
    {
        if (!$this->shippingStatusService) {
            $this->shippingStatusService = new ShippingStatusService($this);
        }

        return $this->shippingStatusService;
    }

    /**
     * Set the confirming service
     *
     * @param ConfirmingService $service
     */
    public function setShippingStatusService(ShippingStatusService $service)
    {
        $this->shippingStatusService = $service;
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
    public function generateBarcode($type, $range = null, $serie = null, $eps = false)
    {
        if (!in_array($type, ['2S', '3S', 'CC', 'CD', 'CF', 'CP', 'CX'])) {
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
        $confirm = false
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
     * @param Shipment[] $shipments   (key = ID) Shipments
     * @param string     $printertype Printer type, see PostNL dev docs for available types
     * @param bool       $confirm     Immediately confirm the shipments
     * @param bool       $merge       Merge the PDFs and return them in a MyParcel way
     * @param int        $format      A4 or A6
     * @param array      $positions   Set the positions of the A6s on the first A4
     *                                The indices should be the position number, marked with `true` or `false`
     *                                These are the position numbers:
     *                                ```
     *                                +-+-+
     *                                |2|4|
     *                                +-+-+
     *                                |1|3|
     *                                +-+-+
     *                                ```
     *                                So, for
     *                                ```
     *                                +-+-+
     *                                |x|✔|
     *                                +-+-+
     *                                |✔|x|
     *                                +-+-+
     *                                ```
     *                                you would have to pass:
     *                                ```php
     *                                [
     *                                  1 => true,
     *                                  2 => false,
     *                                  3 => false,
     *                                  4 => true,
     *                                ]
     *                                ```
     *
     * @return GenerateLabelResponse[]|string
     * @throws \Exception
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     */
    public function generateLabels(
        array $shipments,
        $printertype = 'GraphicFile|PDF',
        $confirm = false,
        $merge = false,
        $format = Label::FORMAT_A4,
        $positions = [
            1 => true,
            2 => true,
            3 => true,
            4 => true,
        ]
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
        }

        // Disable header and footer
        $pdf = new RFPdi('P', 'mm', $format === Label::FORMAT_A4 ? [210, 297] : [105, 148]);
        $deferred = [];
        if ($format === Label::FORMAT_A6) {
            foreach ($labels as $label) {
                $pdfContent = base64_decode($label->getResponseShipments()[0]->getLabels()[0]->getContent());
                $sizes = Util::getPdfSizeAndOrientation($pdfContent);
                if ($sizes['iso'] === 'A6') {
                    $pdf->addPage('P');
                    $pdf->rotateCounterClockWise();
                    $pdf->setSourceFile(StreamReader::createByString($pdfContent));
                    $pdf->useTemplate($pdf->importPage(1), -128, 0);
                } else {
                    // Assuming A4 here (could be multi-page) - defer to end
                    $stream = StreamReader::createByString($pdfContent);
                    $deferred[] = [
                        'stream' => $stream,
                        'sizes'  => $sizes,
                    ];
                }
            }
        } else {
            $a6s = 4; // Amount of A6s available
            $pdf->addPage('P', [297, 210], 90);
            foreach ($labels as $label) {
                if ($label instanceof AbstractException) {
                    throw $label;
                }

                $pdfContent = base64_decode($label->getResponseShipments()[0]->getLabels()[0]->getContent());
                $sizes = Util::getPdfSizeAndOrientation($pdfContent);
                if ($sizes['iso'] === 'A6') {
                    while (empty($positions[5 - $a6s]) && $a6s >= 1) {
                        $positions[5 - $a6s] = true;
                        $a6s--;
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
                    $stream = StreamReader::createByString($pdfContent);
                    $deferred[] = [
                        'stream' => $stream,
                        'sizes'  => $sizes,
                    ];
                }
            }
        }
        foreach ($deferred as $defer) {
            $sizes = $defer['sizes'];
            $pdf->addPage($sizes['orientation'], 'A4');
            $pdf->rotateCounterClockWise();
            $pages = $pdf->setSourceFile($defer['stream']);
            for ($i = 1; $i < ($pages + 1); $i++) {
                $pdf->useTemplate($pdf->importPage($i), -190, 0);
            }
        }

        return $pdf->output('', 'S');
    }

    /**
     * @param Shipment $shipment
     *
     * @return ConfirmingResponseShipment
     */
    public function confirmShipment(Shipment $shipment)
    {
        return $this->getConfirmingService()->confirmShipment(new Confirming([$shipment], $this->customer));
    }

    /**
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
     * @param CurrentStatus $currentStatus
     *
     * @return CurrentStatusResponse
     */
    public function getCurrentStatus(CurrentStatus $currentStatus)
    {
        $currentStatus->setCustomer($this->getCustomer());
        if (!$currentStatus->getMessage()) {
            $currentStatus->setMessage(new Message());
        }

        return $this->getShippingStatusService()->currentStatus($currentStatus);
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
    protected function findBarcodeSerie($type, $range, $eps)
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
