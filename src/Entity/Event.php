<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
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

use Sabre\Xml\Writer;
use ThirtyBees\PostNL\Entity\Response\CompleteStatusResponseEvent;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class Event
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string getCompleteStatusResponseEvent()
 *
 * @method Event setCompleteStatusResponseEvent(CompleteStatusResponseEvent|null $event)
 */
class Event extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'CompleteStatusResponseEvent' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'CompleteStatusResponseEvent' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'CompleteStatusResponseEvent' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'CompleteStatusResponseEvent' => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'CompleteStatusResponseEvent' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'CompleteStatusResponseEvent' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'CompleteStatusResponseEvent' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var CompleteStatusResponseEvent $completeStatusResponseEvent */
    protected $CompleteStatusResponseEvent;
    // @codingStandardsIgnoreEnd

    /**
     * @param CompleteStatusResponseEvent|null $completeStatusResponseEvent
     */
    public function __construct($completeStatusResponseEvent = null)
    {
        parent::__construct();

        $this->setCompleteStatusResponseEvent($completeStatusResponseEvent);
    }
}
