<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2018 Thirty Development, LLC
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
 * Class CutOffTime
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string getDay()
 * @method string getTime()
 * @method bool   getAvailable()
 *
 * @method CutOffTime setDay(string $day)
 * @method CutOffTime setTime(string $time)
 * @method CutOffTime setAvailable(bool $available)
 */
class CutOffTime extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'Day'       => BarcodeService::DOMAIN_NAMESPACE,
            'Time'      => BarcodeService::DOMAIN_NAMESPACE,
            'Available' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Day'       => ConfirmingService::DOMAIN_NAMESPACE,
            'Time'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Available' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Day'       => LabellingService::DOMAIN_NAMESPACE,
            'Time'      => LabellingService::DOMAIN_NAMESPACE,
            'Available' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Day'       => ShippingStatusService::DOMAIN_NAMESPACE,
            'Time'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'Available' => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Day'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'Time'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Available' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Day'       => LocationService::DOMAIN_NAMESPACE,
            'Time'      => LocationService::DOMAIN_NAMESPACE,
            'Available' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Day'       => TimeframeService::DOMAIN_NAMESPACE,
            'Time'      => TimeframeService::DOMAIN_NAMESPACE,
            'Available' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string $Day */
    protected $Day;
    /** @var string $Time */
    protected $Time;
    /** @var bool $Available */
    protected $Available;
    // @codingStandardsIgnoreEnd

    /**
     * @param string $day
     * @param string $time
     * @param bool $available
     */
    public function __construct($day = null, $time = null, $available = null)
    {
        parent::__construct();

        $this->setDay($day);
        $this->setTime($time);
        $this->setAvailable($available);
    }
}
