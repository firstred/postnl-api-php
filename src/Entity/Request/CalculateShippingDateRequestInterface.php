<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
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
 * @copyright 2017-2019 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\EntityInterface;
use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class CalculateShippingDateRequest.
 *
 * This class is both the container and can be the actual CalculateShippingDateRequest object itself!
 */
interface CalculateShippingDateRequestInterface extends EntityInterface
{
    /**
     * Get zip / postal code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateShippingDateRequest::$postalCode
     */
    public function getPostalCode(): ?string;

    /**
     * Set the zip / postcode.
     *
     * @pattern ^.{0,10}$
     *
     * @param string|null $postcode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 2132WT
     *
     * @since   2.0.0
     * @see     CalculateShippingDateRequest::$postalCode
     */
    public function setPostalCode(?string $postcode = null): CalculateShippingDateRequest;

    /**
     * Get city.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateShippingDateRequest::$city
     */
    public function getCity(): ?string;

    /**
     * Set city.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $city
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example Hoofddorp
     *
     * @since   2.0.0
     * @see     CalculateShippingDateRequest::$city
     */
    public function setCity(?string $city): CalculateShippingDateRequest;

    /**
     * Get country code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateShippingDateRequest::$countryCode
     */
    public function getCountryCode(): ?string;

    /**
     * Set country code.
     *
     * @pattern ^(?:NL|BE)$
     *
     * @param string|null $countryCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example NL
     *
     * @since   2.0.0
     * @see     CalculateShippingDateRequest::$countryCode
     */
    public function setCountryCode(?string $countryCode): CalculateShippingDateRequest;

    /**
     * Get house number.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   CalculateShippingDateRequest::$houseNumber
     */
    public function getHouseNumber(): ?int;

    /**
     * Set house number.
     *
     * @pattern ^\d{1,10}$
     *
     * @param string|int|float|null $houseNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 42
     *
     * @since   2.0.0
     * @see     CalculateShippingDateRequest::$houseNumber
     */
    public function setHouseNumber($houseNumber): CalculateShippingDateRequest;

    /**
     * Get house number extension.
     *
     * Get house number extension
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateShippingDateRequest::$houseNrExt
     */
    public function getHouseNrExt(): ?string;

    /**
     * Set house number extension.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $houseNrExt
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example A
     *
     * @since   2.0.0
     * @see     CalculateShippingDateRequest::$houseNrExt
     */
    public function setHouseNrExt(?string $houseNrExt): CalculateShippingDateRequest;

    /**
     * Get origin country code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateShippingDateRequest::$originCountryCode
     */
    public function getOriginCountryCode(): ?string;

    /**
     * Set origin country code.
     *
     * @pattern ^(?:NL|BE)$
     *
     * @param string|null $originCountryCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example NL
     *
     * @since   2.0.0
     * @see     CalculateShippingDateRequest::$originCountryCode
     */
    public function setOriginCountryCode(?string $originCountryCode): CalculateShippingDateRequest;

    /**
     * Get shipping date.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateShippingDateRequest::$deliveryDate
     */
    public function getDeliveryDate(): ?string;

    /**
     * Set shipping date.
     *
     * @pattern ^(?:[0-3]\d-[01]\d-[12]\d{3}\s+)[0-2]\d:[0-5]\d(?:[0-5]\d)$
     *
     * @param string|null $deliveryDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 03-07-2019 17:00:00
     *
     * @since   2.0.0
     * @see     CalculateShippingDateRequest::$deliveryDate
     */
    public function setDeliveryDate(?string $deliveryDate): CalculateShippingDateRequest;

    /**
     * Get shipping duration.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   CalculateShippingDateRequest::$shippingDuration
     */
    public function getShippingDuration(): ?int;

    /**
     * Set shipping duration.
     *
     * @pattern ^\d{1,10}$
     *
     * @param int|float|string|null $shippingDuration
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 2
     *
     * @since   2.0.0
     * @see     CalculateShippingDateRequest::$shippingDuration
     */
    public function setShippingDuration($shippingDuration): CalculateShippingDateRequest;

    /**
     * Get street.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateShippingDateRequest::$street
     */
    public function getStreet(): ?string;

    /**
     * Set street.
     *
     * @pattern ^.{0,95}$
     *
     * @param string|null $street
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example Siriusdreef
     *
     * @since   2.0.0
     * @see     CalculateShippingDateRequest::$street
     */
    public function setStreet(?string $street): CalculateShippingDateRequest;
}
