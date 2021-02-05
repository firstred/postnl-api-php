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

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\LabellingServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Contact.
 */
class Contact extends SerializableObject
{
    #[RequestProp(optionalFor: [LabellingServiceInterface::class])]
    protected string|null $ContactType = null;
    #[RequestProp(optionalFor: [LabellingServiceInterface::class])]
    protected string|null $Email = null;
    #[RequestProp(optionalFor: [LabellingServiceInterface::class])]
    protected string|null $SMSNr = null;
    #[RequestProp(optionalFor: [LabellingServiceInterface::class])]
    protected string|null $TelNr = null;

    /**
     * Contact constructor.
     *
     * @param string      $service
     * @param string      $propType
     * @param string|null $ContactType
     * @param string|null $Email
     * @param string|null $SMSNr
     * @param string|null $TelNr
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        string|null $ContactType = null,
        string|null $Email = null,
        string|null $SMSNr = null,
        string|null $TelNr = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setContactType(ContactType: $ContactType);
        $this->setEmail(Email: $Email);
        $this->setSMSNr(SMSNr: $SMSNr);
        $this->setTelNr(TelNr: $TelNr);
    }

    /**
     * @return string|null
     */
    public function getContactType(): string|null
    {
        return $this->ContactType;
    }

    /**
     * @param string|null $ContactType
     *
     * @return static
     */
    public function setContactType(string|null $ContactType = null): static
    {
        $this->ContactType = $ContactType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): string|null
    {
        return $this->Email;
    }

    /**
     * @param string|null $Email
     *
     * @return static
     */
    public function setEmail(string|null $Email = null): static
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSMSNr(): string|null
    {
        return $this->SMSNr;
    }

    /**
     * @param string|null $SMSNr
     *
     * @return static
     */
    public function setSMSNr(string|null $SMSNr = null): static
    {
        $this->SMSNr = $SMSNr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTelNr(): string|null
    {
        return $this->TelNr;
    }

    /**
     * @param string|null $TelNr
     *
     * @return static
     */
    public function setTelNr(string|null $TelNr = null): static
    {
        $this->TelNr = $TelNr;

        return $this;
    }
}
