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
 * @copyright 2017-2021 Michael Dekker
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
 * Class ResponseGroup.
 *
 * @method string|null   getGroupCount()
 * @method string|null   getGroupSequence()
 * @method string|null   getGroupType()
 * @method string|null   getMainBarcode()
 * @method ResponseGroup setGroupCount(string|null $groupCount = null)
 * @method ResponseGroup setGroupSequence(string|null $groupSequence = null)
 * @method ResponseGroup setGroupType(string|null $groupType = null)
 * @method ResponseGroup setMainBarcode(string|null $mainBarcode = null)
 *
 * @since 1.0.0
 */
class ResponseGroup extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'GroupCount'    => BarcodeService::DOMAIN_NAMESPACE,
            'GroupSequence' => BarcodeService::DOMAIN_NAMESPACE,
            'GroupType'     => BarcodeService::DOMAIN_NAMESPACE,
            'MainBarcode'   => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'GroupCount'    => ConfirmingService::DOMAIN_NAMESPACE,
            'GroupSequence' => ConfirmingService::DOMAIN_NAMESPACE,
            'GroupType'     => ConfirmingService::DOMAIN_NAMESPACE,
            'MainBarcode'   => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'GroupCount'    => LabellingService::DOMAIN_NAMESPACE,
            'GroupSequence' => LabellingService::DOMAIN_NAMESPACE,
            'GroupType'     => LabellingService::DOMAIN_NAMESPACE,
            'MainBarcode'   => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'GroupCount'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'GroupSequence' => ShippingStatusService::DOMAIN_NAMESPACE,
            'GroupType'     => ShippingStatusService::DOMAIN_NAMESPACE,
            'MainBarcode'   => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'GroupCount'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'GroupSequence' => DeliveryDateService::DOMAIN_NAMESPACE,
            'GroupType'     => DeliveryDateService::DOMAIN_NAMESPACE,
            'MainBarcode'   => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'GroupCount'    => LocationService::DOMAIN_NAMESPACE,
            'GroupSequence' => LocationService::DOMAIN_NAMESPACE,
            'GroupType'     => LocationService::DOMAIN_NAMESPACE,
            'MainBarcode'   => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'GroupCount'    => TimeframeService::DOMAIN_NAMESPACE,
            'GroupSequence' => TimeframeService::DOMAIN_NAMESPACE,
            'GroupType'     => TimeframeService::DOMAIN_NAMESPACE,
            'MainBarcode'   => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /**
     * Amount of shipments in the ResponseGroup.
     *
     * @var string|null
     */
    protected $GroupCount;
    /**
     * Sequence number.
     *
     * @var string|null
     */
    protected $GroupSequence;
    /**
     * The type of Group.
     *
     * Possible values:
     *
     * - `01`: Collection request
     * - `03`: Multiple parcels in one shipment (multi-colli)
     * - `04`: Single parcel in one shipment
     *
     * @var string|null
     */
    protected $GroupType;
    /**
     * Main barcode for the shipment.
     *
     * @var string|null
     */
    protected $MainBarcode;
    // @codingStandardsIgnoreEnd

    /**
     * ResponseGroup Constructor.
     *
     * @param string|null $groupCount
     * @param string|null $groupSequence
     * @param string|null $groupType
     * @param string|null $mainBarcode
     */
    public function __construct(
        $groupCount = null,
        $groupSequence = null,
        $groupType = null,
        $mainBarcode = null
    ) {
        parent::__construct();

        $this->setGroupCount($groupCount);
        $this->setGroupSequence($groupSequence);
        $this->setGroupType($groupType);
        $this->setMainBarcode($mainBarcode);
    }
}
