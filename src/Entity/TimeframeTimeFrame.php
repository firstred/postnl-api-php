<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * *Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class TimeframeTimeFrame
 *
 * @method string|null   getDate()
 * @method string|null   getFrom()
 * @method string|null   getTo()
 * @method string[]|null getOptions()
 *
 * @method TimeframeTimeFrame setDate(string|null $date = null)
 * @method TimeframeTimeFrame setFrom(string|null $from = null)
 * @method TimeframeTimeFrame setTo(string|null $to = null)
 * @method TimeframeTimeFrame setOptions(string[]|null $options = null)
 */
class TimeframeTimeFrame extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'Date'    => BarcodeService::DOMAIN_NAMESPACE,
            'From'    => BarcodeService::DOMAIN_NAMESPACE,
            'Options' => BarcodeService::DOMAIN_NAMESPACE,
            'To'      => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Date'    => ConfirmingService::DOMAIN_NAMESPACE,
            'From'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Options' => ConfirmingService::DOMAIN_NAMESPACE,
            'To'      => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Date'    => LabellingService::DOMAIN_NAMESPACE,
            'From'    => LabellingService::DOMAIN_NAMESPACE,
            'Options' => LabellingService::DOMAIN_NAMESPACE,
            'To'      => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Date'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'From'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'Options' => ShippingStatusService::DOMAIN_NAMESPACE,
            'To'      => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Date'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'From'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Options' => DeliveryDateService::DOMAIN_NAMESPACE,
            'To'      => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Date'    => LocationService::DOMAIN_NAMESPACE,
            'From'    => LocationService::DOMAIN_NAMESPACE,
            'Options' => LocationService::DOMAIN_NAMESPACE,
            'To'      => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Date'    => TimeframeService::DOMAIN_NAMESPACE,
            'From'    => TimeframeService::DOMAIN_NAMESPACE,
            'Options' => TimeframeService::DOMAIN_NAMESPACE,
            'To'      => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null $Date */
    protected $Date;
    /** @var string|null $From */
    protected $From;
    /** @var string[]|null $Options */
    protected $Options;
    /** @var string|null $To */
    protected $To;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null   $date
     * @param string|null   $from
     * @param string|null   $to
     * @param string[]|null $options
     */
    public function __construct($date = null, $from = null, $to = null, array $options = null)
    {
        parent::__construct();

        $this->setDate($date);
        $this->setFrom($from);
        $this->setTo($to);
        $this->setOptions($options);
    }
}
