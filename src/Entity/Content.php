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

namespace ThirtyBees\PostNL\Entity;

use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class Content
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string getCountryOfOrigin()
 * @method string getDescription()
 * @method string getHSTariffNr()
 * @method string getQuantity()
 * @method string getValue()
 * @method string getWeight()
 *
 * @method Content setCountryOfOrigin(string $countryOfOrigin)
 * @method Content setDescription(string $description)
 * @method Content setHSTariffNr(string $hsTariffNr)
 * @method Content setQuantity(string $qty)
 * @method Content setValue(string $val)
 * @method Content setWeight(string $weight)
 */
class Content extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'CountryOfOrigin' => BarcodeService::DOMAIN_NAMESPACE,
            'Description'     => BarcodeService::DOMAIN_NAMESPACE,
            'HSTariffNr'      => BarcodeService::DOMAIN_NAMESPACE,
            'Quantity'        => BarcodeService::DOMAIN_NAMESPACE,
            'Value'           => BarcodeService::DOMAIN_NAMESPACE,
            'Weight'          => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'CountryOfOrigin' => ConfirmingService::DOMAIN_NAMESPACE,
            'Description'     => ConfirmingService::DOMAIN_NAMESPACE,
            'HSTariffNr'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Quantity'        => ConfirmingService::DOMAIN_NAMESPACE,
            'Value'           => ConfirmingService::DOMAIN_NAMESPACE,
            'Weight'          => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'CountryOfOrigin' => LabellingService::DOMAIN_NAMESPACE,
            'Description'     => LabellingService::DOMAIN_NAMESPACE,
            'HSTariffNr'      => LabellingService::DOMAIN_NAMESPACE,
            'Quantity'        => LabellingService::DOMAIN_NAMESPACE,
            'Value'           => LabellingService::DOMAIN_NAMESPACE,
            'Weight'          => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'CountryOfOrigin' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Description'     => ShippingStatusService::DOMAIN_NAMESPACE,
            'HSTariffNr'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'Quantity'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'Value'           => ShippingStatusService::DOMAIN_NAMESPACE,
            'Weight'          => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'CountryOfOrigin' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Description'     => DeliveryDateService::DOMAIN_NAMESPACE,
            'HSTariffNr'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Quantity'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'Value'           => DeliveryDateService::DOMAIN_NAMESPACE,
            'Weight'          => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'CountryOfOrigin' => LocationService::DOMAIN_NAMESPACE,
            'Description'     => LocationService::DOMAIN_NAMESPACE,
            'HSTariffNr'      => LocationService::DOMAIN_NAMESPACE,
            'Quantity'        => LocationService::DOMAIN_NAMESPACE,
            'Value'           => LocationService::DOMAIN_NAMESPACE,
            'Weight'          => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'CountryOfOrigin' => TimeframeService::DOMAIN_NAMESPACE,
            'Description'     => TimeframeService::DOMAIN_NAMESPACE,
            'HSTariffNr'      => TimeframeService::DOMAIN_NAMESPACE,
            'Quantity'        => TimeframeService::DOMAIN_NAMESPACE,
            'Value'           => TimeframeService::DOMAIN_NAMESPACE,
            'Weight'          => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string $CountryOfOrigin */
    protected $CountryOfOrigin;
    /** @var string $Description */
    protected $Description;
    /** @var string $HSTariffNr */
    protected $HSTariffNr;
    /** @var string $Quantity */
    protected $Quantity;
    /** @var string $Value */
    protected $Value;
    /** @var string $Weight */
    protected $Weight;
    // @codingStandardsIgnoreEnd

    /**
     * @param string $countryOfOrigin
     * @param string $description
     * @param string $hsTariffNr
     * @param string $qty
     * @param string $val
     * @param string $weight
     */
    public function __construct(
        $countryOfOrigin = null,
        $description = null,
        $hsTariffNr = null,
        $qty = null,
        $val = null,
        $weight = null
    ) {
        parent::__construct();

        $this->setCountryOfOrigin($countryOfOrigin);
        $this->setDescription($description);
        $this->setHSTariffNr($hsTariffNr);
        $this->setQuantity($qty);
        $this->setValue($val);
        $this->setWeight($weight);
    }
}
