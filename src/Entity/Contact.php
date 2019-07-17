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

/**
 * Class Contact
 */
class Contact extends AbstractEntity
{
    /** @var string|null $contactType */
    protected $contactType;
    /** @var string|null $email */
    protected $email;
    /** @var string|null $SMSNr */
    protected $SMSNr;
    /** @var string|null $telNr */
    protected $telNr;

    /**
     * @param string|null $contactType
     * @param string|null $email
     * @param string|null $smsNr
     * @param string|null $telNr
     */
    public function __construct(?string $contactType = null, ?string $email = null, ?string $smsNr = null, ?string $telNr = null)
    {
        parent::__construct();

        $this->setContactType($contactType);
        $this->setEmail($email);
        $this->setSMSNr($smsNr);
        $this->setTelNr($telNr);
    }

    /**
     * @return string|null
     */
    public function getContactType(): ?string
    {
        return $this->contactType;
    }

    /**
     * @param string|null $contactType
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setContactType(?string $contactType): Contact
    {
        $this->contactType = $contactType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setEmail(?string $email): Contact
    {
        $this->email = $email;

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
     * @param string|null $SMSNr
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setSMSNr(?string $SMSNr): Contact
    {
        $this->SMSNr = $SMSNr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTelNr(): ?string
    {
        return $this->telNr;
    }

    /**
     * @param string|null $telNr
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setTelNr(?string $telNr): Contact
    {
        $this->telNr = $telNr;

        return $this;
    }
}
