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
 * @method Body|null   getBody()
 *
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
            'Body' => BarcodeService::ENVELOPE_NAMESPACE,
        ],
        'Confirming'     => [
            'Body' => ConfirmingService::ENVELOPE_NAMESPACE,
        ],
        'Labelling'      => [
            'Body' => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Body' => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Body' => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'Location'       => [
            'Body' => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'Timeframe'      => [
            'Body' => LabellingService::ENVELOPE_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Body|null $Body */
    protected $Body;
    // @codingStandardsIgnoreEnd

    /**
     * Envelope constructor.
     *
     * @param Body|null $body
     *
     * @since 1.0.0
     */
    public function __construct(Body $body = null)
    {
        parent::__construct();

        if ($body) {
            $this->setBody($body);
        }
    }
}
