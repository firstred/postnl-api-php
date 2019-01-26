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

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Label;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class MergedLabel
 *
 * @method int|null       getProductCodeDelivery()
 * @method string[]|null  getBarcodes()
 * @method Warning[]|null getWarnings()
 * @method Label[]|null   getLabels()
 *
 * @method MergedLabel setProductCodeDelivery(int|null $code = null)
 * @method MergedLabel setBarcodes(string[]|null $barcodes = null)
 * @method MergedLabel setWarnings(Warning[]|null $warnings = null)
 * @method MergedLabel setLabels(Label[]|null $labels = null)
 */
class MergedLabel extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'ProductCodeDelivery' => BarcodeService::DOMAIN_NAMESPACE,
            'Barcodes'            => BarcodeService::DOMAIN_NAMESPACE,
            'Warnings'            => BarcodeService::DOMAIN_NAMESPACE,
            'Labels'              => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'ProductCodeDelivery' => ConfirmingService::DOMAIN_NAMESPACE,
            'Barcodes'            => ConfirmingService::DOMAIN_NAMESPACE,
            'Warnings'            => ConfirmingService::DOMAIN_NAMESPACE,
            'Labels'              => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'ProductCodeDelivery' => LabellingService::DOMAIN_NAMESPACE,
            'Barcodes'            => LabellingService::DOMAIN_NAMESPACE,
            'Warnings'            => LabellingService::DOMAIN_NAMESPACE,
            'Labels'              => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'ProductCodeDelivery' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Barcodes'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'Warnings'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'Labels'              => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'ProductCodeDelivery' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Barcodes'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'Warnings'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'Labels'              => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'ProductCodeDelivery' => LocationService::DOMAIN_NAMESPACE,
            'Barcodes'            => LocationService::DOMAIN_NAMESPACE,
            'Warnings'            => LocationService::DOMAIN_NAMESPACE,
            'Labels'              => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'ProductCodeDelivery' => TimeframeService::DOMAIN_NAMESPACE,
            'Barcodes'            => TimeframeService::DOMAIN_NAMESPACE,
            'Warnings'            => TimeframeService::DOMAIN_NAMESPACE,
            'Labels'              => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string[]|null $Barcodes */
    protected $Barcodes;
    /** @var Label[]|null $Labels */
    protected $Labels;
    // @codingStandardsIgnoreEnd

    /**
     * @param int|null       $productCodeDelivery
     * @param string[]|null  $barcodes
     * @param Warning[]|null $warnings
     * @param Label[]|null   $labels
     */
    public function __construct(?int $productCodeDelivery = null, array $barcodes = null, array $warnings = null, array $labels = null)
    {
        parent::__construct();

        $this->setProductCodeDelivery($productCodeDelivery);
        $this->setBarcodes($barcodes);
        $this->setWarnings($warnings);
        $this->setLabels($labels);
    }
}
