<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * *Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\SOAP;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\LabellingService;

/**
 * Class Envelope
 *
 * @method Header|null getHeader()
 * @method Body|null   getBody()
 *
 * @method Envelope setHeader(Header|null $header = null)
 * @method Envelope setBody(Body|null $body = null)
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
        'Barcode'        => [
            'Header' => BarcodeService::ENVELOPE_NAMESPACE,
            'Body'   => BarcodeService::ENVELOPE_NAMESPACE,
        ],
        'Confirming'     => [
            'Header' => ConfirmingService::ENVELOPE_NAMESPACE,
            'Body'   => ConfirmingService::ENVELOPE_NAMESPACE,
        ],
        'Labelling'      => [
            'Header' => LabellingService::ENVELOPE_NAMESPACE,
            'Body'   => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Header' => LabellingService::ENVELOPE_NAMESPACE,
            'Body'   => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Header' => LabellingService::ENVELOPE_NAMESPACE,
            'Body'   => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'Location'       => [
            'Header' => LabellingService::ENVELOPE_NAMESPACE,
            'Body'   => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'Timeframe'      => [
            'Header' => LabellingService::ENVELOPE_NAMESPACE,
            'Body'   => LabellingService::ENVELOPE_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Header|null $Header */
    protected $Header;
    /** @var Body|null $Body */
    protected $Body;
    // @codingStandardsIgnoreEnd

    /**
     * Envelope constructor.
     *
     * @param Header|null $header
     * @param Body|null   $body
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
