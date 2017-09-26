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
 * @copyright 2017 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Entity;

use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\LabellingService;

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
        'Content'     => [
            'Barcode'    => BarcodeService::DOMAIN_NAMESPACE,
            'Confirming' => ConfirmingService::DOMAIN_NAMESPACE,
            'Labelling'  => LabellingService::DOMAIN_NAMESPACE,
            ],
        'Contenttype' => [
            'Barcode'    => BarcodeService::DOMAIN_NAMESPACE,
            'Confirming' => ConfirmingService::DOMAIN_NAMESPACE,
            'Labelling'  => LabellingService::DOMAIN_NAMESPACE,
            ],
        'Labeltype'   => [
            'Barcode'    => BarcodeService::DOMAIN_NAMESPACE,
            'Confirming' => ConfirmingService::DOMAIN_NAMESPACE,
            'Labelling'  => LabellingService::DOMAIN_NAMESPACE,
            ],
    ];
    // @codingStandardsIgnoreStart
    /**
     * @var string $Content
     *
     * Base 64 encoded content
     */
    protected $Content = null;
    /** @var string $Contenttype */
    protected $Contenttype = null;
    /** @var string $Labeltype */
    protected $Labeltype = null;
    // @codingStandardsIgnoreEnd

    /**
     * @param string $content
     * @param string $contentType
     * @param string $labelType
     */
    public function __construct($content, $contentType, $labelType)
    {
        parent::__construct();

        $this->setContent($content);
        $this->setContenttype($contentType);
        $this->setLabeltype($labelType);
    }
}
