<?php
/**
 * The MIT License (MIT).
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
use ThirtyBees\PostNL\Service\ShippingService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class Contact.
 *
 * @method string|null getContactType()
 * @method string|null getEmail()
 * @method string|null getSMSNr()
 * @method string|null getTelNr()
 * @method Contact     setContactType(string|null $contactType = null)
 * @method Contact     setEmail(string|null $email = null)
 * @method Contact     setSMSNr(string|null $smsNr = null)
 * @method Contact     setTelNr(string|null $telNr = null)
 */
class Contact extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'ContactType' => BarcodeService::DOMAIN_NAMESPACE,
            'Email'       => BarcodeService::DOMAIN_NAMESPACE,
            'SMSNr'       => BarcodeService::DOMAIN_NAMESPACE,
            'TelNr'       => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'ContactType' => ConfirmingService::DOMAIN_NAMESPACE,
            'Email'       => ConfirmingService::DOMAIN_NAMESPACE,
            'SMSNr'       => ConfirmingService::DOMAIN_NAMESPACE,
            'TelNr'       => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'ContactType' => LabellingService::DOMAIN_NAMESPACE,
            'Email'       => LabellingService::DOMAIN_NAMESPACE,
            'SMSNr'       => LabellingService::DOMAIN_NAMESPACE,
            'TelNr'       => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'ContactType' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Email'       => ShippingStatusService::DOMAIN_NAMESPACE,
            'SMSNr'       => ShippingStatusService::DOMAIN_NAMESPACE,
            'TelNr'       => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'ContactType' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Email'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'SMSNr'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'TelNr'       => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'ContactType' => LocationService::DOMAIN_NAMESPACE,
            'Email'       => LocationService::DOMAIN_NAMESPACE,
            'SMSNr'       => LocationService::DOMAIN_NAMESPACE,
            'TelNr'       => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'ContactType' => TimeframeService::DOMAIN_NAMESPACE,
            'Email'       => TimeframeService::DOMAIN_NAMESPACE,
            'SMSNr'       => TimeframeService::DOMAIN_NAMESPACE,
            'TelNr'       => TimeframeService::DOMAIN_NAMESPACE,
        ],
        'Shipping' => [
            'ContactType' => ShippingService::DOMAIN_NAMESPACE,
            'Email'       => ShippingService::DOMAIN_NAMESPACE,
            'SMSNr'       => ShippingService::DOMAIN_NAMESPACE,
            'TelNr'       => ShippingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $ContactType;
    /** @var string|null */
    protected $Email;
    /** @var string|null */
    protected $SMSNr;
    /** @var string|null */
    protected $TelNr;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null $contactType
     * @param string|null $email
     * @param string|null $smsNr
     * @param string|null $telNr
     */
    public function __construct($contactType = null, $email = null, $smsNr = null, $telNr = null)
    {
        parent::__construct();

        $this->setContactType($contactType);
        $this->setEmail($email);
        $this->setSMSNr($smsNr);
        $this->setTelNr($telNr);
    }
}
