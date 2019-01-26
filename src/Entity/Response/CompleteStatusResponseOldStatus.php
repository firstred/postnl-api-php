<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * *Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class CompleteStatusResponseOldStatus
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
            'StatusCode'        => BarcodeService::DOMAIN_NAMESPACE,
            'StatusDescription' => BarcodeService::DOMAIN_NAMESPACE,
            'PhaseCode'         => BarcodeService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => BarcodeService::DOMAIN_NAMESPACE,
            'TimeStamp'         => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'StatusCode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'StatusDescription' => ConfirmingService::DOMAIN_NAMESPACE,
            'PhaseCode'         => ConfirmingService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => ConfirmingService::DOMAIN_NAMESPACE,
            'TimeStamp'         => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'StatusCode'        => LabellingService::DOMAIN_NAMESPACE,
            'StatusDescription' => LabellingService::DOMAIN_NAMESPACE,
            'PhaseCode'         => LabellingService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => LabellingService::DOMAIN_NAMESPACE,
            'TimeStamp'         => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'StatusCode'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'StatusDescription' => ShippingStatusService::DOMAIN_NAMESPACE,
            'PhaseCode'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => ShippingStatusService::DOMAIN_NAMESPACE,
            'TimeStamp'         => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'StatusCode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'StatusDescription' => DeliveryDateService::DOMAIN_NAMESPACE,
            'PhaseCode'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'TimeStamp'         => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'StatusCode'        => LocationService::DOMAIN_NAMESPACE,
            'StatusDescription' => LocationService::DOMAIN_NAMESPACE,
            'PhaseCode'         => LocationService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => LocationService::DOMAIN_NAMESPACE,
            'TimeStamp'         => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'StatusCode'        => TimeframeService::DOMAIN_NAMESPACE,
            'StatusDescription' => TimeframeService::DOMAIN_NAMESPACE,
            'PhaseCode'         => TimeframeService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => TimeframeService::DOMAIN_NAMESPACE,
            'TimeStamp'         => TimeframeService::DOMAIN_NAMESPACE,
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
     *
     * @since 1.0.0
     */
    public function __construct(?string $code = null, ?string $description = null, ?string $phaseCode = null, ?string $phaseDescription = null, ?string $timeStamp = null)
    {
        parent::__construct();

        $this->setStatusCode($code);
        $this->setStatusDescription($description);
        $this->setPhaseCode($phaseCode);
        $this->setPhaseDescription($phaseDescription);
        $this->setTimeStamp($timeStamp);
    }
}
