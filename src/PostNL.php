<?php

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

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
use Firstred\PostNL\Entity\Request\GenerateBarcode;
use Firstred\PostNL\Entity\Request\GenerateLabel;
use Firstred\PostNL\Entity\Request\GetDeliveryDate;
use Firstred\PostNL\Entity\Request\GetLocation;
use Firstred\PostNL\Entity\Request\GetLocationsInArea;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Entity\Request\GetSentDateRequest;
use Firstred\PostNL\Entity\Request\GetSignature;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Request\SendShipment;
use Firstred\PostNL\Entity\Response\CompleteStatusResponseShipment;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Entity\Response\CurrentStatusResponseShipment;
use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Entity\Response\GetDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\GetLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Entity\Response\GetSentDateResponse;
use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Entity\Response\SendShipmentResponse;
use Firstred\PostNL\Entity\Response\UpdatedShipmentsResponse;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidBarcodeException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotFoundException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\PostNLException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\HttpClient\CurlHttpClient;
use Firstred\PostNL\HttpClient\GuzzleHttpClient;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\HttpClient\HTTPlugHttpClient;
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
use Firstred\PostNL\Service\RequestBuilder\DeliveryDateServiceRequestBuilderInterface;
use Firstred\PostNL\Service\RequestBuilder\LocationServiceRequestBuilderInterface;
use Firstred\PostNL\Service\RequestBuilder\TimeframeServiceRequestBuilderInterface;
use Firstred\PostNL\Service\ResponseProcessor\DeliveryDateServiceResponseProcessorInterface;
use Firstred\PostNL\Service\ResponseProcessor\LocationServiceResponseProcessorInterface;
use Firstred\PostNL\Service\ResponseProcessor\TimeframeServiceResponseProcessorInterface;
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
use Http\Discovery\Exception\ClassInstantiationFailedException;
use Http\Discovery\Exception\DiscoveryFailedException;
use Http\Discovery\Exception\NoCandidateFoundException;
use Http\Discovery\HttpAsyncClientDiscovery;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use ParagonIE\HiddenString\HiddenString;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use ReflectionObject;
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
use function count;
use function defined;
use function interface_exists;
use function is_array;

/**
 * Class PostNL.
 *
 * @since 1.0.0
 */
