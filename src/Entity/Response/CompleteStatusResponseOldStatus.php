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

namespace Firstred\PostNL\Entity\Response;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;
use function is_string;

/**
 * Class CompleteStatusResponseOldStatus.
 *
 * @method string|null                     getStatusCode()
 * @method string|null                     getStatusDescription()
 * @method string|null                     getPhaseCode()
 * @method string|null                     getPhaseDescription()
 * @method DateTimeInterface|null          getTimeStamp()
 * @method CompleteStatusResponseOldStatus setStatusCode(string|null $StatusCode = null)
 * @method CompleteStatusResponseOldStatus setStatusDescription(string|null $StatusDescription = null)
 * @method CompleteStatusResponseOldStatus setPhaseCode(string|null $PhaseCode = null)
 * @method CompleteStatusResponseOldStatus setPhaseDescription(string|null $PhaseDescription = null)
 *
 * @since 1.0.0
 */
class CompleteStatusResponseOldStatus extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode' => [
            'StatusCode'        => BarcodeService::DOMAIN_NAMESPACE,
            'StatusDescription' => BarcodeService::DOMAIN_NAMESPACE,
            'PhaseCode'         => BarcodeService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => BarcodeService::DOMAIN_NAMESPACE,
            'TimeStamp'         => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'StatusCode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'StatusDescription' => ConfirmingService::DOMAIN_NAMESPACE,
            'PhaseCode'         => ConfirmingService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => ConfirmingService::DOMAIN_NAMESPACE,
            'TimeStamp'         => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
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
        'DeliveryDate' => [
            'StatusCode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'StatusDescription' => DeliveryDateService::DOMAIN_NAMESPACE,
            'PhaseCode'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'TimeStamp'         => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'StatusCode'        => LocationService::DOMAIN_NAMESPACE,
            'StatusDescription' => LocationService::DOMAIN_NAMESPACE,
            'PhaseCode'         => LocationService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => LocationService::DOMAIN_NAMESPACE,
            'TimeStamp'         => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'StatusCode'        => TimeframeService::DOMAIN_NAMESPACE,
            'StatusDescription' => TimeframeService::DOMAIN_NAMESPACE,
            'PhaseCode'         => TimeframeService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => TimeframeService::DOMAIN_NAMESPACE,
            'TimeStamp'         => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $StatusCode;
    /** @var string|null */
    protected $StatusDescription;
    /** @var string|null */
    protected $PhaseCode;
    /** @var string|null */
    protected $PhaseDescription;
    /** @var DateTimeInterface|null */
    protected $TimeStamp;
    // @codingStandardsIgnoreEnd

    /**
     * CompleteStatusResponseOldStatus constructor.
     *
     * @param string|null                   $StatusCode
     * @param string|null                   $StatusDescription
     * @param string|null                   $PhaseCode
     * @param string|null                   $PhaseDescription
     * @param DateTimeInterface|string|null $TimeStamp
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        $StatusCode = null,
        $StatusDescription = null,
        $PhaseCode = null,
        $PhaseDescription = null,
        $TimeStamp = null
    ) {
        parent::__construct();

        $this->setStatusCode($StatusCode);
        $this->setStatusDescription($StatusDescription);
        $this->setPhaseCode($PhaseCode);
        $this->setPhaseDescription($PhaseDescription);
        $this->setTimeStamp($TimeStamp);
    }

    /**
     * @param string|DateTimeInterface|null $TimeStamp
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setTimeStamp($TimeStamp = null)
    {
        if (is_string($TimeStamp)) {
            try {
                $TimeStamp = new DateTimeImmutable($TimeStamp, new DateTimeZone('Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->TimeStamp = $TimeStamp;

        return $this;
    }
}
