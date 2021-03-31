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

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Label;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class ResponseShipment.
 *
 * @method string|null    getBarcode()
 * @method string|null    getProductCodeDelivery()
 * @method string|null    getDownPartnerBarcode()
 * @method string|null    getDownPartnerId()
 * @method string|null    getDownPartnerLocation()
 * @method Label[]|null   getLabels()
 * @method Warning[]|null getWarnings()
 * @method MergedLabel    setBarcode(string|null $Barcode = null)
 * @method MergedLabel    setProductCodeDelivery(string|null $ProductCodeDelivery = null)
 * @method MergedLabel    setDownPartnerBarcode(string|null $DownPartnerCode = null)
 * @method MergedLabel    setDownPartnerId(string|null $DownPartnerID = null)
 * @method MergedLabel    setDownPartnerLocation(string|null $DownPartnerLocation = null)
 * @method MergedLabel    setLabels(Label[]|null $Labels = null)
 * @method MergedLabel    setWarnings(Warning[]|null $Warnings = null)
 *
 * @since 1.0.0
 */
class ResponseShipment extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'Barcode'             => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'  => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerID'       => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerLocation' => BarcodeService::DOMAIN_NAMESPACE,
            'Labels'              => BarcodeService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery' => BarcodeService::DOMAIN_NAMESPACE,
            'Warnings'            => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Barcode'             => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'  => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerID'       => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerLocation' => ConfirmingService::DOMAIN_NAMESPACE,
            'Labels'              => ConfirmingService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery' => ConfirmingService::DOMAIN_NAMESPACE,
            'Warnings'            => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Barcode'             => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'  => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerID'       => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerLocation' => LabellingService::DOMAIN_NAMESPACE,
            'Labels'              => LabellingService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery' => LabellingService::DOMAIN_NAMESPACE,
            'Warnings'            => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Barcode'             => DeliveryDateService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'DownPartnerID'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'DownPartnerLocation' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Labels'              => DeliveryDateService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Warnings'            => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Barcode'             => LocationService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'  => LocationService::DOMAIN_NAMESPACE,
            'DownPartnerID'       => LocationService::DOMAIN_NAMESPACE,
            'DownPartnerLocation' => LocationService::DOMAIN_NAMESPACE,
            'Labels'              => LocationService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery' => LocationService::DOMAIN_NAMESPACE,
            'Warnings'            => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Barcode'             => TimeframeService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'  => TimeframeService::DOMAIN_NAMESPACE,
            'DownPartnerID'       => TimeframeService::DOMAIN_NAMESPACE,
            'DownPartnerLocation' => TimeframeService::DOMAIN_NAMESPACE,
            'Labels'              => TimeframeService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery' => TimeframeService::DOMAIN_NAMESPACE,
            'Warnings'            => TimeframeService::DOMAIN_NAMESPACE,
        ],
        'Shipping' => [
            'Barcode'             => ShippingService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'  => ShippingService::DOMAIN_NAMESPACE,
            'DownPartnerID'       => ShippingService::DOMAIN_NAMESPACE,
            'DownPartnerLocation' => ShippingService::DOMAIN_NAMESPACE,
            'Labels'              => ShippingService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery' => ShippingService::DOMAIN_NAMESPACE,
            'Warnings'            => ShippingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $Barcode;
    /** @var string|null */
    protected $DownPartnerBarcode;
    /** @var string|null */
    protected $DownPartnerID;
    /** @var string|null */
    protected $DownPartnerLocation;
    /** @var Label[]|null */
    protected $Labels;
    /** @var string|null */
    protected $ProductCodeDelivery;
    /** @var Warning[]|null */
    protected $Warnings;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null    $Barcode
     * @param string|null    $ProductCodeDelivery
     * @param Label[]|null   $Labels
     * @param string|null    $DownPartnerBarcode
     * @param string|null    $DownPartnerID
     * @param string|null    $DownPartnerLocation
     * @param Warning[]|null $Warnings
     */
    public function __construct(
        $Barcode = null,
        $ProductCodeDelivery = null,
        array $Labels = null,
        $DownPartnerBarcode = null,
        $DownPartnerID = null,
        $DownPartnerLocation = null,
        $Warnings = null
    ) {
        parent::__construct();

        $this->setBarcode($Barcode);
        $this->setProductCodeDelivery($ProductCodeDelivery);
        $this->setDownPartnerBarcode($DownPartnerBarcode);
        $this->setDownPartnerId($DownPartnerID);
        $this->setDownPartnerLocation($DownPartnerLocation);
        $this->setLabels($Labels);
        $this->setWarnings($Warnings);
    }
}
