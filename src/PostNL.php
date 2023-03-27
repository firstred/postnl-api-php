<?php
declare(strict_types=1);
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
use Firstred\PostNL\Entity\Request\GetDeliveryDate;
use Firstred\PostNL\Entity\Request\GetLocation;
use Firstred\PostNL\Entity\Request\GetLocationsInArea;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Entity\Request\GetSentDateRequest;
use Firstred\PostNL\Entity\Request\GetSignature;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Request\SendShipment;
use Firstred\PostNL\Entity\Response\CompleteStatusResponse;
use Firstred\PostNL\Entity\Response\CompleteStatusResponseShipment;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Entity\Response\CurrentStatusResponse;
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
use Firstred\PostNL\Entity\Soap\UsernameToken;
use Firstred\PostNL\Enum\PostNLApiMode;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\InvalidBarcodeException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotFoundException as PostNLNotFoundException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\PostNLException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Exception\ShipmentNotFoundException;
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
use Http\Discovery\NotFoundException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use JetBrains\PhpStorm\Deprecated;
use ParagonIE\HiddenString\HiddenString;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
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
use function ini_get;
use function interface_exists;
use function is_array;
use function php_sapi_name;
use function trigger_error;
use const E_USER_WARNING;

/**
 * Class PostNL.
 *
 * @since 1.0.0
 */
