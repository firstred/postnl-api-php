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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class Group.
 *
 * @method string|null getGroupCount()
 * @method string|null getGroupSequence()
 * @method string|null getGroupType()
 * @method string|null getMainBarcode()
 * @method Group       setGroupCount(string|null $GroupCount = null)
 * @method Group       setGroupSequence(string|null $GroupSequence = null)
 * @method Group       setGroupType(string|null $GroupType = null)
 * @method Group       setMainBarcode(string|null $MainBarcode = null)
 *
 * @since 1.0.0
 */
class Group extends AbstractEntity
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
        'Shipping' => [
            'GroupCount'    => ShippingService::DOMAIN_NAMESPACE,
            'GroupSequence' => ShippingService::DOMAIN_NAMESPACE,
            'GroupType'     => ShippingService::DOMAIN_NAMESPACE,
            'MainBarcode'   => ShippingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /**
     * Amount of shipments in the group.
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
     * The type of group.
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
     * Group Constructor.
     *
     * @param string|null $GroupCount
     * @param string|null $GroupSequence
     * @param string|null $GroupType
     * @param string|null $MainBarcode
     */
    public function __construct($GroupCount = null, $GroupSequence = null, $GroupType = null, $MainBarcode = null)
    {
        parent::__construct();

        $this->setGroupCount($GroupCount);
        $this->setGroupSequence($GroupSequence);
        $this->setGroupType($GroupType);
        $this->setMainBarcode($MainBarcode);
    }
}
