<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker
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
 * @copyright 2017-2019 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class GetLocation
 *
 * This class is both the container and can be the actual GetLocation object itself!
 *
 * @package Firstred\PostNL\Entity
 *
 * @method string|null  getLocationCode()
 * @method Message|null getMessage()
 * @method string|null  getRetailNetworkID()
 *
 * @method GetLocation setLocationCode(string|null $location = null)
 * @method GetLocation setMessage(Message|null $message = null)
 * @method GetLocation setRetailNetworkID(string|null $id = null)
 */
class GetLocation extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API
     *
     * @var array $defaultProperties
     */
    public static $defaultProperties = [
        'Barcode'        => [
            'LocationCode'    => BarcodeService::DOMAIN_NAMESPACE,
            'Message'         => BarcodeService::DOMAIN_NAMESPACE,
            'RetailNetworkID' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'LocationCode'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Message'         => ConfirmingService::DOMAIN_NAMESPACE,
            'RetailNetworkID' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'LocationCode'    => LabellingService::DOMAIN_NAMESPACE,
            'Message'         => LabellingService::DOMAIN_NAMESPACE,
            'RetailNetworkID' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'LocationCode'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'Message'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'RetailNetworkID' => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'LocationCode'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Message'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'RetailNetworkID' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'LocationCode'    => LocationService::DOMAIN_NAMESPACE,
            'Message'         => LocationService::DOMAIN_NAMESPACE,
            'RetailNetworkID' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'LocationCode'    => TimeframeService::DOMAIN_NAMESPACE,
            'Message'         => TimeframeService::DOMAIN_NAMESPACE,
            'RetailNetworkID' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null $LocationCode */
    protected $LocationCode;
    /** @var Message|null $Message */
    protected $Message;
    /** @var string|null $RetailNetworkID */
    protected $RetailNetworkID;
    // @codingStandardsIgnoreEnd

    /**
     * GetLocation constructor.
     *
     * @param string|null  $location
     * @param Message|null $message
     * @param string|null  $networkId
     */
    public function __construct(
        $location = null,
        Message $message = null,
        $networkId = null
    ) {
        parent::__construct();

        $this->setLocationCode($location);
        $this->setMessage($message ?: new Message());
        $this->setRetailNetworkID($networkId);
    }
}
