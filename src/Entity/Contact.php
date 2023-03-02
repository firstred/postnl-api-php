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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingService;
use Firstred\PostNL\Service\TimeframeService;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use function class_exists;
use function is_null;

/**
 * Class Contact.
 *
 * @method string|null getContactType()
 * @method string|null getEmail()
 * @method string|null getSMSNr()
 * @method string|null getTelNr()
 * @method Contact     setContactType(string|null $ContactType = null)
 * @method Contact     setEmail(string|null $Email = null)
 *
 * @since 1.0.0
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
     * Contact constructor.
     *
     * @param string|null $ContactType
     * @param string|null $Email
     * @param string|null $SMSNr
     * @param string|null $TelNr
     *
     * @throws NumberParseException
     */
    public function __construct($ContactType = null, $Email = null, $SMSNr = null, $TelNr = null)
    {
        parent::__construct();

        $this->setContactType($ContactType);
        $this->setEmail($Email);
        $this->setSMSNr($SMSNr);
        $this->setTelNr($TelNr);
    }

    /**
     * Set the telephone number.
     *
     * @param string|null $TelNr
     * @param string|null $countryCode
     *
     * @return static
     *
     * @throws NumberParseException
     *
     * @since 1.0.0
     * @since 1.2.0 Possibility to auto format number
     */
    public function setTelNr($TelNr = null, $countryCode = null)
    {
        if (is_null($TelNr)) {
            $this->TelNr = null;
        } else {
            if ($countryCode && class_exists(PhoneNumberUtil::class)) {
                $phoneUtil = PhoneNumberUtil::getInstance();
                $parsedNumber = $phoneUtil->parse($TelNr, $countryCode);
                $TelNr = $phoneUtil->format($parsedNumber, PhoneNumberFormat::E164);
            }

            $this->TelNr = $TelNr;
        }

        return $this;
    }

    /**
     * Set the mobile number.
     *
     * @param string|null $SMSNr
     * @param string|null $countryCode
     *
     * @return static
     *
     * @throws NumberParseException
     *
     * @since 1.0.0
     * @since 1.2.0 Possibility to auto format number
     */
    public function setSMSNr($SMSNr = null, $countryCode = null)
    {
        if (is_null($SMSNr)) {
            $this->SMSNr = null;
        } else {
            if ($countryCode && class_exists(PhoneNumberUtil::class)) {
                $phoneUtil = PhoneNumberUtil::getInstance();
                $parsedNumber = $phoneUtil->parse($SMSNr, $countryCode);
                $SMSNr = $phoneUtil->format($parsedNumber, PhoneNumberFormat::E164);
            }

            $this->SMSNr = $SMSNr;
        }

        return $this;
    }
}
