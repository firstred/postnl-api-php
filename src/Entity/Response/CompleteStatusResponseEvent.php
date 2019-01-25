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

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class CompleteStatusResponseEvent
 *
 * @package Firstred\PostNL\Entity
 *
 * @method string|null getCode()
 * @method string|null getDescription()
 * @method string|null getDestinationLocationCode()
 * @method string|null getLocationCode()
 * @method string|null getRouteCode()
 * @method string|null getRouteName()
 * @method string|null getTimeStamp()
 *
 * @method CompleteStatusResponseEvent setCode(string|null $code = null)
 * @method CompleteStatusResponseEvent setDescription(string|null $description = null)
 * @method CompleteStatusResponseEvent setDestinationLocationCode(string|null $code = null)
 * @method CompleteStatusResponseEvent setLocationCode(string|null $code = null)
 * @method CompleteStatusResponseEvent setRouteCode(string|null $code = null)
 * @method CompleteStatusResponseEvent setRouteName(string|null $name = null)
 * @method CompleteStatusResponseEvent setTimeStamp(string|null $timestamp = null)
 */
class CompleteStatusResponseEvent extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API
     *
     * @var array $defaultProperties
     */
    public static $defaultProperties = [
        'Barcode'        => [
            'Code'                    => BarcodeService::DOMAIN_NAMESPACE,
            'Description'             => BarcodeService::DOMAIN_NAMESPACE,
            'DestinationLocationCode' => BarcodeService::DOMAIN_NAMESPACE,
            'LocationCode'            => BarcodeService::DOMAIN_NAMESPACE,
            'RouteCode'               => BarcodeService::DOMAIN_NAMESPACE,
            'RouteName'               => BarcodeService::DOMAIN_NAMESPACE,
            'TimeStamp'               => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Code'                    => ConfirmingService::DOMAIN_NAMESPACE,
            'Description'             => ConfirmingService::DOMAIN_NAMESPACE,
            'DestinationLocationCode' => ConfirmingService::DOMAIN_NAMESPACE,
            'LocationCode'            => ConfirmingService::DOMAIN_NAMESPACE,
            'RouteCode'               => ConfirmingService::DOMAIN_NAMESPACE,
            'RouteName'               => ConfirmingService::DOMAIN_NAMESPACE,
            'TimeStamp'               => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Code'                    => LabellingService::DOMAIN_NAMESPACE,
            'Description'             => LabellingService::DOMAIN_NAMESPACE,
            'DestinationLocationCode' => LabellingService::DOMAIN_NAMESPACE,
            'LocationCode'            => LabellingService::DOMAIN_NAMESPACE,
            'RouteCode'               => LabellingService::DOMAIN_NAMESPACE,
            'RouteName'               => LabellingService::DOMAIN_NAMESPACE,
            'TimeStamp'               => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Code'                    => ShippingStatusService::DOMAIN_NAMESPACE,
            'Description'             => ShippingStatusService::DOMAIN_NAMESPACE,
            'DestinationLocationCode' => ShippingStatusService::DOMAIN_NAMESPACE,
            'LocationCode'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'RouteCode'               => ShippingStatusService::DOMAIN_NAMESPACE,
            'RouteName'               => ShippingStatusService::DOMAIN_NAMESPACE,
            'TimeStamp'               => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Code'                    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Description'             => DeliveryDateService::DOMAIN_NAMESPACE,
            'DestinationLocationCode' => DeliveryDateService::DOMAIN_NAMESPACE,
            'LocationCode'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'RouteCode'               => DeliveryDateService::DOMAIN_NAMESPACE,
            'RouteName'               => DeliveryDateService::DOMAIN_NAMESPACE,
            'TimeStamp'               => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Code'                    => LocationService::DOMAIN_NAMESPACE,
            'Description'             => LocationService::DOMAIN_NAMESPACE,
            'DestinationLocationCode' => LocationService::DOMAIN_NAMESPACE,
            'LocationCode'            => LocationService::DOMAIN_NAMESPACE,
            'RouteCode'               => LocationService::DOMAIN_NAMESPACE,
            'RouteName'               => LocationService::DOMAIN_NAMESPACE,
            'TimeStamp'               => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Code'                    => TimeframeService::DOMAIN_NAMESPACE,
            'Description'             => TimeframeService::DOMAIN_NAMESPACE,
            'DestinationLocationCode' => TimeframeService::DOMAIN_NAMESPACE,
            'LocationCode'            => TimeframeService::DOMAIN_NAMESPACE,
            'RouteCode'               => TimeframeService::DOMAIN_NAMESPACE,
            'RouteName'               => TimeframeService::DOMAIN_NAMESPACE,
            'TimeStamp'               => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null $Code */
    protected $Code;
    /** @var string|null $Description */
    protected $Description;
    /** @var string|null $DestinationLocationCode */
    protected $DestinationLocationCode;
    /** @var string|null $LocationCode */
    protected $LocationCode;
    /** @var string|null $RouteCode */
    protected $RouteCode;
    /** @var string|null $RouteName */
    protected $RouteName;
    /** @var string|null $TimeStamp */
    protected $TimeStamp;
    // @codingStandardsIgnoreEnd

    /**
     * CompleteStatusResponseEvent constructor.
     *
     * @param string|null $code
     * @param string|null $description
     * @param string|null $destinationLocationCode
     * @param string|null $locationCode
     * @param string|null $routeCode
     * @param string|null $routeName
     * @param string|null $timeStamp
     */
    public function __construct(
        $code = null,
        $description = null,
        $destinationLocationCode = null,
        $locationCode = null,
        $routeCode = null,
        $routeName = null,
        $timeStamp = null
    ) {
        parent::__construct();

        $this->setCode($code);
        $this->setDescription($description);
        $this->setDestinationLocationCode($destinationLocationCode);
        $this->setLocationCode($locationCode);
        $this->setRouteCode($routeCode);
        $this->setRouteName($routeName);
        $this->setTimeStamp($timeStamp);
    }
}
