<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2018 Thirty Development, LLC
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

namespace ThirtyBees\PostNL\Entity\Request;

use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Message\Message;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class GetLocation.
 *
 * This class is both the container and can be the actual GetLocation object itself!
 *
 * @method string|null  getLocationCode()
 * @method Message|null getMessage()
 * @method string|null  getRetailNetworkID()
 * @method GetLocation  setLocationCode(string|null $location = null)
 * @method GetLocation  setMessage(Message|null $message = null)
 * @method GetLocation  setRetailNetworkID(string|null $id = null)
 */
class GetLocation extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode' => [
            'LocationCode'    => BarcodeService::DOMAIN_NAMESPACE,
            'Message'         => BarcodeService::DOMAIN_NAMESPACE,
            'RetailNetworkID' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'LocationCode'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Message'         => ConfirmingService::DOMAIN_NAMESPACE,
            'RetailNetworkID' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'LocationCode'    => LabellingService::DOMAIN_NAMESPACE,
            'Message'         => LabellingService::DOMAIN_NAMESPACE,
            'RetailNetworkID' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'LocationCode'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'Message'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'RetailNetworkID' => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'LocationCode'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Message'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'RetailNetworkID' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'LocationCode'    => LocationService::DOMAIN_NAMESPACE,
            'Message'         => LocationService::DOMAIN_NAMESPACE,
            'RetailNetworkID' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'LocationCode'    => TimeframeService::DOMAIN_NAMESPACE,
            'Message'         => TimeframeService::DOMAIN_NAMESPACE,
            'RetailNetworkID' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $LocationCode;
    /** @var Message|null */
    protected $Message;
    /** @var string|null */
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
