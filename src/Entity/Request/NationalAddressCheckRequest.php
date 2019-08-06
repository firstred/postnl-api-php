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

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;

/**
 * Class NationalAddressCheckRequest
 */
class NationalAddressCheckRequest extends AbstractEntity
{
    /**
     * Country
     *
     * @var string|null $country
     *
     * @since 2.0.0
     */
    protected $country;

    /**
     * Street
     *
     * @var string|null $street
     *
     * @since 2.0.0
     */
    protected $street;

    /**
     * House number
     *
     * @var string|null $houseNumber
     *
     * @since 2.0.0
     */
    protected $houseNumber;

    /**
     * House number addition
     *
     * @var string|null $addition
     *
     * @since 2.0.0
     */
    protected $addition;

    /**
     * Postal code
     *
     * @pattern ^.{0,10}$
     *
     * @example 2132WT
     *
     * @var string|null $postalCode
     *
     * @since   2.0.0
     */
    protected $postalCode;

    /**
     * City
     *
     * @pattern ^.{0,35}$
     *
     * @example Hoofddorp
     *
     * @var string|null $city
     *
     * @since   2.0.0
     */
    protected $city;

    /**
     * NationalAddressCheckRequest constructor.
     *
     * @param string|null $country
     * @param string|null $street
     * @param string|null $houseNumber
     * @param string|null $addition
     * @param string|null $postalCode
     * @param string|null $city
     *
     * @since 2.0.0
     */
    public function __construct(?string $country = null, ?string $street = null, ?string $houseNumber = null, ?string $addition = null, ?string $postalCode = null, ?string $city = null)
    {
        parent::__construct();

        $this->setCountry($country);
        $this->setStreet($street);
        $this->setHouseNumber($houseNumber);
        $this->setAddition($addition);
        $this->setPostalCode($postalCode);
        $this->setCity($city);
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCountry(?string $country): NationalAddressCheckRequest
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setStreet(?string $street): NationalAddressCheckRequest
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    /**
     * @param string|null $houseNumber
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setHouseNumber(?string $houseNumber): NationalAddressCheckRequest
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAddition(): ?string
    {
        return $this->addition;
    }

    /**
     * @param string|null $addition
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAddition(?string $addition): NationalAddressCheckRequest
    {
        $this->addition = $addition;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string|null $postalCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setPostalCode(?string $postalCode): NationalAddressCheckRequest
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCity(?string $city): NationalAddressCheckRequest
    {
        $this->city = $city;

        return $this;
    }
}
