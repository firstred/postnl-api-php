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

namespace Firstred\PostNL\Entity\SOAP;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\LabellingService;
use JetBrains\PhpStorm\Deprecated;

/**
 * Class Envelope.
 *
 * @method Header|null getHeader()
 * @method Body|null   getBody()
 * @method Envelope    setHeader(Header|null $Header = null)
 * @method Envelope    setBody(Body|null $Body = null)
 *
 * NOTE: this class has been introduced for deserializing
 *
 * @since 1.0.0
 * @deprecated 1.4.1 SOAP support is going to be removed
 */
#[Deprecated]
class Envelope extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode' => [
            'Header' => BarcodeService::ENVELOPE_NAMESPACE,
            'Body'   => BarcodeService::ENVELOPE_NAMESPACE,
        ],
        'Confirming' => [
            'Header' => ConfirmingService::ENVELOPE_NAMESPACE,
            'Body'   => ConfirmingService::ENVELOPE_NAMESPACE,
        ],
        'Labelling' => [
            'Header' => LabellingService::ENVELOPE_NAMESPACE,
            'Body'   => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Header' => LabellingService::ENVELOPE_NAMESPACE,
            'Body'   => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Header' => LabellingService::ENVELOPE_NAMESPACE,
            'Body'   => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'Location' => [
            'Header' => LabellingService::ENVELOPE_NAMESPACE,
            'Body'   => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'Timeframe' => [
            'Header' => LabellingService::ENVELOPE_NAMESPACE,
            'Body'   => LabellingService::ENVELOPE_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Header|null */
    protected $Header;
    /** @var Body|null */
    protected $Body;
    // @codingStandardsIgnoreEnd

    /**
     * Envelope constructor.
     *
     * @param Header|null $Header
     * @param Body|null   $Body
     */
    public function __construct(Header $Header = null, Body $Body = null)
    {
        parent::__construct();

        if ($Header) {
            $this->setHeader($Header);
        }
        if ($Body) {
            $this->setBody($Body);
        }
    }
}
