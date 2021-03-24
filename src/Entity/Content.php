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

use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class Content.
 *
 * @method string|null    getCountryOfOrigin()
 * @method string|null    getDescription()
 * @method string|null    getHSTariffNr()
 * @method string|null    getQuantity()
 * @method string|null    getValue()
 * @method string|null    getWeight()
 * @method Content[]|null getContent()
 * @method Content        setCountryOfOrigin(string|null $countryOfOrigin = null)
 * @method Content        setDescription(string|null $description = null)
 * @method Content        setHSTariffNr(string|null $hsTariffNr = null)
 * @method Content        setQuantity(string|null $qty = null)
 * @method Content        setValue(string|null $val = null)
 * @method Content        setWeight(string|null $weight = null)
 * @method Content        setContent(Content[]|null $content = null)
 *
 * @since 1.0.0
 */
class Content extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'CountryOfOrigin' => BarcodeService::DOMAIN_NAMESPACE,
            'Description'     => BarcodeService::DOMAIN_NAMESPACE,
            'HSTariffNr'      => BarcodeService::DOMAIN_NAMESPACE,
            'Quantity'        => BarcodeService::DOMAIN_NAMESPACE,
            'Value'           => BarcodeService::DOMAIN_NAMESPACE,
            'Weight'          => BarcodeService::DOMAIN_NAMESPACE,
            'Content'         => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'CountryOfOrigin' => ConfirmingService::DOMAIN_NAMESPACE,
            'Description'     => ConfirmingService::DOMAIN_NAMESPACE,
            'HSTariffNr'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Quantity'        => ConfirmingService::DOMAIN_NAMESPACE,
            'Value'           => ConfirmingService::DOMAIN_NAMESPACE,
            'Weight'          => ConfirmingService::DOMAIN_NAMESPACE,
            'Content'         => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'CountryOfOrigin' => LabellingService::DOMAIN_NAMESPACE,
            'Description'     => LabellingService::DOMAIN_NAMESPACE,
            'HSTariffNr'      => LabellingService::DOMAIN_NAMESPACE,
            'Quantity'        => LabellingService::DOMAIN_NAMESPACE,
            'Value'           => LabellingService::DOMAIN_NAMESPACE,
            'Weight'          => LabellingService::DOMAIN_NAMESPACE,
            'Content'         => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'CountryOfOrigin' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Description'     => ShippingStatusService::DOMAIN_NAMESPACE,
            'HSTariffNr'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'Quantity'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'Value'           => ShippingStatusService::DOMAIN_NAMESPACE,
            'Weight'          => ShippingStatusService::DOMAIN_NAMESPACE,
            'Content'         => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'CountryOfOrigin' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Description'     => DeliveryDateService::DOMAIN_NAMESPACE,
            'HSTariffNr'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Quantity'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'Value'           => DeliveryDateService::DOMAIN_NAMESPACE,
            'Weight'          => DeliveryDateService::DOMAIN_NAMESPACE,
            'Content'         => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'CountryOfOrigin' => LocationService::DOMAIN_NAMESPACE,
            'Description'     => LocationService::DOMAIN_NAMESPACE,
            'HSTariffNr'      => LocationService::DOMAIN_NAMESPACE,
            'Quantity'        => LocationService::DOMAIN_NAMESPACE,
            'Value'           => LocationService::DOMAIN_NAMESPACE,
            'Weight'          => LocationService::DOMAIN_NAMESPACE,
            'Content'         => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'CountryOfOrigin' => TimeframeService::DOMAIN_NAMESPACE,
            'Description'     => TimeframeService::DOMAIN_NAMESPACE,
            'HSTariffNr'      => TimeframeService::DOMAIN_NAMESPACE,
            'Quantity'        => TimeframeService::DOMAIN_NAMESPACE,
            'Value'           => TimeframeService::DOMAIN_NAMESPACE,
            'Weight'          => TimeframeService::DOMAIN_NAMESPACE,
            'Content'         => TimeframeService::DOMAIN_NAMESPACE,
        ],
        'Shipping' => [
            'CountryOfOrigin' => ShippingService::DOMAIN_NAMESPACE,
            'Description'     => ShippingService::DOMAIN_NAMESPACE,
            'HSTariffNr'      => ShippingService::DOMAIN_NAMESPACE,
            'Quantity'        => ShippingService::DOMAIN_NAMESPACE,
            'Value'           => ShippingService::DOMAIN_NAMESPACE,
            'Weight'          => ShippingService::DOMAIN_NAMESPACE,
            'Content'         => ShippingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $CountryOfOrigin;
    /** @var string|null */
    protected $Description;
    /** @var string|null */
    protected $HSTariffNr;
    /** @var string|null */
    protected $Quantity;
    /** @var string|null */
    protected $Value;
    /** @var string|null */
    protected $Weight;
    /** @var Content[]|null */
    protected $Content;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null    $countryOfOrigin
     * @param string|null    $description
     * @param string|null    $hsTariffNr
     * @param string|null    $qty
     * @param string|null    $val
     * @param string|null    $weight
     * @param Content[]|null $content
     */
    public function __construct(
        $countryOfOrigin = null,
        $description = null,
        $hsTariffNr = null,
        $qty = null,
        $val = null,
        $weight = null,
        $content = null
    ) {
        parent::__construct();

        $this->setCountryOfOrigin($countryOfOrigin);
        $this->setDescription($description);
        $this->setHSTariffNr($hsTariffNr);
        $this->setQuantity($qty);
        $this->setValue($val);
        $this->setWeight($weight);
        $this->setContent($content);
    }
}
