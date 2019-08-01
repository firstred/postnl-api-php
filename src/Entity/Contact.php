<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Misc\ValidateAndFix;
use libphonenumber\NumberParseException;
use ReflectionException;
use TypeError;

/**
 * Class Contact
 */
class Contact extends AbstractEntity
{
    /**
     * Type of the contact. This is a code.
     *
     * @pattern ^\d{2}$
     *
     * @example 01
     *
     * @var string|null $contactType
     *
     * @since   1.0.0
     */
    protected $contactType;

    /**
     * Email address of the contact. Mandatory in some cases.
     *
     * @pattern ^.{0,50}$
     *
     * @example receiver@gmail.com
     *
     * @var string|null $email
     *
     * @since   1.0.0
     */
    protected $email;

    /**
     * Mobile phone number of the contact. Mandatory in some cases.
     *
     * @pattern ^.{10,17}$
     *
     * @example 0612345678
     *
     * @var string|null $SMSNr
     *
     * @since   1.0.0
     */
    protected $SMSNr;

    /**
     * Phone number of the contact
     *
     * @pattern ^.{10,17}$
     *
     * @example 0612345678
     *
     * @var string|null $telNr
     *
     * @since   1.0.0
     */
    protected $telNr;

    /**
     * Contact constructor.
     *
     * @param string|null $contactType Contact type
     * @param string|null $email       Email address
     * @param string|null $smsNr       Telephone number (mobile)
     * @param string|null $telNr       Telephone number (fixed line)
     * @param string      $countryCode 2-letter ISO country code for phone formatting
     *
     * @throws TypeError
     * @throws ReflectionException
     * @throws NumberParseException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     */
    public function __construct(?string $contactType = null, ?string $email = null, ?string $smsNr = null, ?string $telNr = null, string $countryCode = 'NL')
    {
        parent::__construct();

        $this->setContactType($contactType);
        $this->setEmail($email);
        $this->setSMSNr($smsNr, $countryCode);
        $this->setTelNr($telNr, $countryCode);
    }

    /**
     * Get contact type
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Contact::$contactType
     */
    public function getContactType(): ?string
    {
        return $this->contactType;
    }

    /**
     * Set contact type
     *
     * @pattern ^\d{2}$
     *
     * @param string|int|null $contactType
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example 01
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Contact::$contactType
     */
    public function setContactType($contactType): Contact
    {
        $this->contactType = ValidateAndFix::contactType($contactType);

        return $this;
    }

    /**
     * Get email
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Contact::$email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @pattern ^.{0,50}$
     *
     * @param string|null $email
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example receiver@gmail.com
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Contact::$email
     */
    public function setEmail(?string $email): Contact
    {
        $this->email = ValidateAndFix::email($email);

        return $this;
    }

    /**
     * Get SMS number
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Contact::$SMSNr
     */
    public function getSMSNr(): ?string
    {
        return $this->SMSNr;
    }

    /**
     * Set SMS number
     *
     * @pattern ^.{10,17}$
     *
     * @param string|null $nr          A telephone number capable of receiving texts, preferably with country prefix
     * @param string      $countryCode 2-letter ISO country code, defaults to NL
     *
     * @return static
     *
     * @throws NumberParseException
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example 0612345678
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Contact::$SMSNr
     */
    public function setSMSNr(?string $nr, string $countryCode = 'NL'): Contact
    {
        $this->SMSNr = ValidateAndFix::telephoneNumber($nr, $countryCode);

        return $this;
    }

    /**
     * Get the telephone number
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Contact::$telNr
     */
    public function getTelNr(): ?string
    {
        return $this->telNr;
    }

    /**
     * Set the telephone number
     *
     * @pattern ^.{10,17}$
     *
     * @param string|null $nr          Telephone number, preferably with country prefix
     * @param string      $countryCode 2-letter ISO country code, defaults to NL
     *
     * @return static
     *
     * @throws NumberParseException
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example 0612345678
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Contact::$telNr
     */
    public function setTelNr(?string $nr, string $countryCode = 'NL'): Contact
    {
        $this->telNr = ValidateAndFix::telephoneNumber($nr, $countryCode);

        return $this;
    }
}
