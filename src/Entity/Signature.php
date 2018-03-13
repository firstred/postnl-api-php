<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2018 Thirty Development, LLC
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

use ThirtyBees\PostNL\Entity\Response\GetSignatureResponseSignature;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class Signature
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method GetSignatureResponseSignature|null getGetSignatureResponseSignature()
 * @method Warning[]|null getWarnings()
 *
 * @method Signature setGetSignatureResponseSignature(GetSignatureResponseSignature|null $signature = null)
 * @method Signature setWarnings(Warning[]|null $warnings = null)
 */
class Signature extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'           => [
            'GetSignatureResponseSignature' => BarcodeService::DOMAIN_NAMESPACE,
            'Warnings'                      => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'        => [
            'GetSignatureResponseSignature' => ConfirmingService::DOMAIN_NAMESPACE,
            'Warnings'                      => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'         => [
            'GetSignatureResponseSignature' => LabellingService::DOMAIN_NAMESPACE,
            'Warnings'                      => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingSignature' => [
            'GetSignatureResponseSignature' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Warnings'                      => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'      => [
            'GetSignatureResponseSignature' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Warnings'                      => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'          => [
            'GetSignatureResponseSignature' => LocationService::DOMAIN_NAMESPACE,
            'Warnings'                      => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'         => [
            'GetSignatureResponseSignature' => TimeframeService::DOMAIN_NAMESPACE,
            'Warnings'                      => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var GetSignatureResponseSignature|null $GetSignatureResponseSignature */
    protected $GetSignatureResponseSignature;
    /** @var Warning[]|null $Warnings */
    protected $Warnings;
    // @codingStandardsIgnoreEnd

    public function __construct(
        GetSignatureResponseSignature $signature = null,
        array $warnings = null
    ) {
        parent::__construct();

        $this->setGetSignatureResponseSignature($signature);
        $this->setWarnings($warnings);
    }
}
