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
 * Class Label
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string getContent()
 * @method string getContentType()
 * @method string getLabelType()
 *
 * @method Label setContent(string $content)
 * @method Label setContentType(string $contentType)
 * @method Label setLabelType(string $labelType)
 */
class Label extends AbstractEntity
{
    const FORMAT_A4 = 1;
    const FORMAT_A6 = 2;

    /** @var string[] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'Content'     => BarcodeService::DOMAIN_NAMESPACE,
            'ContentType' => BarcodeService::DOMAIN_NAMESPACE,
            'Labeltype'   => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Content'     => ConfirmingService::DOMAIN_NAMESPACE,
            'ContentType' => ConfirmingService::DOMAIN_NAMESPACE,
            'Labeltype'   => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Content'     => LabellingService::DOMAIN_NAMESPACE,
            'ContentType' => LabellingService::DOMAIN_NAMESPACE,
            'Labeltype'   => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Content'     => ShippingStatusService::DOMAIN_NAMESPACE,
            'ContentType' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Labeltype'   => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Content'     => DeliveryDateService::DOMAIN_NAMESPACE,
            'ContentType' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Labeltype'   => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Content'     => LocationService::DOMAIN_NAMESPACE,
            'ContentType' => LocationService::DOMAIN_NAMESPACE,
            'Labeltype'   => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Content'     => TimeframeService::DOMAIN_NAMESPACE,
            'ContentType' => TimeframeService::DOMAIN_NAMESPACE,
            'Labeltype'   => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /**
     * @var string $Content
     *
     * Base 64 encoded content
     */
    protected $Content;
    /** @var string $Contenttype */
    protected $Contenttype;
    /** @var string $Labeltype */
    protected $Labeltype;
    // @codingStandardsIgnoreEnd

    /**
     * @param string $content
     * @param string $contentType
     * @param string $labelType
     */
    public function __construct($content = null, $contentType = null, $labelType = null)
    {
        parent::__construct();

        $this->setContent($content);
        $this->setContenttype($contentType);
        $this->setLabeltype($labelType);
    }
}
