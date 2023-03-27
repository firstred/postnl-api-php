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

use Firstred\PostNL\Attribute\SerializableEntityProperty;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Attribute\SerializableScalarProperty;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Service\ConfirmingServiceInterface;
use Firstred\PostNL\Service\DeliveryDateServiceInterface;
use Firstred\PostNL\Service\LabellingServiceInterface;
use Firstred\PostNL\Service\LocationServiceInterface;
use Firstred\PostNL\Service\ShippingServiceInterface;
use Firstred\PostNL\Service\TimeframeServiceInterface;

/**
 * @since 1.0.0
 */
class Customer extends AbstractEntity
{
    /** @var Address|null $Address */
    #[SerializableEntityProperty(
        namespace: SoapNamespace::Domain,
        supportedServices: [
            ConfirmingServiceInterface::class,
            LabellingServiceInterface::class,
            DeliveryDateServiceInterface::class,
            LocationServiceInterface::class,
            TimeframeServiceInterface::class,
            ShippingServiceInterface::class,
        ],
    )]
    protected ?Address $Address = null;

    /** @var string|null $CollectionLocation */
    #[SerializableScalarProperty(
        namespace: SoapNamespace::Domain,
        supportedServices: [
            ConfirmingServiceInterface::class,
            LabellingServiceInterface::class,
            DeliveryDateServiceInterface::class,
            LocationServiceInterface::class,
            TimeframeServiceInterface::class,
            ShippingServiceInterface::class,
        ],
    )]
    protected ?string $CollectionLocation = null;

    /** @var string|null $ContactPerson */
    #[SerializableScalarProperty(
        namespace: SoapNamespace::Domain,
        supportedServices: [
            ConfirmingServiceInterface::class,
            LabellingServiceInterface::class,
            DeliveryDateServiceInterface::class,
            LocationServiceInterface::class,
            TimeframeServiceInterface::class,
            ShippingServiceInterface::class,
        ],
    )]
    protected ?string $ContactPerson = null;

    /** @var string|null $CustomerCode */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CustomerCode = null;

    /** @var string|null $CustomerNumber */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CustomerNumber = null;

    /** @var string|null $GlobalPackCustomerCode */
    protected ?string $GlobalPackCustomerCode = null;

    /** @var string|null $GlobalPackBarcodeType */
    protected ?string $GlobalPackBarcodeType = null;

    /** @var string|null $Email */
    #[SerializableScalarProperty(
        namespace: SoapNamespace::Domain,
        supportedServices: [
            ConfirmingServiceInterface::class,
            LabellingServiceInterface::class,
            DeliveryDateServiceInterface::class,
            LocationServiceInterface::class,
            TimeframeServiceInterface::class,
            ShippingServiceInterface::class,
        ],
    )]
    protected ?string $Email = null;

    /** @var string|null $Name */
    #[SerializableScalarProperty(
        namespace: SoapNamespace::Domain,
        supportedServices: [
            ConfirmingServiceInterface::class,
            LabellingServiceInterface::class,
            DeliveryDateServiceInterface::class,
            LocationServiceInterface::class,
            TimeframeServiceInterface::class,
            ShippingServiceInterface::class,
        ],
    )]
    protected ?string $Name = null;

    /**
     * @param string|null  $CustomerNumber
     * @param string|null  $CustomerCode
     * @param string|null  $CollectionLocation
     * @param string|null  $ContactPerson
     * @param string|null  $Email
     * @param string|null  $Name
     * @param Address|null $Address
     * @param string|null  $GlobalPackCustomerCode
     * @param string|null  $GlobalPackBarcodeType
     */
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

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    /**
     * @param Address|null $Address
     *
     * @return $this
     */
    public function setAddress(?Address $Address): static
    {
        $this->Address = $Address;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCollectionLocation(): ?string
    {
        return $this->CollectionLocation;
    }

    /**
     * @param string|null $CollectionLocation
     *
     * @return $this
     */
    public function setCollectionLocation(?string $CollectionLocation): static
    {
        $this->CollectionLocation = $CollectionLocation;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContactPerson(): ?string
    {
        return $this->ContactPerson;
    }

    /**
     * @param string|null $ContactPerson
     *
     * @return $this
     */
    public function setContactPerson(?string $ContactPerson): static
    {
        $this->ContactPerson = $ContactPerson;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerCode(): ?string
    {
        return $this->CustomerCode;
    }

    /**
     * @param string|null $CustomerCode
     *
     * @return $this
     */
    public function setCustomerCode(?string $CustomerCode): static
    {
        $this->CustomerCode = $CustomerCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerNumber(): ?string
    {
        return $this->CustomerNumber;
    }

    /**
     * @param string|null $CustomerNumber
     *
     * @return $this
     */
    public function setCustomerNumber(?string $CustomerNumber): static
    {
        $this->CustomerNumber = $CustomerNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGlobalPackCustomerCode(): ?string
    {
        return $this->GlobalPackCustomerCode;
    }

    /**
     * @param string|null $GlobalPackCustomerCode
     *
     * @return $this
     */
    public function setGlobalPackCustomerCode(?string $GlobalPackCustomerCode): static
    {
        $this->GlobalPackCustomerCode = $GlobalPackCustomerCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGlobalPackBarcodeType(): ?string
    {
        return $this->GlobalPackBarcodeType;
    }

    /**
     * @param string|null $GlobalPackBarcodeType
     *
     * @return $this
     */
    public function setGlobalPackBarcodeType(?string $GlobalPackBarcodeType): static
    {
        $this->GlobalPackBarcodeType = $GlobalPackBarcodeType;

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
     * @return $this
     */
    public function setEmail(?string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->Name;
    }

    /**
     * @param string|null $Name
     *
     * @return $this
     */
    public function setName(?string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }
}
