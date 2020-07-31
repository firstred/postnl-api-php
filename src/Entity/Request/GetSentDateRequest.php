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

namespace ThirtyBees\PostNL\Entity\Request;

use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Message\Message;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class GetSentDateRequest.
 *
 * @method GetSentDate|null   getGetSentDate()
 * @method Message|null       getMessage()
 * @method GetSentDateRequest setGetSentDate(GetSentDate|null $date = null)
 * @method GetSentDateRequest setMessage(Message|null $message = null)
 */
class GetSentDateRequest extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode' => [
            'GetSentDate' => BarcodeService::DOMAIN_NAMESPACE,
            'Message'     => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'GetSentDate' => ConfirmingService::DOMAIN_NAMESPACE,
            'Message'     => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'GetSentDate' => LabellingService::DOMAIN_NAMESPACE,
            'Message'     => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'GetSentDate' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Message'     => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'GetSentDate' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Message'     => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'GetSentDate' => LocationService::DOMAIN_NAMESPACE,
            'Message'     => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'GetSentDate' => TimeframeService::DOMAIN_NAMESPACE,
            'Message'     => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var GetSentDate|null */
    protected $GetSentDate;
    /** @var Message|null */
    protected $Message;
    // @codingStandardsIgnoreEnd

    /**
     * GetSentDate constructor.
     *
     * @param GetSentDate|null $date
     * @param Message|null     $message
     */
    public function __construct(
        GetSentDate $date = null,
        Message $message = null
    ) {
        parent::__construct();

        $this->setGetSentDate($date);
        $this->setMessage($message ?: new Message());
    }
}
