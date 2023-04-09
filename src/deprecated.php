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

spl_autoload_register(function ($deprecatedClass) {
    static $deprecatedClasses = [
        'ThirtyBees\\PostNL\\Entity\\AbstractEntity'                            => AbstractEntity::class,
        'ThirtyBees\\PostNL\\Entity\\Address'                                   => Address::class,
        'ThirtyBees\\PostNL\\Entity\\Amount'                                    => Amount::class,
        'ThirtyBees\\PostNL\\Entity\\Area'                                      => Area::class,
        'ThirtyBees\\PostNL\\Entity\\Barcode'                                   => Barcode::class,
        'ThirtyBees\\PostNL\\Entity\\Contact'                                   => Contact::class,
        'ThirtyBees\\PostNL\\Entity\\Content'                                   => Content::class,
        'ThirtyBees\\PostNL\\Entity\\Coordinates'                               => Coordinates::class,
        'ThirtyBees\\PostNL\\Entity\\CoordinatesNorthWest'                      => CoordinatesNorthWest::class,
        'ThirtyBees\\PostNL\\Entity\\CoordinatesSouthEast'                      => CoordinatesSouthEast::class,
        'ThirtyBees\\PostNL\\Entity\\Customer'                                  => Customer::class,
        'ThirtyBees\\PostNL\\Entity\\Customs'                                   => Customs::class,
        'ThirtyBees\\PostNL\\Entity\\CutOffTime'                                => CutOffTime::class,
        'ThirtyBees\\PostNL\\Entity\\Dimension'                                 => Dimension::class,
        'ThirtyBees\\PostNL\\Entity\\Event'                                     => Event::class,
        'ThirtyBees\\PostNL\\Entity\\Expectation'                               => Expectation::class,
        'ThirtyBees\\PostNL\\Entity\\Group'                                     => Group::class,
        'ThirtyBees\\PostNL\\Entity\\Label'                                     => Label::class,
        'ThirtyBees\\PostNL\\Entity\\Location'                                  => Location::class,
        'ThirtyBees\\PostNL\\Entity\\Message\\LabellingMessage'                 => LabellingMessage::class,
        'ThirtyBees\\PostNL\\Entity\\Message\\Message'                          => Message::class,
        'ThirtyBees\\PostNL\\Entity\\OldStatus'                                 => OldStatus::class,
        'ThirtyBees\\PostNL\\Entity\\OpeningHours'                              => OpeningHours::class,
        'ThirtyBees\\PostNL\\Entity\\ProductOption'                             => ProductOption::class,
        'ThirtyBees\\PostNL\\Entity\\ReasonNoTimeframe'                         => ReasonNoTimeframe::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatus'                   => CompleteStatus::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatusByPhase'            => CompleteStatusByPhase::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatusByReference'        => CompleteStatusByReference::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatusByStatus'           => CompleteStatusByStatus::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\Confirming'                       => Confirming::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatus'                    => CurrentStatus::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatusByPhase'             => CurrentStatusByPhase::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatusByReference'         => CurrentStatusByReference::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatusByStatus'            => CurrentStatusByStatus::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\GenerateBarcode'                  => GenerateBarcode::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\GenerateLabel'                    => GenerateLabel::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate'                  => GetDeliveryDate::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\GetLocation'                      => GetLocation::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\GetLocationsInArea'               => GetLocationsInArea::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\GetNearestLocations'              => GetNearestLocations::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\GetSentDate'                      => GetSentDate::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\GetSentDateRequest'               => GetSentDateRequest::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\GetSignature'                     => GetSignature::class,
        'ThirtyBees\\PostNL\\Entity\\Request\\GetTimeframes'                    => GetTimeframes::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponse'          => CompleteStatusResponse::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponseEvent'     => CompleteStatusResponseEvent::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus' => CompleteStatusResponseOldStatus::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment'  => CompleteStatusResponseShipment::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment'      => ConfirmingResponseShipment::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\CurrentStatusResponse'           => CurrentStatusResponse::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment'   => CurrentStatusResponseShipment::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\GenerateBarcodeResponse'         => GenerateBarcodeResponse::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\GenerateLabelResponse'           => GenerateLabelResponse::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\GetDeliveryDateResponse'         => GetDeliveryDateResponse::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse'      => GetLocationsInAreaResponse::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsResult'              => GetLocationsResult::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\GetNearestLocationsResponse'     => GetNearestLocationsResponse::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\GetSentDateResponse'             => GetSentDateResponse::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\GetSignatureResponseSignature'   => GetSignatureResponseSignature::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\MergedLabel'                     => MergedLabel::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\ResponseAddress'                 => ResponseAddress::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\ResponseAmount'                  => ResponseAmount::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\ResponseGroup'                   => ResponseGroup::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\ResponseLocation'                => ResponseLocation::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\ResponseShipment'                => ResponseShipment::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\ResponseTimeframes'              => ResponseTimeframes::class,
        'ThirtyBees\\PostNL\\Entity\\Response\\SignatureResponse'               => SignatureResponse::class,
        'ThirtyBees\\PostNL\\Entity\\SOAP\\Body'                                => Body::class,
        'ThirtyBees\\PostNL\\Entity\\SOAP\\Envelope'                            => Envelope::class,
        'ThirtyBees\\PostNL\\Entity\\SOAP\\Header'                              => Header::class,
        'ThirtyBees\\PostNL\\Entity\\SOAP\\Security'                            => Security::class,
        'ThirtyBees\\PostNL\\Entity\\SOAP\\UsernameToken'                       => UsernameToken::class,
        'ThirtyBees\\PostNL\\Entity\\Shipment'                                  => Shipment::class,
        'ThirtyBees\\PostNL\\Entity\\Signature'                                 => Signature::class,
        'ThirtyBees\\PostNL\\Entity\\Status'                                    => Status::class,
        'ThirtyBees\\PostNL\\Entity\\Timeframe'                                 => Timeframe::class,
        'ThirtyBees\\PostNL\\Entity\\TimeframeTimeFrame'                        => TimeframeTimeFrame::class,
        'ThirtyBees\\PostNL\\Entity\\Timeframes'                                => Timeframes::class,
        'ThirtyBees\\PostNL\\Entity\\Warning'                                   => Warning::class,
        'ThirtyBees\\PostNL\\Exception\\ApiConnectionException'                 => ApiConnectionException::class,
        'ThirtyBees\\PostNL\\Exception\\ApiException'                           => ApiException::class,
        'ThirtyBees\\PostNL\\Exception\\CifDownException'                       => CifDownException::class,
        'ThirtyBees\\PostNL\\Exception\\CifException'                           => CifException::class,
        'ThirtyBees\\PostNL\\Exception\\HttpClientException'                    => HttpClientException::class,
        'ThirtyBees\\PostNL\\Exception\\InvalidArgumentException'               => InvalidArgumentException::class,
        'ThirtyBees\\PostNL\\Exception\\InvalidBarcodeException'                => InvalidBarcodeException::class,
        'ThirtyBees\\PostNL\\Exception\\InvalidConfigurationException'          => InvalidConfigurationException::class,
        'ThirtyBees\\PostNL\\Exception\\InvalidMethodException'                 => InvalidMethodException::class,
        'ThirtyBees\\PostNL\\Exception\\NotImplementedException'                => NotImplementedException::class,
        'ThirtyBees\\PostNL\\Exception\\NotSupportedException'                  => NotSupportedException::class,
        'ThirtyBees\\PostNL\\Exception\\Promise\\AggregateException'            => AggregateException::class,
        'ThirtyBees\\PostNL\\Exception\\Promise\\CancellationException'         => CancellationException::class,
        'ThirtyBees\\PostNL\\Exception\\Promise\\RejectionException'            => RejectionException::class,
        'ThirtyBees\\PostNL\\Exception\\ResponseException'                      => ResponseException::class,
        'ThirtyBees\\PostNL\\Factory\\GuzzleRequestFactory'                     => GuzzleRequestFactory::class,
        'ThirtyBees\\PostNL\\Factory\\GuzzleResponseFactory'                    => GuzzleResponseFactory::class,
        'ThirtyBees\\PostNL\\Factory\\GuzzleStreamFactory'                      => GuzzleStreamFactory::class,
        'ThirtyBees\\PostNL\\Factory\\RequestFactoryInterface'                  => RequestFactoryInterface::class,
        'ThirtyBees\\PostNL\\Factory\\ResponseFactoryInterface'                 => ResponseFactoryInterface::class,
        'ThirtyBees\\PostNL\\Factory\\StreamFactoryInterface'                   => StreamFactoryInterface::class,
        'ThirtyBees\\PostNL\\HttpClient\\ClientInterface'                       => ClientInterface::class,
        'ThirtyBees\\PostNL\\HttpClient\\CurlClient'                            => CurlClient::class,
        'ThirtyBees\\PostNL\\HttpClient\\GuzzleClient'                          => GuzzleClient::class,
        'ThirtyBees\\PostNL\\HttpClient\\HTTPlugClient'                         => HTTPlugClient::class,
        'ThirtyBees\\PostNL\\HttpClient\\MockClient'                            => MockClient::class,
        'ThirtyBees\\PostNL\\PostNL'                                            => PostNL::class,
        'ThirtyBees\\PostNL\\Service\\AbstractService'                          => AbstractService::class,
        'ThirtyBees\\PostNL\\Service\\BarcodeService'                           => BarcodeService::class,
        'ThirtyBees\\PostNL\\Service\\BarcodeServiceInterface'                  => BarcodeServiceInterface::class,
        'ThirtyBees\\PostNL\\Service\\ConfirmingService'                        => ConfirmingService::class,
        'ThirtyBees\\PostNL\\Service\\ConfirmingServiceInterface'               => ConfirmingServiceInterface::class,
        'ThirtyBees\\PostNL\\Service\\DeliveryDateService'                      => DeliveryDateService::class,
        'ThirtyBees\\PostNL\\Service\\DeliveryDateServiceInterface'             => DeliveryDateServiceInterface::class,
        'ThirtyBees\\PostNL\\Service\\LabellingService'                         => LabellingService::class,
        'ThirtyBees\\PostNL\\Service\\LabellingServiceInterface'                => LabellingServiceInterface::class,
        'ThirtyBees\\PostNL\\Service\\LocationService'                          => LocationService::class,
        'ThirtyBees\\PostNL\\Service\\LocationServiceInterface'                 => LocationServiceInterface::class,
        'ThirtyBees\\PostNL\\Service\\ServiceInterface'                         => ServiceInterface::class,
        'ThirtyBees\\PostNL\\Service\\ShippingService'                          => ShippingService::class,
        'ThirtyBees\\PostNL\\Service\\ShippingServiceInterface'                 => ShippingServiceInterface::class,
        'ThirtyBees\\PostNL\\Service\\ShippingStatusService'                    => ShippingStatusService::class,
        'ThirtyBees\\PostNL\\Service\\ShippingStatusServiceInterface'           => ShippingStatusServiceInterface::class,
        'ThirtyBees\\PostNL\\Service\\TimeframeService'                         => TimeframeService::class,
        'ThirtyBees\\PostNL\\Service\\TimeframeServiceInterface'                => TimeframeServiceInterface::class,
        'ThirtyBees\\PostNL\\Util\\DummyLogger'                                 => DummyLogger::class,
        'ThirtyBees\\PostNL\\Util\\EachPromise'                                 => EachPromise::class,
        'ThirtyBees\\PostNL\\Util\\FlexibleEntityTrait'                         => FlexibleEntityTrait::class,
        'ThirtyBees\\PostNL\\Util\\Message'                                     => UtilMessage::class,
        'ThirtyBees\\PostNL\\Util\\PendingPromise'                              => PendingPromise::class,
        'ThirtyBees\\PostNL\\Util\\PromiseTool'                                 => PromiseTool::class,
        'ThirtyBees\\PostNL\\Util\\RFPdi'                                       => RFPdi::class,
        'ThirtyBees\\PostNL\\Util\\TaskQueue'                                   => TaskQueue::class,
        'ThirtyBees\\PostNL\\Util\\UUID'                                        => UUID::class,
        'ThirtyBees\\PostNL\\Util\\Util'                                        => Util::class,
        'ThirtyBees\\PostNL\\Util\\XmlSerializable'                             => XmlSerializable::class,
        'ThirtyBees\\PostNL\\Exception\\AbstractException'                      => PostNLException::class,
    ];

    if (isset($deprecatedClasses[$deprecatedClass])) {
        $originalClass = $deprecatedClasses[$deprecatedClass];
        PostNL::triggerDeprecation(
            'firstred/postnl-api-php',
            '1.4.0',
            "Using class `$deprecatedClass` is deprecated. Please use the `$originalClass` class instead."
        );
        class_alias($originalClass, $deprecatedClass);
    }
});