class PostNL implements LoggerAwareInterface
{
    /**
     * REST API
     *
     * @deprecated See `PostNLApiMode::Rest`
     */
    #[Deprecated(
        reason: 'since version 2.0.0, use the PostNLApiMode::Rest enum instead',
        replacement: PostNLApiMode::class.'::Rest',
    )]
    const MODE_REST = 1;
    /**
     * SOAP API
     *
     * @deprecated See `PostNLApiMode::Soap`
     */
    #[Deprecated(
        reason: 'from version 3.0.0 support for the SOAP API will be removed, use the PostNLApiMode::Rest enum instead',
        replacement: PostNLApiMode::class.'::Rest',
    )]
    const MODE_SOAP = 2;
    /**
     * Legacy SOAP API
     *
     * @deprecated See `PostNLApiMode::Soap`
     */
    #[Deprecated(
        reason: 'from version 3.0.0 support for the SOAP API will be removed, use the PostNLApiMode::Rest enum instead',
        replacement: PostNLApiMode::class.'::Rest',
    )]
    const MODE_LEGACY = 2;

    /**
     * 3S (or EU Pack Special) countries.
     *
     * @var array                $threeSCountries
     * @phpstan-var list<string> $threeSCountries
     * @psalm-var list<string>   $threeSCountries
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
     * @var array $a6positions
     * @phpstan-var array{1: array{int, int}, 2: array{int, int}, 3: array{int, int}, 4: array{int, int}} $a6positions
     * @psalm-var array{1: array{int, int}, 2: array{int, int}, 3: array{int, int}, 4: array{int, int}} $a6positions
     */
    public static array $a6positions = [
        4 => [-276, 2],
        3 => [-132, 2],
        2 => [-276, 110],
        1 => [-132, 110],
    ];

    /** @var HiddenString $apiKey */
    protected HiddenString $apiKey;

    /** @var Customer $customer */
    protected Customer $customer;

    /** @var bool $sandbox */
    protected bool $sandbox = false;

    /** @var HttpClientInterface $httpClient */
    protected HttpClientInterface $httpClient;

    /** @var LoggerInterface $logger */
    protected LoggerInterface $logger;

    /** @var RequestFactoryInterface $requestFactory */
    protected RequestFactoryInterface $requestFactory;
    /** @var ResponseFactoryInterface $responseFactory */
    protected ResponseFactoryInterface $responseFactory;
    /** @var StreamFactoryInterface $streamFactory */
    protected StreamFactoryInterface $streamFactory;

    /** @var PostNLApiMode $apiMode */
    protected PostNLApiMode $apiMode = PostNLApiMode::Rest;

    /** @var BarcodeServiceInterface $barcodeService */
    protected BarcodeServiceInterface $barcodeService;
    /** @var LabellingServiceInterface $labellingService */
    protected LabellingServiceInterface $labellingService;
    /** @var ConfirmingServiceInterface $confirmingService */
    protected ConfirmingServiceInterface $confirmingService;
    /** @var ShippingStatusServiceInterface $shippingStatusService */
    protected ShippingStatusServiceInterface $shippingStatusService;
    /** @var DeliveryDateServiceInterface $deliveryDateService */
    protected DeliveryDateServiceInterface $deliveryDateService;
    /** @var TimeframeServiceInterface $timeframeService */
    protected TimeframeServiceInterface $timeframeService;
    /** @var LocationServiceInterface $locationService */
    protected LocationServiceInterface $locationService;
    /** @var ShippingServiceInterface $shippingService */
    protected ShippingServiceInterface $shippingService;

    /**
     * PostNL constructor.
     *
     * @param Customer                       $customer Customer object.
     * @param string|UsernameToken           $apiKey   API key or UsernameToken object.
     * @param bool                           $sandbox  Whether the testing environment should be used.
     * @param PostNLApiMode|int              $mode     Set the preferred connection strategy.
     *                                                 Valid options are:
     *                                                 - `PostNLApiMode.Rest` or `1`: New REST API
     *                                                 - `PostNLApiMode.Soap` or `2`: New SOAP API
     * @phpstan-param PostNLApiMode|int<1,2> $mode
     * @psalm-param PostNLApiMode|int<1,2>   $mode
     *
     * @throws PostNLInvalidArgumentException
     */
    public function __construct(
        Customer             $customer,
        string|UsernameToken $apiKey,
        bool                 $sandbox,
        PostNLApiMode|int    $mode = PostNLApiMode::Rest,
    ) {
        $this->checkEnvironment();

        $this->setCustomer(customer: $customer);
        $this->setApiKey(apiKey: $apiKey);
        $this->setSandbox(sandbox: $sandbox);
        $this->setApiMode(mode: $mode);
    }

    /**
     * Set the token.
     *
     * @since 1.0.0
     * @since 2.0.0 Support `HiddenString`
     *
     * @deprecated
     */
    public function setToken(string|HiddenString|UsernameToken $apiKey): static
    {
        if ($apiKey instanceof UsernameToken) {
            $this->apiKey = $apiKey->getPassword();

            return $this;
        }

        $this->apiKey = $apiKey instanceof HiddenString ? $apiKey : new HiddenString(value: $apiKey);

        return $this;
    }

    /**
     * @throws PostNLInvalidArgumentException
     * @deprecated
     */
    public function getToken(): UsernameToken
    {
        return new UsernameToken(Password: $this->getApiKey());
    }


    /**
     * Get API Key
     *
     * @throws PostNLInvalidArgumentException
     * @since 1.0.0
     */
    public function getApiKey(): HiddenString
    {
        if (!isset($this->apiKey)) {
            throw new InvalidArgumentException(message: 'API key not set');
        }

        return $this->apiKey;
    }

    /**
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
     * @since 1.0.0
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * Set PostNL Customer.
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
     * @since 1.0.0
     */
    public function getSandbox(): bool
    {
        return $this->sandbox;
    }

    /**
     * Set sandbox mode.
     *
     * @throws PostNLInvalidArgumentException
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
     * @param PostNLApiMode|int $mode
     *
     * @return $this
     * @throws PostNLInvalidArgumentException
     *
     * @deprecated 2.0.0
     */
    public function setMode(PostNLApiMode|int $mode): static
    {
        trigger_deprecation(
            package: 'firstred/postnl-api-php',
            version: '2.0.0',
            message: 'Using `PostNL::setMode` is deprecated, use `PostNL::setApiMode` instead.',
        );

        return $this->setApiMode(mode: $mode);
    }

    /**
     * @return int
     *
     * @deprecated
     */
    public function getMode(): int
    {
        trigger_deprecation(
            package: 'firstred/postnl-api-php',
            version: '2.0.0',
            message: 'Using `PostNL::getMode` is deprecated, use `PostNL::getApiMode` instead.',
        );

        return $this->getApiMode()->value;
    }

    /**
     * Get the current mode.
     *
     * @since 1.0.0
     */
    public function getApiMode(): PostNLApiMode
    {
        return $this->apiMode;
    }

    /**
     * Set current mode.
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 PostNLApiMode enum
     */
    public function setApiMode(PostNLApiMode|int $mode): static
    {
        if (is_int(value: $mode)) {
            trigger_deprecation(
                package: 'firstred/postnl-api-php',
                version: '2.0.0',
                message: 'Using `PostNL::MODE_*` is deprecated, use the `PostNLApiMode` enum instead.',
            );
            $mode = PostNLApiMode::tryFrom(value: $mode);
        }

        if (PostNLApiMode::Soap === $mode) {
            trigger_deprecation(
                package: 'firstred/postnl-api-php',
                version: '2.0.0',
                message: 'Using the SOAP API is deprecated, use the REST API instead.',
            );
        }

        $this->getBarcodeService()->setApiMode(mode: $mode);
        $this->getConfirmingService()->setApiMode(mode: $mode);
        $this->getDeliveryDateService()->setApiMode(mode: $mode);
        $this->getLabellingService()->setApiMode(mode: $mode);
        $this->getLocationService()->setApiMode(mode: $mode);
        $this->getShippingService()->setApiMode(mode: $mode);
        $this->getShippingStatusService()->setApiMode(mode: $mode);
        $this->getTimeframeService()->setApiMode(mode: $mode);

        $this->apiMode = $mode;

        return $this;
    }

    /**
     * HttpClient.
     *
     * Automatically load Guzzle when available
     *
     * @since 1.0.0
     */
    public function getHttpClient(): HTTPlugHttpClient|CurlHttpClient|HttpClientInterface|GuzzleHttpClient
    {
        // @codeCoverageIgnoreStart
        if (!isset($this->httpClient)) {
            if (interface_exists(interface: GuzzleClientInterface::class)
                && ((defined(constant_name: GuzzleClientInterface::class.'::MAJOR_VERSION') && Util::compareGuzzleVersion(
                        a: constant(name: GuzzleClientInterface::class.'::MAJOR_VERSION'),
                        b: '7.0.0'
                    ) >= 0))
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
     * @throws PostNLInvalidArgumentException
     * @since 2.0.0 Renamed `$client` to `$httpClient`
     * @since 1.0.0
     */
    public function setHttpClient(HttpClientInterface $httpClient): void
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
    }

    /**
     * Get the logger.
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
     * Set a dummy logger
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
     * @throws PostNLInvalidArgumentException
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
     * @throws PostNLInvalidArgumentException
     * @since 1.3.0 Also sets the request factory on the HTTP client
     * @since 2.0.0 Also sets the request factory on services
     * @since 1.2.0
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
     * @since 1.2.0
     * @since 1.3.0 Also sets the response factory on the HTTP client
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
     * @since 1.2.0
     * @since 1.3.0 Also sets the stream factory on the HTTP client
     * @since 2.0.0 Also sets the stream factory on services
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
     * @since 1.0.0
     */
    public function getBarcodeService(): BarcodeServiceInterface
    {
        if (!isset($this->barcodeService)) {
            $this->setBarcodeService(service: new BarcodeService(
                apiKey: $this->getApiKey(),
                apiMode: $this->getApiMode(),
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
     * @since 1.0.0
     */
    public function setBarcodeService(BarcodeServiceInterface $service): void
    {
        $this->barcodeService = $service;
    }

    /**
     * Labelling service.
     *
     * Automatically load the labelling service
     *
     * @throws PostNLInvalidArgumentException
     * @since 1.0.0
     */
    public function getLabellingService(): LabellingServiceInterface
    {
        if (!isset($this->labellingService)) {
            $this->setLabellingService(service: new LabellingService(
                apiKey: $this->getApiKey(),
                apiMode: $this->getApiMode(),
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
     * @since 1.0.0
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
     * @throws PostNLInvalidArgumentException
     * @since 1.0.0
     */
    public function getConfirmingService(): ConfirmingServiceInterface
    {
        if (!isset($this->confirmingService)) {
            $this->setConfirmingService(service: new ConfirmingService(
                apiKey: $this->getApiKey(),
                apiMode: $this->getApiMode(),
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
     * @since 1.0.0
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
     * @throws PostNLInvalidArgumentException
     * @since 1.0.0
     */
    public function getShippingStatusService(): ShippingStatusServiceInterface
    {
        if (!isset($this->shippingStatusService)) {
            $this->setShippingStatusService(service: new ShippingStatusService(
                apiKey: $this->getApiKey(),
                apiMode: $this->getApiMode(),
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
     * @throws PostNLInvalidArgumentException
     * @since 1.0.0
     */
    public function getDeliveryDateService(): DeliveryDateServiceInterface
    {
        if (!isset($this->deliveryDateService)) {
            $this->setDeliveryDateService(service: new DeliveryDateService(
                apiKey: $this->getApiKey(),
                apiMode: $this->getApiMode(),
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
    public function getTimeframeService(): TimeframeServiceInterface
    {
        if (!isset($this->timeframeService)) {
            $this->setTimeframeService(service: new TimeframeService(
                apiKey: $this->getApiKey(),
                apiMode: $this->getApiMode(),
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
     * @since 1.0.0
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
     * @throws PostNLInvalidArgumentException
     * @since 1.0.0
     */
    public function getLocationService(): LocationServiceInterface
    {
        if (!isset($this->locationService)) {
            $this->setLocationService(service: new LocationService(
                apiKey: $this->getApiKey(),
                apiMode: $this->getApiMode(),
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
     * @since 1.2.0
     */
    public function getShippingService(): ShippingServiceInterface
    {
        if (!isset($this->shippingService)) {
            $this->setShippingService(service: new ShippingService(
                apiKey: $this->getApiKey(),
                apiMode: $this->getApiMode(),
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
     * @since 1.2.0
     */
    public function setShippingService(ShippingServiceInterface $service): void
    {
        $this->shippingService = $service;
    }

    /**
     * Generate a single barcode.
     *
     * @throws InvalidBarcodeException
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
     * @throws InvalidConfigurationException
     * @throws InvalidBarcodeException
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
     * @param array                      $isos key = iso code, value = amount of barcodes requested
     *
     * @phpstan-param array<string, int> $isos
     *
     * @return array Country isos with the barcodes as string
     * @phpstan-return array<string, array<string>>
     *
     * @throws InvalidConfigurationException
     * @throws InvalidConfigurationException
     * @throws InvalidBarcodeException
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
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function sendShipment(
        Shipment $shipment,
        string   $printertype = 'GraphicFile|PDF',
        bool     $confirm = true
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
     * @param Shipment[]                                        $shipments     Array of shipments
     * @param string                                            $printertype   Printer type, see PostNL dev docs for
     *                                                                         available types
     * @param bool                                              $confirm       Immediately confirm the shipments
     * @param bool                                              $merge         Merge the PDFs and return them in a
     *                                                                         MyParcel way
     * @param int                                               $format        A4 or A6
     *
     * @phpstan-param array{1: bool, 2: bool, 3: bool, 4: bool} $positions
     *
     * @param array                                             $positions     Set the positions of the A6s on the
     *                                                                         first A4 The indices should be the
     *                                                                         position number, marked with `true` or
     *                                                                         `false` These are the position numbers:
     *                                                                         ```
     *                                                                         +-+-+
     *                                                                         |2|4|
     *                                                                         +-+-+
     *                                                                         |1|3|
     *                                                                         +-+-+
     *                                                                         ```
     *                                                                         So, for
     *                                                                         ```
     *                                                                         +-+-+
     *                                                                         |x|✔|
     *                                                                         +-+-+
     *                                                                         |✔|x|
     *                                                                         +-+-+
     *                                                                         ```
     *                                                                         you would have to pass:
     *                                                                         ```php
     *                                                                         [
     *                                                                         1 => true,
     *                                                                         2 => false,
     *                                                                         3 => false,
     *                                                                         4 => true,
     *                                                                         ]
     *                                                                         ```
     * @param string                                            $a6Orientation A6 orientation (P or L)
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
        array  $shipments,
        string $printertype = 'GraphicFile|PDF',
        bool   $confirm = true,
        bool   $merge = false,
        int    $format = Label::FORMAT_A4,
        array  $positions = [
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
                        $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
                    } else {
                        $stream = StreamReader::createByString(content: $pdfContent);
                        $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
                    }
                }
            }
        }
        foreach ($deferred as $defer) {
            $sizes = $defer['sizes'];
            $pdf->addPage(orientation: $sizes['orientation'], size: 'A4');
            if (is_array(value: $defer['stream']) && count(value: $defer['stream']) > 1) {
                // Multilabel
                $pdf->rotateCounterClockWise();
                if (2 === count(value: $deferred['stream'])) {
                    $pdf->setSourceFile(file: $defer['stream'][0]);
                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 0);
                    $pdf->setSourceFile(file: $defer['stream'][1]);
                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 148);
                } else {
                    $pdf->setSourceFile(file: $defer['stream'][0]);
                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 0);
                    $pdf->setSourceFile(file: $defer['stream'][1]);
                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 148);
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
     * @throws PostNLInvalidArgumentException
     * @throws PostNLNotFoundException
     *
     * @since 1.0.0
     */
    public function generateLabel(
        Shipment $shipment,
        string   $printertype = 'GraphicFile|PDF',
        bool     $confirm = true
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
     * @throws PostNLInvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function generateLabels(
        array  $shipments,
        string $printertype = 'GraphicFile|PDF',
        bool   $confirm = true,
        bool   $merge = false,
        int    $format = Label::FORMAT_A4,
        array  $positions = [
            1 => true,
            2 => true,
            3 => true,
            4 => true,
        ],
        string $a6Orientation = 'P'
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
                        $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
                    } else {
                        $stream = StreamReader::createByString(content: $pdfContent);
                        $deferred[] = ['stream' => $stream, 'sizes' => $sizes];
                    }
                }
            }
        }
        foreach ($deferred as $defer) {
            $sizes = $defer['sizes'];
            $pdf->addPage(orientation: $sizes['orientation'], size: 'A4');
            if (is_array(value: $defer['stream']) && count(value: $defer['stream']) > 1) {
                // Multilabel
                $pdf->rotateCounterClockWise();
                if (2 === count(value: $deferred['stream'])) {
                    $pdf->setSourceFile(file: $defer['stream'][0]);
                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 0);
                    $pdf->setSourceFile(file: $defer['stream'][1]);
                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 148);
                } else {
                    $pdf->setSourceFile(file: $defer['stream'][0]);
                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 0);
                    $pdf->setSourceFile(file: $defer['stream'][1]);
                    $pdf->useTemplate(tpl: $pdf->importPage(pageNumber: 1), x: -190, y: 148);
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
     * @since 1.0.0
     */
    public function confirmShipment(Shipment $shipment): ConfirmingResponseShipment
    {
        return $this->getConfirmingService()->confirmShipment(confirming: new Confirming(Shipments: [$shipment], Customer: $this->customer));
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
    public function confirmShipments(array $shipments): array
    {
        $confirmings = [];
        foreach ($shipments as $uuid => $shipment) {
            $confirmings[$uuid] = (new Confirming(Shipments: [$shipment], Customer: $this->customer))->setId(id: $uuid);
        }

        return $this->getConfirmingService()->confirmShipments(confirms: $confirmings);
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
     * @since      1.0.0
     *
     * @deprecated 1.2.0 Use the dedicated methods (get by phase and status are no longer working)
     */
    public function getCurrentStatus(CurrentStatusByReference|CurrentStatus $currentStatus): CurrentStatusResponse
    {
        if (null !== $currentStatus->getShipment()->getPhaseCode()) {
            throw new NotSupportedException(message: 'Getting the current status by phase code is no longer supported.');
        }
        if (null !== $currentStatus->getShipment()->getStatusCode()) {
            throw new NotSupportedException(message: 'Getting the current status by status code is no longer supported.');
        }

        $fullCustomer = $this->getCustomer();
        $currentStatus->setCustomer(Customer: (new Customer())
            ->setCustomerCode(CustomerCode: $fullCustomer->getCustomerCode())
            ->setCustomerNumber(CustomerNumber: $fullCustomer->getCustomerNumber())
        );
        if (!$currentStatus->getMessage()) {
            $currentStatus->setMessage(Message: new Message());
        }

        return $this->getShippingStatusService()->currentStatus(currentStatus: $currentStatus);
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
            throw new ShipmentNotFoundException(message: $barcode);
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
     * @throws PostNLInvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     * @throws NotFoundException
     * @throws ShipmentNotFoundException
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
            throw new ShipmentNotFoundException(message: $reference);
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
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @throws PostNLNotFoundException
     *
     * @since      1.0.0
     *
     * @deprecated 1.2.0 Use the dedicated getShippingStatus* methods (get by phase and status are no longer working)
     */
    public function getCompleteStatus(CompleteStatus $completeStatus): CompleteStatusResponse
    {
        if (null !== $completeStatus->getShipment()->getPhaseCode()) {
            throw new NotSupportedException(message: 'Getting the complete status by phase code is no longer supported.');
        }
        if (null !== $completeStatus->getShipment()->getStatusCode()) {
            throw new NotSupportedException(message: 'Getting the complete status by status code is no longer supported.');
        }

        $fullCustomer = $this->getCustomer();

        $completeStatus->setCustomer(Customer: (new Customer())
            ->setCustomerCode(CustomerCode: $fullCustomer->getCustomerCode())
            ->setCustomerNumber(CustomerNumber: $fullCustomer->getCustomerNumber())
        );
        if (!$completeStatus->getMessage()) {
            $completeStatus->setMessage(Message: new Message());
        }

        return $this->getShippingStatusService()->completeStatus(completeStatus: $completeStatus);
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
    public function getUpdatedShipments(DateTimeInterface $dateTimeFrom = null, DateTimeInterface $dateTimeTo = null): array
    {
        return $this->getShippingStatusService()->getUpdatedShipments($this->getCustomer(), $dateTimeFrom, $dateTimeTo);
    }

    /**
     * Get the signature of a shipment.
     *
     * @param GetSignature $signature
     *
     * @return GetSignatureResponseSignature
     *
     * @since      1.0.0
     *
     * @deprecated 1.2.0 Use the getSignature(s)By* alternatives
     */
    public function getSignature(GetSignature $signature): GetSignatureResponseSignature
    {
        $signature->setCustomer(Customer: $this->getCustomer());
        if (!$signature->getMessage()) {
            $signature->setMessage(Message: new Message());
        }

        return $this->getShippingStatusService()->getSignature(getSignature: $signature);
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
     * @throws PostNLInvalidArgumentException
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
                    Shipment: (new Shipment())->setBarcode(Barcode: $barcode),
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
        GetTimeframes       $getTimeframes,
        GetNearestLocations $getNearestLocations,
        GetDeliveryDate     $getDeliveryDate
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

        $this->getHttpClient()->addOrUpdateRequest(
            id: 'timeframes',
            request: $this->getTimeframeService()->buildGetTimeframesRequest($getTimeframes)
        );
        $this->getHttpClient()->addOrUpdateRequest(
            id: 'locations',
            request: $this->getLocationService()->buildGetNearestLocationsRequest($getNearestLocations)
        );
        $this->getHttpClient()->addOrUpdateRequest(
            id: 'delivery_date',
            request: $this->getDeliveryDateService()->buildGetDeliveryDateRequest($getDeliveryDate)
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
                        if (PostNLApiMode::Rest === $this->getApiMode()) {
                            TimeframeServiceRestAdapter::validateRESTResponse(response: $response);
                        }

                        if ($itemTimeframe instanceof CacheItemInterface) {
                            $itemTimeframe->set(value: PsrMessage::toString(message: $response));
                            $this->getTimeframeService()->cacheItem(item: $itemTimeframe);
                        }

                        break;
                    case 'locations':
                        if (PostNLApiMode::Rest === $this->getApiMode()) {
                            LocationServiceRestAdapter::validateRESTResponse(response: $response);
                        }

                        if ($itemTimeframe instanceof CacheItemInterface) {
                            $itemLocation->set(value: PsrMessage::toString(message: $response));
                            $this->getLocationService()->cacheItem(item: $itemLocation);
                        }

                        break;
                    case 'delivery_date':
                        if (PostNLApiMode::Rest === $this->getApiMode()) {
                            DeliveryDateService::validateRESTResponse(response: $response);
                        }

                        if ($itemTimeframe instanceof CacheItemInterface) {
                            $itemDeliveryDate->set(value: PsrMessage::toString(message: $response));
                            $this->getDeliveryDateService()->cacheItem(item: $itemDeliveryDate);
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
     * @param bool   $eps Indicates whether it is an EPS Shipment
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

    /**
     * Check whether this library will work in the current environment
     *
     * @since 1.2.0
     */
    private function checkEnvironment()
    {
        // Check access to `ini_get` function && check OPCache save_comments setting
        if (function_exists(function: 'ini_get')
            && (php_sapi_name() === 'cli' && ini_get(option: 'opcache.enable_cli')
                || php_sapi_name() !== 'cli' && ini_get(option: 'opcache.enable')
            )
            && !ini_get(option: 'opcache.save_comments')
        ) {
            trigger_error(
                message: 'OPCache has been enabled, but comments are removed from the cache. Please set `opcache.save_comments` to `1` in order to use the PostNL library.',
                error_level: E_USER_WARNING
            );
        }
    }
}