class PostNL implements LoggerAwareInterface
{
    /**
     * 3S (or EU Pack Special) countries.
     *
     * @var list<string>
     */
    public static array $threeSCountries = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'NL',
        'PL',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];

    /**
     * A6 positions
     * (index = amount of a6 left on the page).
     *
     * @var array{1: array{int, int}, 2: array{int, int}, 3: array{int, int}, 4: array{int, int}}
     */
    public static array $a6positions = [
        4 => [-276, 2],
        3 => [-132, 2],
        2 => [-276, 110],
        1 => [-132, 110],
    ];

    /** @var HiddenString */
    protected HiddenString $apiKey;

    /** @var Customer */
    protected Customer $customer;

    /** @var bool */
    protected bool $sandbox = false;

    /** @var HttpClientInterface */
    protected HttpClientInterface $httpClient;

    /** @var LoggerInterface */
    protected LoggerInterface $logger;

    /** @var RequestFactoryInterface */
    protected RequestFactoryInterface $requestFactory;
    /** @var ResponseFactoryInterface */
    protected ResponseFactoryInterface $responseFactory;
    /** @var StreamFactoryInterface */
    protected StreamFactoryInterface $streamFactory;

    /** @var BarcodeServiceInterface */
    protected BarcodeServiceInterface $barcodeService;
    /** @var LabellingServiceInterface */
    protected LabellingServiceInterface $labellingService;
    /** @var ConfirmingServiceInterface */
    protected ConfirmingServiceInterface $confirmingService;
    /** @var ShippingStatusServiceInterface */
    protected ShippingStatusServiceInterface $shippingStatusService;
    /** @var DeliveryDateServiceInterface */
    protected DeliveryDateServiceInterface $deliveryDateService;
    /** @var TimeframeServiceInterface */
    protected TimeframeServiceInterface $timeframeService;
    /** @var LocationServiceInterface */
    protected LocationServiceInterface $locationService;
    /** @var ShippingServiceInterface */
    protected ShippingServiceInterface $shippingService;

    /**
     * PostNL constructor.
     *
     * @param Customer            $customer customer object
     * @param string|HiddenString $apiKey   API key or UsernameToken object
     * @param bool                $sandbox  whether the testing environment should be used
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        Customer $customer,
        string|HiddenString $apiKey,
        bool $sandbox,
    ) {
        $this->setCustomer(customer: $customer);
        $this->setApiKey(apiKey: $apiKey);
        $this->setSandbox(sandbox: $sandbox);
    }

    /**
     * Get API Key.
     *
     * @return HiddenString
     *
     * @throws InvalidArgumentException
     *
     * @since 1.4.1
     */
    public function getApiKey(): HiddenString
    {
        if (!isset($this->apiKey)) {
            throw new InvalidArgumentException(message: 'API key not set');
        }

        return $this->apiKey;
    }

    /**
     * @param HiddenString|string $apiKey
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setApiKey(HiddenString|string $apiKey): static
    {
        $this->apiKey = is_string(value: $apiKey) ? new HiddenString(value: $apiKey) : $apiKey;

        return $this;
    }

    /**
     * Get PostNL Customer.
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
     * Set PostNL Customer.
     *
     * @param Customer $customer
     *
     * @return static
     *
     * @since 1.0.0
     */
    public function setCustomer(Customer $customer): static
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
    public function getSandbox(): bool
    {
        return $this->sandbox;
    }

    /**
     * Set sandbox mode.
     *
     * @param bool $sandbox
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function setSandbox(bool $sandbox): static
    {
        $this->sandbox = $sandbox;

        $this->getBarcodeService()->setSandbox(sandbox: $sandbox);
        $this->getConfirmingService()->setSandbox(sandbox: $sandbox);
        $this->getDeliveryDateService()->setSandbox(sandbox: $sandbox);
        $this->getLabellingService()->setSandbox(sandbox: $sandbox);
        $this->getLocationService()->setSandbox(sandbox: $sandbox);
        $this->getShippingService()->setSandbox(sandbox: $sandbox);
        $this->getShippingStatusService()->setSandbox(sandbox: $sandbox);
        $this->getTimeframeService()->setSandbox(sandbox: $sandbox);

        return $this;
    }

    /**
     * HttpClient.
     *
     * Automatically load Guzzle when available
     *
     * @return HTTPlugHttpClient|CurlHttpClient|HttpClientInterface|GuzzleHttpClient
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function getHttpClient(): HTTPlugHttpClient|CurlHttpClient|HttpClientInterface|GuzzleHttpClient
    {
        // @codeCoverageIgnoreStart
        if (!isset($this->httpClient)) {
            if (interface_exists(interface: GuzzleClientInterface::class)
                && (defined(constant_name: GuzzleClientInterface::class.'::MAJOR_VERSION') && Util::compareGuzzleVersion(
                    a: constant(name: GuzzleClientInterface::class.'::MAJOR_VERSION'),
                    b: '7.0.0'
                ) >= 0)
            ) {
                $this->setHttpClient(httpClient: new GuzzleHttpClient());
            }

            if (!isset($this->httpClient) && class_exists(class: HttpAsyncClientDiscovery::class)) {
                try {
                    // Detect PHP HTTPlug async HTTP client support
                    if (HttpAsyncClientDiscovery::find()) {
                        $this->setHttpClient(httpClient: new HTTPlugHttpClient());
                    }
                } catch (NotFoundException|\Http\Discovery\Exception\NotFoundException|NoCandidateFoundException|ClassInstantiationFailedException|DiscoveryFailedException) {
                }
            }

            if (!isset($this->httpClient) && class_exists(class: Psr18ClientDiscovery::class)) {
                try {
                    // Detect PHP HTTPlug PSR-18 HTTP client support
                    if (Psr18ClientDiscovery::find()) {
                        $this->setHttpClient(httpClient: new HTTPlugHttpClient());
                    }
                } catch (NotFoundException|\Http\Discovery\Exception\NotFoundException|DiscoveryFailedException|NoCandidateFoundException|ClassInstantiationFailedException) {
                }
            }

            if (!isset($this->httpClient) && class_exists(class: HttpClientDiscovery::class)) {
                try {
                    // Detect PHP HTTPlug HTTP client support
                    if (HttpClientDiscovery::find()) {
                        $this->setHttpClient(httpClient: new HTTPlugHttpClient());
                    }
                } catch (NotFoundException|DiscoveryFailedException|NoCandidateFoundException|\Http\Discovery\Exception\NotFoundException|ClassInstantiationFailedException) {
                }
            }

            if (!isset($this->httpClient)) {
                $this->setHttpClient(httpClient: new CurlHttpClient());
            }

            $this->httpClient->setLogger(logger: $this->getLogger());
        }
        // @codeCoverageIgnoreEnd

        $this->httpClient->setRequestFactory(requestFactory: $this->getRequestFactory());
        $this->httpClient->setResponseFactory(responseFactory: $this->getResponseFactory());
        $this->httpClient->setStreamFactory(streamFactory: $this->getStreamFactory());

        return $this->httpClient;
    }

    /**
     * Set the HttpClient.
     *
     * @param HttpClientInterface $httpClient
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 Renamed `$client` to `$httpClient`, return `$this`
     */
    public function setHttpClient(HttpClientInterface $httpClient): static
    {
        $this->httpClient = $httpClient;

        $this->getBarcodeService()->setHttpClient(httpClient: $httpClient);
        $this->getConfirmingService()->setHttpClient(httpClient: $httpClient);
        $this->getDeliveryDateService()->setHttpClient(httpClient: $httpClient);
        $this->getLabellingService()->setHttpClient(httpClient: $httpClient);
        $this->getLocationService()->setHttpClient(httpClient: $httpClient);
        $this->getShippingService()->setHttpClient(httpClient: $httpClient);
        $this->getShippingStatusService()->setHttpClient(httpClient: $httpClient);
        $this->getTimeframeService()->setHttpClient(httpClient: $httpClient);

        $this->httpClient->setLogger(logger: $this->getLogger());

        return $this;
    }

    /**
     * Get the logger.
     *
     * @return LoggerInterface
     *
     * @since 1.0.0
     */
    public function getLogger(): LoggerInterface
    {
        if (!isset($this->logger)) {
            $this->resetLogger();
        }

        return $this->logger;
    }

    /**
     * Set the logger.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
        if ($this->getHttpClient() instanceof HttpClientInterface) {
            $this->getHttpClient()->setLogger(logger: $logger);
        }
    }

    /**
     * Set a dummy logger.
     *
     * @return static
     *
     * @since 1.2.0
     */
    public function resetLogger(): static
    {
        $this->logger = new DummyLogger();

        return $this;
    }

    /**
     * Get PSR-7 Request factory.
     *
     * @return RequestFactoryInterface
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function getRequestFactory(): RequestFactoryInterface
    {
        if (!isset($this->requestFactory)) {
            $this->setRequestFactory(requestFactory: Psr17FactoryDiscovery::findRequestFactory());
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
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     * @since 1.3.0 Also sets the request factory on the HTTP client
     * @since 2.0.0 Also sets the request factory on services
     */
    public function setRequestFactory(RequestFactoryInterface $requestFactory): static
    {
        $this->requestFactory = $requestFactory;

        $this->getBarcodeService()->setRequestFactory(requestFactory: $requestFactory);
        $this->getConfirmingService()->setRequestFactory(requestFactory: $requestFactory);
        $this->getDeliveryDateService()->setRequestFactory(requestFactory: $requestFactory);
        $this->getLabellingService()->setRequestFactory(requestFactory: $requestFactory);
        $this->getLocationService()->setRequestFactory(requestFactory: $requestFactory);
        $this->getShippingService()->setRequestFactory(requestFactory: $requestFactory);
        $this->getShippingStatusService()->setRequestFactory(requestFactory: $requestFactory);
        $this->getTimeframeService()->setRequestFactory(requestFactory: $requestFactory);

        $this->getHttpClient()->setRequestFactory(requestFactory: $requestFactory);

        return $this;
    }

    /**
     * Get PSR-7 Response factory.
     *
     * @return ResponseFactoryInterface
     *
     * @since 1.2.0
     */
    public function getResponseFactory(): ResponseFactoryInterface
    {
        if (!isset($this->responseFactory)) {
            $this->responseFactory = Psr17FactoryDiscovery::findResponseFactory();
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
     * @since 1.3.0 Also sets the response factory on the HTTP client
     *
     * @throws InvalidArgumentException
     */
    public function setResponseFactory(ResponseFactoryInterface $responseFactory): static
    {
        $this->responseFactory = $responseFactory;

        $this->getHttpClient()->setResponseFactory(responseFactory: $responseFactory);

        return $this;
    }

    /**
     * Set PSR-7 Stream factory.
     *
     * @return StreamFactoryInterface
     *
     * @since 1.2.0
     */
    public function getStreamFactory(): StreamFactoryInterface
    {
        if (!isset($this->streamFactory)) {
            $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
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
     * @since 1.3.0 Also sets the stream factory on the HTTP client
     * @since 2.0.0 Also sets the stream factory on services
     *
     * @throws InvalidArgumentException
     */
    public function setStreamFactory(StreamFactoryInterface $streamFactory): static
    {
        $this->streamFactory = $streamFactory;

        $this->barcodeService->setStreamFactory(streamFactory: $streamFactory);
        $this->confirmingService->setStreamFactory(streamFactory: $streamFactory);
        $this->deliveryDateService->setStreamFactory(streamFactory: $streamFactory);
        $this->labellingService->setStreamFactory(streamFactory: $streamFactory);
        $this->locationService->setStreamFactory(streamFactory: $streamFactory);
        $this->shippingService->setStreamFactory(streamFactory: $streamFactory);
        $this->shippingStatusService->setStreamFactory(streamFactory: $streamFactory);
        $this->timeframeService->setStreamFactory(streamFactory: $streamFactory);

        $this->getHttpClient()->setStreamFactory(streamFactory: $streamFactory);

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
     *
     * @throws InvalidArgumentException
     */
    public function getBarcodeService(): BarcodeServiceInterface
    {
        if (!isset($this->barcodeService)) {
            $this->setBarcodeService(service: new BarcodeService(
                apiKey: $this->getApiKey(),
                sandbox: $this->getSandbox(),
                httpClient: $this->getHttpClient(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            ));
        }

        return $this->barcodeService;
    }

    /**
     * Set the barcode service.
     *
     * @param BarcodeServiceInterface $service
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Return `$this`
     */
    public function setBarcodeService(BarcodeServiceInterface $service): static
    {
        $this->barcodeService = $service;

        return $this;
    }

    /**
     * Labelling service.
     *
     * Automatically load the labelling service
     *
     * @return LabellingServiceInterface
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function getLabellingService(): LabellingServiceInterface
    {
        if (!isset($this->labellingService)) {
            $this->setLabellingService(service: new LabellingService(
                apiKey: $this->getApiKey(),
                sandbox: $this->getSandbox(),
                httpClient: $this->getHttpClient(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            ));
        }

        return $this->labellingService;
    }

    /**
     * Set the labelling service.
     *
     * @param LabellingServiceInterface $service
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Return `$this`
     */
    public function setLabellingService(LabellingServiceInterface $service): static
    {
        $this->labellingService = $service;

        return $this;
    }

    /**
     * Confirming service.
     *
     * Automatically load the confirming service
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function getConfirmingService(): ConfirmingServiceInterface
    {
        if (!isset($this->confirmingService)) {
            $this->setConfirmingService(service: new ConfirmingService(
                apiKey: $this->getApiKey(),
                sandbox: $this->getSandbox(),
                httpClient: $this->getHttpClient(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            ));
        }

        return $this->confirmingService;
    }

    /**
     * Set the confirming service.
     *
     * @param ConfirmingServiceInterface $service
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Return `$this`
     */
    public function setConfirmingService(ConfirmingServiceInterface $service): static
    {
        $this->confirmingService = $service;

        return $this;
    }

    /**
     * Shipping status service.
     *
     * Automatically load the shipping status service
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function getShippingStatusService(): ShippingStatusServiceInterface
    {
        if (!isset($this->shippingStatusService)) {
            $this->setShippingStatusService(service: new ShippingStatusService(
                apiKey: $this->getApiKey(),
                sandbox: $this->getSandbox(),
                httpClient: $this->getHttpClient(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            ));
        }

        return $this->shippingStatusService;
    }

    /**
     * Set the shipping status service.
     *
     * @param ShippingStatusServiceInterface $service
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Return `$this`
     */
    public function setShippingStatusService(ShippingStatusServiceInterface $service): static
    {
        $this->shippingStatusService = $service;

        return $this;
    }

    /**
     * Delivery date service.
     *
     * Automatically load the delivery date service
     *
     * @return DeliveryDateServiceInterface
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function getDeliveryDateService(): DeliveryDateServiceInterface
    {
        if (!isset($this->deliveryDateService)) {
            $this->setDeliveryDateService(service: new DeliveryDateService(
                apiKey: $this->getApiKey(),
                sandbox: $this->getSandbox(),
                httpClient: $this->getHttpClient(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            ));
        }

        return $this->deliveryDateService;
    }

    /**
     * Set the delivery date service.
     *
     * @param DeliveryDateServiceInterface $service
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Return `$this`
     */
    public function setDeliveryDateService(DeliveryDateServiceInterface $service): static
    {
        $this->deliveryDateService = $service;

        return $this;
    }

    /**
     * Timeframe service.
     *
     * Automatically load the timeframe service
     *
     * @return TimeframeServiceInterface
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function getTimeframeService(): TimeframeServiceInterface
    {
        if (!isset($this->timeframeService)) {
            $this->setTimeframeService(service: new TimeframeService(
                apiKey: $this->getApiKey(),
                sandbox: $this->getSandbox(),
                httpClient: $this->getHttpClient(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            ));
        }

        return $this->timeframeService;
    }

    /**
     * Set the timeframe service.
     *
     * @param TimeframeServiceInterface $service
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Return `$this`
     */
    public function setTimeframeService(TimeframeServiceInterface $service): static
    {
        $this->timeframeService = $service;

        return $this;
    }

    /**
     * Location service.
     *
     * Automatically load the location service
     *
     * @return LocationServiceInterface
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function getLocationService(): LocationServiceInterface
    {
        if (!isset($this->locationService)) {
            $this->setLocationService(service: new LocationService(
                apiKey: $this->getApiKey(),
                sandbox: $this->getSandbox(),
                httpClient: $this->getHttpClient(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            ));
        }

        return $this->locationService;
    }

    /**
     * Set the location service.
     *
     * @param LocationServiceInterface $service
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Return `$this`
     */
    public function setLocationService(LocationServiceInterface $service): static
    {
        $this->locationService = $service;

        return $this;
    }

    /**
     * Shipping service.
     *
     * Automatically load the shipping service
     *
     * @return ShippingServiceInterface
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function getShippingService(): ShippingServiceInterface
    {
        if (!isset($this->shippingService)) {
            $this->setShippingService(service: new ShippingService(
                apiKey: $this->getApiKey(),
                sandbox: $this->getSandbox(),
                httpClient: $this->getHttpClient(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
            ));
        }

        return $this->shippingService;
    }

    /**
     * Set the shipping service.
     *
     * @param ShippingServiceInterface $service
     *
     * @return static
     *
     * @since 1.2.0
     * @since 2.0.0 Return `$this`
     */
    public function setShippingService(ShippingServiceInterface $service): static
    {
        $this->shippingService = $service;

        return $this;
    }

    /**
     * Generate a single barcode.
     *
     * @param string      $type
     * @param string|null $range
     * @param string|null $serie
     * @param bool        $eps
     *
     * @return string
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws InvalidBarcodeException
     * @throws InvalidConfigurationException
     * @throws ResponseException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function generateBarcode(string $type = '3S', string $range = null, string $serie = null, bool $eps = false): string
    {
        if (2 !== strlen(string: $type)) {
            throw new InvalidBarcodeException(message: "Barcode type `$type` is invalid");
        }

        if (!$range) {
            if (in_array(needle: $type, haystack: ['2S', '3S'])) {
                $range = $this->getCustomer()->getCustomerCode();
            } else {
                $range = $this->getCustomer()->getGlobalPackCustomerCode();
            }
        }
        if (!$range) {
            throw new InvalidBarcodeException(message: 'Unable to find a valid range');
        }

        if (!$serie) {
            $serie = $this->findBarcodeSerie(type: $type, range: $range, eps: $eps);
        }

        return $this->getBarcodeService()->generateBarcode(
            generateBarcode: new GenerateBarcode(
                Barcode: new Barcode(
                    Type: $type,
                    Range: $range,
                    Serie: $serie
                ),
                Customer: $this->customer,
            ),
        );
    }

    /**
     * Generate a single barcode by country code.
     *
     * @param string $iso 2-letter Country ISO Code
     *
     * @return string The Barcode as a string
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws InvalidBarcodeException
     * @throws InvalidConfigurationException
     * @throws ResponseException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function generateBarcodeByCountryCode(string $iso): string
    {
        if (in_array(needle: strtoupper(string: $iso), haystack: static::$threeSCountries)) {
            $range = $this->getCustomer()->getCustomerCode();
            $type = '3S';
        } else {
            $range = $this->getCustomer()->getGlobalPackCustomerCode();
            $type = $this->getCustomer()->getGlobalPackBarcodeType();

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
            eps: 'NL' !== strtoupper(string: $iso) && in_array(needle: strtoupper(string: $iso), haystack: static::$threeSCountries)
        );

        return $this->getBarcodeService()->generateBarcode(generateBarcode: new GenerateBarcode(Barcode: new Barcode(Type: $type, Range: $range, Serie: $serie), Customer: $this->customer));
    }

    /**
     * Generate a single barcode by country code.
     *
     * @param array<string, int> $isos key = iso code, value = amount of barcodes requested
     *
     * @return array<string, array<string>> Country isos with the barcodes as string
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws InvalidBarcodeException
     * @throws InvalidConfigurationException
     * @throws ResponseException
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
            if (in_array(needle: strtoupper(string: $iso), haystack: static::$threeSCountries)) {
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
                eps: 'NL' !== strtoupper(string: $iso) && in_array(needle: strtoupper(string: $iso), haystack: static::$threeSCountries)
            );

            for ($i = 0; $i < $qty; ++$i) {
                $generateBarcodes[] = (new GenerateBarcode(Barcode: new Barcode(Type: $type, Range: $range, Serie: $serie), Customer: $this->customer))->setId(id: "$iso-$index");
                ++$index;
            }
        }

        $results = $this->getBarcodeService()->generateBarcodes(generateBarcodes: $generateBarcodes);

        $barcodes = [];
        foreach ($results as $id => $barcode) {
            list($iso) = explode(separator: '-', string: $id);
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
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws NotFoundException
     * @throws InvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.2.0
     */
    public function sendShipment(
        Shipment $shipment,
        string $printertype = 'GraphicFile|PDF',
        bool $confirm = true
    ): SendShipmentResponse {
        return $this->getShippingService()->sendShipment(
            sendShipment: new SendShipment(
                Shipments: [$shipment],
                Message: new LabellingMessage(Printertype: $printertype),
                Customer: $this->customer,
            ),
            confirm: $confirm,
        );
    }

    /**
     * Send multiple shipments.
     *
     * @param Shipment[]                                $shipments     Array of shipments
     * @param string                                    $printertype   Printer type, see PostNL dev docs for
     *                                                                 available types
     * @param bool                                      $confirm       Immediately confirm the shipments
     * @param bool                                      $merge         Merge the PDFs and return them in a
     *                                                                 MyParcel way
     * @param int                                       $format        A4 or A6
     * @param array{1: bool, 2: bool, 3: bool, 4: bool} $positions     Set the positions of the A6s on the
     *                                                                 first A4 The indices should be the
     *                                                                 position number, marked with `true` or
     *                                                                 `false` These are the position numbers:
     *                                                                 ```
     *                                                                 +-+-+
     *                                                                 |2|4|
     *                                                                 +-+-+
     *                                                                 |1|3|
     *                                                                 +-+-+
     *                                                                 ```
     *                                                                 So, for
     *                                                                 ```
     *                                                                 +-+-+
     *                                                                 |x|✔|
     *                                                                 +-+-+
     *                                                                 |✔|x|
     *                                                                 +-+-+
     *                                                                 ```
     *                                                                 you would have to pass:
     *                                                                 ```php
     *                                                                 [
     *                                                                 1 => true,
     *                                                                 2 => false,
     *                                                                 3 => false,
     *                                                                 4 => true,
     *                                                                 ]
     *                                                                 ```
     * @param string                                    $a6Orientation A6 orientation (P or L)
     *
     * @return SendShipmentResponse|string
     *
     * @throws NotSupportedException
     * @throws CrossReferenceException
     * @throws FilterException
     * @throws PdfParserException
     * @throws PdfTypeException
     * @throws PdfReaderException
     * @throws NotFoundException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function sendShipments(
        array $shipments,
        string $printertype = 'GraphicFile|PDF',
        bool $confirm = true,
        bool $merge = false,
        int $format = Label::FORMAT_A4,
        array $positions = [
            1 => true,
            2 => true,
            3 => true,
            4 => true,
        ],
        string $a6Orientation = 'P'
    ): SendShipmentResponse|string {
        if ($merge) {
            if ('GraphicFile|PDF' !== $printertype) {
                throw new NotSupportedException(message: 'Labels with the chosen printer type cannot be merged');
            }
            foreach ([1, 2, 3, 4] as $i) {
                if (!array_key_exists(key: $i, array: $positions)) {
                    throw new NotSupportedException(message: 'All label positions need to be passed for merge mode');
                }
            }
        }

        $responseShipments = $this->getShippingService()->sendShipment(
            sendShipment: new SendShipment(
                Shipments: $shipments,
                Message: new LabellingMessage(Printertype: $printertype),
                Customer: $this->customer
            ),
            confirm: $confirm
        );

        if (!$merge) {
            return $responseShipments;
        }

        // Disable header and footer
        $pdf = new RFPdi(orientation: 'P', unit: 'mm', size: Label::FORMAT_A4 === $format ? [210, 297] : [105, 148]);
        $deferred = [];
        $firstPage = true;
        if (Label::FORMAT_A6 === $format) {
            foreach ($responseShipments->getResponseShipments() as $responseShipment) {
                foreach ($responseShipment->getLabels() as $label) {
                    $pdfContent = base64_decode(string: $label->getContent());
                    $sizes = Util::getPdfSizeAndOrientation(pdf: $pdfContent);
                    if ('A6' === $sizes['iso']) {
                        $pdf->addPage(orientation: $a6Orientation);
                        $correction = [0, 0];
                        if ('L' === $a6Orientation && 'P' === $sizes['orientation']) {
                            $correction[0] = -84;
                            $correction[1] = -0.5;
                            $pdf->rotateCounterClockWise();
                        } elseif ('P' === $a6Orientation && 'L' === $sizes['orientation']) {
                            $pdf->rotateCounterClockWise();
                        }
                        $pdf->setSourceFile(file: StreamReader::createByString(content: $pdfContent));
                        $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: $correction[0], y: $correction[1]);
                    } else {
                        // Assuming A4 here (could be multi-page) - defer to end
                        $stream = StreamReader::createByString(content: $pdfContent);
                        $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
                    }
                }
            }
        } else {
            $a6s = 4; // Amount of A6s available
            $responseShipmentsArray = $responseShipments->getResponseShipments();
            foreach ($responseShipmentsArray as $label) {
                $pdfContent = base64_decode(string: $label->getLabels()[0]->getContent());
                $sizes = Util::getPdfSizeAndOrientation(pdf: $pdfContent);
                if ('A6' === $sizes['iso']) {
                    if ($firstPage) {
                        $pdf->addPage(orientation: 'P', size: [297, 210], rotation: 90);
                    }
                    $firstPage = false;
                    while (empty($positions[5 - $a6s]) && $a6s >= 1) {
                        $positions[5 - $a6s] = true;
                        --$a6s;
                    }
                    if ($a6s < 1) {
                        $pdf->addPage(orientation: 'P', size: [297, 210], rotation: 90);
                        $a6s = 4;
                    }
                    $pdf->rotateCounterClockWise();
                    $pdf->setSourceFile(file: StreamReader::createByString(content: $pdfContent));
                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: static::$a6positions[$a6s][0], y: static::$a6positions[$a6s][1]);
                    --$a6s;
                    if ($a6s < 1) {
                        if ($label !== end(array: $responseShipmentsArray)) {
                            $pdf->addPage(orientation: 'P', size: [297, 210], rotation: 90);
                        }
                        $a6s = 4;
                    }
                } else {
                    // Assuming A4 here (could be multi-page) - defer to end
                    if (count(value: $label->getLabels()) > 1) {
                        $stream = [];
                        foreach ($label->getResponseShipments()[0]->getLabels() as $labelContent) {
                            $stream[] = StreamReader::createByString(content: base64_decode(string: $labelContent->getContent()));
                        }
                    } else {
                        $stream = StreamReader::createByString(content: $pdfContent);
                    }
                    $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
                }
            }
        }
        foreach ($deferred as $defer) {
            $sizes = $defer['sizes'];
            $pdf->addPage(orientation: $sizes['orientation'], size: 'A4');
            if (is_array(value: $defer['stream']) && count(value: $defer['stream']) > 1) {
                // Multilabel
                $pdf->rotateCounterClockWise();
                $pdf->setSourceFile(file: $defer['stream'][0]);
                $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 0);
                $pdf->setSourceFile(file: $defer['stream'][1]);
                $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 148);
                if (2 !== count(value: $deferred['stream'])) {
                    for ($i = 2; $i < count(value: $defer['stream']); ++$i) {
                        $pages = $pdf->setSourceFile(file: $defer['stream'][$i]);
                        for ($j = 1; $j < $pages + 1; ++$j) {
                            $pdf->addPage(orientation: $sizes['orientation'], size: 'A4');
                            $pdf->rotateCounterClockWise();
                            $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 0);
                        }
                    }
                }
            } else {
                if (!is_array(value: $defer['stream'])) {
                    $pdf->setSourceFile(file: $defer['stream']);
                } else {
                    $pdf->setSourceFile(file: $defer['stream'][0]);
                }
                $width = $pdf->GetPageWidth();
                $height = $pdf->GetPageHeight();
                $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: 0, y: 0, width: $width, height: $height);
            }
        }

        return $pdf->output(dest: '', name: 'S');
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
     * @throws InvalidArgumentException
     * @throws NotFoundException
     *
     * @since 1.0.0
     */
    public function generateLabel(
        Shipment $shipment,
        string $printertype = 'GraphicFile|PDF',
        bool $confirm = true
    ): GenerateLabelResponse {
        return $this->getLabellingService()->generateLabel(
            generateLabel: new GenerateLabel(
                Shipments: [$shipment],
                Message: new LabellingMessage(Printertype: $printertype),
                Customer: $this->customer
            ),
            confirm: $confirm
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
     * @throws InvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function generateLabels(
        array $shipments,
        string $printertype = 'GraphicFile|PDF',
        bool $confirm = true,
        bool $merge = false,
        int $format = Label::FORMAT_A4,
        array $positions = [
            1 => true,
            2 => true,
            3 => true,
            4 => true,
        ],
        string $a6Orientation = 'P',
    ): string|array {
        if ($merge) {
            if ('GraphicFile|PDF' !== $printertype) {
                throw new NotSupportedException(message: 'Labels with the chosen printer type cannot be merged');
            }
            foreach ([1, 2, 3, 4] as $i) {
                if (!array_key_exists(key: $i, array: $positions)) {
                    throw new NotSupportedException(message: 'All label positions need to be passed for merge mode');
                }
            }
        }

        $generateLabels = [];
        foreach ($shipments as $uuid => $shipment) {
            $generateLabels[$uuid] = [(new GenerateLabel(Shipments: [$shipment], Message: new LabellingMessage(Printertype: $printertype), Customer: $this->customer))->setId(id: $uuid), $confirm];
        }
        $responseShipments = $this->getLabellingService()->generateLabels(generateLabels: $generateLabels);

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
        $pdf = new RFPdi(orientation: 'P', unit: 'mm', size: Label::FORMAT_A4 === $format ? [210, 297] : [105, 148]);
        $deferred = [];
        $firstPage = true;
        if (Label::FORMAT_A6 === $format) {
            foreach ($responseShipments as $responseShipment) {
                foreach ($responseShipment->getResponseShipments()[0]->getLabels() as $label) {
                    $pdfContent = base64_decode(string: $label->getContent());
                    $sizes = Util::getPdfSizeAndOrientation(pdf: $pdfContent);
                    if ('A6' === $sizes['iso']) {
                        $pdf->addPage(orientation: $a6Orientation);
                        $correction = [0, 0];
                        if ('L' === $a6Orientation && 'P' === $sizes['orientation']) {
                            $correction[0] = -84;
                            $correction[1] = -0.5;
                            $pdf->rotateCounterClockWise();
                        } elseif ('P' === $a6Orientation && 'L' === $sizes['orientation']) {
                            $pdf->rotateCounterClockWise();
                        }
                        $pdf->setSourceFile(file: StreamReader::createByString(content: $pdfContent));
                        $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: $correction[0], y: $correction[1]);
                    } else {
                        // Assuming A4 here (could be multi-page) - defer to end
                        $stream = StreamReader::createByString(content: $pdfContent);
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
                $pdfContent = base64_decode(string: $responseShipment->getResponseShipments()[0]->getLabels()[0]->getContent());
                $sizes = Util::getPdfSizeAndOrientation(pdf: $pdfContent);
                if ('A6' === $sizes['iso']) {
                    if ($firstPage) {
                        $pdf->addPage(orientation: 'P', size: [297, 210], rotation: 90);
                    }
                    $firstPage = false;
                    while (empty($positions[5 - $a6s]) && $a6s >= 1) {
                        $positions[5 - $a6s] = true;
                        --$a6s;
                    }
                    if ($a6s < 1) {
                        $pdf->addPage(orientation: 'P', size: [297, 210], rotation: 90);
                        $a6s = 4;
                    }
                    $pdf->rotateCounterClockWise();
                    $pdf->setSourceFile(file: StreamReader::createByString(content: $pdfContent));
                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: static::$a6positions[$a6s][0], y: static::$a6positions[$a6s][1]);
                    --$a6s;
                    if ($a6s < 1) {
                        if ($responseShipment !== end(array: $responseShipments)) {
                            $pdf->addPage(orientation: 'P', size: [297, 210], rotation: 90);
                        }
                        $a6s = 4;
                    }
                } else {
                    // Assuming A4 here (could be multi-page) - defer to end
                    if (count(value: $responseShipment->getResponseShipments()[0]->getLabels()) > 1) {
                        $stream = [];
                        foreach ($responseShipment->getResponseShipments()[0]->getLabels() as $labelContent) {
                            $stream[] = StreamReader::createByString(content: base64_decode(string: $labelContent->getContent()));
                        }
                    } else {
                        $stream = StreamReader::createByString(content: $pdfContent);
                    }
                    $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
                }
            }
        }
        foreach ($deferred as $defer) {
            $sizes = $defer['sizes'];
            $pdf->addPage(orientation: $sizes['orientation'], size: 'A4');
            if (is_array(value: $defer['stream']) && count(value: $defer['stream']) > 1) {
                // Multilabel
                $pdf->rotateCounterClockWise();
                $pdf->setSourceFile(file: $defer['stream'][0]);
                $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 0);
                $pdf->setSourceFile(file: $defer['stream'][1]);
                $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 148);
                if (2 !== count(value: $deferred['stream'])) {
                    for ($i = 2; $i < count(value: $defer['stream']); ++$i) {
                        $pages = $pdf->setSourceFile(file: $defer['stream'][$i]);
                        for ($j = 1; $j < $pages + 1; ++$j) {
                            $pdf->addPage(orientation: $sizes['orientation'], size: 'A4');
                            $pdf->rotateCounterClockWise();
                            $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 0);
                        }
                    }
                }
            } else {
                if (!is_array(value: $defer['stream'])) {
                    $pdf->setSourceFile(file: $defer['stream']);
                } else {
                    $pdf->setSourceFile(file: $defer['stream'][0]);
                }
                $width = $pdf->GetPageWidth();
                $height = $pdf->GetPageHeight();
                $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: 0, y: 0, width: $width, height: $height);
            }
        }

        return $pdf->output(dest: '', name: 'S');
    }

    /**
     * Confirm a single shipment.
     *
     * @param Shipment $shipment
     *
     * @return ConfirmingResponseShipment
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function confirmShipment(Shipment $shipment): ConfirmingResponseShipment
    {
        return $this->getConfirmingService()->confirmShipment(
            confirming: new Confirming(
                Shipments: [$shipment],
                Customer: $this->customer,
            ),
        );
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
     *
     * @since 1.0.0
     */
    public function confirmShipments(array $shipments): array
    {
        $confirmings = [];
        foreach ($shipments as $uuid => $shipment) {
            $confirmings[$uuid] = (new Confirming(Shipments: [$shipment], Customer: $this->customer))->setId(id: $uuid);
        }

        return $this->getConfirmingService()->confirmShipments(confirms: $confirmings);
    }

    /**
     * Get the current status of the given shipment by barcode.
     *
     * @param string $barcode  Pass a single barcode
     * @param bool   $complete Return the complete status (incl. shipment history)
     *
     * @return CurrentStatusResponseShipment|CompleteStatusResponseShipment
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws ResponseException
     * @throws NotFoundException
     * @throws PsrCacheInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function getShippingStatusByBarcode(string $barcode, bool $complete = false): CurrentStatusResponseShipment|CompleteStatusResponseShipment
    {
        if ($complete) {
            $statusRequest = new CompleteStatus(Shipment: (new Shipment())->setBarcode(Barcode: $barcode));
        } else {
            $statusRequest = new CurrentStatus(Shipment: (new Shipment())->setBarcode(Barcode: $barcode));
        }

        if (!$statusRequest->getMessage()) {
            $statusRequest->setMessage(Message: new Message());
        }

        if ($complete) {
            $shipments = $this->getShippingStatusService()->completeStatus(completeStatus: $statusRequest)->getShipments();
        } else {
            $shipments = $this->getShippingStatusService()->currentStatus(currentStatus: $statusRequest)->getShipments();
        }

        if (empty($shipments) || !is_array(value: $shipments)) {
            throw new NotFoundException(message: "Barcode `$barcode`` not found");
        }

        return $shipments[0];
    }

    /**
     * Get the current statuses of the given shipments by barcodes.
     *
     * @param string[] $barcodes Pass multiple barcodes
     * @param bool     $complete Return the complete status (incl. shipment history)
     *
     * @return non-empty-array<string, CurrentStatusResponseShipment|CompleteStatusResponseShipment>
     *
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.2.0
     */
    public function getShippingStatusesByBarcodes(array $barcodes, bool $complete = false): array
    {
        $shipments = [];
        if ($complete) {
            $shipmentResponses = $this->getShippingStatusService()->completeStatuses(completeStatuses: array_map(
                callback: function ($barcode) {
                    return (new CompleteStatus())->setShipment(Shipment: (new Shipment())->setBarcode(Barcode: $barcode));
                },
                array: $barcodes
            ));
        } else {
            $shipmentResponses = $this->getShippingStatusService()->currentStatuses(currentStatuses: array_map(
                callback: function ($barcode) {
                    return (new CurrentStatus())->setShipment(Shipment: (new Shipment())->setBarcode(Barcode: $barcode));
                },
                array: $barcodes
            ));
        }

        foreach ($shipmentResponses as $shipmentResponse) {
            foreach ($shipmentResponse->getShipments() as $shipment) {
                $shipments[$shipment->getBarcode()] = $shipment;
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
     * @throws InvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     * @throws NotFoundException
     *
     * @since 1.2.0
     */
    public function getShippingStatusByReference(string $reference, bool $complete = false): CurrentStatusResponseShipment|CompleteStatusResponseShipment
    {
        if ($complete) {
            $statusRequest = new CompleteStatus(Shipment: (new Shipment())->setReference(Reference: $reference));
        } else {
            $statusRequest = new CurrentStatus(Shipment: (new Shipment())->setReference(Reference: $reference));
        }

        if (!$statusRequest->getMessage()) {
            $statusRequest->setMessage(Message: new Message());
        }

        if ($complete) {
            $shipments = $this->getShippingStatusService()->completeStatus(completeStatus: $statusRequest)->getShipments();
        } else {
            $shipments = $this->getShippingStatusService()->currentStatus(currentStatus: $statusRequest)->getShipments();
        }

        if (empty($shipments) || !is_array(value: $shipments)) {
            throw new NotFoundException(message: "Shipment with reference `$reference` not found");
        }

        return $shipments[0];
    }

    /**
     * Get the current statuses of the given shipments by references.
     *
     * @param string[] $references Pass multiple references
     * @param bool     $complete   Return the complete status (incl. shipment history)
     *
     * @return non-empty-array<string, CurrentStatusResponseShipment|CompleteStatusResponseShipment>
     *
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.2.0
     */
    public function getShippingStatusesByReferences(array $references, bool $complete = false): array
    {
        $shipments = [];
        if ($complete) {
            $shipmentResponses = $this->getShippingStatusService()->completeStatuses(completeStatuses: array_map(
                callback: function ($reference) {
                    return (new CompleteStatus())->setShipment(Shipment: (new Shipment())->setReference(Reference: $reference));
                },
                array: $references
            ));
        } else {
            $shipmentResponses = $this->getShippingStatusService()->currentStatuses(currentStatuses: array_map(
                callback: function ($reference) {
                    return (new CurrentStatus())->setShipment(Shipment: (new Shipment())->setReference(Reference: $reference));
                },
                array: $references
            ));
        }

        foreach ($shipmentResponses as $shipmentResponse) {
            foreach ($shipmentResponse->getShipments() as $shipment) {
                $shipments[$shipment->getReference()] = $shipment;
            }
        }

        return $shipments;
    }

    /**
     * Get updated shipments.
     *
     * @param DateTimeInterface|null $dateTimeFrom
     * @param DateTimeInterface|null $dateTimeTo
     *
     * @return UpdatedShipmentsResponse[]
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.2.0
     */
    public function getUpdatedShipments(DateTimeInterface $dateTimeFrom = null, DateTimeInterface $dateTimeTo = null): array
    {
        return $this->getShippingStatusService()->getUpdatedShipments(
            customer: $this->getCustomer(),
            dateTimeFrom: $dateTimeFrom,
            dateTimeTo: $dateTimeTo,
        );
    }

    /**
     * Get the signature of a shipment.
     *
     * @param string $barcode
     *
     * @return GetSignatureResponseSignature
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.2.0
     */
    public function getSignatureByBarcode(string $barcode): GetSignatureResponseSignature
    {
        $signatureRequest = new GetSignature(Shipment: (new Shipment())->setBarcode(Barcode: $barcode));
        $signatureRequest->setCustomer(Customer: $this->getCustomer());
        if (!$signatureRequest->getMessage()) {
            $signatureRequest->setMessage(Message: new Message());
        }

        return $this->getShippingStatusService()->getSignature(getSignature: $signatureRequest);
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
     * @throws InvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.2.0
     */
    public function getSignaturesByBarcodes(array $barcodes): array
    {
        $customer = $this->getCustomer();

        return $this->getShippingStatusService()->getSignatures(getSignatures: array_map(
            callback: function ($barcode) use ($customer) {
                return new GetSignature(
                    Shipment: (new Shipment())
                        ->setCustomer(Customer: $customer)
                        ->setBarcode(Barcode: $barcode),
                    Customer: $customer,
                    Message: new Message()
                );
            },
            array: $barcodes
        ));
    }

    /**
     * Get a delivery date.
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return GetDeliveryDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function getDeliveryDate(GetDeliveryDate $getDeliveryDate): GetDeliveryDateResponse
    {
        return $this->getDeliveryDateService()->getDeliveryDate(getDeliveryDate: $getDeliveryDate);
    }

    /**
     * Get a shipping date.
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return GetSentDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function getSentDate(GetSentDateRequest $getSentDate): GetSentDateResponse
    {
        return $this->getDeliveryDateService()->getSentDate(getSentDate: $getSentDate);
    }

    /**
     * Get timeframes.
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return ResponseTimeframes
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function getTimeframes(GetTimeframes $getTimeframes): ResponseTimeframes
    {
        return $this->getTimeframeService()->getTimeframes(getTimeframes: $getTimeframes);
    }

    /**
     * Get nearest locations.
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return GetNearestLocationsResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function getNearestLocations(GetNearestLocations $getNearestLocations): GetNearestLocationsResponse
    {
        return $this->getLocationService()->getNearestLocations(getNearestLocations: $getNearestLocations);
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
     *               timeframes => ResponseTimeframes,
     *               locations => GetNearestLocationsResponse,
     *               delivery_date => GetDeliveryDateResponse,
     *               ]
     *
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws \ReflectionException
     *
     * @since 1.0.0
     */
    public function getTimeframesAndNearestLocations(
        GetTimeframes $getTimeframes,
        GetNearestLocations $getNearestLocations,
        GetDeliveryDate $getDeliveryDate
    ): array {
        $results = [];
        $itemTimeframe = $this->getTimeframeService()->retrieveCachedItem(uuid: $getTimeframes->getId());
        if ($itemTimeframe instanceof CacheItemInterface && $itemTimeframe->get()) {
            $results['timeframes'] = PsrMessage::parseResponse(message: $itemTimeframe->get());
        }
        $itemLocation = $this->getLocationService()->retrieveCachedItem(uuid: $getNearestLocations->getId());
        if ($itemLocation instanceof CacheItemInterface && $itemLocation->get()) {
            $results['locations'] = PsrMessage::parseResponse(message: $itemLocation->get());
        }
        $itemDeliveryDate = $this->getDeliveryDateService()->retrieveCachedItem(uuid: $getDeliveryDate->getId());
        if ($itemDeliveryDate instanceof CacheItemInterface && $itemDeliveryDate->get()) {
            $results['delivery_date'] = PsrMessage::parseResponse(message: $itemDeliveryDate->get());
        }

        // FIXME: do not rely on reflection
        $reflectionTimeframeService = new ReflectionObject(object: $this->getTimeframeService());
        $reflectionTimeframeServiceRequestBuilder = $reflectionTimeframeService->getProperty(name: 'requestBuilder');
        /* @noinspection PhpExpressionResultUnusedInspection */
        $reflectionTimeframeServiceRequestBuilder->setAccessible(accessible: true);
        /** @var TimeframeServiceRequestBuilderInterface $timeframeServiceRequestBuilder */
        $timeframeServiceRequestBuilder = $reflectionTimeframeServiceRequestBuilder->getValue(object: $this->getTimeframeService());
        $reflectionTimeframeServiceResponseProcessor = $reflectionTimeframeService->getProperty(name: 'responseProcessor');
        /* @noinspection PhpExpressionResultUnusedInspection */
        $reflectionTimeframeServiceResponseProcessor->setAccessible(accessible: true);
        /** @var TimeframeServiceResponseProcessorInterface $timeframeServiceResponseProcessor */
        $timeframeServiceResponseProcessor = $reflectionTimeframeServiceResponseProcessor->getValue(object: $this->getTimeframeService());
        $reflectionTimeframeServiceResponseProcessor = new ReflectionObject(object: $timeframeServiceResponseProcessor);
        $reflectionTimeframeServiceResponseValidator = $reflectionTimeframeServiceResponseProcessor->getMethod(name: 'validateResponse');
        /* @noinspection PhpExpressionResultUnusedInspection */
        $reflectionTimeframeServiceResponseValidator->setAccessible(accessible: true);

        $reflectionLocationService = new ReflectionObject(object: $this->getLocationService());
        $reflectionLocationServiceRequestBuilder = $reflectionLocationService->getProperty(name: 'requestBuilder');
        /* @noinspection PhpExpressionResultUnusedInspection */
        $reflectionLocationServiceRequestBuilder->setAccessible(accessible: true);
        /** @var LocationServiceRequestBuilderInterface $locationServiceRequestBuilder */
        $locationServiceRequestBuilder = $reflectionLocationServiceRequestBuilder->getValue(object: $this->getLocationService());
        $reflectionLocationServiceResponseProcessor = $reflectionLocationService->getProperty(name: 'responseProcessor');
        /* @noinspection PhpExpressionResultUnusedInspection */
        $reflectionLocationServiceResponseProcessor->setAccessible(accessible: true);
        /** @var LocationServiceResponseProcessorInterface $locationServiceResponseProcessor */
        $locationServiceResponseProcessor = $reflectionLocationServiceResponseProcessor->getValue(object: $this->getLocationService());
        $reflectionLocationServiceResponseProcessor = new ReflectionObject(object: $locationServiceResponseProcessor);
        $reflectionLocationServiceResponseValidator = $reflectionLocationServiceResponseProcessor->getMethod(name: 'validateResponse');
        /* @noinspection PhpExpressionResultUnusedInspection */
        $reflectionLocationServiceResponseValidator->setAccessible(accessible: true);

        $reflectionDeliveryDateService = new ReflectionObject(object: $this->getDeliveryDateService());
        $reflectionDeliveryDateServiceRequestBuilder = $reflectionDeliveryDateService->getProperty(name: 'requestBuilder');
        /* @noinspection PhpExpressionResultUnusedInspection */
        $reflectionDeliveryDateServiceRequestBuilder->setAccessible(accessible: true);
        /** @var DeliveryDateServiceRequestBuilderInterface $deliveryDateServiceRequestBuilder */
        $deliveryDateServiceRequestBuilder = $reflectionDeliveryDateServiceRequestBuilder->getValue(object: $this->getDeliveryDateService());
        $reflectionDeliveryDateServiceResponseProcessor = $reflectionDeliveryDateService->getProperty(name: 'responseProcessor');
        /* @noinspection PhpExpressionResultUnusedInspection */
        $reflectionDeliveryDateServiceResponseProcessor->setAccessible(accessible: true);
        /** @var DeliveryDateServiceResponseProcessorInterface $deliveryDateServiceResponseProcessor */
        $deliveryDateServiceResponseProcessor = $reflectionDeliveryDateServiceResponseProcessor->getValue(object: $this->getDeliveryDateService());
        $reflectionDeliveryDateServiceResponseProcessor = new ReflectionObject(object: $deliveryDateServiceResponseProcessor);
        $reflectionDeliveryDateServiceResponseValidator = $reflectionDeliveryDateServiceResponseProcessor->getMethod(name: 'validateResponse');
        /* @noinspection PhpExpressionResultUnusedInspection */
        $reflectionDeliveryDateServiceResponseValidator->setAccessible(accessible: true);

        $this->getHttpClient()->addOrUpdateRequest(
            id: 'timeframes',
            request: $timeframeServiceRequestBuilder->buildGetTimeframesRequest(getTimeframes: $getTimeframes)
        );
        $this->getHttpClient()->addOrUpdateRequest(
            id: 'locations',
            request: $locationServiceRequestBuilder->buildGetNearestLocationsRequest(getNearestLocations: $getNearestLocations)
        );
        $this->getHttpClient()->addOrUpdateRequest(
            id: 'delivery_date',
            request: $deliveryDateServiceRequestBuilder->buildGetDeliveryDateRequest(getDeliveryDate: $getDeliveryDate)
        );

        $responses = $this->getHttpClient()->doRequests();
        foreach ($responses as $uuid => $response) {
            if ($response instanceof Response) {
                $results[$uuid] = $response;
            } else {
                if ($response instanceof Exception) {
                    throw $response;
                }
                throw new InvalidArgumentException(message: 'Invalid multi-request');
            }
        }

        foreach ($responses as $type => $response) {
            if (!$response instanceof Response) {
                if ($response instanceof Exception) {
                    throw $response;
                }
                throw new InvalidArgumentException(message: 'Invalid multi-request');
            } else {
                switch ($type) {
                    case 'timeframes':
                        $reflectionTimeframeServiceResponseValidator->invokeArgs(
                            object: $timeframeServiceResponseProcessor,
                            args: [$response],
                        );

                        if ($itemTimeframe instanceof CacheItemInterface) {
                            $itemTimeframe->set(value: PsrMessage::toString(message: $response));
                            $this->getTimeframeService()->cacheItem(item: $itemTimeframe);
                        }

                        break;
                    case 'locations':
                        $reflectionLocationServiceResponseValidator->invokeArgs(
                            object: $locationServiceResponseProcessor,
                            args: [$response],
                        );

                        if ($itemTimeframe instanceof CacheItemInterface) {
                            $itemLocation->set(value: PsrMessage::toString(message: $response));
                            $this->getLocationService()->cacheItem(item: $itemLocation);
                        }

                        break;
                    case 'delivery_date':
                        $reflectionDeliveryDateServiceResponseValidator->invokeArgs(
                            object: $deliveryDateServiceResponseProcessor,
                            args: [$response],
                        );

                        if ($itemTimeframe instanceof CacheItemInterface) {
                            $itemDeliveryDate->set(value: PsrMessage::toString(message: $response));
                            $this->getDeliveryDateService()->cacheItem(item: $itemDeliveryDate);
                        }

                        break;
                }
            }
        }

        return [
            'timeframes'    => $reflectionTimeframeServiceResponseProcessor
                ->getMethod(name: 'processGetTimeframesResponse')
                ->invokeArgs(
                    object: $timeframeServiceResponseProcessor,
                    args: [$results['timeframes']],
                ),
            'locations'     => $reflectionLocationServiceResponseProcessor
                ->getMethod(name: 'processGetNearestLocationsResponse')
                ->invokeArgs(
                    object: $locationServiceResponseProcessor,
                    args: [$results['locations']],
                ),
            'delivery_date' => $reflectionDeliveryDateServiceResponseProcessor
                ->getMethod(name: 'processGetDeliveryDateResponse')
                ->invokeArgs(
                    object: $deliveryDateServiceResponseProcessor,
                    args: [$results['delivery_date']],
                ),
        ];
    }

    /**
     * Get locations in area.
     *
     * @param GetLocationsInArea $getLocationsInArea
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function getLocationsInArea(GetLocationsInArea $getLocationsInArea): GetLocationsInAreaResponse
    {
        return $this->getLocationService()->getLocationsInArea(getLocations: $getLocationsInArea);
    }

    /**
     * Get locations in area.
     *
     * @param GetLocation $getLocation
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function getLocation(GetLocation $getLocation): GetLocationsInAreaResponse
    {
        return $this->getLocationService()->getLocation(getLocation: $getLocation);
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
}
