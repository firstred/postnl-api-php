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

/** @noinspection PhpDocRedundantThrowsInspection */

namespace Firstred\PostNL;

use DateTimeInterface;
use Exception;
use Firstred\PostNL\Entity\Barcode;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Label;
use Firstred\PostNL\Entity\Message\LabellingMessage;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Request\CompleteStatus;
use Firstred\PostNL\Entity\Request\Confirming;
use Firstred\PostNL\Entity\Request\CurrentStatus;
use Firstred\PostNL\Entity\Request\CurrentStatusByReference;
use Firstred\PostNL\Entity\Request\GenerateBarcode;
use Firstred\PostNL\Entity\Request\GenerateLabel;
use Firstred\PostNL\Entity\Request\SendShipment;
use Firstred\PostNL\Entity\Request\GetDeliveryDate;
use Firstred\PostNL\Entity\Request\GetLocation;
use Firstred\PostNL\Entity\Request\GetLocationsInArea;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Entity\Request\GetSentDateRequest;
use Firstred\PostNL\Entity\Request\GetSignature;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Response\CompleteStatusResponse;
use Firstred\PostNL\Entity\Response\CompleteStatusResponseShipment;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Entity\Response\CurrentStatusResponse;
use Firstred\PostNL\Entity\Response\CurrentStatusResponseShipment;
use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Entity\Response\SendShipmentResponse;
use Firstred\PostNL\Entity\Response\GetDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\GetLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Entity\Response\GetSentDateResponse;
use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Entity\Response\UpdatedShipmentsResponse;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Entity\SOAP\UsernameToken;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\PostNLException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidBarcodeException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotFoundException as PostNLNotFoundException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Exception\ShipmentNotFoundException;
use Firstred\PostNL\Factory\GuzzleRequestFactory;
use Firstred\PostNL\Factory\GuzzleResponseFactory;
use Firstred\PostNL\Factory\GuzzleStreamFactory;
use Firstred\PostNL\Factory\RequestFactoryInterface;
use Firstred\PostNL\Factory\ResponseFactoryInterface;
use Firstred\PostNL\Factory\StreamFactoryInterface;
use Firstred\PostNL\HttpClient\ClientInterface;
use Firstred\PostNL\HttpClient\CurlClient;
use Firstred\PostNL\HttpClient\GuzzleClient;
use Firstred\PostNL\HttpClient\HTTPlugClient;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\ConfirmingServiceInterface;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\DeliveryDateServiceInterface;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LabellingServiceInterface;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\LocationServiceInterface;
use Firstred\PostNL\Service\ShippingService;
use Firstred\PostNL\Service\ShippingServiceInterface;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\ShippingStatusServiceInterface;
use Firstred\PostNL\Service\TimeframeService;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use Firstred\PostNL\Util\DummyLogger;
use Firstred\PostNL\Util\RFPdi;
use Firstred\PostNL\Util\Util;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Psr7\Message as PsrMessage;
use GuzzleHttp\Psr7\Response;
use Http\Discovery\Exception\DiscoveryFailedException;
use Http\Discovery\Exception\NoCandidateFoundException;
use Http\Discovery\HttpAsyncClientDiscovery;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\NotFoundException;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Sabre\Xml\Version;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\Filter\FilterException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\StreamReader;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use setasign\Fpdi\PdfReader\PdfReaderException;
use function array_map;
use function base64_decode;
use function class_exists;
use function constant;
use function defined;
use function ini_get;
use function interface_exists;
use function is_array;
use function php_sapi_name;
use function trigger_error;
use function version_compare;
use const E_USER_WARNING;

/**
 * Class PostNL.
 *
 * @since 1.0.0
 */
class PostNL implements LoggerAwareInterface
{
    // New REST API
    const MODE_REST = 1;
    // New SOAP API
    const MODE_SOAP = 2;
    // Old SOAP API
    const MODE_LEGACY = 2;

