<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Response;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Status;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class CompleteStatusResponse.
 *
 * @method string|null              getBarcode()
 * @method DateTimeInterface|null   getCreationDate()
 * @method string|null              getCustomerNumber()
 * @method string|null              getCustomerCode()
 * @method Status|null              getStatus()
 * @method UpdatedShipmentsResponse setBarcode(string $Barcode = null)
 * @method UpdatedShipmentsResponse setCustomerNumber(string $CustomerNumber = null)
 * @method UpdatedShipmentsResponse setCustomerCode(string $CustomerCode = null)
 * @method UpdatedShipmentsResponse setStatus(Status $Status = null)
 *
 * @since 1.2.0
 */
class UpdatedShipmentsResponse extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode'        => [
            'Barcode'        => BarcodeService::DOMAIN_NAMESPACE,
            'CreationDate'   => BarcodeService::DOMAIN_NAMESPACE,
            'CustomerNumber' => BarcodeService::DOMAIN_NAMESPACE,
            'CustomerCode'   => BarcodeService::DOMAIN_NAMESPACE,
            'Status'         => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Barcode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'CreationDate'   => ConfirmingService::DOMAIN_NAMESPACE,
            'CustomerNumber' => ConfirmingService::DOMAIN_NAMESPACE,
            'CustomerCode'   => ConfirmingService::DOMAIN_NAMESPACE,
            'Status'         => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Barcode'        => LabellingService::DOMAIN_NAMESPACE,
            'CreationDate'   => LabellingService::DOMAIN_NAMESPACE,
            'CustomerNumber' => LabellingService::DOMAIN_NAMESPACE,
            'CustomerCode'   => LabellingService::DOMAIN_NAMESPACE,
            'Status'         => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Barcode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'CreationDate'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'CustomerNumber' => DeliveryDateService::DOMAIN_NAMESPACE,
            'CustomerCode'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'Status'         => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Barcode'        => LocationService::DOMAIN_NAMESPACE,
            'CreationDate'   => LocationService::DOMAIN_NAMESPACE,
            'CustomerNumber' => LocationService::DOMAIN_NAMESPACE,
            'CustomerCode'   => LocationService::DOMAIN_NAMESPACE,
            'Status'         => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Barcode'        => TimeframeService::DOMAIN_NAMESPACE,
            'CreationDate'   => TimeframeService::DOMAIN_NAMESPACE,
            'CustomerNumber' => TimeframeService::DOMAIN_NAMESPACE,
            'CustomerCode'   => TimeframeService::DOMAIN_NAMESPACE,
            'Status'         => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $Barcode;
    /** @var DateTimeInterface|null */
    protected $CreationDate;
    /** @var string|null */
    protected $CustomerNumber;
    /** @var string|null */
    protected $CustomerCode;
    /** @var Status|null */
    protected $Status;
    // @codingStandardsIgnoreEnd


    /**
     * UpdatedShipmentsResponse constructor.
     *
     * @param string|null $Barcode
     * @param string|DateTimeInterface|null $CreationDate
     * @param string|null $CustomerNumber
     * @param string|null $CustomerCode
     * @param Status|null $Status
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        $Barcode = null,
        $CreationDate = null,
        $CustomerNumber = null,
        $CustomerCode = null,
        $Status = null
    ) {
        parent::__construct();

        $this->setBarcode($Barcode);
        $this->setCreationDate($CreationDate);
        $this->setCustomerNumber($CustomerNumber);
        $this->setCustomerCode($CustomerCode);
        $this->setStatus($Status);
    }

    /**
     * @param string|DateTimeInterface|null $CreationDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setCreationDate($CreationDate = null)
    {
        if (is_string($CreationDate)) {
            try {
                $CreationDate = new DateTimeImmutable($CreationDate, new DateTimeZone('Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->CreationDate = $CreationDate;

        return $this;
    }
}
