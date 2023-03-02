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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingService;
use Firstred\PostNL\Service\TimeframeService;

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
 * @method Content        setCountryOfOrigin(string|null $CountryOfOrigin = null)
 * @method Content        setDescription(string|null $Description = null)
 * @method Content        setHSTariffNr(string|null $HSTariffNr = null)
 * @method Content        setQuantity(string|null $Quantity = null)
 * @method Content        setValue(string|null $Value = null)
 * @method Content        setWeight(string|null $Weight = null)
 * @method Content        setContent(Content[]|null $Content = null)
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
     * @param string|null    $CountryOfOrigin
     * @param string|null    $Description
     * @param string|null    $HSTariffNr
     * @param string|null    $Quantity
     * @param string|null    $Value
     * @param string|null    $Weight
     * @param Content[]|null $Content
     */
    public function __construct(
        $CountryOfOrigin = null,
        $Description = null,
        $HSTariffNr = null,
        $Quantity = null,
        $Value = null,
        $Weight = null,
        $Content = null
    ) {
        parent::__construct();

        $this->setCountryOfOrigin($CountryOfOrigin);
        $this->setDescription($Description);
        $this->setHSTariffNr($HSTariffNr);
        $this->setQuantity($Quantity);
        $this->setValue($Value);
        $this->setWeight($Weight);
        $this->setContent($Content);
    }
}
