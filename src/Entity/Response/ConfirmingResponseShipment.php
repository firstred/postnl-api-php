<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Response;

use stdClass;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class ConfirmingResponseShipment.
 *
 * @method string|null                getBarcode()
 * @method Warning[]|null             getWarnings()
 * @method ConfirmingResponseShipment setBarcode(string|null $Barcode = null)
 * @method ConfirmingResponseShipment setWarnings(Warning[]|null $Warnings = null)
 *
 * @since 1.0.0
 */
class ConfirmingResponseShipment extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'Barcode'  => BarcodeService::DOMAIN_NAMESPACE,
            'Warnings' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Barcode'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Warnings' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Barcode'  => LabellingService::DOMAIN_NAMESPACE,
            'Warnings' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Barcode'  => ShippingStatusService::DOMAIN_NAMESPACE,
            'Warnings' => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Barcode'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Warnings' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Barcode'  => LocationService::DOMAIN_NAMESPACE,
            'Warnings' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Barcode'  => TimeframeService::DOMAIN_NAMESPACE,
            'Warnings' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $Barcode;
    /** @var Warning[]|null */
    protected $Warnings;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null    $Barcode
     * @param Warning[]|null $Warnings
     */
    public function __construct(
        $Barcode = null,
        $Warnings = null
    ) {
        parent::__construct();

        $this->setBarcode($Barcode);
        $this->setWarnings($Warnings);
    }
}
