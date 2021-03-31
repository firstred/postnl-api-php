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

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Signature;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class SignatureResponse.
 *
 * @method string|null       getSignature()
 * @method SignatureResponse setSignature(Signature|null $Signature = null)
 *
 * @since 1.0.0
 */
class SignatureResponse extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode' => [
            'Signature' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Signature' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Signature' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Signature' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Signature' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Signature' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Signature|null */
    protected $Signature;
    // @codingStandardsIgnoreEnd

    /**
     * SignatureResponse constructor.
     *
     * @param Signature|null $Signature
     */
    public function __construct(Signature $Signature = null)
    {
        parent::__construct();

        $this->setSignature($Signature);
    }
}
