<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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

namespace ThirtyBees\PostNL\Entity\Message;

use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class LabellingMessage.
 *
 * @method string|null getMessageID()
 * @method string|null getMessageTimeStamp()
 * @method string|null getPrinterType()
 * @method Message     setMessageID(string|null $mid = null)
 * @method Message     setMessageTimeStamp(string|null $timestamp = null)
 * @method Message     setPrinterType(string|null $printerType = null)
 *
 * @since 1.0.0
 */
class LabellingMessage extends Message
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'MessageID'        => BarcodeService::DOMAIN_NAMESPACE,
            'MessageTimeStamp' => BarcodeService::DOMAIN_NAMESPACE,
            'Printertype'      => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'MessageID'        => ConfirmingService::DOMAIN_NAMESPACE,
            'MessageTimeStamp' => ConfirmingService::DOMAIN_NAMESPACE,
            'Printertype'      => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'MessageID'        => LabellingService::DOMAIN_NAMESPACE,
            'MessageTimeStamp' => LabellingService::DOMAIN_NAMESPACE,
            'Printertype'      => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'MessageID'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'MessageTimeStamp' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Printertype'      => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'MessageID'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'MessageTimeStamp' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Printertype'      => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'MessageID'        => LocationService::DOMAIN_NAMESPACE,
            'MessageTimeStamp' => LocationService::DOMAIN_NAMESPACE,
            'Printertype'      => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'MessageID'        => TimeframeService::DOMAIN_NAMESPACE,
            'MessageTimeStamp' => TimeframeService::DOMAIN_NAMESPACE,
            'Printertype'      => TimeframeService::DOMAIN_NAMESPACE,
        ],
        'Shipping' => [
            'MessageID'        => ShippingService::DOMAIN_NAMESPACE,
            'MessageTimeStamp' => ShippingService::DOMAIN_NAMESPACE,
            'Printertype'      => ShippingService::DOMAIN_NAMESPACE,
        ],
    ];
    /**
     * @var string|null
     */
    protected $Printertype;

    /**
     * @param string|null $printerType
     * @param string|null $mid
     * @param string|null $timestamp
     */
    public function __construct(
        $printerType = 'GraphicFile|PDF',
        $mid = null,
        $timestamp = null
    ) {
        parent::__construct($mid, $timestamp);

        $this->setPrintertype($printerType);
    }
}
