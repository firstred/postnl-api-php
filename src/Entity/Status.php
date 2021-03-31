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

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class Status.
 *
 * @method string|null            getPhaseCode()
 * @method string|null            getPhaseDescription()
 * @method string|null            getStatusCode()
 * @method string|null            getStatusDescription()
 * @method DateTimeInterface|null getTimeStamp()
 * @method Status                 setPhaseCode(string|null $code = null)
 * @method Status                 setPhaseDescription(string|null $desc = null)
 * @method Status                 setStatusCode(string|null $code = null)
 * @method Status                 setStatusDescription(string|null $desc = null)
 *
 * @since 1.0.0
 */
class Status extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode'        => [
            'PhaseCode'         => BarcodeService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => BarcodeService::DOMAIN_NAMESPACE,
            'StatusCode'        => BarcodeService::DOMAIN_NAMESPACE,
            'StatusDescription' => BarcodeService::DOMAIN_NAMESPACE,
            'TimeStamp'         => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'PhaseCode'         => ConfirmingService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => ConfirmingService::DOMAIN_NAMESPACE,
            'StatusCode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'StatusDescription' => ConfirmingService::DOMAIN_NAMESPACE,
            'TimeStamp'         => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'PhaseCode'         => LabellingService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => LabellingService::DOMAIN_NAMESPACE,
            'StatusCode'        => LabellingService::DOMAIN_NAMESPACE,
            'StatusDescription' => LabellingService::DOMAIN_NAMESPACE,
            'TimeStamp'         => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'PhaseCode'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => ShippingStatusService::DOMAIN_NAMESPACE,
            'StatusCode'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'StatusDescription' => ShippingStatusService::DOMAIN_NAMESPACE,
            'TimeStamp'         => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'PhaseCode'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'StatusCode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'StatusDescription' => DeliveryDateService::DOMAIN_NAMESPACE,
            'TimeStamp'         => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'PhaseCode'         => LocationService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => LocationService::DOMAIN_NAMESPACE,
            'StatusCode'        => LocationService::DOMAIN_NAMESPACE,
            'StatusDescription' => LocationService::DOMAIN_NAMESPACE,
            'TimeStamp'         => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'PhaseCode'         => TimeframeService::DOMAIN_NAMESPACE,
            'PhaseDescription'  => TimeframeService::DOMAIN_NAMESPACE,
            'StatusCode'        => TimeframeService::DOMAIN_NAMESPACE,
            'StatusDescription' => TimeframeService::DOMAIN_NAMESPACE,
            'TimeStamp'         => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $PhaseCode;
    /** @var string|null */
    protected $PhaseDescription;
    /** @var string|null */
    protected $StatusCode;
    /** @var string|null */
    protected $StatusDescription;
    /** @var DateTimeInterface|null */
    protected $TimeStamp;
    // @codingStandardsIgnoreEnd

    /**
     * Status constructor.
     *
     * @param string|null                   $PhaseCode
     * @param string|null                   $PhaseDescription
     * @param string|null                   $StatusCode
     * @param string|null                   $StatusDescription
     * @param string|DateTimeInterface|null $TimeStamp
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        $PhaseCode = null,
        $PhaseDescription = null,
        $StatusCode = null,
        $StatusDescription = null,
        $TimeStamp = null
    ) {
        parent::__construct();

        $this->setPhaseCode($PhaseCode);
        $this->setPhaseDescription($PhaseDescription);
        $this->setStatusCode($StatusCode);
        $this->setStatusDescription($StatusDescription);
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

    /**
     * Backward compatible with SOAP API
     *
     * @return string|null
     *
     * @since 1.2.0
     */
    public function getCurrentStatusPhaseCode()
    {
        return $this->PhaseCode;
    }

    /**
     * Backward compatible with SOAP API
     *
     * @return string|null
     *
     * @since 1.2.0
     */
    public function getCurrentStatusPhaseDescription()
    {
        return $this->PhaseDescription;
    }

    /**
     * Backward compatible with SOAP API
     *
     * @return string|null
     *
     * @since 1.2.0
     */
    public function getCurrentStatusStatusCode()
    {
        return $this->PhaseDescription;
    }

    /**
     * Backward compatible with SOAP API
     *
     * @return string|null
     *
     * @since 1.2.0
     */
    public function getCurrentStatusStatusDescription()
    {
        return $this->PhaseDescription;
    }

    /**
     * Backward compatible with SOAP API
     *
     * @return string|null
     *
     * @since 1.2.0
     */
    public function getCurrentStatusTimeStamp()
    {
        return $this->PhaseDescription;
    }

    /**
     * Backward compatible with SOAP API
     *
     * @return string|null
     *
     * @since 1.2.0
     */
    public function getCompleteStatusPhaseCode()
    {
        return $this->PhaseCode;
    }

    /**
     * Backward compatible with SOAP API
     *
     * @return string|null
     *
     * @since 1.2.0
     */
    public function getCompleteStatusPhaseDescription()
    {
        return $this->PhaseDescription;
    }

    /**
     * Backward compatible with SOAP API
     *
     * @return string|null
     *
     * @since 1.2.0
     */
    public function getCompleteStatusStatusCode()
    {
        return $this->PhaseDescription;
    }

    /**
     * Backward compatible with SOAP API
     *
     * @return string|null
     *
     * @since 1.2.0
     */
    public function getCompleteStatusStatusDescription()
    {
        return $this->PhaseDescription;
    }

    /**
     * Backward compatible with SOAP API
     *
     * @return string|null
     *
     * @since 1.2.0
     */
    public function getCompleteStatusTimeStamp()
    {
        return $this->PhaseDescription;
    }
}
