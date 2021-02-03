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
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

class Customer extends SerializableObject
{
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        protected ?Address $Address = null,
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

    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    public function setAddress(?Address $Address = null): static
    {
        $this->Address = $Address;

        return $this;
    }

    public function getCollectionLocation(): string|null
    {
        return $this->CollectionLocation;
    }

    public function setCollectionLocation(string|null $CollectionLocation = null): static
    {
        $this->CollectionLocation = $CollectionLocation;

        return $this;
    }

    public function getContactPerson(): string|null
    {
        return $this->ContactPerson;
    }

    public function setContactPerson(string|null $ContactPerson = null): static
    {
        $this->ContactPerson = $ContactPerson;

        return $this;
    }

    public function getCustomerCode(): string|null
    {
        return $this->CustomerCode;
    }

    public function setCustomerCode(string|null $CustomerCode = null): static
    {
        $this->CustomerCode = $CustomerCode;

        return $this;
    }

    public function getCustomerNumber(): string|null
    {
        return $this->CustomerNumber;
    }

    public function setCustomerNumber(string|null $CustomerNumber = null): static
    {
        $this->CustomerNumber = $CustomerNumber;

        return $this;
    }

    public function getGlobalPackCustomerCode(): string|null
    {
        return $this->GlobalPackCustomerCode;
    }

    public function setGlobalPackCustomerCode(string|null $GlobalPackCustomerCode = null): static
    {
        $this->GlobalPackCustomerCode = $GlobalPackCustomerCode;

        return $this;
    }

    public function getGlobalPackBarcodeType(): string|null
    {
        return $this->GlobalPackBarcodeType;
    }

    public function setGlobalPackBarcodeType(string|null $GlobalPackBarcodeType = null): static
    {
        $this->GlobalPackBarcodeType = $GlobalPackBarcodeType;

        return $this;
    }

    public function getEmail(): string|null
    {
        return $this->Email;
    }

    public function setEmail(string|null $Email = null): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getName(): string|null
    {
        return $this->Name;
    }

    public function setName(string|null $Name = null): static
    {
        $this->Name = $Name;

        return $this;
    }
}
