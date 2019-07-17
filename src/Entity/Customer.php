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
 * Class Customer
 */
class Customer extends AbstractEntity
{
    /** @var Address|null $address */
    protected $address;
    /** @var string|null $collectionLocation */
    protected $collectionLocation;
    /** @var string|null $contactPerson */
    protected $contactPerson;
    /** @var string|null $customerCode */
    protected $customerCode;
    /** @var string|null $customerNumber */
    protected $customerNumber;
    /** @var null|string $globalPackCustomerCode */
    protected $globalPackCustomerCode;
    /** @var null|string $globalPackBarcodeType */
    protected $globalPackBarcodeType;
    /** @var string|null $email */
    protected $email;
    /** @var string|null $name */
    protected $name;

    /**
     * @param string  $customerNr
     * @param string  $customerCode
     * @param string  $collectionLocation
     * @param string  $contactPerson
     * @param string  $email
     * @param string  $name
     * @param Address $address
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $customerNr = null, ?string $customerCode = null, ?string $collectionLocation = null, ?string $contactPerson = null, ?string $email = null, ?string $name = null, ?Address $address = null)
    {
        parent::__construct();

        $this->setCustomerNumber($customerNr);
        $this->setCustomerCode($customerCode);
        $this->setCollectionLocation($collectionLocation);
        $this->setContactPerson($contactPerson);
        $this->setEmail($email);
        $this->setName($name);
        $this->setAddress($address);
    }

    /**
     * @return Address|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address|null $address
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAddress(?Address $address): Customer
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCollectionLocation(): ?string
    {
        return $this->collectionLocation;
    }

    /**
     * @param string|null $collectionLocation
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCollectionLocation(?string $collectionLocation): Customer
    {
        $this->collectionLocation = $collectionLocation;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getContactPerson(): ?string
    {
        return $this->contactPerson;
    }

    /**
     * @param string|null $contactPerson
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setContactPerson(?string $contactPerson): Customer
    {
        $this->contactPerson = $contactPerson;

        return $this;
    }

    /**
     * @return int|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCustomerCode(): ?int
    {
        return $this->customerCode;
    }

    /**
     * @param string|null $customerCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCustomerCode(?string $customerCode): Customer
    {
        $this->customerCode = $customerCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCustomerNumber(): ?string
    {
        return $this->customerNumber;
    }

    /**
     * @param string|null $customerNumber
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCustomerNumber(?string $customerNumber): Customer
    {
        $this->customerNumber = $customerNumber;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getGlobalPackCustomerCode(): ?string
    {
        return $this->globalPackCustomerCode;
    }

    /**
     * @param string|null $globalPackCustomerCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setGlobalPackCustomerCode(?string $globalPackCustomerCode): Customer
    {
        $this->globalPackCustomerCode = $globalPackCustomerCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getGlobalPackBarcodeType(): ?string
    {
        return $this->globalPackBarcodeType;
    }

    /**
     * @param string|null $globalPackBarcodeType
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setGlobalPackBarcodeType(?string $globalPackBarcodeType): Customer
    {
        $this->globalPackBarcodeType = $globalPackBarcodeType;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
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
    public function setEmail(?string $email): Customer
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setName(?string $name): Customer
    {
        $this->name = $name;

        return $this;
    }
}
