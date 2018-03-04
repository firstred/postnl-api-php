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
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class GenerateLabelResponse
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method MergedLabel[]      getMergedLabels()
 * @method ResponseShipment[] getResponseShipments()
 *
 * @method GenerateLabelResponse setMergedLabels(MergedLabel[] $mergedLabels)
 * @method GenerateLabelResponse setResponseShipments(ResponseShipment[] $responseShipment)
 */
class GenerateLabelResponse extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API
     *
     * @var array $defaultProperties
     */
    public static $defaultProperties = [
        'Barcode'        => [
            'MergedLabels'      => BarcodeService::DOMAIN_NAMESPACE,
            'ResponseShipments' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'MergedLabels'      => ConfirmingService::DOMAIN_NAMESPACE,
            'ResponseShipments' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'MergedLabels'      => LabellingService::DOMAIN_NAMESPACE,
            'ResponseShipments' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'MergedLabels'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'ResponseShipments' => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'MergedLabels'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'ResponseShipments' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'MergedLabels'      => LocationService::DOMAIN_NAMESPACE,
            'ResponseShipments' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'MergedLabels'      => TimeframeService::DOMAIN_NAMESPACE,
            'ResponseShipments' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var MergedLabel[] $MergedLabels */
    public $MergedLabels;
    /** @var ResponseShipment[] $ResponseShipments */
    public $ResponseShipments;
    // @codingStandardsIgnoreEnd

    /**
     * LabelRequest constructor.
     *
     * @param MergedLabel[]      $mergedLabels
     * @param ResponseShipment[] $responseShipments
     */
    public function __construct(array $mergedLabels, array $responseShipments)
    {
        parent::__construct();

        $this->setMergedLabels($mergedLabels);
        $this->setResponseShipments($responseShipments);
    }
}
