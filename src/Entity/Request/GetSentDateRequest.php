<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;
use JetBrains\PhpStorm\Deprecated;

/**
 * Class GetSentDateRequest.
 *
 * @method GetSentDate|null   getGetSentDate()
 * @method GetSentDateRequest setGetSentDate(GetSentDate|null $GetSentDate = null)
 *
 * @since 1.0.0
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
    /**
     * @var Message|null
     * @deprecated 1.4.1 SOAP support is going to be removed
     */
    #[Deprecated]
    protected $Message;
    // @codingStandardsIgnoreEnd

    /**
     * GetSentDate constructor.
     *
     * @param GetSentDate|null $GetSentDate
     * @param Message|null     $Message
     */
    public function __construct(
        GetSentDate $GetSentDate = null,
        #[Deprecated]
        Message $Message = null
    ) {
        parent::__construct();

        $this->setGetSentDate($GetSentDate);

        if ($Message instanceof Message) {
            PostNL::triggerDeprecation(
                'firstred/postnl-api-php',
                '1.4.1',
                'Please do not pass a `Message` object. SOAP support is going to be removed.'
            );
        }
        $this->setMessage($Message ?: new Message());
    }

    /**
     * @return Message|null
     *
     * @deprecated 1.4.1 SOAP support is going to be removed
     */
    #[Deprecated]
    public function getMessage()
    {
        return $this->Message;
    }

    /**
     * @param Message|null $Message
     *
     * @return static
     *
     * @deprecated 1.4.1 SOAP support is going to be removec
     */
    #[Deprecated]
    public function setMessage($Message)
    {
        $this->Message = $Message;

        return $this;
    }
}
