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

namespace ThirtyBees\PostNL\Entity\Message;

use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class LabellingMessage
 *
 * @package ThirtyBees\PostNL\Entity\Message
 *
 * @method string getMessageID()
 * @method string getMessageTimeStamp()
 * @method string getPrinterType()
 *
 * @method Message setMessageID(string $mid)
 * @method Message setMessageTimeStamp(string $timestamp)
 * @method Message setPrinterType(string $printerType)
 */
class LabellingMessage extends Message
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'MessageID'        => BarcodeService::DOMAIN_NAMESPACE,
            'MessageTimeStamp' => BarcodeService::DOMAIN_NAMESPACE,
            'Printertype'      => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'MessageID'        => ConfirmingService::DOMAIN_NAMESPACE,
            'MessageTimeStamp' => ConfirmingService::DOMAIN_NAMESPACE,
            'Printertype'      => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'MessageID'        => LabellingService::DOMAIN_NAMESPACE,
            'MessageTimeStamp' => LabellingService::DOMAIN_NAMESPACE,
            'Printertype'      => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'MessageID'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'MessageTimeStamp' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Printertype'      => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'MessageID'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'MessageTimeStamp' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Printertype'      => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'MessageID'        => LocationService::DOMAIN_NAMESPACE,
            'MessageTimeStamp' => LocationService::DOMAIN_NAMESPACE,
            'Printertype'      => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'MessageID'        => TimeframeService::DOMAIN_NAMESPACE,
            'MessageTimeStamp' => TimeframeService::DOMAIN_NAMESPACE,
            'Printertype'      => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    /**
     * @var string $Printertype
     */
    protected $Printertype;

    /**
     * @param string $printerType
     * @param string $mid
     * @param string $timestamp
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