    /**
     * 3S (or EU Pack Special) countries.
     *
     * @var array
     */
    public static $threeSCountries = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DK',
        'EE',
        'FI',
        'FR',
        'DE',
        'GB',
        'GR',
        'HR',
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
        'SE',
        'ES',
    ];

    /**
     * A6 positions
     * (index = amount of a6 left on the page).
     *
     * @var array
     */
    public static $a6positions = [
        4 => [-276, 2],
        3 => [-132, 2],
        2 => [-276, 110],
        1 => [-132, 110],
    ];

    /**
     * Verify SSL certificate of the PostNL REST API.
     *
     * @var bool
     *
     * @deprecated
     */
    public $verifySslCerts = true;

    /**
     * The PostNL REST API key or SOAP username/password to be used for requests.
     *
     * In case of REST the API key is the `Password` property of the `UsernameToken`
     * In case of SOAP this has to be a `UsernameToken` object, with the following requirements:
     *   - Do not pass a username (`null`)
     *     And pass the plaintext password.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * The PostNL Customer to be used for requests.
     *
     * @var Customer
     */
    protected $customer;

    /**
     * Sandbox mode.
     *
     * @var bool
     */
    protected $sandbox = false;

    /** @var ClientInterface */
    protected $httpClient;

    /** @var LoggerInterface */
    protected $logger;

    /**
     * @var RequestFactoryInterface
     */
    protected $requestFactory;

    /**
     * @var ResponseFactoryInterface
     */
    protected $responseFactory;

    /**
     * @var StreamFactoryInterface
     */
    protected $streamFactory;

    /**
     * This is the current mode.
     *
     * @var int
     */
    protected $mode;

    /** @var BarcodeServiceInterface */
    protected $barcodeService;

    /** @var LabellingServiceInterface */
    protected $labellingService;

    /** @var ConfirmingServiceInterface */
    protected $confirmingService;

    /** @var ShippingStatusServiceInterface */
    protected $shippingStatusService;

    /** @var DeliveryDateServiceInterface */
    protected $deliveryDateService;

    /** @var TimeframeServiceInterface */
    protected $timeframeService;

    /** @var LocationServiceInterface */
    protected $locationService;

    /** @var ShippingServiceInterface */
    protected $shippingService;

    /**
     * PostNL constructor.
     *
     * @param Customer             $customer Customer object.
     * @param UsernameToken|string $apiKey   API key or UsernameToken object.
     * @param bool                 $sandbox  Whether the testing environment should be used.
     * @param int                  $mode     Set the preferred connection strategy.
     *                                       Valid options are:
     *                                       - `MODE_REST`: New REST API
     *                                       - `MODE_SOAP`: New SOAP API
     *                                       - `MODE_LEGACY`: Not supported anymore, converts to `MODE_SOAP`
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        Customer $customer,
        $apiKey,
        $sandbox,
        $mode = self::MODE_REST
    ) {
        $this->checkEnvironment();

        $this->setCustomer($customer);
        $this->setToken($apiKey);
        $this->setSandbox((bool) $sandbox);
        $this->setMode((int) $mode);
    }

    /**
     * Set the token.
     *
     * @param string|UsernameToken $apiKey
     *
     * @return PostNL
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function setToken($apiKey)
    {
        if ($apiKey instanceof UsernameToken) {
            $this->apiKey = $apiKey;

            return $this;
        } elseif (is_string($apiKey)) {
            $this->apiKey = new UsernameToken(null, $apiKey);

            return $this;
        }

        throw new InvalidArgumentException('Invalid username/token');
    }

    /**
     * Get REST API Key.
     *
     * @return bool|string
     *
     * @since 1.0.0
     */
    public function getRestApiKey()
    {
        if ($this->apiKey instanceof UsernameToken) {
            return $this->apiKey->getPassword();
        }

        return false;
    }

    /**
     * Get UsernameToken object (for SOAP).
     *
     * @return bool|UsernameToken
     *
     * @since 1.0.0
     */
    public function getToken()
    {
        if ($this->apiKey instanceof UsernameToken) {
            return $this->apiKey;
        }

        return false;
    }

    /**
     * Get PostNL Customer.
     *
     * @return Customer
     *
     * @since 1.0.0
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set PostNL Customer.
     *
     * @param Customer $customer
     *
     * @return PostNL
     *
     * @since 1.0.0
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get sandbox mode.
     *
     * @return bool
     *
     * @since 1.0.0
     */
    public function getSandbox()
    {
        return $this->sandbox;
    }

    /**
     * Set sandbox mode.
     *
     * @param bool $sandbox
     *
     * @return PostNL
     *
     * @since 1.0.0
     */
    public function setSandbox($sandbox)
    {
        $this->sandbox = (bool) $sandbox;

        return $this;
    }

    /**
     * Get the current mode.
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set current mode.
     *
     * @param int $mode
     *
     * @return PostNL
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
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

        if (in_array($mode, [static::MODE_SOAP, static::MODE_LEGACY])
            && (!class_exists(Version::class) || version_compare(Version::VERSION, '2.0.0', '>='))
        ) {
            // Seamlessly switch to the REST API
            $mode = static::MODE_REST;
        } elseif (static::MODE_LEGACY === $mode) {
            $mode = static::MODE_SOAP;
        }

        $this->mode = (int) $mode;

        return $this;
    }

    /**
     * HttpClient.
     *
     * Automatically load Guzzle when available
     *
     * @return ClientInterface
     *
     * @since 1.0.0
     */
    public function getHttpClient()
    {
        // @codeCoverageIgnoreStart
        if (!$this->httpClient) {
            if (interface_exists(GuzzleClientInterface::class)
                && ((defined(GuzzleClientInterface::class.'::VERSION') && version_compare(
                            constant(GuzzleClientInterface::class.'::VERSION'),
                            '6.0.0',
                            '>='
                        ))
                    || (defined(GuzzleClientInterface::class.'::MAJOR_VERSION') && version_compare(
                            constant(GuzzleClientInterface::class.'::MAJOR_VERSION'),
                            '7.0.0',
                            '>='
                        )))
            ) {
                $this->httpClient = new GuzzleClient();
            }

            if (!$this->httpClient && class_exists(HttpAsyncClientDiscovery::class)) {
                try {
                    // Detect PHP HTTPlug async HTTP client support
                    if (HttpAsyncClientDiscovery::find()) {
                        $this->httpClient = new HTTPlugClient();
                    }
                } catch (NotFoundException $e) {
                } catch (\Http\Discovery\Exception\NotFoundException $e) {
                } catch (NoCandidateFoundException $e) {
                } catch (DiscoveryFailedException $e) {
                }
            }

            if (!$this->httpClient && class_exists(Psr18ClientDiscovery::class)) {
                try {
                    // Detect PHP HTTPlug PSR-18 HTTP client support
                    if (Psr18ClientDiscovery::find()) {
                        $this->httpClient = new HTTPlugClient();
                    }
                } catch (NotFoundException $e) {
                } catch (\Http\Discovery\Exception\NotFoundException $e) {
                } catch (NoCandidateFoundException $e) {
                } catch (DiscoveryFailedException $e) {
                }
            }

            if (!$this->httpClient && class_exists(HttpClientDiscovery::class)) {
                try {
                    // Detect PHP HTTPlug HTTP client support
                    if (HttpClientDiscovery::find()) {
                        $this->httpClient = new HTTPlugClient();
                    }
                } catch (NotFoundException $e) {
                } catch (\Http\Discovery\Exception\NotFoundException $e) {
                } catch (NoCandidateFoundException $e) {
                } catch (DiscoveryFailedException $e) {
                }
            }

            if (!$this->httpClient) {
                $this->httpClient = new CurlClient();
            }

            $this->httpClient->setLogger($this->getLogger());
            $this->httpClient->setVerify($this->verifySslCerts);
        }
        // @codeCoverageIgnoreEnd

        return $this->httpClient;
    }

    /**
     * Set the HttpClient.
     *
     * @param ClientInterface $client
     *
     * @since 1.0.0
     */
    public function setHttpClient(ClientInterface $client)
    {
        $this->httpClient = $client;

        $this->httpClient->setLogger($this->getLogger());
    }

    /**
     * Get the logger.
     *
     * @return LoggerInterface
     *
     * @since 1.0.0
     */
    public function getLogger()
    {
        if (!$this->logger) {
            $this->resetLogger();
        }

        return $this->logger;
    }

    /**
     * Set the logger.
     *
     * @param LoggerInterface $logger
     *
     * @return PostNL
     *
     * @since 1.0.0
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        if ($this->getHttpClient() instanceof ClientInterface) {
            $this->getHttpClient()->setLogger($logger);
        }

        return $this;
    }

    /**
     * Set a dummy logger
     *
     * @return static
     *
     * @since 1.2.0
     */
    public function resetLogger()
    {
        $this->logger = new DummyLogger();

        return $this;
    }

    /**
     * Get PSR-7 Request factory.
     *
     * @return RequestFactoryInterface
     *
     * @since 1.2.0
     */
    public function getRequestFactory()
    {
        if (!$this->requestFactory) {
            $this->requestFactory = new GuzzleRequestFactory();
        }

        return $this->requestFactory;
    }

    /**
     * Set PSR-7 Request factory.
     *
     * @param RequestFactoryInterface $requestFactory
     *
     * @return static
     *
     * @since 1.2.0
     */
    public function setRequestFactory($requestFactory)
    {
        $this->requestFactory = $requestFactory;

        return $this;
    }

    /**
     * Get PSR-7 Response factory.
     *
     * @return ResponseFactoryInterface
     *
     * @since 1.2.0
     */
    public function getResponseFactory()
    {
        if (!$this->responseFactory) {
            $this->responseFactory = new GuzzleResponseFactory();
        }

        return $this->responseFactory;
    }

    /**
     * Set PSR-7 Response factory.
     *
     * @param ResponseFactoryInterface $responseFactory
     *
     * @return static
     *
     * @since 1.2.0
     */
    public function setResponseFactory($responseFactory)
    {
        $this->responseFactory = $responseFactory;

        return $this;
    }

    /**
     * Set PSR-7 Stream factory.
     *
     * @return StreamFactoryInterface
     *
     * @since 1.2.0
     */
    public function getStreamFactory()
    {
        if (!$this->streamFactory) {
            $this->streamFactory = new GuzzleStreamFactory();
        }

        return $this->streamFactory;
    }

    /**
     * Set PSR-7 Stream factory.
     *
     * @param StreamFactoryInterface $streamFactory
     *
     * @return static
     *
     * @since 1.2.0
     */
    public function setStreamFactory($streamFactory)
    {
        $this->streamFactory = $streamFactory;

        return $this;
    }

    /**
     * Barcode service.
     *
     * Automatically load the barcode service
     *
     * @return BarcodeServiceInterface
     *
     * @since 1.0.0
     */
    public function getBarcodeService()
    {
        if (!$this->barcodeService) {
            $this->setBarcodeService(new BarcodeService($this));
        }

        return $this->barcodeService;
    }

    /**
     * Set the barcode service.
     *
     * @param BarcodeServiceInterface $service
     *
     * @since 1.0.0
     */
    public function setBarcodeService(BarcodeServiceInterface $service)
    {
        $this->barcodeService = $service;
    }

    /**
     * Labelling service.
     *
     * Automatically load the labelling service
     *
     * @return LabellingServiceInterface
     *
     * @since 1.0.0
     */
    public function getLabellingService()
    {
        if (!$this->labellingService) {
            $this->setLabellingService(new LabellingService($this));
        }

        return $this->labellingService;
    }

    /**
     * Set the labelling service.
     *
     * @param LabellingServiceInterface $service
     *
     * @since 1.0.0
     */
    public function setLabellingService(LabellingServiceInterface $service)
    {
        $this->labellingService = $service;
    }

    /**
     * Confirming service.
     *
     * Automatically load the confirming service
     *
     * @return ConfirmingServiceInterface
     *
     * @since 1.0.0
     */
    public function getConfirmingService()
    {
        if (!$this->confirmingService) {
            $this->setConfirmingService(new ConfirmingService($this));
        }

        return $this->confirmingService;
    }

    /**
     * Set the confirming service.
     *
     * @param ConfirmingServiceInterface $service
     *
     * @since 1.0.0
     */
    public function setConfirmingService(ConfirmingServiceInterface $service)
    {
        $this->confirmingService = $service;
    }

    /**
     * Shipping status service.
     *
     * Automatically load the shipping status service
     *
     * @return ShippingStatusServiceInterface
     *
     * @since 1.0.0
     */
    public function getShippingStatusService()
    {
        if (!$this->shippingStatusService) {
            $this->setShippingStatusService(new ShippingStatusService($this));
        }

        return $this->shippingStatusService;
    }

    /**
     * Set the shipping status service.
     *
     * @param ShippingStatusServiceInterface $service
     *
     * @since 1.0.0
     */
    public function setShippingStatusService(ShippingStatusServiceInterface $service)
    {
        $this->shippingStatusService = $service;
    }

    /**
     * Delivery date service.
     *
     * Automatically load the delivery date service
     *
     * @return DeliveryDateServiceInterface
     *
     * @since 1.0.0
     */
    public function getDeliveryDateService()
    {
        if (!$this->deliveryDateService) {
            $this->setDeliveryDateService(new DeliveryDateService($this));
        }

        return $this->deliveryDateService;
    }

    /**
     * Set the delivery date service.
     *
     * @param DeliveryDateServiceInterface $service
     *
     * @since 1.0.0
     */
    public function setDeliveryDateService(DeliveryDateServiceInterface $service)
    {
        $this->deliveryDateService = $service;
    }

    /**
     * Timeframe service.
     *
     * Automatically load the timeframe service
     *
     * @return TimeframeServiceInterface
     *
     * @since 1.0.0
     */
    public function getTimeframeService()
    {
        if (!$this->timeframeService) {
            $this->setTimeframeService(new TimeframeService($this));
        }

        return $this->timeframeService;
    }

    /**
     * Set the timeframe service.
     *
     * @param TimeframeServiceInterface $service
     *
     * @since 1.0.0
     */
    public function setTimeframeService(TimeframeServiceInterface $service)
    {
        $this->timeframeService = $service;
    }

    /**
     * Location service.
     *
     * Automatically load the location service
     *
     * @return LocationServiceInterface
     *
     * @since 1.0.0
     */
    public function getLocationService()
    {
        if (!$this->locationService) {
            $this->setLocationService(new LocationService($this));
        }

        return $this->locationService;
    }

    /**
     * Set the location service.
     *
     * @param LocationServiceInterface $service
     *
     * @since 1.0.0
     */
    public function setLocationService(LocationServiceInterface $service)
    {
        $this->locationService = $service;
    }

    /**
     * Shipping service.
     *
     * Automatically load the shipping service
     *
     * @return mixed
     *
     * @since 1.2.0
     */
    public function getShippingService()
    {
        if (!$this->shippingService) {
            $this->setShippingService(new ShippingService($this));
        }

        return $this->shippingService;
    }

    /**
     * Set the shipping service.
     *
     * @param ShippingServiceInterface $service
     *
     * @since 1.2.0
     */
    public function setShippingService(ShippingServiceInterface $service)
    {
        $this->shippingService = $service;
    }

    /**
     * Generate a single barcode.
     *
     * @param string $type
     * @param string $range
     * @param string $serie
     * @param bool   $eps
     *
     * @return string The barcode as a string
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws InvalidConfigurationException
     * @throws InvalidBarcodeException
     *
     * @since 1.0.0
     */
    public function generateBarcode($type = '3S', $range = null, $serie = null, $eps = false)
    {
        if (2 !== strlen($type)) {
            throw new InvalidBarcodeException("Barcode type `$type` is invalid");
        }

        if (!$range) {
            if (in_array($type, ['LA', 'UE', 'RI'])) {
                $range = 'NL';
            } elseif (in_array($type, ['2S', '3S'])) {
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
     * Generate a single barcode by country code.
     *
     * @param string $iso 2-letter Country ISO Code
     *
     * @return string The Barcode as a string
     *
     * @throws InvalidConfigurationException
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws InvalidConfigurationException
     * @throws InvalidBarcodeException
     *
     * @since 1.0.0
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
            'NL' !== strtoupper($iso) && in_array(strtoupper($iso), static::$threeSCountries)
        );

        return $this->getBarcodeService()->generateBarcode(new GenerateBarcode(new Barcode($type, $range, $serie), $this->customer));
    }

    /**
     * Generate a single barcode by country code.
     *
     * @param array $isos key = iso code, value = amount of barcodes requested
     *
     * @return array Country isos with the barcode as string
     *
     * @throws InvalidConfigurationException
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws InvalidConfigurationException
     * @throws InvalidBarcodeException
     *
     * @since 1.0.0
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
                'NL' !== strtoupper($iso) && in_array(strtoupper($iso), static::$threeSCountries)
            );

            for ($i = 0; $i < $qty; ++$i) {
                $generateBarcodes[] = (new GenerateBarcode(new Barcode($type, $range, $serie), $this->customer))->setId("$iso-$index");
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
     * Send a single shipment.
     *
     * @param Shipment $shipment
     * @param string   $printertype
     * @param bool     $confirm
     *
     * @return SendShipmentResponse
     *
     * @throws PostNLNotFoundException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function sendShipment(
        Shipment $shipment,
        $printertype = 'GraphicFile|PDF',
        $confirm = true
    ) {
        return $this->getShippingService()->sendShipment(
            new SendShipment(
                [$shipment],
                new LabellingMessage($printertype),
                $this->customer
            ),
            $confirm);
    }

    /**
     * Send multiple shipments.
     *
     * @param Shipment[] $shipments     Array of shipments
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
     * @param string     $a6Orientation A6 orientation (P or L)
     *
     * @return SendShipmentResponse|string
     *
     * @throws NotSupportedException
     * @throws CrossReferenceException
     * @throws FilterException
     * @throws PdfParserException
     * @throws PdfTypeException
     * @throws PdfReaderException
     * @throws PostNLNotFoundException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function sendShipments(
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
            if ('GraphicFile|PDF' !== $printertype) {
                throw new NotSupportedException('Labels with the chosen printer type cannot be merged');
            }
            foreach ([1, 2, 3, 4] as $i) {
                if (!array_key_exists($i, $positions)) {
                    throw new NotSupportedException('All label positions need to be passed for merge mode');
                }
            }
        }

        $responseShipments = $this->getShippingService()->sendShipment(
            new SendShipment(
                $shipments,
                new LabellingMessage($printertype),
                $this->customer
            ),
            $confirm
        );

        if (!$merge) {
            return $responseShipments;
        }

        // Disable header and footer
        $pdf = new RFPdi('P', 'mm', Label::FORMAT_A4 === $format ? [210, 297] : [105, 148]);
        $deferred = [];
        $firstPage = true;
        if (Label::FORMAT_A6 === $format) {
            foreach ($responseShipments->getResponseShipments() as $responseShipment) {
                foreach ($responseShipment->getLabels() as $label) {
                    $pdfContent = base64_decode($label->getContent());
                    $sizes = Util::getPdfSizeAndOrientation($pdfContent);
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
            }
        } else {
            $a6s = 4; // Amount of A6s available
            $responseShipmentsArray = $responseShipments->getResponseShipments();
            foreach ($responseShipmentsArray as $label) {
                $pdfContent = base64_decode($label->getLabels()[0]->getContent());
                $sizes = Util::getPdfSizeAndOrientation($pdfContent);
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
                    $pdf->useTemplate($pdf->importPage(1), static::$a6positions[$a6s][0], static::$a6positions[$a6s][1]);
                    --$a6s;
                    if ($a6s < 1) {
                        if ($label !== end($responseShipmentsArray)) {
                            $pdf->addPage('P', [297, 210], 90);
                        }
                        $a6s = 4;
                    }
                } else {
                    // Assuming A4 here (could be multi-page) - defer to end
                    if (count($label->getLabels()) > 1) {
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
                if (is_resource($defer['stream']) || $defer['stream'] instanceof StreamReader) {
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
     * Generate a single label.
     *
     * @param Shipment $shipment
     * @param string   $printertype
     * @param bool     $confirm
     *
     * @return GenerateLabelResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws PostNLNotFoundException
     *
     * @since 1.0.0
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
     * Generate or retrieve multiple labels.
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
     * @param string     $a6Orientation A6 orientation (P or L)
     *
     * @return GenerateLabelResponse[]|string
     *
     * @throws PostNLException
     * @throws NotSupportedException
     * @throws CrossReferenceException
     * @throws FilterException
     * @throws PdfParserException
     * @throws PdfTypeException
     * @throws PdfReaderException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.0.0
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
            if ('GraphicFile|PDF' !== $printertype) {
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
        $responseShipments = $this->getLabellingService()->generateLabels($generateLabels, $confirm);

        if (!$merge) {
            return $responseShipments;
        } else {
            foreach ($responseShipments as $responseShipment) {
                if (!$responseShipment instanceof GenerateLabelResponse) {
                    return $responseShipments;
                }
            }
        }

        // Disable header and footer
        $pdf = new RFPdi('P', 'mm', Label::FORMAT_A4 === $format ? [210, 297] : [105, 148]);
        $deferred = [];
        $firstPage = true;
        if (Label::FORMAT_A6 === $format) {
            foreach ($responseShipments as $responseShipment) {
                foreach ($responseShipment->getResponseShipments()[0]->getLabels() as $label) {
                    $pdfContent = base64_decode($label->getContent());
                    $sizes = Util::getPdfSizeAndOrientation($pdfContent);
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
            }
        } else {
            $a6s = 4; // Amount of A6s available
            foreach ($responseShipments as $responseShipment) {
                if ($responseShipment instanceof PostNLException) {
                    throw $responseShipment;
                }
                $pdfContent = base64_decode($responseShipment->getResponseShipments()[0]->getLabels()[0]->getContent());
                $sizes = Util::getPdfSizeAndOrientation($pdfContent);
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
                    $pdf->useTemplate($pdf->importPage(1), static::$a6positions[$a6s][0], static::$a6positions[$a6s][1]);
                    --$a6s;
                    if ($a6s < 1) {
                        if ($responseShipment !== end($responseShipments)) {
                            $pdf->addPage('P', [297, 210], 90);
                        }
                        $a6s = 4;
                    }
                } else {
                    // Assuming A4 here (could be multi-page) - defer to end
                    if (count($responseShipment->getResponseShipments()[0]->getLabels()) > 1) {
                        $stream = [];
                        foreach ($responseShipment->getResponseShipments()[0]->getLabels() as $labelContent) {
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
                if (is_resource($defer['stream']) || $defer['stream'] instanceof StreamReader) {
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
     * Confirm a single shipment.
     *
     * @param Shipment $shipment
     *
     * @return ConfirmingResponseShipment
     *
     * @since 1.0.0
     */
    public function confirmShipment(Shipment $shipment)
    {
        return $this->getConfirmingService()->confirmShipment(new Confirming([$shipment], $this->customer));
    }

    /**
     * Confirm multiple shipments.
     *
     * @param array $shipments
     *
     * @return ConfirmingResponseShipment[]
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws PostNLNotFoundException
     *
     * @since 1.0.0
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
     * Get the current status of a shipment.
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     *
     * @param CurrentStatus|CurrentStatusByReference $currentStatus
     *
     * @return CurrentStatusResponse
     *
     * @throws NotSupportedException
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @throws PostNLNotFoundException
     *
     * @since 1.0.0
     *
     * @deprecated 1.2.0 Use the dedicated methods (get by phase and status are no longer working)
     */
    public function getCurrentStatus($currentStatus)
    {
        if (null !== $currentStatus->getShipment()->getPhaseCode()) {
            throw new NotSupportedException('Getting the current status by phase code is no longer supported.');
        }
        if (null !== $currentStatus->getShipment()->getStatusCode()) {
            throw new NotSupportedException('Getting the current status by status code is no longer supported.');
        }

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
     * Get the current status of the given shipment by barcode.
     *
     * @param string $barcode  Pass a single barcode
     * @param bool   $complete Return the complete status (incl. shipment history)
     *
     * @return CurrentStatusResponseShipment|CompleteStatusResponseShipment
     *
     * @throws ShipmentNotFoundException
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @throws PostNLNotFoundException
     *
     * @since 1.2.0
     */
    public function getShippingStatusByBarcode($barcode, $complete = false)
    {
        if ($complete) {
            $statusRequest = new CompleteStatus((new Shipment())->setBarcode($barcode));
        } else {
            $statusRequest = new CurrentStatus((new Shipment())->setBarcode($barcode));
        }

        if (!$statusRequest->getMessage()) {
            $statusRequest->setMessage(new Message());
        }

        if ($complete) {
            $shipments = $this->getShippingStatusService()->completeStatus($statusRequest)->getShipments();
        } else {
            $shipments = $this->getShippingStatusService()->currentStatus($statusRequest)->getShipments();
        }

        if (empty($shipments) || !is_array($shipments)) {
            throw new ShipmentNotFoundException($barcode);
        }

        return $shipments[0];
    }

    /**
     * Get the current statuses of the given shipments by barcodes.
     *
     * @param string[] $barcodes Pass multiple barcodes
     * @param bool     $complete Return the complete status (incl. shipment history)
     *
     * @return CurrentStatusResponseShipment[]|CompleteStatusResponseShipment[]
     * @psalm-return non-empty-array<string, CurrentStatusResponseShipment|CompleteStatusResponseShipment>
     *
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.2.0
     */
    public function getShippingStatusesByBarcodes(array $barcodes, $complete = false)
    {
        $shipments = [];
        if ($complete) {
            $shipmentResponses = $this->getShippingStatusService()->completeStatuses(array_map(
                function ($barcode) {
                    return (new CompleteStatus())->setShipment((new Shipment())->setBarcode($barcode));
                },
                $barcodes
            ));
        } else {
            $shipmentResponses = $this->getShippingStatusService()->currentStatuses(array_map(
                function ($barcode) {
                    return (new CurrentStatus())->setShipment((new Shipment())->setBarcode($barcode));
                },
                $barcodes
            ));
        }

        foreach ($shipmentResponses as $shipmentResponse) {
            foreach ($shipmentResponse->getShipments() as $shipment) {
                $shipments[] = $shipment;
            }
        }

        return $shipments;
    }

    /**
     * Get the current status of the given shipment by reference.
     *
     * @param string $reference Pass a single reference
     * @param bool   $complete  Return the complete status (incl. shipment history)
     *
     * @return CurrentStatusResponseShipment|CompleteStatusResponseShipment
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     * @throws NotFoundException
     *
     * @since 1.2.0
     */
    public function getShippingStatusByReference($reference, $complete = false)
    {
        if ($complete) {
            $statusRequest = new CompleteStatus((new Shipment())->setReference($reference));
        } else {
            $statusRequest = new CurrentStatus((new Shipment())->setReference($reference));
        }

        if (!$statusRequest->getMessage()) {
            $statusRequest->setMessage(new Message());
        }

        if ($complete) {
            $shipments = $this->getShippingStatusService()->completeStatus($statusRequest)->getShipments();
        } else {
            $shipments = $this->getShippingStatusService()->currentStatus($statusRequest)->getShipments();
        }

        if (empty($shipments) || !is_array($shipments)) {
            throw new ShipmentNotFoundException($reference);
        }

        return $shipments[0];
    }

    /**
     * Get the current statuses of the given shipments by references.
     *
     * @param string[] $references Pass multiple references
     * @param bool     $complete   Return the complete status (incl. shipment history)
     *
     * @return CurrentStatusResponseShipment[]|CompleteStatusResponseShipment[]
     * @psalm-return non-empty-array<string, CurrentStatusResponseShipment|CompleteStatusResponseShipment>
     *
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.2.0
     */
    public function getShippingStatusesByReference(array $references, $complete = false)
    {
        $shipments = [];
        if ($complete) {
            $shipmentResponses = $this->getShippingStatusService()->completeStatuses(array_map(
                function ($reference) {
                    return (new CompleteStatus())->setShipment((new Shipment())->setReference($reference));
                },
                $references
            ));
        } else {
            $shipmentResponses = $this->getShippingStatusService()->currentStatuses(array_map(
                function ($reference) {
                    return (new CurrentStatus())->setShipment((new Shipment())->setReference($reference));
                },
                $references
            ));
        }

        foreach ($shipmentResponses as $shipmentResponse) {
            foreach ($shipmentResponse->getShipments() as $shipment) {
                $shipments[] = $shipment;
            }
        }

        return $shipments;
    }

    /**
     * Get the complete status of a shipment.
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
     *   - Fill the Shipment->StatusCode property. Leave the rest empty.
     *
     * @param CompleteStatus $completeStatus
     *
     * @return CompleteStatusResponse
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @throws PostNLNotFoundException
     *
     * @since 1.0.0
     *
     * @deprecated 1.2.0 Use the dedicated getShippingStatus* methods (get by phase and status are no longer working)
     */
    public function getCompleteStatus($completeStatus)
    {
        if (null !== $completeStatus->getShipment()->getPhaseCode()) {
            throw new NotSupportedException('Getting the complete status by phase code is no longer supported.');
        }
        if (null !== $completeStatus->getShipment()->getStatusCode()) {
            throw new NotSupportedException('Getting the complete status by status code is no longer supported.');
        }

        $fullCustomer = $this->getCustomer();

        $completeStatus->setCustomer((new Customer())
            ->setCustomerCode($fullCustomer->getCustomerCode())
            ->setCustomerNumber($fullCustomer->getCustomerNumber())
        );
        if (!$completeStatus->getMessage()) {
            $completeStatus->setMessage(new Message());
        }

        return $this->getShippingStatusService()->completeStatus($completeStatus);
    }

    /**
     * Get updated shipments
     *
     * @param DateTimeInterface|null $dateTimeFrom
     * @param DateTimeInterface|null $dateTimeTo
     *
     * @return UpdatedShipmentsResponse[]
     *
     * @since 1.2.0
     */
    public function getUpdatedShipments($dateTimeFrom = null, $dateTimeTo = null)
    {
        return $this->shippingStatusService->getUpdatedShipments($this->getCustomer(), $dateTimeFrom, $dateTimeTo);
    }

    /**
     * Get the signature of a shipment.
     *
     * @param GetSignature $signature
     *
     * @return GetSignatureResponseSignature
     *
     * @since 1.0.0
     *
     * @deprecated 1.2.0 Use the getSignature(s)By* alternatives
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
     * Get the signature of a shipment.
     *
     * @param string $barcode
     *
     * @return GetSignatureResponseSignature
     *
     * @since 1.2.0
     */
    public function getSignatureByBarcode($barcode)
    {
        $signatureRequest = new GetSignature((new Shipment())->setBarcode($barcode));
        $signatureRequest->setCustomer($this->getCustomer());
        if (!$signatureRequest->getMessage()) {
            $signatureRequest->setMessage(new Message());
        }

        return $this->getShippingStatusService()->getSignature($signatureRequest);
    }

    /**
     * Get the signature of a shipment.
     *
     * @param string[] $barcodes
     *
     * @return GetSignatureResponseSignature[]
     *
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.2.0
     */
    public function getSignaturesByBarcodes(array $barcodes)
    {
        $customer = $this->getCustomer();
        return $this->getShippingStatusService()->getSignatures(array_map(
            function ($barcode) use ($customer) {
                return new GetSignature(
                    (new Shipment())->setBarcode($barcode),
                    $customer,
                    new Message()
                );
            },
            $barcodes
        ));
    }

    /**
     * Get a delivery date.
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return GetDeliveryDateResponse
     *
     * @since 1.0.0
     */
    public function getDeliveryDate(GetDeliveryDate $getDeliveryDate)
    {
        return $this->getDeliveryDateService()->getDeliveryDate($getDeliveryDate);
    }

    /**
     * Get a shipping date.
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return GetSentDateResponse
     *
     * @since 1.0.0
     */
    public function getSentDate(GetSentDateRequest $getSentDate)
    {
        return $this->getDeliveryDateService()->getSentDate($getSentDate);
    }

    /**
     * Get timeframes.
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return ResponseTimeframes
     *
     * @since 1.0.0
     */
    public function getTimeframes(GetTimeframes $getTimeframes)
    {
        return $this->getTimeframeService()->getTimeframes($getTimeframes);
    }

    /**
     * Get nearest locations.
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return GetNearestLocationsResponse
     *
     * @since 1.0.0
     */
    public function getNearestLocations(GetNearestLocations $getNearestLocations)
    {
        return $this->getLocationService()->getNearestLocations($getNearestLocations);
    }

    /**
     * All-in-one function for checkout widgets. It retrieves and returns the
     * - timeframes
     * - locations
     * - delivery date.
     *
     * @param GetTimeframes       $getTimeframes
     * @param GetNearestLocations $getNearestLocations
     * @param GetDeliveryDate     $getDeliveryDate
     *
     * @return array [
     *                   timeframes => ResponseTimeframes,
     *                   locations => GetNearestLocationsResponse,
     *                   delivery_date => GetDeliveryDateResponse,
     *               ]
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function getTimeframesAndNearestLocations(
        GetTimeframes $getTimeframes,
        GetNearestLocations $getNearestLocations,
        GetDeliveryDate $getDeliveryDate
    ) {
        $results = [];
        $itemTimeframe = $this->getTimeframeService()->retrieveCachedItem($getTimeframes->getId());
        if ($itemTimeframe instanceof CacheItemInterface && $itemTimeframe->get()) {
            $results['timeframes'] = PsrMessage::parseResponse($itemTimeframe->get());
        }
        $itemLocation = $this->getLocationService()->retrieveCachedItem($getNearestLocations->getId());
        if ($itemLocation instanceof CacheItemInterface && $itemLocation->get()) {
            $results['locations'] = PsrMessage::parseResponse($itemLocation->get());
        }
        $itemDeliveryDate = $this->getDeliveryDateService()->retrieveCachedItem($getDeliveryDate->getId());
        if ($itemDeliveryDate instanceof CacheItemInterface && $itemDeliveryDate->get()) {
            $results['delivery_date'] = PsrMessage::parseResponse($itemDeliveryDate->get());
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
                if ($response instanceof Exception) {
                    throw $response;
                }
                throw new InvalidArgumentException('Invalid multi-request');
            }
        }

        foreach ($responses as $type => $response) {
            if (!$response instanceof Response) {
                if ($response instanceof Exception) {
                    throw $response;
                }
                throw new InvalidArgumentException('Invalid multi-request');
            } else {
                switch ($type) {
                    case 'timeframes':
                        if (static::MODE_REST === $this->getMode()) {
                            TimeframeService::validateRESTResponse($response);
                        }

                        if ($itemTimeframe instanceof CacheItemInterface) {
                            $itemTimeframe->set(PsrMessage::toString($response));
                            $this->getTimeframeService()->cacheItem($itemTimeframe);
                        }

                        break;
                    case 'locations':
                        if (static::MODE_REST === $this->getMode()) {
                            LocationService::validateRESTResponse($response);
                        }

                        if ($itemTimeframe instanceof CacheItemInterface) {
                            $itemLocation->set(PsrMessage::toString($response));
                            $this->getLocationService()->cacheItem($itemLocation);
                        }

                        break;
                    case 'delivery_date':
                        if (static::MODE_REST === $this->getMode()) {
                            DeliveryDateService::validateRESTResponse($response);
                        }

                        if ($itemTimeframe instanceof CacheItemInterface) {
                            $itemDeliveryDate->set(PsrMessage::toString($response));
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
     * Get locations in area.
     *
     * @param GetLocationsInArea $getLocationsInArea
     *
     * @return GetLocationsInAreaResponse
     *
     * @since 1.0.0
     */
    public function getLocationsInArea(GetLocationsInArea $getLocationsInArea)
    {
        return $this->getLocationService()->getLocationsInArea($getLocationsInArea);
    }

    /**
     * Get locations in area.
     *
     * @param GetLocation $getLocation
     *
     * @return GetLocationsInAreaResponse
     *
     * @since 1.0.0
     */
    public function getLocation(GetLocation $getLocation)
    {
        return $this->getLocationService()->getLocation($getLocation);
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
                    }
                }
                // Regular domestic codes
                $serie = (4 === strlen($range) ? '987000000-987600000' : '0000000-9999999');

                break;
            case 'LA':
            case 'UE':
            case 'RI':
                $serie = '00000000-99999999';

                break;
            default:
                // GlobalPack
                $serie = '0000-9999';

                break;
        }

        return $serie;
    }

    /**
     * Check whether this library will work in the current environment
     *
     * @since 1.2.0
     */
    private function checkEnvironment()
    {
        // Check access to `ini_get` function && check OPCache save_comments setting
        if (function_exists('ini_get')
            && (php_sapi_name() === 'cli' && ini_get('opcache.enable_cli')
                || php_sapi_name() !== 'cli' && ini_get('opcache.enable')
            )
            && !ini_get('opcache.save_comments')
        ) {
            trigger_error(
                'OPCache has been enabled, but comments are removed from the cache. Please set `opcache.save_comments` to `1` in order to use the PostNL library.',
                E_USER_WARNING
            );
        }
    }
}
