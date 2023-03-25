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

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * @since 1.0.0
 */
class Customer extends AbstractEntity
{
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?Address $Address = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CollectionLocation = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $ContactPerson = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CustomerCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CustomerNumber = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $GlobalPackCustomerCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $GlobalPackBarcodeType = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Email = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Name = null;

    public function __construct(
        ?string  $CustomerNumber = null,
        ?string  $CustomerCode = null,
        ?string  $CollectionLocation = null,
        ?string  $ContactPerson = null,
        ?string  $Email = null,
        ?string  $Name = null,
        ?Address $Address = null,
        ?string  $GlobalPackCustomerCode = null,
        ?string  $GlobalPackBarcodeType = null
    ) {
        parent::__construct();

        $this->setCustomerNumber(CustomerNumber: $CustomerNumber);
        $this->setCustomerCode(CustomerCode: $CustomerCode);
        $this->setCollectionLocation(CollectionLocation: $CollectionLocation);
        $this->setContactPerson(ContactPerson: $ContactPerson);
        $this->setEmail(Email: $Email);
        $this->setName(Name: $Name);
        $this->setAddress(Address: $Address);
        $this->setGlobalPackCustomerCode(GlobalPackCustomerCode: $GlobalPackCustomerCode);
        $this->setGlobalPackBarcodeType(GlobalPackBarcodeType: $GlobalPackBarcodeType);
    }

    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    public function setAddress(?Address $Address): static
    {
        $this->Address = $Address;

        return $this;
    }

    public function getCollectionLocation(): ?string
    {
        return $this->CollectionLocation;
    }

    public function setCollectionLocation(?string $CollectionLocation): static
    {
        $this->CollectionLocation = $CollectionLocation;

        return $this;
    }

    public function getContactPerson(): ?string
    {
        return $this->ContactPerson;
    }

    public function setContactPerson(?string $ContactPerson): static
    {
        $this->ContactPerson = $ContactPerson;

        return $this;
    }

    public function getCustomerCode(): ?string
    {
        return $this->CustomerCode;
    }

    public function setCustomerCode(?string $CustomerCode): static
    {
        $this->CustomerCode = $CustomerCode;

        return $this;
    }

    public function getCustomerNumber(): ?string
    {
        return $this->CustomerNumber;
    }

    public function setCustomerNumber(?string $CustomerNumber): static
    {
        $this->CustomerNumber = $CustomerNumber;

        return $this;
    }

    public function getGlobalPackCustomerCode(): ?string
    {
        return $this->GlobalPackCustomerCode;
    }

    public function setGlobalPackCustomerCode(?string $GlobalPackCustomerCode): static
    {
        $this->GlobalPackCustomerCode = $GlobalPackCustomerCode;

        return $this;
    }

    public function getGlobalPackBarcodeType(): ?string
    {
        return $this->GlobalPackBarcodeType;
    }

    public function setGlobalPackBarcodeType(?string $GlobalPackBarcodeType): static
    {
        $this->GlobalPackBarcodeType = $GlobalPackBarcodeType;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }
}
