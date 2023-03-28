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

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Amount;
use Firstred\PostNL\Entity\Area;
use Firstred\PostNL\Entity\Barcode;
use Firstred\PostNL\Entity\Contact;
use Firstred\PostNL\Entity\Content;
use Firstred\PostNL\Entity\Coordinates;
use Firstred\PostNL\Entity\CoordinatesNorthWest;
use Firstred\PostNL\Entity\CoordinatesSouthEast;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Customs;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\Dimension;
use Firstred\PostNL\Entity\Event;
use Firstred\PostNL\Entity\Expectation;
use Firstred\PostNL\Entity\Group;
use Firstred\PostNL\Entity\Label;
use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Entity\Message\LabellingMessage;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\OldStatus;
use Firstred\PostNL\Entity\OpeningHours;
use Firstred\PostNL\Entity\ProductOption;
use Firstred\PostNL\Entity\ReasonNoTimeframe;
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
use Firstred\PostNL\Entity\Request\GetSentDate;
use Firstred\PostNL\Entity\Request\GetSentDateRequest;
use Firstred\PostNL\Entity\Request\GetSignature;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Response\CompleteStatusResponse;
use Firstred\PostNL\Entity\Response\CompleteStatusResponseEvent;
use Firstred\PostNL\Entity\Response\CompleteStatusResponseOldStatus;
use Firstred\PostNL\Entity\Response\CompleteStatusResponseShipment;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Entity\Response\CurrentStatusResponse;
use Firstred\PostNL\Entity\Response\CurrentStatusResponseShipment;
use Firstred\PostNL\Entity\Response\GenerateBarcodeResponse;
use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Entity\Response\GetDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\GetLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\GetLocationsResult;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Entity\Response\GetSentDateResponse;
use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use Firstred\PostNL\Entity\Response\MergedLabel;
use Firstred\PostNL\Entity\Response\ResponseAddress;
use Firstred\PostNL\Entity\Response\ResponseAmount;
use Firstred\PostNL\Entity\Response\ResponseGroup;
use Firstred\PostNL\Entity\Response\ResponseLocation;
use Firstred\PostNL\Entity\Response\ResponseShipment;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Entity\Response\SignatureResponse;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Entity\Signature;
use Firstred\PostNL\Entity\SOAP\Body;
use Firstred\PostNL\Entity\SOAP\Envelope;
use Firstred\PostNL\Entity\SOAP\Header;
use Firstred\PostNL\Entity\SOAP\Security;
use Firstred\PostNL\Entity\SOAP\UsernameToken;
use Firstred\PostNL\Entity\Status;
use Firstred\PostNL\Entity\Timeframe;
use Firstred\PostNL\Entity\Timeframes;
use Firstred\PostNL\Entity\TimeframeTimeFrame;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Exception\ApiConnectionException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidBarcodeException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\InvalidMethodException;
use Firstred\PostNL\Exception\NotImplementedException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\PostNLException;
use Firstred\PostNL\Exception\Promise\AggregateException;
use Firstred\PostNL\Exception\Promise\CancellationException;
use Firstred\PostNL\Exception\Promise\RejectionException;
use Firstred\PostNL\Exception\ResponseException;
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
use Firstred\PostNL\HttpClient\MockClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\AbstractService;
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
use Firstred\PostNL\Service\ServiceInterface;
use Firstred\PostNL\Service\ShippingService;
use Firstred\PostNL\Service\ShippingServiceInterface;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\ShippingStatusServiceInterface;
use Firstred\PostNL\Service\TimeframeService;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use Firstred\PostNL\Util\DummyLogger;
use Firstred\PostNL\Util\EachPromise;
use Firstred\PostNL\Util\FlexibleEntityTrait;
use Firstred\PostNL\Util\Message as UtilMessage;
use Firstred\PostNL\Util\PendingPromise;
use Firstred\PostNL\Util\PromiseTool;
use Firstred\PostNL\Util\RFPdi;
use Firstred\PostNL\Util\TaskQueue;
use Firstred\PostNL\Util\Util;
use Firstred\PostNL\Util\UUID;
use Firstred\PostNL\Util\XmlSerializable;

