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

namespace ThirtyBees\PostNL\Entity\SOAP;

use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\LabellingService;

/**
 * Class GenerateLabel
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method Header getHeader()
 * @method Body   getBody()
 *
 * @method Envelope setHeader(Header $header)
 * @method Envelope setBody(Body $body)
 *
 * NOTE: this class has been introduced for deserializing
 */
class Envelope extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API
     *
     * @var array $defaultProperties
     */
    public static $defaultProperties = [
        'Barcode'    => [
            'Header' => BarcodeService::ENVELOPE_NAMESPACE,
            'Body'   => BarcodeService::ENVELOPE_NAMESPACE,
        ],
        'Confirming' => [
            'Header' => ConfirmingService::ENVELOPE_NAMESPACE,
            'Body'   => ConfirmingService::ENVELOPE_NAMESPACE,
        ],
        'Labelling'  => [
            'Header' => LabellingService::ENVELOPE_NAMESPACE,
            'Body'   => LabellingService::ENVELOPE_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Header $Header */
    public $Header;
    /** @var Body $Body */
    public $Body;
    // @codingStandardsIgnoreEnd

    /**
     * LabelRequest constructor.
     *
     * @param Header $header
     * @param Body   $body
     */
    public function __construct(Header $header = null, Body $body = null)
    {
        parent::__construct();

        if ($header) {
            $this->setHeader($header);
        }
        if ($body) {
            $this->setBody($body);
        }
    }
}
