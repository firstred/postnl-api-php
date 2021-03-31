<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 keenDelivery, LLC
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
 * @author    Jan-Wilco peters <info@keendelivery.com>
 * @copyright 2017-2021 KeenDelivery, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class GenerateLabelResponse.
 *
 * @method MergedLabel[]|null       getMergedLabels()
 * @method ResponseShipment[]|null  getResponseShipments()
 * @method GenerateShippingResponse setMergedLabels(MergedLabel[]|null $mergedLabels = null)
 * @method GenerateShippingResponse setResponseShipments(ResponseShipment[]|null $responseShipment = null)
 *
 * @since 1.0.0
 */
class GenerateShippingResponse extends AbstractEntity
{
    /**
     * @var array|null
     */
    public static $defaultProperties = [
        'Barcode' => [
            'MergedLabels'      => BarcodeService::DOMAIN_NAMESPACE,
            'ResponseShipments' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'MergedLabels'      => ConfirmingService::DOMAIN_NAMESPACE,
            'ResponseShipments' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'MergedLabels'      => LabellingService::DOMAIN_NAMESPACE,
            'ResponseShipments' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'MergedLabels'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'ResponseShipments' => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'MergedLabels'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'ResponseShipments' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'MergedLabels'      => LocationService::DOMAIN_NAMESPACE,
            'ResponseShipments' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'MergedLabels'      => TimeframeService::DOMAIN_NAMESPACE,
            'ResponseShipments' => TimeframeService::DOMAIN_NAMESPACE,
        ],
        'Shipping' => [
            'MergedLabels'      => ShippingService::DOMAIN_NAMESPACE,
            'ResponseShipments' => ShippingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var MergedLabel[]|null */
    protected $MergedLabels;
    /** @var ResponseShipment[]|null */
    protected $ResponseShipments;
    // @codingStandardsIgnoreEnd

    /**
     * GenerateShippingResponse constructor.
     *
     * @param MergedLabel[]|null      $MergedLabels
     * @param ResponseShipment[]|null $ReponseShipments
     */
    public function __construct(array $MergedLabels = null, array $ReponseShipments = null)
    {
        parent::__construct();

        $this->setMergedLabels($MergedLabels);
        $this->setResponseShipments($ReponseShipments);
    }
}
