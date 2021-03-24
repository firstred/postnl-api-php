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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Entity\Request;

use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Location;
use ThirtyBees\PostNL\Entity\Message\Message;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class GetNearestLocations.
 *
 * This class is both the container and can be the actual GetNearestLocations object itself!
 *
 * @method string|null         getCountrycode()
 * @method Location|null       getLocation()
 * @method Message|null        getMessage()
 * @method GetNearestLocations setCountrycode(string|null $countrycode = null)
 * @method GetNearestLocations setLocation(Location|null $location = null)
 * @method GetNearestLocations setMessage(Message|null $message = null)
 *
 * @since 1.0.0
 */
class GetNearestLocations extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode' => [
            'Countrycode' => BarcodeService::DOMAIN_NAMESPACE,
            'Location'    => BarcodeService::DOMAIN_NAMESPACE,
            'Message'     => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Countrycode' => ConfirmingService::DOMAIN_NAMESPACE,
            'Location'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Message'     => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Countrycode' => LabellingService::DOMAIN_NAMESPACE,
            'Location'    => LabellingService::DOMAIN_NAMESPACE,
            'Message'     => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Countrycode' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Location'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'Message'     => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Countrycode' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Location'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Message'     => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Countrycode' => LocationService::DOMAIN_NAMESPACE,
            'Location'    => LocationService::DOMAIN_NAMESPACE,
            'Message'     => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Countrycode' => TimeframeService::DOMAIN_NAMESPACE,
            'Location'    => TimeframeService::DOMAIN_NAMESPACE,
            'Message'     => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $Countrycode;
    /** @var Location|null */
    protected $Location;
    /** @var Message|null */
    protected $Message;
    // @codingStandardsIgnoreEnd

    /**
     * GetNearestLocations constructor.
     *
     * @param string|null   $Countrycode
     * @param Location|null $location
     * @param Message|null  $message
     */
    public function __construct(
        $Countrycode = null,
        Location $location = null,
        Message $message = null
    ) {
        parent::__construct();

        $this->setCountrycode($Countrycode);
        $this->setLocation($location);
        $this->setMessage($message ?: new Message());
    }
}
