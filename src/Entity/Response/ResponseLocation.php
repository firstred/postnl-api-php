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

namespace ThirtyBees\PostNL\Entity\Response;

use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\Location;
use ThirtyBees\PostNL\Entity\Warning;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class ResponseLocation
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string|null getAddress()
 * @method string[]|null getDeliveryOptions()
 * @method string|null getLocation()
 * @method string|null getWarnings()
 *
 * @method ResponseLocation setAddress(Address $address = null)
 * @method ResponseLocation setDeliveryOptions(string[] $options)
 * @method ResponseLocation setLocation(Location $location = null)
 * @method ResponseLocation setWarnings(Warning[] $warnings = null)
 */
class ResponseLocation extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API
     *
     * @var array $defaultProperties
     */
    public static $defaultProperties = [
        'Barcode'        => [
            'Address'         => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryOptions' => BarcodeService::DOMAIN_NAMESPACE,
            'Location'        => BarcodeService::DOMAIN_NAMESPACE,
            'Warnings'        => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Address'         => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryOptions' => ConfirmingService::DOMAIN_NAMESPACE,
            'Location'        => ConfirmingService::DOMAIN_NAMESPACE,
            'Warnings'        => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Address'         => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryOptions' => LabellingService::DOMAIN_NAMESPACE,
            'Location'        => LabellingService::DOMAIN_NAMESPACE,
            'Warnings'        => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Address'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryOptions' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Location'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'Warnings'        => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Address'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryOptions' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Location'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'Warnings'        => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Address'         => LocationService::DOMAIN_NAMESPACE,
            'DeliveryOptions' => LocationService::DOMAIN_NAMESPACE,
            'Location'        => LocationService::DOMAIN_NAMESPACE,
            'Warnings'        => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Address'         => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryOptions' => TimeframeService::DOMAIN_NAMESPACE,
            'Location'        => TimeframeService::DOMAIN_NAMESPACE,
            'Warnings'        => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Address $Address */
    protected $Address;
    /** @var string[] $DeliveryOptions */
    protected $DeliveryOptions;
    /** @var Location $Location */
    protected $Location;
    /** @var Warning[] $Warnings */
    protected $Warnings;
    // @codingStandardsIgnoreEnd

    /**
     * ResponseLocation constructor.
     *
     * @param Address|null   $address
     * @param string[]       $deliveryOptions
     * @param Location|null  $location
     * @param Warning[]|null $warnings
     */
    public function __construct(
        Address $address = null,
        array $deliveryOptions = [],
        Location $location = null,
        $warnings = null
    ) {
        parent::__construct();

        $this->setAddress($address);
        $this->setDeliveryOptions($deliveryOptions);
        $this->setLocation($location);
        $this->setWarnings($warnings);
    }
}
