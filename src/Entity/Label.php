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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class Label.
 *
 * @method string|null getContent()
 * @method string|null getContentType()
 * @method string|null getLabeltype()
 * @method Label       setContent(string|null $Content = null)
 * @method Label       setContentType(string|null $ContentType = null)
 * @method Label       setLabeltype(string|null $Labeltype = null)
 *
 * @since 1.0.0
 */
class Label extends AbstractEntity
{
    const FORMAT_A4 = 1;
    const FORMAT_A6 = 2;

    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'Content'     => BarcodeService::DOMAIN_NAMESPACE,
            'ContentType' => BarcodeService::DOMAIN_NAMESPACE,
            'Labeltype'   => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Content'     => ConfirmingService::DOMAIN_NAMESPACE,
            'ContentType' => ConfirmingService::DOMAIN_NAMESPACE,
            'Labeltype'   => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Content'     => LabellingService::DOMAIN_NAMESPACE,
            'ContentType' => LabellingService::DOMAIN_NAMESPACE,
            'Labeltype'   => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Content'     => DeliveryDateService::DOMAIN_NAMESPACE,
            'ContentType' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Labeltype'   => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Content'     => LocationService::DOMAIN_NAMESPACE,
            'ContentType' => LocationService::DOMAIN_NAMESPACE,
            'Labeltype'   => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Content'     => TimeframeService::DOMAIN_NAMESPACE,
            'ContentType' => TimeframeService::DOMAIN_NAMESPACE,
            'Labeltype'   => TimeframeService::DOMAIN_NAMESPACE,
        ],
        'Shipping' => [
            'Content'     => ShippingService::DOMAIN_NAMESPACE,
            'ContentType' => ShippingService::DOMAIN_NAMESPACE,
            'Labeltype'   => ShippingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /**
     * @var string|null
     *
     * Base 64 encoded content
     */
    protected $Content;
    /** @var string|null */
    protected $Contenttype;
    /** @var string|null */
    protected $Labeltype;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null $Content
     * @param string|null $ContentType
     * @param string|null $Labeltype
     */
    public function __construct($Content = null, $ContentType = null, $Labeltype = null)
    {
        parent::__construct();

        $this->setContent($Content);
        $this->setContenttype($ContentType);
        $this->setLabeltype($Labeltype);
    }
}
