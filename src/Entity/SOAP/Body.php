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

namespace Firstred\PostNL\Entity\SOAP;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Response\GenerateBarcodeResponse;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\LabellingService;

/**
 * Class Body.
 *
 * NOTE: this class has been introduced for deserializing
 *
 * @since 1.0.0
 */
class Body extends AbstractEntity
{
    /** @var array */
    public static $defaultProperties = [
        'Barcode' => [
            'GenerateBarcodeResponse' => BarcodeService::ENVELOPE_NAMESPACE,
        ],
        'Confirming' => [
            'GenerateBarcodeResponse' => ConfirmingService::ENVELOPE_NAMESPACE,
        ],
        'Labelling' => [
            'GenerateBarcodeResponse' => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'ShippingStatus' => [
            'GenerateBarcodeResponse' => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'DeliveryDate' => [
            'GenerateBarcodeResponse' => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'Location' => [
            'GenerateBarcodeResponse' => LabellingService::ENVELOPE_NAMESPACE,
        ],
        'Timeframe' => [
            'GenerateBarcodeResponse' => LabellingService::ENVELOPE_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var GenerateBarcodeResponse|null */
    protected $GenerateBarcodeResponse;
    // @codingStandardsIgnoreEnd
}
