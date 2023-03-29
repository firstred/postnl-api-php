<?php
declare(strict_types=1);
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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Enum\SoapNamespace;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use function class_exists;
use function is_null;

/**
 * @since 1.0.0
 */
class Contact extends AbstractEntity
{
    /** @var string|null $ContactType */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $ContactType = null;

    /** @var string|null $Email */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Email = null;

    /** @var string|null $SMSNr */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $SMSNr = null;

    /** @var string|null $TelNr */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $TelNr = null;

    /**
     * @param string|null $ContactType
     * @param string|null $Email
     * @param string|null $SMSNr
     * @param string|null $TelNr
     */
    public function __construct(
        ?string $ContactType = null,
        ?string $Email = null,
        ?string $SMSNr = null,
        ?string $TelNr = null,
    ) {
        parent::__construct();

        $this->setContactType(ContactType: $ContactType);
        $this->setEmail(Email: $Email);
        $this->setSMSNr(SMSNr: $SMSNr);
        $this->setTelNr(TelNr: $TelNr);
    }

    /**
     * @return string|null
     */
    public function getContactType(): ?string
    {
        return $this->ContactType;
    }

    /**
     * @param string|null $ContactType
     *
     * @return static
     */
    public function setContactType(?string $ContactType): static
    {
        $this->ContactType = $ContactType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->Email;
    }

    /**
     * @param string|null $Email
     *
     * @return static
     */
    public function setEmail(?string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSMSNr(): ?string
    {
        return $this->SMSNr;
    }

    /**
     * @return string|null
     */
    public function getTelNr(): ?string
    {
        return $this->TelNr;
    }

    /**
     * @since 1.0.0
     * @since 1.2.0 Possibility to auto format number
     */
    public function setTelNr(?string $TelNr = null, ?string $countryCode = null): static
    {
        if (is_null(value: $TelNr)) {
            $this->TelNr = null;
        } else {
            if ($countryCode && class_exists(class: PhoneNumberUtil::class)) {
                $phoneUtil = PhoneNumberUtil::getInstance();
                $parsedNumber = $phoneUtil->parse($TelNr, $countryCode);
                $TelNr = $phoneUtil->format($parsedNumber, PhoneNumberFormat::E164);
            }

            $this->TelNr = $TelNr;
        }

        return $this;
    }

    /**
     * @since 1.0.0
     * @since 1.2.0 Possibility to auto format number
     */
    public function setSMSNr(?string $SMSNr = null, ?string $countryCode = null): static
    {
        if (is_null(value: $SMSNr)) {
            $this->SMSNr = null;
        } else {
            if ($countryCode && class_exists(class: PhoneNumberUtil::class)) {
                $phoneUtil = PhoneNumberUtil::getInstance();
                $parsedNumber = $phoneUtil->parse($SMSNr, $countryCode);
                $SMSNr = $phoneUtil->format($parsedNumber, PhoneNumberFormat::E164);
            }

            $this->SMSNr = $SMSNr;
        }

        return $this;
    }
}
