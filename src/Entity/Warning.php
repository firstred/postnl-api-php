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

use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class Warning
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string getCode()
 * @method string getDescription()
 *
 * @method Warning setCode(string $code)
 * @method Warning setDescription(string $description)
 */
class Warning extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'Code'        => BarcodeService::DOMAIN_NAMESPACE,
            'Description' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Code'        => ConfirmingService::DOMAIN_NAMESPACE,
            'Description' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Code'        => LabellingService::DOMAIN_NAMESPACE,
            'Description' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Code'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'Description' => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Code'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'Description' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Code'        => LocationService::DOMAIN_NAMESPACE,
            'Description' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Code'        => TimeframeService::DOMAIN_NAMESPACE,
            'Description' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string $Code */
    protected $Code;
    /** @var string $Description */
    protected $Description;
    // @codingStandardsIgnoreEnd

    /**
     * @param string $code
     * @param string $description
     */
    public function __construct($code = null, $description = null)
    {
        parent::__construct();

        $this->setCode($code);
        $this->setDescription($description);
    }
}
