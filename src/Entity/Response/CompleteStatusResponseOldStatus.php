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
 * Class CompleteStatusResponseOldStatus
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string getCode()
 * @method string getDescription()
 * @method string getPhaseCode()
 * @method string getPhaseDescription()
 * @method string getTimeStamp()
 *
 * @method CompleteStatusResponseOldStatus setCode(string $code)
 * @method CompleteStatusResponseOldStatus setDescription(string $description)
 * @method CompleteStatusResponseOldStatus setPhaseCode(string $code)
 * @method CompleteStatusResponseOldStatus setPhaseDescription(string $description)
 * @method CompleteStatusResponseOldStatus setTimeStamp(string $timestamp)
 */
class CompleteStatusResponseOldStatus extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API
     *
     * @var array $defaultProperties
     */
    public static $defaultProperties = [
        'Barcode'        => [
            'Code'             => BarcodeService::DOMAIN_NAMESPACE,
            'Description'      => BarcodeService::DOMAIN_NAMESPACE,
            'PhaseCode'        => BarcodeService::DOMAIN_NAMESPACE,
            'PhaseDescription' => BarcodeService::DOMAIN_NAMESPACE,
            'TimeStamp'        => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Code'             => ConfirmingService::DOMAIN_NAMESPACE,
            'Description'      => ConfirmingService::DOMAIN_NAMESPACE,
            'PhaseCode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'PhaseDescription' => ConfirmingService::DOMAIN_NAMESPACE,
            'TimeStamp'        => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Code'             => LabellingService::DOMAIN_NAMESPACE,
            'Description'      => LabellingService::DOMAIN_NAMESPACE,
            'PhaseCode'        => LabellingService::DOMAIN_NAMESPACE,
            'PhaseDescription' => LabellingService::DOMAIN_NAMESPACE,
            'TimeStamp'        => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Code'             => ShippingStatusService::DOMAIN_NAMESPACE,
            'Description'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'PhaseCode'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'PhaseDescription' => ShippingStatusService::DOMAIN_NAMESPACE,
            'TimeStamp'        => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Code'             => DeliveryDateService::DOMAIN_NAMESPACE,
            'Description'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'PhaseCode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'PhaseDescription' => DeliveryDateService::DOMAIN_NAMESPACE,
            'TimeStamp'        => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Code'             => LocationService::DOMAIN_NAMESPACE,
            'Description'      => LocationService::DOMAIN_NAMESPACE,
            'PhaseCode'        => LocationService::DOMAIN_NAMESPACE,
            'PhaseDescription' => LocationService::DOMAIN_NAMESPACE,
            'TimeStamp'        => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Code'             => TimeframeService::DOMAIN_NAMESPACE,
            'Description'      => TimeframeService::DOMAIN_NAMESPACE,
            'PhaseCode'        => TimeframeService::DOMAIN_NAMESPACE,
            'PhaseDescription' => TimeframeService::DOMAIN_NAMESPACE,
            'TimeStamp'        => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string $Code */
    public $Code;
    /** @var string $Description */
    public $Description;
    /** @var string $PhaseCode */
    public $PhaseCode;
    /** @var string $PhaseDescription */
    public $PhaseDescription;
    /** @var string $TimeStamp */
    public $TimeStamp;
    // @codingStandardsIgnoreEnd

    /**
     * LabelRequest constructor.
     *
     * @param string|null $code
     * @param string|null $description
     * @param string|null $phaseCode
     * @param string|null $phaseDescription
     * @param string|null $timeStamp
     */
    public function __construct(
        $code = null,
        $description = null,
        $phaseCode = null,
        $phaseDescription = null,
        $timeStamp = null
    ) {
        parent::__construct();

        $this->setCode($code);
        $this->setDescription($description);
        $this->setPhaseCode($phaseCode);
        $this->setPhaseDescription($phaseDescription);
        $this->setTimeStamp($timeStamp);
    }
}
