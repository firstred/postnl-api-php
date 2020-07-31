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

namespace ThirtyBees\PostNL\Entity;

use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class OldStatus.
 *
 * @method string|null getCurrentPhaseCode()
 * @method string|null getCurrentPhaseDescription()
 * @method string|null getCurrentOldStatusCode()
 * @method string|null getCurrentOldStatusDescription()
 * @method string|null getCurrentOldStatusTimeStamp()
 * @method OldStatus   setCurrentPhaseCode(string|null $code)
 * @method OldStatus   setCurrentPhaseDescription(string|null $desc)
 * @method OldStatus   setCurrentOldStatusCode(string|null $code)
 * @method OldStatus   setCurrentOldStatusDescription(string|null $desc)
 * @method OldStatus   setCurrentOldStatusTimeStamp(string|null $dateTime)
 */
class OldStatus extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'CurrentPhaseCode'            => BarcodeService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'     => BarcodeService::DOMAIN_NAMESPACE,
            'CurrentOldStatusCode'        => BarcodeService::DOMAIN_NAMESPACE,
            'CurrentOldStatusDescription' => BarcodeService::DOMAIN_NAMESPACE,
            'CurrentOldStatusTimeStamp'   => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'CurrentPhaseCode'            => ConfirmingService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'     => ConfirmingService::DOMAIN_NAMESPACE,
            'CurrentOldStatusCode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'CurrentOldStatusDescription' => ConfirmingService::DOMAIN_NAMESPACE,
            'CurrentOldStatusTimeStamp'   => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'CurrentPhaseCode'            => LabellingService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'     => LabellingService::DOMAIN_NAMESPACE,
            'CurrentOldStatusCode'        => LabellingService::DOMAIN_NAMESPACE,
            'CurrentOldStatusDescription' => LabellingService::DOMAIN_NAMESPACE,
            'CurrentOldStatusTimeStamp'   => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'CurrentPhaseCode'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'     => ShippingStatusService::DOMAIN_NAMESPACE,
            'CurrentOldStatusCode'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'CurrentOldStatusDescription' => ShippingStatusService::DOMAIN_NAMESPACE,
            'CurrentOldStatusTimeStamp'   => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'CurrentPhaseCode'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'     => DeliveryDateService::DOMAIN_NAMESPACE,
            'CurrentOldStatusCode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'CurrentOldStatusDescription' => DeliveryDateService::DOMAIN_NAMESPACE,
            'CurrentOldStatusTimeStamp'   => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'CurrentPhaseCode'            => LocationService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'     => LocationService::DOMAIN_NAMESPACE,
            'CurrentOldStatusCode'        => LocationService::DOMAIN_NAMESPACE,
            'CurrentOldStatusDescription' => LocationService::DOMAIN_NAMESPACE,
            'CurrentOldStatusTimeStamp'   => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'CurrentPhaseCode'            => TimeframeService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'     => TimeframeService::DOMAIN_NAMESPACE,
            'CurrentOldStatusCode'        => TimeframeService::DOMAIN_NAMESPACE,
            'CurrentOldStatusDescription' => TimeframeService::DOMAIN_NAMESPACE,
            'CurrentOldStatusTimeStamp'   => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $CurrentPhaseCode;
    /** @var string|null */
    protected $CurrentPhaseDescription;
    /** @var string|null */
    protected $CurrentOldStatusCode;
    /** @var string|null */
    protected $CurrentOldStatusDescription;
    /** @var string|null */
    protected $CurrentOldStatusTimeStamp;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null $phaseCode
     * @param string|null $phaseDesc
     * @param string|null $OldStatusCode
     * @param string|null $OldStatusDesc
     * @param string|null $timeStamp
     */
    public function __construct(
        $phaseCode = null,
        $phaseDesc = null,
        $OldStatusCode = null,
        $OldStatusDesc = null,
        $timeStamp = null
    ) {
        parent::__construct();

        $this->setCurrentPhaseCode($phaseCode);
        $this->setCurrentPhaseDescription($phaseDesc);
        $this->setCurrentOldStatusCode($OldStatusCode);
        $this->setCurrentOldStatusDescription($OldStatusDesc);
        $this->setCurrentOldStatusTimeStamp($timeStamp);
    }
}
