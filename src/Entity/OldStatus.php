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
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class OldStatus.
 *
 * @method string|null getCurrentPhaseCode()
 * @method string|null getCurrentPhaseDescription()
 * @method string|null getCurrentOldStatusCode()
 * @method string|null getCurrentOldStatusDescription()
 * @method string|null getCurrentOldStatusTimeStamp()
 * @method OldStatus   setCurrentPhaseCode(string|null $CurrentPhaseCode)
 * @method OldStatus   setCurrentPhaseDescription(string|null $CurrentPhaseDescription)
 * @method OldStatus   setCurrentOldStatusCode(string|null $CurrentOldStatusCode)
 * @method OldStatus   setCurrentOldStatusDescription(string|null $CurrentOldStatusDescription)
 * @method OldStatus   setCurrentOldStatusTimeStamp(string|null $CurrentOldStatusTimeStamp)
 *
 * @since 1.0.0
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
     * @param string|null $PhaseCode
     * @param string|null $PhaseDescription
     * @param string|null $OldStatusCode
     * @param string|null $OldStatusDescription
     * @param string|null $TimeStamp
     */
    public function __construct(
        $PhaseCode = null,
        $PhaseDescription = null,
        $OldStatusCode = null,
        $OldStatusDescription = null,
        $TimeStamp = null
    ) {
        parent::__construct();

        $this->setCurrentPhaseCode($PhaseCode);
        $this->setCurrentPhaseDescription($PhaseDescription);
        $this->setCurrentOldStatusCode($OldStatusCode);
        $this->setCurrentOldStatusDescription($OldStatusDescription);
        $this->setCurrentOldStatusTimeStamp($TimeStamp);
    }
}
