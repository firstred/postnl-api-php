<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
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
 * Class OpeningHours.
 *
 * @method string|null  getMonday()
 * @method string|null  getTuesday()
 * @method string|null  getWednesday()
 * @method string|null  getThursday()
 * @method string|null  getFriday()
 * @method string|null  getSaturday()
 * @method string|null  getSunday()
 * @method OpeningHours setMonday(string|null $monday = null)
 * @method OpeningHours setTuesday(string|null $tuesday = null)
 * @method OpeningHours setWednesday(string|null $wednesday = null)
 * @method OpeningHours setThursday(string|null $thursday = null)
 * @method OpeningHours setFriday(string|null $friday = null)
 * @method OpeningHours setSaturday(string|null $saturday = null)
 * @method OpeningHours setSunday(string|null $sunday = null)
 */
class OpeningHours extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'Monday'    => BarcodeService::DOMAIN_NAMESPACE,
            'Tuesday'   => BarcodeService::DOMAIN_NAMESPACE,
            'Wednesday' => BarcodeService::DOMAIN_NAMESPACE,
            'Thursday'  => BarcodeService::DOMAIN_NAMESPACE,
            'Friday'    => BarcodeService::DOMAIN_NAMESPACE,
            'Saturday'  => BarcodeService::DOMAIN_NAMESPACE,
            'Sunday'    => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Monday'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Tuesday'   => ConfirmingService::DOMAIN_NAMESPACE,
            'Wednesday' => ConfirmingService::DOMAIN_NAMESPACE,
            'Thursday'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Friday'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Saturday'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Sunday'    => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
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
        'DeliveryDate' => [
            'Monday'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Tuesday'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'Wednesday' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Thursday'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Friday'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Saturday'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Sunday'    => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Monday'    => LocationService::DOMAIN_NAMESPACE,
            'Tuesday'   => LocationService::DOMAIN_NAMESPACE,
            'Wednesday' => LocationService::DOMAIN_NAMESPACE,
            'Thursday'  => LocationService::DOMAIN_NAMESPACE,
            'Friday'    => LocationService::DOMAIN_NAMESPACE,
            'Saturday'  => LocationService::DOMAIN_NAMESPACE,
            'Sunday'    => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
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
    /** @var string|null */
    protected $Monday = '';
    /** @var string|null */
    protected $Tuesday = '';
    /** @var string|null */
    protected $Wednesday = '';
    /** @var string|null */
    protected $Thursday = '';
    /** @var string|null */
    protected $Friday = '';
    /** @var string|null */
    protected $Saturday = '';
    /** @var string|null */
    protected $Sunday = '';
    // @codingStandardsIgnoreEnd

    /**
     * OpeningHours constructor.
     *
     * @param string|null $monday
     * @param string|null $tuesday
     * @param string|null $wednesday
     * @param string|null $thursday
     * @param string|null $friday
     * @param string|null $saturday
     * @param string|null $sunday
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
        parent::__construct();

        $this->setMonday($monday);
        $this->setTuesday($tuesday);
        $this->setWednesday($wednesday);
        $this->setThursday($thursday);
        $this->setFriday($friday);
        $this->setSaturday($saturday);
        $this->setSunday($sunday);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach (array_keys(static::$defaultProperties['Barcode']) as $property) {
            if (isset($this->{$property})) {
                $array[$property] = $this->{$property};
            }
        }

        return $array;
    }
}
