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
 * Class ValidatedAddress
 */
class ValidatedAddress extends AbstractEntity
{
    /**
     * Result number
     *
     * @pattern ^\d{1,10}$
     *
     * @example 13
     *
     * @var string|null $resultNumber
     *
     * @since   2.0.0
     */
    protected $resultNumber;

    /**
     * Mailability score
     *
     * @pattern ^\d{1,3}$
     *
     * @example 50
     *
     * @var int|null $mailabilityScore
     *
     * @since   2.0.0
     */
    protected $mailabilityScore;

    /**
     * Result percentage
     *
     * @pattern ^\d{1,3}$
     *
     * @example 50
     *
     * @var int|null $resultPercentage
     *
     * @since   2.0.0
     */
    protected $resultPercentage;

    /**
     * Postal code
     *
     * @pattern ^.{0,10}$
     *
     * @example 3123WT
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
     * Province
     *
     * @pattern ^.{0,35}$
     *
     * @example Zuid-Holland
     *
     * @var string|null $province
     *
     * @since   2.0.0
     */
    protected $province;

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
     * Formatted address
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string[]|null $formattedAddress
     *
     * @since   2.0.0
     */
    protected $formattedAddress;

    /**
     * Geocode
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var Geocode|null $geocode
     *
     * @since   2.0.0
     */
    protected $geocode;

    /**
     * ValidatedAddress constructor.
     *
     * @param string|null  $city
     * @param string|null  $postalCode
     * @param string|null  $street
     * @param string|null  $houseNumber
     * @param string|null  $addition
     * @param array|null   $formattedAddress
     * @param Geocode|null $geocode
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function __construct(?string $city = null, ?string $postalCode = null, ?string $street = null, ?string $houseNumber = null, ?string $addition = null, ?array $formattedAddress = null, ?Geocode $geocode = null)
    {
        parent::__construct();

        $this->setCity($city);
        $this->setPostalCode($postalCode);
        $this->setStreet($street);
        $this->setHouseNumber($houseNumber);
        $this->setAddition($addition);
        $this->setFormattedAddress($formattedAddress);
        $this->setGeocode($geocode);
    }

    /**
     * Get postal code
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   ValidatedAddress::$postalCode
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
     * @example 3123WT
     *
     * @param string|null $postalCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     *
     * @see     ValidatedAddress::$postalCode
     */
    public function setPostalCode(?string $postalCode): ValidatedAddress
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
     * @see   ValidatedAddress::$city
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
     * @see     ValidatedAddress::$city
     */
    public function setCity(?string $city): ValidatedAddress
    {
        $this->city = ValidateAndFix::city($city);

        return $this;
    }

    /**
     * Get street
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   ValidatedAddress::$street
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
     * @see     ValidatedAddress::$street
     *
     */
    public function setStreet(?string $street): ValidatedAddress
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
     * @see   ValidatedAddress::$houseNumber
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
     * @since   2.0.0
     *
     * @see     ValidatedAddress::$houseNumber
     */
    public function setHouseNumber(?string $houseNumber): ValidatedAddress
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get house number addition
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   ValidatedAddress::$addition
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
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$addition
     *
     */
    public function setAddition(?string $addition): ValidatedAddress
    {
        $this->addition = ValidateAndFix::genericString($addition);

        return $this;
    }

    /**
     * Get formatted address
     *
     * @return string[]|null
     *
     * @since 2.0.0
     *
     * @see   ValidatedAddress::$formattedAddress
     */
    public function getFormattedAddress(): ?array
    {
        return $this->formattedAddress;
    }

    /**
     * Set formatted address
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string[]|null $formattedAddress
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     ValidatedAddress::$formattedAddress
     */
    public function setFormattedAddress(?array $formattedAddress): ValidatedAddress
    {
        $this->formattedAddress = $formattedAddress;

        return $this;
    }

    /**
     * Get Geocode
     *
     * @return Geocode|null
     *
     * @since 2.0.0
     *
     * @see   Geocode
     */
    public function getGeocode(): ?Geocode
    {
        return $this->geocode;
    }

    /**
     * Set Geocode
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param Geocode|null $geocode
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     Geocode
     */
    public function setGeocode(?Geocode $geocode): ValidatedAddress
    {
        $this->geocode = $geocode;

        return $this;
    }

    /**
     * Get result number
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   ValidatedAddress::$resultNumber
     */
    public function getResultNumber(): ?string
    {
        return $this->resultNumber;
    }

    /**
     * Set result number
     *
     * @pattern ^\d{1,10}$
     *
     * @example 13
     *
     * @param string|float|int|null $resultNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     *
     * @see     ValidatedAddress::$resultNumber
     */
    public function setResultNumber($resultNumber): ValidatedAddress
    {
        $this->resultNumber = ValidateAndFix::integer($resultNumber);

        return $this;
    }

    /**
     * Get mailability score
     *
     * @return int|null
     *
     * @since 2.0.0
     *
     * @see   ValidatedAddress::$mailabilityScore
     */
    public function getMailabilityScore(): ?int
    {
        return $this->mailabilityScore;
    }

    /**
     * Set mailability score
     *
     * @pattern \d{1,3}$
     *
     * @example 50
     *
     * @param int|float|string|null $mailabilityScore
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     *
     * @see     ValidatedAddress::$mailabilityScore
     */
    public function setMailabilityScore($mailabilityScore): ValidatedAddress
    {
        $this->mailabilityScore = ValidateAndFix::integer($mailabilityScore);

        return $this;
    }

    /**
     * Get result percentage
     *
     * @return int|null
     *
     * @since 2.0.0
     *
     * @see   ValidatedAddress::$resultPercentage
     */
    public function getResultPercentage(): ?int
    {
        return $this->resultPercentage;
    }

    /**
     * Set result percentage
     *
     * @pattern ^\d{1,3}$
     *
     * @example 60
     *
     * @param int|string|float|null $resultPercentage
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     *
     * @see     ValidatedAddress::$resultPercentage
     */
    public function setResultPercentage($resultPercentage): ValidatedAddress
    {
        $this->resultPercentage = ValidateAndFix::integer($resultPercentage);

        return $this;
    }

    /**
     * Get province
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   ValidatedAddress::$province
     */
    public function getProvince(): ?string
    {
        return $this->province;
    }

    /**
     * Set province
     *
     * @pattern ^.{0,35}$
     *
     * @example Zuid-Holland
     *
     * @param string|null $province
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     ValidatedAddress::$province
     */
    public function setProvince(?string $province): ValidatedAddress
    {
        $this->province = $province;

        return $this;
    }
}
