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

use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class Dimension.
 *
 * @method string|null getHeight()
 * @method string|null getLength()
 * @method string|null getVolume()
 * @method string|null getWeight()
 * @method string|null getWidth()
 * @method Dimension   setHeight(string|null $Height = null)
 * @method Dimension   setLength(string|null $Length = null)
 * @method Dimension   setVolume(string|null $Volume = null)
 * @method Dimension   setWeight(string|null $Weight = null)
 * @method Dimension   setWidth(string|null $Width = null)
 *
 * @since 1.0.0
 */
class Dimension extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'Height' => BarcodeService::DOMAIN_NAMESPACE,
            'Length' => BarcodeService::DOMAIN_NAMESPACE,
            'Volume' => BarcodeService::DOMAIN_NAMESPACE,
            'Weight' => BarcodeService::DOMAIN_NAMESPACE,
            'Width'  => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Height' => ConfirmingService::DOMAIN_NAMESPACE,
            'Length' => ConfirmingService::DOMAIN_NAMESPACE,
            'Volume' => ConfirmingService::DOMAIN_NAMESPACE,
            'Weight' => ConfirmingService::DOMAIN_NAMESPACE,
            'Width'  => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Height' => LabellingService::DOMAIN_NAMESPACE,
            'Length' => LabellingService::DOMAIN_NAMESPACE,
            'Volume' => LabellingService::DOMAIN_NAMESPACE,
            'Weight' => LabellingService::DOMAIN_NAMESPACE,
            'Width'  => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Height' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Length' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Volume' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Weight' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Width'  => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Height' => LocationService::DOMAIN_NAMESPACE,
            'Length' => LocationService::DOMAIN_NAMESPACE,
            'Volume' => LocationService::DOMAIN_NAMESPACE,
            'Weight' => LocationService::DOMAIN_NAMESPACE,
            'Width'  => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Height' => TimeframeService::DOMAIN_NAMESPACE,
            'Length' => TimeframeService::DOMAIN_NAMESPACE,
            'Volume' => TimeframeService::DOMAIN_NAMESPACE,
            'Weight' => TimeframeService::DOMAIN_NAMESPACE,
            'Width'  => TimeframeService::DOMAIN_NAMESPACE,
        ],
        'Shipping' => [
            'Height' => ShippingService::DOMAIN_NAMESPACE,
            'Length' => ShippingService::DOMAIN_NAMESPACE,
            'Volume' => ShippingService::DOMAIN_NAMESPACE,
            'Weight' => ShippingService::DOMAIN_NAMESPACE,
            'Width'  => ShippingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $Height;
    /** @var string|null */
    protected $Length;
    /** @var string|null */
    protected $Volume;
    /** @var string|null */
    protected $Weight;
    /** @var string|null */
    protected $Width;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null $Weight
     * @param string|null $Height
     * @param string|null $Length
     * @param string|null $Volume
     * @param string|null $Width
     */
    public function __construct($Weight = null, $Height = null, $Length = null, $Volume = null, $Width = null)
    {
        parent::__construct();

        $this->setWeight($Weight);

        // Optional parameters.
        $this->setHeight($Height);
        $this->setLength($Length);
        $this->setVolume($Volume);
        $this->setWidth($Width);
    }
}
