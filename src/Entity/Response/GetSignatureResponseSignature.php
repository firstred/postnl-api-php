<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2022 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2022 Michael Dekker
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
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class GetSignatureResponseSignature.
 *
 * @method string|null            getBarcode()
 * @method DateTimeInterface|null getSignatureDate()
 * @method string|null            getSignatureImage()
 * @method SignatureResponse      setBarcode(string|null $Barcode = null)
 * @method SignatureResponse      setSignatureImage(string|null $SignatureImage = null)
 *
 * @since 1.0.0
 */
class GetSignatureResponseSignature extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode'        => [
            'Barcode'        => BarcodeService::DOMAIN_NAMESPACE,
            'SignatureDate'  => BarcodeService::DOMAIN_NAMESPACE,
            'SignatureImage' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Barcode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'SignatureDate'  => ConfirmingService::DOMAIN_NAMESPACE,
            'SignatureImage' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Barcode'        => LabellingService::DOMAIN_NAMESPACE,
            'SignatureDate'  => LabellingService::DOMAIN_NAMESPACE,
            'SignatureImage' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Barcode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'SignatureDate'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'SignatureImage' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Barcode'        => LocationService::DOMAIN_NAMESPACE,
            'SignatureDate'  => LocationService::DOMAIN_NAMESPACE,
            'SignatureImage' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Barcode'        => TimeframeService::DOMAIN_NAMESPACE,
            'SignatureDate'  => TimeframeService::DOMAIN_NAMESPACE,
            'SignatureImage' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $Barcode;
    /** @var string|null */
    protected $SignatureDate;
    /** @var string|null */
    protected $SignatureImage;
    // @codingStandardsIgnoreEnd

    /**
     * GetSignatureResponseSignature constructor.
     *
     * @param string|null $Barcode
     * @param string|null $SignatureDate
     * @param string|null $SignatureImage
     *
     * @throws InvalidArgumentException
     */
    public function __construct($Barcode = null, $SignatureDate = null, $SignatureImage = null)
    {
        parent::__construct();

        $this->setBarcode($Barcode);
        $this->setSignatureDate($SignatureDate);
        $this->setSignatureImage($SignatureImage);
    }

    /**
     * @param string|DateTimeInterface|null $SignatureDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setSignatureDate($SignatureDate = null)
    {
        if (is_string($SignatureDate)) {
            try {
                $SignatureDate = new DateTimeImmutable($SignatureDate, new DateTimeZone('Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->SignatureDate = $SignatureDate;

        return $this;
    }
}
