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
use ThirtyBees\PostNL\Service\LabellingService;

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
        'Barcode'    => [
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
        'Labelling'  => [
            'Monday'    => LabellingService::DOMAIN_NAMESPACE,
            'Tuesday'   => LabellingService::DOMAIN_NAMESPACE,
            'Wednesday' => LabellingService::DOMAIN_NAMESPACE,
            'Thursday'  => LabellingService::DOMAIN_NAMESPACE,
            'Friday'    => LabellingService::DOMAIN_NAMESPACE,
            'Saturday'  => LabellingService::DOMAIN_NAMESPACE,
            'Sunday'    => LabellingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string $Monday */
    protected $Monday = null;
    /** @var string $Tuesday */
    protected $Tuesday = null;
    /** @var string $Wednesday */
    protected $Wednesday = null;
    /** @var string $Thursday */
    protected $Thursday = null;
    /** @var string $Friday */
    protected $Friday = null;
    /** @var string $Saturday */
    protected $Saturday = null;
    /** @var string $Sunday */
    protected $Sunday = null;
    // @codingStandardsIgnoreEnd
}
