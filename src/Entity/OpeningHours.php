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

namespace ThirtyBees\PostNL\Entity;

use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class OpeningHours
 *
 * @package MijnPostNLExportModule\Postnl\ComplexTypes
 *
 * @method string getMonday()
 * @method string getTuesday()
 * @method string getWednesday()
 * @method string getThursday()
 * @method string getFriday()
 * @method string getSaturday()
 * @method string getSunday()
 *
 * @method OpeningHours setMonday(string $monday)
 * @method OpeningHours setTuesday(string $tuesday)
 * @method OpeningHours setWednesday(string $wednesday)
 * @method OpeningHours setThursday(string $thursday)
 * @method OpeningHours setFriday(string $friday)
 * @method OpeningHours setSaturday(string $saturday)
 * @method OpeningHours setSunday(string $sunday)
 */
class OpeningHours extends AbstractEntity
{
    /** @var string[] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'Monday'    => BarcodeService::DOMAIN_NAMESPACE,
            'Tuesday'   => BarcodeService::DOMAIN_NAMESPACE,
            'Wednesday' => BarcodeService::DOMAIN_NAMESPACE,
            'Thursday'  => BarcodeService::DOMAIN_NAMESPACE,
            'Friday'    => BarcodeService::DOMAIN_NAMESPACE,
            'Saturday'  => BarcodeService::DOMAIN_NAMESPACE,
            'Sunday'    => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Monday'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Tuesday'   => ConfirmingService::DOMAIN_NAMESPACE,
            'Wednesday' => ConfirmingService::DOMAIN_NAMESPACE,
            'Thursday'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Friday'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Saturday'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Sunday'    => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Monday'    => LabellingService::DOMAIN_NAMESPACE,
            'Tuesday'   => LabellingService::DOMAIN_NAMESPACE,
            'Wednesday' => LabellingService::DOMAIN_NAMESPACE,
            'Thursday'  => LabellingService::DOMAIN_NAMESPACE,
            'Friday'    => LabellingService::DOMAIN_NAMESPACE,
            'Saturday'  => LabellingService::DOMAIN_NAMESPACE,
            'Sunday'    => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Monday'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'Tuesday'   => ShippingStatusService::DOMAIN_NAMESPACE,
            'Wednesday' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Thursday'  => ShippingStatusService::DOMAIN_NAMESPACE,
            'Friday'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'Saturday'  => ShippingStatusService::DOMAIN_NAMESPACE,
            'Sunday'    => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Monday'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Tuesday'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'Wednesday' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Thursday'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Friday'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Saturday'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Sunday'    => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Monday'    => LocationService::DOMAIN_NAMESPACE,
            'Tuesday'   => LocationService::DOMAIN_NAMESPACE,
            'Wednesday' => LocationService::DOMAIN_NAMESPACE,
            'Thursday'  => LocationService::DOMAIN_NAMESPACE,
            'Friday'    => LocationService::DOMAIN_NAMESPACE,
            'Saturday'  => LocationService::DOMAIN_NAMESPACE,
            'Sunday'    => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Monday'    => TimeframeService::DOMAIN_NAMESPACE,
            'Tuesday'   => TimeframeService::DOMAIN_NAMESPACE,
            'Wednesday' => TimeframeService::DOMAIN_NAMESPACE,
            'Thursday'  => TimeframeService::DOMAIN_NAMESPACE,
            'Friday'    => TimeframeService::DOMAIN_NAMESPACE,
            'Saturday'  => TimeframeService::DOMAIN_NAMESPACE,
            'Sunday'    => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string $Monday */
    protected $Monday = '';
    /** @var string $Tuesday */
    protected $Tuesday = '';
    /** @var string $Wednesday */
    protected $Wednesday = '';
    /** @var string $Thursday */
    protected $Thursday = '';
    /** @var string $Friday */
    protected $Friday = '';
    /** @var string $Saturday */
    protected $Saturday = '';
    /** @var string $Sunday */
    protected $Sunday = '';
    // @codingStandardsIgnoreEnd

    /**
     * OpeningHours constructor.
     *
     * @param string $monday
     * @param string $tuesday
     * @param string $wednesday
     * @param string $thursday
     * @param string $friday
     * @param string $saturday
     * @param string $sunday
     */
    public function __construct(
        $monday = '',
        $tuesday = '',
        $wednesday = '',
        $thursday = '',
        $friday = '',
        $saturday = '',
        $sunday = ''
    ) {
        $this->setMonday($monday);
        $this->setTuesday($tuesday);
        $this->setWednesday($wednesday);
        $this->setThursday($thursday);
        $this->setFriday($friday);
        $this->setSaturday($saturday);
        $this->setSunday($sunday);
    }
}
