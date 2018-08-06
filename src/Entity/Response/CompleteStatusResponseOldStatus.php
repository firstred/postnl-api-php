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
 * @method string|null getStatusCode()
 * @method string|null getStatusDescription()
 * @method string|null getPhaseCode()
 * @method string|null getPhaseDescription()
 * @method string|null getTimeStamp()
 *
 * @method CompleteStatusResponseOldStatus setStatusCode(string|null $code = null)
 * @method CompleteStatusResponseOldStatus setStatusDescription(string|null $description = null)
 * @method CompleteStatusResponseOldStatus setPhaseCode(string|null $code = null)
 * @method CompleteStatusResponseOldStatus setPhaseDescription(string|null $description = null)
 * @method CompleteStatusResponseOldStatus setTimeStamp(string|null $timestamp = null)
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
            'StatusCode'             => BarcodeService::DOMAIN_NAMESPACE,
            'StatusDescription'      => BarcodeService::DOMAIN_NAMESPACE,
            'PhaseCode'        => BarcodeService::DOMAIN_NAMESPACE,
            'PhaseDescription' => BarcodeService::DOMAIN_NAMESPACE,
            'TimeStamp'        => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'StatusCode'             => ConfirmingService::DOMAIN_NAMESPACE,
            'StatusDescription'      => ConfirmingService::DOMAIN_NAMESPACE,
            'PhaseCode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'PhaseDescription' => ConfirmingService::DOMAIN_NAMESPACE,
            'TimeStamp'        => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'StatusCode'             => LabellingService::DOMAIN_NAMESPACE,
            'StatusDescription'      => LabellingService::DOMAIN_NAMESPACE,
            'PhaseCode'        => LabellingService::DOMAIN_NAMESPACE,
            'PhaseDescription' => LabellingService::DOMAIN_NAMESPACE,
            'TimeStamp'        => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'StatusCode'             => ShippingStatusService::DOMAIN_NAMESPACE,
            'StatusDescription'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'PhaseCode'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'PhaseDescription' => ShippingStatusService::DOMAIN_NAMESPACE,
            'TimeStamp'        => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'StatusCode'             => DeliveryDateService::DOMAIN_NAMESPACE,
            'StatusDescription'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'PhaseCode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'PhaseDescription' => DeliveryDateService::DOMAIN_NAMESPACE,
            'TimeStamp'        => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'StatusCode'             => LocationService::DOMAIN_NAMESPACE,
            'StatusDescription'      => LocationService::DOMAIN_NAMESPACE,
            'PhaseCode'        => LocationService::DOMAIN_NAMESPACE,
            'PhaseDescription' => LocationService::DOMAIN_NAMESPACE,
            'TimeStamp'        => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'StatusCode'             => TimeframeService::DOMAIN_NAMESPACE,
            'StatusDescription'      => TimeframeService::DOMAIN_NAMESPACE,
            'PhaseCode'        => TimeframeService::DOMAIN_NAMESPACE,
            'PhaseDescription' => TimeframeService::DOMAIN_NAMESPACE,
            'TimeStamp'        => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null $StatusCode */
    protected $StatusCode;
    /** @var string|null $StatusDescription */
    protected $StatusDescription;
    /** @var string|null $PhaseCode */
    protected $PhaseCode;
    /** @var string|null $PhaseDescription */
    protected $PhaseDescription;
    /** @var string|null $TimeStamp */
    protected $TimeStamp;
    // @codingStandardsIgnoreEnd

    /**
     * CompleteStatusResponseOldStatus constructor.
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

        $this->setStatusCode($code);
        $this->setStatusDescription($description);
        $this->setPhaseCode($phaseCode);
        $this->setPhaseDescription($phaseDescription);
        $this->setTimeStamp($timeStamp);
    }
}
