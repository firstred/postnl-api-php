<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2022 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2022 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

class_alias('Firstred\\PostNL\\Entity\\AbstractEntity', 'ThirtyBees\\PostNL\\Entity\\AbstractEntity');
class_alias('Firstred\\PostNL\\Entity\\Address', 'ThirtyBees\\PostNL\\Entity\\Address');
class_alias('Firstred\\PostNL\\Entity\\Amount', 'ThirtyBees\\PostNL\\Entity\\Amount');
class_alias('Firstred\\PostNL\\Entity\\Area', 'ThirtyBees\\PostNL\\Entity\\Area');
class_alias('Firstred\\PostNL\\Entity\\Barcode', 'ThirtyBees\\PostNL\\Entity\\Barcode');
class_alias('Firstred\\PostNL\\Entity\\Contact', 'ThirtyBees\\PostNL\\Entity\\Contact');
class_alias('Firstred\\PostNL\\Entity\\Content', 'ThirtyBees\\PostNL\\Entity\\Content');
class_alias('Firstred\\PostNL\\Entity\\Coordinates', 'ThirtyBees\\PostNL\\Entity\\Coordinates');
class_alias('Firstred\\PostNL\\Entity\\CoordinatesNorthWest', 'ThirtyBees\\PostNL\\Entity\\CoordinatesNorthWest');
class_alias('Firstred\\PostNL\\Entity\\CoordinatesSouthEast', 'ThirtyBees\\PostNL\\Entity\\CoordinatesSouthEast');
class_alias('Firstred\\PostNL\\Entity\\Customer', 'ThirtyBees\\PostNL\\Entity\\Customer');
class_alias('Firstred\\PostNL\\Entity\\Customs', 'ThirtyBees\\PostNL\\Entity\\Customs');
class_alias('Firstred\\PostNL\\Entity\\CutOffTime', 'ThirtyBees\\PostNL\\Entity\\CutOffTime');
class_alias('Firstred\\PostNL\\Entity\\Dimension', 'ThirtyBees\\PostNL\\Entity\\Dimension');
class_alias('Firstred\\PostNL\\Entity\\Event', 'ThirtyBees\\PostNL\\Entity\\Event');
class_alias('Firstred\\PostNL\\Entity\\Expectation', 'ThirtyBees\\PostNL\\Entity\\Expectation');
class_alias('Firstred\\PostNL\\Entity\\Group', 'ThirtyBees\\PostNL\\Entity\\Group');
class_alias('Firstred\\PostNL\\Entity\\Label', 'ThirtyBees\\PostNL\\Entity\\Label');
class_alias('Firstred\\PostNL\\Entity\\Location', 'ThirtyBees\\PostNL\\Entity\\Location');
class_alias('Firstred\\PostNL\\Entity\\Message\\LabellingMessage', 'ThirtyBees\\PostNL\\Entity\\Message\\LabellingMessage');
class_alias('Firstred\\PostNL\\Entity\\Message\\Message', 'ThirtyBees\\PostNL\\Entity\\Message\\Message');
class_alias('Firstred\\PostNL\\Entity\\OldStatus', 'ThirtyBees\\PostNL\\Entity\\OldStatus');
class_alias('Firstred\\PostNL\\Entity\\OpeningHours', 'ThirtyBees\\PostNL\\Entity\\OpeningHours');
class_alias('Firstred\\PostNL\\Entity\\ProductOption', 'ThirtyBees\\PostNL\\Entity\\ProductOption');
class_alias('Firstred\\PostNL\\Entity\\ReasonNoTimeframe', 'ThirtyBees\\PostNL\\Entity\\ReasonNoTimeframe');
class_alias('Firstred\\PostNL\\Entity\\Request\\CompleteStatus', 'ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatus');
class_alias('Firstred\\PostNL\\Entity\\Request\\CompleteStatusByPhase', 'ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatusByPhase');
class_alias('Firstred\\PostNL\\Entity\\Request\\CompleteStatusByReference', 'ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatusByReference');
class_alias('Firstred\\PostNL\\Entity\\Request\\CompleteStatusByStatus', 'ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatusByStatus');
class_alias('Firstred\\PostNL\\Entity\\Request\\Confirming', 'ThirtyBees\\PostNL\\Entity\\Request\\Confirming');
class_alias('Firstred\\PostNL\\Entity\\Request\\CurrentStatus', 'ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatus');
class_alias('Firstred\\PostNL\\Entity\\Request\\CurrentStatusByPhase', 'ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatusByPhase');
class_alias('Firstred\\PostNL\\Entity\\Request\\CurrentStatusByReference', 'ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatusByReference');
class_alias('Firstred\\PostNL\\Entity\\Request\\CurrentStatusByStatus', 'ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatusByStatus');
class_alias('Firstred\\PostNL\\Entity\\Request\\GenerateBarcode', 'ThirtyBees\\PostNL\\Entity\\Request\\GenerateBarcode');
class_alias('Firstred\\PostNL\\Entity\\Request\\GenerateLabel', 'ThirtyBees\\PostNL\\Entity\\Request\\GenerateLabel');
class_alias('Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate', 'ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate');
class_alias('Firstred\\PostNL\\Entity\\Request\\GetLocation', 'ThirtyBees\\PostNL\\Entity\\Request\\GetLocation');
class_alias('Firstred\\PostNL\\Entity\\Request\\GetLocationsInArea', 'ThirtyBees\\PostNL\\Entity\\Request\\GetLocationsInArea');
class_alias('Firstred\\PostNL\\Entity\\Request\\GetNearestLocations', 'ThirtyBees\\PostNL\\Entity\\Request\\GetNearestLocations');
class_alias('Firstred\\PostNL\\Entity\\Request\\GetSentDate', 'ThirtyBees\\PostNL\\Entity\\Request\\GetSentDate');
class_alias('Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest', 'ThirtyBees\\PostNL\\Entity\\Request\\GetSentDateRequest');
class_alias('Firstred\\PostNL\\Entity\\Request\\GetSignature', 'ThirtyBees\\PostNL\\Entity\\Request\\GetSignature');
class_alias('Firstred\\PostNL\\Entity\\Request\\GetTimeframes', 'ThirtyBees\\PostNL\\Entity\\Request\\GetTimeframes');
class_alias('Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponse', 'ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponse');
class_alias('Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseEvent', 'ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponseEvent');
class_alias('Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus', 'ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus');
class_alias('Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment', 'ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment');
class_alias('Firstred\\PostNL\\Entity\\Response\\ConfirmingResponseShipment', 'ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment');
class_alias('Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponse', 'ThirtyBees\\PostNL\\Entity\\Response\\CurrentStatusResponse');
class_alias('Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment', 'ThirtyBees\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment');
class_alias('Firstred\\PostNL\\Entity\\Response\\GenerateBarcodeResponse', 'ThirtyBees\\PostNL\\Entity\\Response\\GenerateBarcodeResponse');
class_alias('Firstred\\PostNL\\Entity\\Response\\GenerateLabelResponse', 'ThirtyBees\\PostNL\\Entity\\Response\\GenerateLabelResponse');
class_alias('Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse', 'ThirtyBees\\PostNL\\Entity\\Response\\GetDeliveryDateResponse');
class_alias('Firstred\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse', 'ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse');
class_alias('Firstred\\PostNL\\Entity\\Response\\GetLocationsResult', 'ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsResult');
class_alias('Firstred\\PostNL\\Entity\\Response\\GetNearestLocationsResponse', 'ThirtyBees\\PostNL\\Entity\\Response\\GetNearestLocationsResponse');
class_alias('Firstred\\PostNL\\Entity\\Response\\GetSentDateResponse', 'ThirtyBees\\PostNL\\Entity\\Response\\GetSentDateResponse');
class_alias('Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature', 'ThirtyBees\\PostNL\\Entity\\Response\\GetSignatureResponseSignature');
class_alias('Firstred\\PostNL\\Entity\\Response\\MergedLabel', 'ThirtyBees\\PostNL\\Entity\\Response\\MergedLabel');
class_alias('Firstred\\PostNL\\Entity\\Response\\ResponseAddress', 'ThirtyBees\\PostNL\\Entity\\Response\\ResponseAddress');
class_alias('Firstred\\PostNL\\Entity\\Response\\ResponseAmount', 'ThirtyBees\\PostNL\\Entity\\Response\\ResponseAmount');
class_alias('Firstred\\PostNL\\Entity\\Response\\ResponseGroup', 'ThirtyBees\\PostNL\\Entity\\Response\\ResponseGroup');
class_alias('Firstred\\PostNL\\Entity\\Response\\ResponseLocation', 'ThirtyBees\\PostNL\\Entity\\Response\\ResponseLocation');
class_alias('Firstred\\PostNL\\Entity\\Response\\ResponseShipment', 'ThirtyBees\\PostNL\\Entity\\Response\\ResponseShipment');
class_alias('Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes', 'ThirtyBees\\PostNL\\Entity\\Response\\ResponseTimeframes');
class_alias('Firstred\\PostNL\\Entity\\Response\\SignatureResponse', 'ThirtyBees\\PostNL\\Entity\\Response\\SignatureResponse');
class_alias('Firstred\\PostNL\\Entity\\SOAP\\Body', 'ThirtyBees\\PostNL\\Entity\\SOAP\\Body');
class_alias('Firstred\\PostNL\\Entity\\SOAP\\Envelope', 'ThirtyBees\\PostNL\\Entity\\SOAP\\Envelope');
class_alias('Firstred\\PostNL\\Entity\\SOAP\\Header', 'ThirtyBees\\PostNL\\Entity\\SOAP\\Header');
class_alias('Firstred\\PostNL\\Entity\\SOAP\\Security', 'ThirtyBees\\PostNL\\Entity\\SOAP\\Security');
class_alias('Firstred\\PostNL\\Entity\\SOAP\\UsernameToken', 'ThirtyBees\\PostNL\\Entity\\SOAP\\UsernameToken');
class_alias('Firstred\\PostNL\\Entity\\Shipment', 'ThirtyBees\\PostNL\\Entity\\Shipment');
class_alias('Firstred\\PostNL\\Entity\\Signature', 'ThirtyBees\\PostNL\\Entity\\Signature');
class_alias('Firstred\\PostNL\\Entity\\Status', 'ThirtyBees\\PostNL\\Entity\\Status');
class_alias('Firstred\\PostNL\\Entity\\Timeframe', 'ThirtyBees\\PostNL\\Entity\\Timeframe');
class_alias('Firstred\\PostNL\\Entity\\TimeframeTimeFrame', 'ThirtyBees\\PostNL\\Entity\\TimeframeTimeFrame');
class_alias('Firstred\\PostNL\\Entity\\Timeframes', 'ThirtyBees\\PostNL\\Entity\\Timeframes');
class_alias('Firstred\\PostNL\\Entity\\Warning', 'ThirtyBees\\PostNL\\Entity\\Warning');
class_alias('Firstred\\PostNL\\Exception\\ApiConnectionException', 'ThirtyBees\\PostNL\\Exception\\ApiConnectionException');
class_alias('Firstred\\PostNL\\Exception\\ApiException', 'ThirtyBees\\PostNL\\Exception\\ApiException');
class_alias('Firstred\\PostNL\\Exception\\CifDownException', 'ThirtyBees\\PostNL\\Exception\\CifDownException');
class_alias('Firstred\\PostNL\\Exception\\CifException', 'ThirtyBees\\PostNL\\Exception\\CifException');
class_alias('Firstred\\PostNL\\Exception\\HttpClientException', 'ThirtyBees\\PostNL\\Exception\\HttpClientException');
class_alias('Firstred\\PostNL\\Exception\\InvalidArgumentException', 'ThirtyBees\\PostNL\\Exception\\InvalidArgumentException');
class_alias('Firstred\\PostNL\\Exception\\InvalidBarcodeException', 'ThirtyBees\\PostNL\\Exception\\InvalidBarcodeException');
class_alias('Firstred\\PostNL\\Exception\\InvalidConfigurationException', 'ThirtyBees\\PostNL\\Exception\\InvalidConfigurationException');
class_alias('Firstred\\PostNL\\Exception\\InvalidMethodException', 'ThirtyBees\\PostNL\\Exception\\InvalidMethodException');
class_alias('Firstred\\PostNL\\Exception\\NotImplementedException', 'ThirtyBees\\PostNL\\Exception\\NotImplementedException');
class_alias('Firstred\\PostNL\\Exception\\NotSupportedException', 'ThirtyBees\\PostNL\\Exception\\NotSupportedException');
class_alias('Firstred\\PostNL\\Exception\\Promise\\AggregateException', 'ThirtyBees\\PostNL\\Exception\\Promise\\AggregateException');
class_alias('Firstred\\PostNL\\Exception\\Promise\\CancellationException', 'ThirtyBees\\PostNL\\Exception\\Promise\\CancellationException');
class_alias('Firstred\\PostNL\\Exception\\Promise\\RejectionException', 'ThirtyBees\\PostNL\\Exception\\Promise\\RejectionException');
class_alias('Firstred\\PostNL\\Exception\\ResponseException', 'ThirtyBees\\PostNL\\Exception\\ResponseException');
class_alias('Firstred\\PostNL\\Factory\\GuzzleRequestFactory', 'ThirtyBees\\PostNL\\Factory\\GuzzleRequestFactory');
class_alias('Firstred\\PostNL\\Factory\\GuzzleResponseFactory', 'ThirtyBees\\PostNL\\Factory\\GuzzleResponseFactory');
class_alias('Firstred\\PostNL\\Factory\\GuzzleStreamFactory', 'ThirtyBees\\PostNL\\Factory\\GuzzleStreamFactory');
class_alias('Firstred\\PostNL\\Factory\\RequestFactoryInterface', 'ThirtyBees\\PostNL\\Factory\\RequestFactoryInterface');
class_alias('Firstred\\PostNL\\Factory\\ResponseFactoryInterface', 'ThirtyBees\\PostNL\\Factory\\ResponseFactoryInterface');
class_alias('Firstred\\PostNL\\Factory\\StreamFactoryInterface', 'ThirtyBees\\PostNL\\Factory\\StreamFactoryInterface');
class_alias('Firstred\\PostNL\\HttpClient\\ClientInterface', 'ThirtyBees\\PostNL\\HttpClient\\ClientInterface');
class_alias('Firstred\\PostNL\\HttpClient\\CurlClient', 'ThirtyBees\\PostNL\\HttpClient\\CurlClient');
class_alias('Firstred\\PostNL\\HttpClient\\GuzzleClient', 'ThirtyBees\\PostNL\\HttpClient\\GuzzleClient');
class_alias('Firstred\\PostNL\\HttpClient\\HTTPlugClient', 'ThirtyBees\\PostNL\\HttpClient\\HTTPlugClient');
class_alias('Firstred\\PostNL\\HttpClient\\MockClient', 'ThirtyBees\\PostNL\\HttpClient\\MockClient');
class_alias('Firstred\\PostNL\\PostNL', 'ThirtyBees\\PostNL\\PostNL');
class_alias('Firstred\\PostNL\\Service\\AbstractService', 'ThirtyBees\\PostNL\\Service\\AbstractService');
class_alias('Firstred\\PostNL\\Service\\BarcodeService', 'ThirtyBees\\PostNL\\Service\\BarcodeService');
class_alias('Firstred\\PostNL\\Service\\BarcodeServiceInterface', 'ThirtyBees\\PostNL\\Service\\BarcodeServiceInterface');
class_alias('Firstred\\PostNL\\Service\\ConfirmingService', 'ThirtyBees\\PostNL\\Service\\ConfirmingService');
class_alias('Firstred\\PostNL\\Service\\ConfirmingServiceInterface', 'ThirtyBees\\PostNL\\Service\\ConfirmingServiceInterface');
class_alias('Firstred\\PostNL\\Service\\DeliveryDateService', 'ThirtyBees\\PostNL\\Service\\DeliveryDateService');
class_alias('Firstred\\PostNL\\Service\\DeliveryDateServiceInterface', 'ThirtyBees\\PostNL\\Service\\DeliveryDateServiceInterface');
class_alias('Firstred\\PostNL\\Service\\LabellingService', 'ThirtyBees\\PostNL\\Service\\LabellingService');
class_alias('Firstred\\PostNL\\Service\\LabellingServiceInterface', 'ThirtyBees\\PostNL\\Service\\LabellingServiceInterface');
class_alias('Firstred\\PostNL\\Service\\LocationService', 'ThirtyBees\\PostNL\\Service\\LocationService');
class_alias('Firstred\\PostNL\\Service\\LocationServiceInterface', 'ThirtyBees\\PostNL\\Service\\LocationServiceInterface');
class_alias('Firstred\\PostNL\\Service\\ServiceInterface', 'ThirtyBees\\PostNL\\Service\\ServiceInterface');
class_alias('Firstred\\PostNL\\Service\\ShippingService', 'ThirtyBees\\PostNL\\Service\\ShippingService');
class_alias('Firstred\\PostNL\\Service\\ShippingServiceInterface', 'ThirtyBees\\PostNL\\Service\\ShippingServiceInterface');
class_alias('Firstred\\PostNL\\Service\\ShippingStatusService', 'ThirtyBees\\PostNL\\Service\\ShippingStatusService');
class_alias('Firstred\\PostNL\\Service\\ShippingStatusServiceInterface', 'ThirtyBees\\PostNL\\Service\\ShippingStatusServiceInterface');
class_alias('Firstred\\PostNL\\Service\\TimeframeService', 'ThirtyBees\\PostNL\\Service\\TimeframeService');
class_alias('Firstred\\PostNL\\Service\\TimeframeServiceInterface', 'ThirtyBees\\PostNL\\Service\\TimeframeServiceInterface');
class_alias('Firstred\\PostNL\\Util\\DummyLogger', 'ThirtyBees\\PostNL\\Util\\DummyLogger');
class_alias('Firstred\\PostNL\\Util\\EachPromise', 'ThirtyBees\\PostNL\\Util\\EachPromise');
class_alias('Firstred\\PostNL\\Util\\FlexibleEntityTrait', 'ThirtyBees\\PostNL\\Util\\FlexibleEntityTrait');
class_alias('Firstred\\PostNL\\Util\\Message', 'ThirtyBees\\PostNL\\Util\\Message');
class_alias('Firstred\\PostNL\\Util\\PendingPromise', 'ThirtyBees\\PostNL\\Util\\PendingPromise');
class_alias('Firstred\\PostNL\\Util\\PromiseTool', 'ThirtyBees\\PostNL\\Util\\PromiseTool');
class_alias('Firstred\\PostNL\\Util\\RFPdi', 'ThirtyBees\\PostNL\\Util\\RFPdi');
class_alias('Firstred\\PostNL\\Util\\TaskQueue', 'ThirtyBees\\PostNL\\Util\\TaskQueue');
class_alias('Firstred\\PostNL\\Util\\UUID', 'ThirtyBees\\PostNL\\Util\\UUID');
class_alias('Firstred\\PostNL\\Util\\Util', 'ThirtyBees\\PostNL\\Util\\Util');
class_alias('Firstred\\PostNL\\Util\\XmlSerializable', 'ThirtyBees\\PostNL\\Util\\XmlSerializable');
class_alias('Firstred\\PostNL\\Exception\\PostNLException', 'ThirtyBees\\PostNL\\Exception\\AbstractException');
