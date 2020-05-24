<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class Customer.
 */
interface CustomerInterface extends EntityInterface
{
    /**
     * Get address.
     *
     * @return AddressInterface|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customer::$address
     */
    public function getAddress(): ?AddressInterface;

    /**
     * Set address.
     *
     * @pattern N/A
     *
     * @param AddressInterface|null $address
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customer::$address
     */
    public function setAddress(?AddressInterface $address): CustomerInterface;

    /**
     * Get collection location.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customer::$collectionLocation
     */
    public function getCollectionLocation(): ?string;

    /**
     * Set collection location.
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
     * @see     Customer::$collectionLocation
     */
    public function setCollectionLocation(?string $collectionLocation): CustomerInterface;

    /**
     * Get contact person.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customer::$contactPerson
     */
    public function getContactPerson(): ?string;

    /**
     * Set contact person.
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
     * @see     Customer::$contactPerson
     */
    public function setContactPerson(?string $contactPerson): CustomerInterface;

    /**
     * Get customer code.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customer::$customerCode
     */
    public function getCustomerCode(): ?string;

    /**
     * Set customer code.
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
     * @see     Customer::$customerCode
     */
    public function setCustomerCode(?string $customerCode): CustomerInterface;

    /**
     * Get customer number.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customer::$customerNumber
     */
    public function getCustomerNumber(): ?string;

    /**
     * Set customer number.
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
     * @see     Customer::$customerNumber
     */
    public function setCustomerNumber(?string $customerNumber): CustomerInterface;

    /**
     * Get global pack customer code.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customer::$globalPackCustomerCode
     */
    public function getGlobalPackCustomerCode(): ?string;

    /**
     * Set global pack customer code.
     *
     * @pattern ^\d{4}$
     *
     * @param string|null $globalPackCustomerCode
     *
     * @return static
     *
     * @example 1234
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customer::$globalPackCustomerCode
     */
    public function setGlobalPackCustomerCode(?string $globalPackCustomerCode): CustomerInterface;

    /**
     * Get global pack barcode type.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customer::$globalPackBarcodeType
     */
    public function getGlobalPackBarcodeType(): ?string;

    /**
     * Set global pack barcode type.
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
     * @see     Customer::$globalPackBarcodeType
     */
    public function setGlobalPackBarcodeType(?string $globalPackBarcodeType): CustomerInterface;

    /**
     * Get email address.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customer::$email
     */
    public function getEmail(): ?string;

    /**
     * Set email address.
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
     * @see      Customer::$email
     *
     * @example  receiver@gmail.com
     */
    public function setEmail(?string $email): CustomerInterface;

    /**
     * Get name.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customer::$name
     */
    public function getName(): ?string;

    /**
     * Set name.
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
     * @see     Customer::$name
     */
    public function setName(?string $name): CustomerInterface;
}