$aliases = array(
    AbstractEntity::class                  => 'ThirtyBees\\PostNL\\Entity\\AbstractEntity',
    Address::class                         => 'ThirtyBees\\PostNL\\Entity\\Address',
    Amount::class                          => 'ThirtyBees\\PostNL\\Entity\\Amount',
    Area::class                            => 'ThirtyBees\\PostNL\\Entity\\Area',
    Barcode::class                         => 'ThirtyBees\\PostNL\\Entity\\Barcode',
    Contact::class                         => 'ThirtyBees\\PostNL\\Entity\\Contact',
    Content::class                         => 'ThirtyBees\\PostNL\\Entity\\Content',
    Coordinates::class                     => 'ThirtyBees\\PostNL\\Entity\\Coordinates',
    CoordinatesNorthWest::class            => 'ThirtyBees\\PostNL\\Entity\\CoordinatesNorthWest',
    CoordinatesSouthEast::class            => 'ThirtyBees\\PostNL\\Entity\\CoordinatesSouthEast',
    Customer::class                        => 'ThirtyBees\\PostNL\\Entity\\Customer',
    Customs::class                         => 'ThirtyBees\\PostNL\\Entity\\Customs',
    CutOffTime::class                      => 'ThirtyBees\\PostNL\\Entity\\CutOffTime',
    Dimension::class                       => 'ThirtyBees\\PostNL\\Entity\\Dimension',
    Event::class                           => 'ThirtyBees\\PostNL\\Entity\\Event',
    Expectation::class                     => 'ThirtyBees\\PostNL\\Entity\\Expectation',
    Group::class                           => 'ThirtyBees\\PostNL\\Entity\\Group',
    Label::class                           => 'ThirtyBees\\PostNL\\Entity\\Label',
    Location::class                        => 'ThirtyBees\\PostNL\\Entity\\Location',
    LabellingMessage::class                => 'ThirtyBees\\PostNL\\Entity\\Message\\LabellingMessage',
    Message::class                         => 'ThirtyBees\\PostNL\\Entity\\Message\\Message',
    OldStatus::class                       => 'ThirtyBees\\PostNL\\Entity\\OldStatus',
    OpeningHours::class                    => 'ThirtyBees\\PostNL\\Entity\\OpeningHours',
    ProductOption::class                   => 'ThirtyBees\\PostNL\\Entity\\ProductOption',
    ReasonNoTimeframe::class               => 'ThirtyBees\\PostNL\\Entity\\ReasonNoTimeframe',
    CompleteStatus::class                  => 'ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatus',
    CompleteStatusByPhase::class           => 'ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatusByPhase',
    CompleteStatusByReference::class       => 'ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatusByReference',
    CompleteStatusByStatus::class          => 'ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatusByStatus',
    Confirming::class                      => 'ThirtyBees\\PostNL\\Entity\\Request\\Confirming',
    CurrentStatus::class                   => 'ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatus',
    CurrentStatusByPhase::class            => 'ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatusByPhase',
    CurrentStatusByReference::class        => 'ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatusByReference',
    CurrentStatusByStatus::class           => 'ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatusByStatus',
    GenerateBarcode::class                 => 'ThirtyBees\\PostNL\\Entity\\Request\\GenerateBarcode',
    GenerateLabel::class                   => 'ThirtyBees\\PostNL\\Entity\\Request\\GenerateLabel',
    GetDeliveryDate::class                 => 'ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate',
    GetLocation::class                     => 'ThirtyBees\\PostNL\\Entity\\Request\\GetLocation',
    GetLocationsInArea::class              => 'ThirtyBees\\PostNL\\Entity\\Request\\GetLocationsInArea',
    GetNearestLocations::class             => 'ThirtyBees\\PostNL\\Entity\\Request\\GetNearestLocations',
    GetSentDate::class                     => 'ThirtyBees\\PostNL\\Entity\\Request\\GetSentDate',
    GetSentDateRequest::class              => 'ThirtyBees\\PostNL\\Entity\\Request\\GetSentDateRequest',
    GetSignature::class                    => 'ThirtyBees\\PostNL\\Entity\\Request\\GetSignature',
    GetTimeframes::class                   => 'ThirtyBees\\PostNL\\Entity\\Request\\GetTimeframes',
    CompleteStatusResponse::class          => 'ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponse',
    CompleteStatusResponseEvent::class     => 'ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponseEvent',
    CompleteStatusResponseOldStatus::class => 'ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus',
    CompleteStatusResponseShipment::class  => 'ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment',
    ConfirmingResponseShipment::class      => 'ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment',
    CurrentStatusResponse::class           => 'ThirtyBees\\PostNL\\Entity\\Response\\CurrentStatusResponse',
    CurrentStatusResponseShipment::class   => 'ThirtyBees\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment',
    GenerateBarcodeResponse::class         => 'ThirtyBees\\PostNL\\Entity\\Response\\GenerateBarcodeResponse',
    GenerateLabelResponse::class           => 'ThirtyBees\\PostNL\\Entity\\Response\\GenerateLabelResponse',
    GetDeliveryDateResponse::class         => 'ThirtyBees\\PostNL\\Entity\\Response\\GetDeliveryDateResponse',
    GetLocationsInAreaResponse::class      => 'ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse',
    GetLocationsResult::class              => 'ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsResult',
    GetNearestLocationsResponse::class     => 'ThirtyBees\\PostNL\\Entity\\Response\\GetNearestLocationsResponse',
    GetSentDateResponse::class             => 'ThirtyBees\\PostNL\\Entity\\Response\\GetSentDateResponse',
    GetSignatureResponseSignature::class   => 'ThirtyBees\\PostNL\\Entity\\Response\\GetSignatureResponseSignature',
    MergedLabel::class                     => 'ThirtyBees\\PostNL\\Entity\\Response\\MergedLabel',
    ResponseAddress::class                 => 'ThirtyBees\\PostNL\\Entity\\Response\\ResponseAddress',
    ResponseAmount::class                  => 'ThirtyBees\\PostNL\\Entity\\Response\\ResponseAmount',
    ResponseGroup::class                   => 'ThirtyBees\\PostNL\\Entity\\Response\\ResponseGroup',
    ResponseLocation::class                => 'ThirtyBees\\PostNL\\Entity\\Response\\ResponseLocation',
    ResponseShipment::class                => 'ThirtyBees\\PostNL\\Entity\\Response\\ResponseShipment',
    ResponseTimeframes::class              => 'ThirtyBees\\PostNL\\Entity\\Response\\ResponseTimeframes',
    SignatureResponse::class               => 'ThirtyBees\\PostNL\\Entity\\Response\\SignatureResponse',
    Body::class                            => 'ThirtyBees\\PostNL\\Entity\\SOAP\\Body',
    Envelope::class                        => 'ThirtyBees\\PostNL\\Entity\\SOAP\\Envelope',
    Header::class                          => 'ThirtyBees\\PostNL\\Entity\\SOAP\\Header',
    Security::class                        => 'ThirtyBees\\PostNL\\Entity\\SOAP\\Security',
    UsernameToken::class                   => 'ThirtyBees\\PostNL\\Entity\\SOAP\\UsernameToken',
    Shipment::class                        => 'ThirtyBees\\PostNL\\Entity\\Shipment',
    Signature::class                       => 'ThirtyBees\\PostNL\\Entity\\Signature',
    Status::class                          => 'ThirtyBees\\PostNL\\Entity\\Status',
    Timeframe::class                       => 'ThirtyBees\\PostNL\\Entity\\Timeframe',
    TimeframeTimeFrame::class              => 'ThirtyBees\\PostNL\\Entity\\TimeframeTimeFrame',
    Timeframes::class                      => 'ThirtyBees\\PostNL\\Entity\\Timeframes',
    Warning::class                         => 'ThirtyBees\\PostNL\\Entity\\Warning',
    ApiConnectionException::class          => 'ThirtyBees\\PostNL\\Exception\\ApiConnectionException',
    ApiException::class                    => 'ThirtyBees\\PostNL\\Exception\\ApiException',
    CifDownException::class                => 'ThirtyBees\\PostNL\\Exception\\CifDownException',
    CifException::class                    => 'ThirtyBees\\PostNL\\Exception\\CifException',
    HttpClientException::class             => 'ThirtyBees\\PostNL\\Exception\\HttpClientException',
    InvalidArgumentException::class        => 'ThirtyBees\\PostNL\\Exception\\InvalidArgumentException',
    InvalidBarcodeException::class         => 'ThirtyBees\\PostNL\\Exception\\InvalidBarcodeException',
    InvalidConfigurationException::class   => 'ThirtyBees\\PostNL\\Exception\\InvalidConfigurationException',
    InvalidMethodException::class          => 'ThirtyBees\\PostNL\\Exception\\InvalidMethodException',
    NotImplementedException::class         => 'ThirtyBees\\PostNL\\Exception\\NotImplementedException',
    NotSupportedException::class           => 'ThirtyBees\\PostNL\\Exception\\NotSupportedException',
    AggregateException::class              => 'ThirtyBees\\PostNL\\Exception\\Promise\\AggregateException',
    CancellationException::class           => 'ThirtyBees\\PostNL\\Exception\\Promise\\CancellationException',
    RejectionException::class              => 'ThirtyBees\\PostNL\\Exception\\Promise\\RejectionException',
    ResponseException::class               => 'ThirtyBees\\PostNL\\Exception\\ResponseException',
    GuzzleRequestFactory::class            => 'ThirtyBees\\PostNL\\Factory\\GuzzleRequestFactory',
    GuzzleResponseFactory::class           => 'ThirtyBees\\PostNL\\Factory\\GuzzleResponseFactory',
    GuzzleStreamFactory::class             => 'ThirtyBees\\PostNL\\Factory\\GuzzleStreamFactory',
    RequestFactoryInterface::class         => 'ThirtyBees\\PostNL\\Factory\\RequestFactoryInterface',
    ResponseFactoryInterface::class        => 'ThirtyBees\\PostNL\\Factory\\ResponseFactoryInterface',
    StreamFactoryInterface::class          => 'ThirtyBees\\PostNL\\Factory\\StreamFactoryInterface',
    ClientInterface::class                 => 'ThirtyBees\\PostNL\\HttpClient\\ClientInterface',
    CurlClient::class                      => 'ThirtyBees\\PostNL\\HttpClient\\CurlClient',
    GuzzleClient::class                    => 'ThirtyBees\\PostNL\\HttpClient\\GuzzleClient',
    HTTPlugClient::class                   => 'ThirtyBees\\PostNL\\HttpClient\\HTTPlugClient',
    MockClient::class                      => 'ThirtyBees\\PostNL\\HttpClient\\MockClient',
    PostNL::class                          => 'ThirtyBees\\PostNL\\PostNL',
    AbstractService::class                 => 'ThirtyBees\\PostNL\\Service\\AbstractService',
    BarcodeService::class                  => 'ThirtyBees\\PostNL\\Service\\BarcodeService',
    BarcodeServiceInterface::class         => 'ThirtyBees\\PostNL\\Service\\BarcodeServiceInterface',
    ConfirmingService::class               => 'ThirtyBees\\PostNL\\Service\\ConfirmingService',
    ConfirmingServiceInterface::class      => 'ThirtyBees\\PostNL\\Service\\ConfirmingServiceInterface',
    DeliveryDateService::class             => 'ThirtyBees\\PostNL\\Service\\DeliveryDateService',
    DeliveryDateServiceInterface::class    => 'ThirtyBees\\PostNL\\Service\\DeliveryDateServiceInterface',
    LabellingService::class                => 'ThirtyBees\\PostNL\\Service\\LabellingService',
    LabellingServiceInterface::class       => 'ThirtyBees\\PostNL\\Service\\LabellingServiceInterface',
    LocationService::class                 => 'ThirtyBees\\PostNL\\Service\\LocationService',
    LocationServiceInterface::class        => 'ThirtyBees\\PostNL\\Service\\LocationServiceInterface',
    ServiceInterface::class                => 'ThirtyBees\\PostNL\\Service\\ServiceInterface',
    ShippingService::class                 => 'ThirtyBees\\PostNL\\Service\\ShippingService',
    ShippingServiceInterface::class        => 'ThirtyBees\\PostNL\\Service\\ShippingServiceInterface',
    ShippingStatusService::class           => 'ThirtyBees\\PostNL\\Service\\ShippingStatusService',
    ShippingStatusServiceInterface::class  => 'ThirtyBees\\PostNL\\Service\\ShippingStatusServiceInterface',
    TimeframeService::class                => 'ThirtyBees\\PostNL\\Service\\TimeframeService',
    TimeframeServiceInterface::class       => 'ThirtyBees\\PostNL\\Service\\TimeframeServiceInterface',
    DummyLogger::class                     => 'ThirtyBees\\PostNL\\Util\\DummyLogger',
    EachPromise::class                     => 'ThirtyBees\\PostNL\\Util\\EachPromise',
    FlexibleEntityTrait::class             => 'ThirtyBees\\PostNL\\Util\\FlexibleEntityTrait',
    UtilMessage::class                     => 'ThirtyBees\\PostNL\\Util\\Message',
    PendingPromise::class                  => 'ThirtyBees\\PostNL\\Util\\PendingPromise',
    PromiseTool::class                     => 'ThirtyBees\\PostNL\\Util\\PromiseTool',
    RFPdi::class                           => 'ThirtyBees\\PostNL\\Util\\RFPdi',
    TaskQueue::class                       => 'ThirtyBees\\PostNL\\Util\\TaskQueue',
    UUID::class                            => 'ThirtyBees\\PostNL\\Util\\UUID',
    Util::class                            => 'ThirtyBees\\PostNL\\Util\\Util',
    XmlSerializable::class                 => 'ThirtyBees\\PostNL\\Util\\XmlSerializable',
    PostNLException::class                 => 'ThirtyBees\\PostNL\\Exception\\AbstractException',
);

spl_autoload_register(function ($alias) {
    if (isset($deprecatedClasses[$alias])) {
        $class = $deprecatedClasses[$alias];
        postnl_trigger_deprecation(
            'firstred/postnl-api-php',
            '1.4.0',
            "Using class `$alias` is deprecated. Please use the `$class` class instead."
        );
        class_alias($class, $alias);
    }
});