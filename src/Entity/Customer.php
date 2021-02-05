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
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Customer.
 */
class Customer extends SerializableObject
{
    /**
     * Customer constructor.
     *
     * @param string       $service
     * @param string       $propType
     * @param Address|null $Address
     * @param string|null  $CollectionLocation
     * @param string|null  $ContactPerson
     * @param string|null  $CustomerCode
     * @param string|null  $CustomerNumber
     * @param string|null  $GlobalPackCustomerCode
     * @param string|null  $GlobalPackBarcodeType
     * @param string|null  $Email
     * @param string|null  $Name
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        protected Address|null $Address = null,
        protected string|null $CollectionLocation = null,
        protected string|null $ContactPerson = null,
        protected string|null $CustomerCode = null,
        protected string|null $CustomerNumber = null,
        protected string|null $GlobalPackCustomerCode = null,
        protected string|null $GlobalPackBarcodeType = null,
        protected string|null $Email = null,
        protected string|null $Name = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setCustomerNumber(CustomerNumber: $CustomerNumber);
        $this->setCustomerCode(CustomerCode: $CustomerCode);
        $this->setCollectionLocation(CollectionLocation: $CollectionLocation);
        $this->setContactPerson(ContactPerson: $ContactPerson);
        $this->setEmail(Email: $Email);
        $this->setName(Name: $Name);
        $this->setAddress(Address: $Address);
    }

    /**
     * @return Address|null
     */
    public function getAddress(): Address|null
    {
        return $this->Address;
    }

    /**
     * @param Address|null $Address
     *
     * @return static
     */
    public function setAddress(Address|null $Address = null): static
    {
        $this->Address = $Address;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCollectionLocation(): string|null
    {
        return $this->CollectionLocation;
    }

    /**
     * @param string|null $CollectionLocation
     *
     * @return static
     */
    public function setCollectionLocation(string|null $CollectionLocation = null): static
    {
        $this->CollectionLocation = $CollectionLocation;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContactPerson(): string|null
    {
        return $this->ContactPerson;
    }

    /**
     * @param string|null $ContactPerson
     *
     * @return static
     */
    public function setContactPerson(string|null $ContactPerson = null): static
    {
        $this->ContactPerson = $ContactPerson;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerCode(): string|null
    {
        return $this->CustomerCode;
    }

    /**
     * @param string|null $CustomerCode
     *
     * @return static
     */
    public function setCustomerCode(string|null $CustomerCode = null): static
    {
        $this->CustomerCode = $CustomerCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerNumber(): string|null
    {
        return $this->CustomerNumber;
    }

    /**
     * @param string|null $CustomerNumber
     *
     * @return static
     */
    public function setCustomerNumber(string|null $CustomerNumber = null): static
    {
        $this->CustomerNumber = $CustomerNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGlobalPackCustomerCode(): string|null
    {
        return $this->GlobalPackCustomerCode;
    }

    /**
     * @param string|null $GlobalPackCustomerCode
     *
     * @return static
     */
    public function setGlobalPackCustomerCode(string|null $GlobalPackCustomerCode = null): static
    {
        $this->GlobalPackCustomerCode = $GlobalPackCustomerCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGlobalPackBarcodeType(): string|null
    {
        return $this->GlobalPackBarcodeType;
    }

    /**
     * @param string|null $GlobalPackBarcodeType
     *
     * @return static
     */
    public function setGlobalPackBarcodeType(string|null $GlobalPackBarcodeType = null): static
    {
        $this->GlobalPackBarcodeType = $GlobalPackBarcodeType;

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
    public function getName(): string|null
    {
        return $this->Name;
    }

    /**
     * @param string|null $Name
     *
     * @return static
     */
    public function setName(string|null $Name = null): static
    {
        $this->Name = $Name;

        return $this;
    }
}
