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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class Status.
 *
 * @method string|null            getCurrentPhaseCode()
 * @method string|null            getCurrentPhaseDescription()
 * @method string|null            getCurrentStatusCode()
 * @method string|null            getCurrentStatusDescription()
 * @method DateTimeInterface|null getCurrentStatusTimeStamp()
 * @method Status                 setCurrentPhaseCode(string|null $code = null)
 * @method Status                 setCurrentPhaseDescription(string|null $desc = null)
 * @method Status                 setCurrentStatusCode(string|null $code = null)
 * @method Status                 setCurrentStatusDescription(string|null $desc = null)
 *
 * @since 1.0.0
 */
class Status extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'CurrentPhaseCode'         => BarcodeService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'  => BarcodeService::DOMAIN_NAMESPACE,
            'CurrentStatusCode'        => BarcodeService::DOMAIN_NAMESPACE,
            'CurrentStatusDescription' => BarcodeService::DOMAIN_NAMESPACE,
            'CurrentStatusTimeStamp'   => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'CurrentPhaseCode'         => ConfirmingService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'  => ConfirmingService::DOMAIN_NAMESPACE,
            'CurrentStatusCode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'CurrentStatusDescription' => ConfirmingService::DOMAIN_NAMESPACE,
            'CurrentStatusTimeStamp'   => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
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
        'DeliveryDate' => [
            'CurrentPhaseCode'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'CurrentStatusCode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'CurrentStatusDescription' => DeliveryDateService::DOMAIN_NAMESPACE,
            'CurrentStatusTimeStamp'   => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'CurrentPhaseCode'         => LocationService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'  => LocationService::DOMAIN_NAMESPACE,
            'CurrentStatusCode'        => LocationService::DOMAIN_NAMESPACE,
            'CurrentStatusDescription' => LocationService::DOMAIN_NAMESPACE,
            'CurrentStatusTimeStamp'   => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'CurrentPhaseCode'         => TimeframeService::DOMAIN_NAMESPACE,
            'CurrentPhaseDescription'  => TimeframeService::DOMAIN_NAMESPACE,
            'CurrentStatusCode'        => TimeframeService::DOMAIN_NAMESPACE,
            'CurrentStatusDescription' => TimeframeService::DOMAIN_NAMESPACE,
            'CurrentStatusTimeStamp'   => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $CurrentPhaseCode;
    /** @var string|null */
    protected $CurrentPhaseDescription;
    /** @var string|null */
    protected $CurrentStatusCode;
    /** @var string|null */
    protected $CurrentStatusDescription;
    /** @var DateTimeInterface|null */
    protected $CurrentStatusTimeStamp;
    // @codingStandardsIgnoreEnd

    /**
     * Status contructor.
     *
     * @param string|null                   $phaseCode
     * @param string|null                   $phaseDesc
     * @param string|null                   $statusCode
     * @param string|null                   $statusDesc
     * @param string|DateTimeInterface|null $timeStamp
     *
     * @throws Exception
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

    /**
     * @param string|DateTimeInterface|null $timeStamp
     *
     * @return static
     *
     * @throws Exception
     *
     * @since 1.2.0
     */
    public function setCurrentStatusTimeStamp($timeStamp = null)
    {
        if (is_string($timeStamp)) {
            $timeStamp = new DateTimeImmutable($timeStamp);
        }

        $this->CurrentStatusTimeStamp = $timeStamp;

        return $this;
    }
}
