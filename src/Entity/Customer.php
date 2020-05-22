<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\ValidateAndFix;

/**
 * Class Customer
 */
class Customer extends AbstractEntity
{
    /**
     * Address
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var Address|null $address
     *
     * @since 1.0.0
     */
    protected $address;

    /**
     * Collection location
     *
     * @pattern ^.{0,35}$
     *
     * @example 11223344
     *
     * @var string|null $collectionLocation
     *
     * @since 1.0.0
     */
    protected $collectionLocation;

    /**
     * Contact person
     *
     * @pattern ^.{0,35}$
     *
     * @example Peter de Ruiter
     *
     * @var string|null $contactPerson
     *
     * @since 1.0.0
     */
    protected $contactPerson;

    /**
     * Customer code
     *
     * @pattern ^[A-Z]{4}$
     *
     * @example DEVC
     *
     * @var string|null $customerCode
     *
     * @since 1.0.0
     */
    protected $customerCode;

    /**
     * Customer number
     *
     * @pattern ^\d{8}$
     *
     * @example 11223344
     *
     * @var string|null $customerNumber
     *
     * @since 1.0.0
     */
    protected $customerNumber;

    /**
     * Global pack customer code
     *
     * @pattern ^\d{4}$
     *
     * @example 1234
     *
     * @var null|string $globalPackCustomerCode
     *
     * @since 1.0.0
     */
    protected $globalPackCustomerCode;

    /**
     * Global pack barcode type
     *
     * @pattern ^[A-Z]{2}$
     *
     * @example CD
     *
     * @var null|string $globalPackBarcodeType
     *
     * @since 1.0.0
     */
    protected $globalPackBarcodeType;

    /**
     * Email address
     *
     * @pattern ^.{0,50}$
     *
     * @example receiver@gmail.com
     *
     * @var string|null $email
     *
     * @since 1.0.0
     */
    protected $email;

    /**
     * Full name
     *
     * @pattern ^{0,35}$
     *
     * @example PostNL
     *
     * @var string|null $name
     *
     * @since 1.0.0
     */
    protected $name;

    /**
     * Customer constructor.
     *
     * @param string  $customerNr
     * @param string  $customerCode
     * @param string  $collectionLocation
     * @param string  $contactPerson
     * @param string  $email
     * @param string  $name
     * @param Address $address
     *
     * @throws InvalidArgumentException
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
     * Get address
     *
     * @return Address|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Customer::$address
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * Set address
     *
     * @pattern N/A
     *
     * @param Address|null $address
     *
     * @return static
     *
     * @example N/A
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     Customer::$address
     */
    public function setAddress(?Address $address): Customer
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get collection location
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Customer::$collectionLocation
     */
    public function getCollectionLocation(): ?string
    {
        return $this->collectionLocation;
    }

    /**
     * Set collection location
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $collectionLocation
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 123456
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Customer::$collectionLocation
     */
    public function setCollectionLocation(?string $collectionLocation): Customer
    {
        $this->collectionLocation = ValidateAndFix::genericString($collectionLocation);

        return $this;
    }

    /**
     * Get contact person
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Customer::$contactPerson
     */
    public function getContactPerson(): ?string
    {
        return $this->contactPerson;
    }

    /**
     * Set contact person
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $contactPerson
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example Peter de Ruiter
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Customer::$contactPerson
     */
    public function setContactPerson(?string $contactPerson): Customer
    {
        $this->contactPerson = ValidateAndFix::genericString($contactPerson);

        return $this;
    }

    /**
     * Get customer code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Customer::$customerCode
     */
    public function getCustomerCode(): ?string
    {
        return $this->customerCode;
    }

    /**
     * Set customer code
     *
     * @pattern ^[A-Z]{2}$
     *
     * @param string|null $customerCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example AB
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Customer::$customerCode
     */
    public function setCustomerCode(?string $customerCode): Customer
    {
        $this->customerCode = ValidateAndFix::customerCode($customerCode);

        return $this;
    }

    /**
     * Get customer number
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Customer::$customerNumber
     */
    public function getCustomerNumber(): ?string
    {
        return $this->customerNumber;
    }

    /**
     * Set customer number
     *
     * @pattern ^\d{4}$
     *
     * @param string|null $customerNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 1234
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Customer::$customerNumber
     */
    public function setCustomerNumber(?string $customerNumber): Customer
    {
        $this->customerNumber = ValidateAndFix::customerNumber($customerNumber);

        return $this;
    }

    /**
     * Get global pack customer code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Customer::$globalPackCustomerCode
     */
    public function getGlobalPackCustomerCode(): ?string
    {
        return $this->globalPackCustomerCode;
    }

    /**
     * Set global pack customer code
     *
     * @pattern ^\d{4}$
     *
     * @param string|null $globalPackCustomerCode
     *
     * @return static
     *
     * @example 1234
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     Customer::$globalPackCustomerCode
     */
    public function setGlobalPackCustomerCode(?string $globalPackCustomerCode): Customer
    {
        $this->globalPackCustomerCode = $globalPackCustomerCode;

        return $this;
    }

    /**
     * Get global pack barcode type
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Customer::$globalPackBarcodeType
     */
    public function getGlobalPackBarcodeType(): ?string
    {
        return $this->globalPackBarcodeType;
    }

    /**
     * Set global pack barcode type
     *
     * @pattern ^[A-Z]{2}$
     *
     * @param string|null $globalPackBarcodeType
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example CD
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Customer::$globalPackBarcodeType
     */
    public function setGlobalPackBarcodeType(?string $globalPackBarcodeType): Customer
    {
        $this->globalPackBarcodeType = ValidateAndFix::isoAlpha2CountryCode($globalPackBarcodeType);

        return $this;
    }

    /**
     * Get email address
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Customer::$email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set email address
     *
     * @pattern  ^.{0,50}$
     *
     * @param string|null $email
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since    1.0.0
     * @since    2.0.0 Strict typing
     *
     * @see      Customer::$email
     *
     * @example  receiver@gmail.com
     */
    public function setEmail(?string $email): Customer
    {
        $this->email = ValidateAndFix::email($email);

        return $this;
    }

    /**
     * Get name
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Customer::$name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @pattern ^{0,35}$
     *
     * @param string|null $name
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example PostNL
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Customer::$name
     */
    public function setName(?string $name): Customer
    {
        $this->name = ValidateAndFix::genericString($name);

        return $this;
    }
}
