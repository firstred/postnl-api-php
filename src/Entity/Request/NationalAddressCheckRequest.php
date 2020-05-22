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

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\ValidateAndFix;

/**
 * Class NationalAddressCheckRequest
 */
class NationalAddressCheckRequest extends AbstractEntity
{
    /**
     * Street
     *
     * @pattern ^.{0,95}$
     *
     * @example Siriusdreef
     *
     * @var string|null $street
     *
     * @since   2.0.0
     */
    protected $street;

    /**
     * House number
     *
     * @pattern ^.{0,35}$
     *
     * @example 42
     *
     * @var string|null $houseNumber
     *
     * @since   2.0.0
     */
    protected $houseNumber;

    /**
     * House number addition
     *
     * @pattern ^.{0,35}$
     *
     * @example A
     *
     * @var string|null $addition
     *
     * @since   2.0.0
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
     * @param string|null $street
     * @param string|null $houseNumber
     * @param string|null $addition
     * @param string|null $postalCode
     * @param string|null $city
     *
     * @since 2.0.0
     */
    public function __construct(?string $street = null, ?string $houseNumber = null, ?string $addition = null, ?string $postalCode = null, ?string $city = null)
    {
        parent::__construct();

        $this->setStreet($street);
        $this->setHouseNumber($houseNumber);
        $this->setAddition($addition);
        $this->setPostalCode($postalCode);
        $this->setCity($city);
    }

    /**
     * Get street
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalAddressCheckRequest::$street
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * Set street
     *
     * @pattern ^.{0,95}$
     *
     * @example Siriusdreef
     *
     * @param string|null $street
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     *
     * @see     NationalAddressCheckRequest::$street
     */
    public function setStreet(?string $street): NationalAddressCheckRequest
    {
        $this->street = ValidateAndFix::street($street);

        return $this;
    }

    /**
     * Get house number
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalAddressCheckRequest::$houseNumber
     */
    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    /**
     * Set house number
     *
     * @pattern ^.{0,35}$
     *
     * @example 42
     *
     * @param string|null $houseNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     *
     * @see     NationalAddressCheckRequest::$houseNumber
     */
    public function setHouseNumber(?string $houseNumber): NationalAddressCheckRequest
    {
        $this->houseNumber = ValidateAndFix::houseNumber($houseNumber);

        return $this;
    }

    /**
     * Get house number addition
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalAddressCheckRequest::$addition
     */
    public function getAddition(): ?string
    {
        return $this->addition;
    }

    /**
     * Set house number addition
     *
     * @pattern ^.{0,35}$
     *
     * @example A
     *
     * @param string|null $addition
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalAddressCheckRequest::$addition
     */
    public function setAddition(?string $addition): NationalAddressCheckRequest
    {
        $this->addition = $addition;

        return $this;
    }

    /**
     * Get postal code
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalAddressCheckRequest::$postalCode
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Set postal code
     *
     * @pattern ^.{0,10}$
     *
     * @example 2132WT
     *
     * @param string|null $postalCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     NationalAddressCheckRequest::$postalCode
     *
     */
    public function setPostalCode(?string $postalCode): NationalAddressCheckRequest
    {
        $this->postalCode = ValidateAndFix::postcode($postalCode);

        return $this;
    }

    /**
     * Get city
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalAddressCheckRequest::$city
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Set city
     *
     * @pattern ^.{0,35}$
     *
     * @example Hoofddorp
     *
     * @param string|null $city
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     *
     * @see     NationalAddressCheckRequest::$city
     */
    public function setCity(?string $city): NationalAddressCheckRequest
    {
        $this->city = ValidateAndFix::city($city);

        return $this;
    }
}
