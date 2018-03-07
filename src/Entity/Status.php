<?php
/**
 * The MIT License (MIT)
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

namespace ThirtyBees\PostNL\Entity;

use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class Status
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string getCurrentPhaseCode()
 * @method string getCurrentPhaseDescription()
 * @method string getCurrentStatusCode()
 * @method string getCurrentStatusDescription()
 * @method string getCurrentStatusTimeStamp()
 *
 * @method Status setCurrentPhaseCode(string $code)
 * @method Status setCurrentPhaseDescription(string $desc)
 * @method Status setCurrentStatusCode(string $code)
 * @method Status setCurrentStatusDescription(string $desc)
 * @method Status setCurrentStatusTimeStamp(string $dateTime)
 */
class Status extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'CurrentPhaseCode'         => BarcodeService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'  => BarcodeService::DOMAIN_NAMESPACE,
            'CurrentStatusCode'        => BarcodeService::DOMAIN_NAMESPACE,
            'CurrentStatusDescription' => BarcodeService::DOMAIN_NAMESPACE,
            'CurrentStatusTimeStamp'   => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'CurrentPhaseCode'         => ConfirmingService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'  => ConfirmingService::DOMAIN_NAMESPACE,
            'CurrentStatusCode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'CurrentStatusDescription' => ConfirmingService::DOMAIN_NAMESPACE,
            'CurrentStatusTimeStamp'   => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'CurrentPhaseCode'         => LabellingService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'  => LabellingService::DOMAIN_NAMESPACE,
            'CurrentStatusCode'        => LabellingService::DOMAIN_NAMESPACE,
            'CurrentStatusDescription' => LabellingService::DOMAIN_NAMESPACE,
            'CurrentStatusTimeStamp'   => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'CurrentPhaseCode'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'  => ShippingStatusService::DOMAIN_NAMESPACE,
            'CurrentStatusCode'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'CurrentStatusDescription' => ShippingStatusService::DOMAIN_NAMESPACE,
            'CurrentStatusTimeStamp'   => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'CurrentPhaseCode'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'CurrentStatusCode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'CurrentStatusDescription' => DeliveryDateService::DOMAIN_NAMESPACE,
            'CurrentStatusTimeStamp'   => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'CurrentPhaseCode'         => LocationService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'  => LocationService::DOMAIN_NAMESPACE,
            'CurrentStatusCode'        => LocationService::DOMAIN_NAMESPACE,
            'CurrentStatusDescription' => LocationService::DOMAIN_NAMESPACE,
            'CurrentStatusTimeStamp'   => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'CurrentPhaseCode'         => TimeframeService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'  => TimeframeService::DOMAIN_NAMESPACE,
            'CurrentStatusCode'        => TimeframeService::DOMAIN_NAMESPACE,
            'CurrentStatusDescription' => TimeframeService::DOMAIN_NAMESPACE,
            'CurrentStatusTimeStamp'   => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string $CurrentPhaseCode */
    protected $CurrentPhaseCode;
    /** @var string $CurrentPhaseDescription */
    protected $CurrentPhaseDescription;
    /** @var string $CurrentStatusCode */
    protected $CurrentStatusCode;
    /** @var string $CurrentStatusDescription */
    protected $CurrentStatusDescription;
    /** @var string $CurrentStatusTimeStamp */
    protected $CurrentStatusTimeStamp;
    // @codingStandardsIgnoreEnd

    /**
     * @param null|string $phaseCode
     * @param null|string $phaseDesc
     * @param null|string $statusCode
     * @param null|string $statusDesc
     * @param null|string $timeStamp
     */
    public function __construct(
        $phaseCode = null,
        $phaseDesc = null,
        $statusCode = null,
        $statusDesc = null,
        $timeStamp = null
    ) {
        parent::__construct();

        $this->setCurrentPhaseCode($phaseCode);
        $this->setCurrentPhaseDescription($phaseDesc);
        $this->setCurrentStatusCode($statusCode);
        $this->setCurrentStatusDescription($statusDesc);
        $this->setCurrentStatusTimeStamp($timeStamp);
    }
}
