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
use ThirtyBees\PostNL\Entity\Label;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class MergedLabel
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string[] getBarcodes()
 * @method Label[]  getLabels()
 *
 * @method MergedLabel setBarcodes(string[] $barcodes)
 * @method MergedLabel setLabels(Label[] $labels)
 */
class MergedLabel extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'Barcodes' => BarcodeService::DOMAIN_NAMESPACE,
            'Labels'   => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Barcodes' => ConfirmingService::DOMAIN_NAMESPACE,
            'Labels'   => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Barcodes' => LabellingService::DOMAIN_NAMESPACE,
            'Labels'   => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Barcodes' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Labels'   => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Barcodes' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Labels'   => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Barcodes' => LocationService::DOMAIN_NAMESPACE,
            'Labels'   => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Barcodes' => TimeframeService::DOMAIN_NAMESPACE,
            'Labels'   => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string[] $Barcodes */
    protected $Barcodes;
    /** @var Label[] $Labels */
    protected $Labels;
    // @codingStandardsIgnoreEnd

    /**
     * @param string[] $barcodes
     * @param Label[]  $labels
     */
    public function __construct(array $barcodes = null, array $labels = null)
    {
        parent::__construct();

        $this->setBarcodes($barcodes);
        $this->setLabels($labels);
    }
}
