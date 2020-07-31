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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Entity\Response;

use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class GenerateBarcodeResponse.
 *
 * @method string|null             getBarcode()
 * @method GenerateBarcodeResponse setBarcode(string|null $shipments = null)
 */
class GenerateBarcodeResponse extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode' => [
            'Barcode' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Barcode' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Barcode' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Barcode' => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Barcode' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Barcode' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Barcode' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $Barcode;
    // @codingStandardsIgnoreEnd

    /**
     * GenerateBarcodeResponse constructor.
     *
     * @param string|null $barcode
     */
    public function __construct($barcode = null)
    {
        parent::__construct();

        $this->setBarcode($barcode);
    }
}
