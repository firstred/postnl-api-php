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

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\ValidateAndFix;

/**
 * Class BasicNationalAddressCheckResponse
 */
class BasicNationalAddressCheckResponse extends AbstractEntity
{
    /**
     * Status
     * Equals 1 if address exists in range, equals 0 if not
     *
     * @pattern ^(?:0|1)$
     *
     * @example 1
     *
     * @var int|null $status
     *
     * @since   2.0.0
     */
    protected $status;

    /**
     * Street name
     *
     * @pattern ^.{0,95}$
     *
     * @example Prinses Beatrixlaan
     *
     * @var string|null $streetName
     *
     * @since   2.0.0
     */
    protected $streetName;

    /**
     * House number
     *
     * @pattern ^.{0,35}$
     *
     * @example 23
     *
     * @var string|null $houseNumber
     *
     * @since   2.0.0
     */
    protected $houseNumber;

    /**
     * Postal code
     *
     * @pattern ^.{0,10}$
     *
     * @example 2595AK
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
     * @example ‘S-GRAVENHAGE
     *
     * @var string|null $city
     *
     * @since   2.0.0
     */
    protected $city;

    /**
     * Telephone area code
     *
     * @pattern ^.{0,10}$
     *
     * @example 070
     *
     * @var string|null $areaCode
     *
     * @since   2.0.0
     */
    protected $areaCode;

    /**
     * BasicInternationalAddressResponse constructor.
     *
     * @param string|null $streetName
     * @param string|null $city
     * @param string|null $houseNumber
     * @param string|null $postalCode
     * @param string|null $areaCode
     * @param int|null    $status
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function __construct(?string $streetName = null, ?string $city = null, ?string $houseNumber = null, ?string $postalCode = null, ?string $areaCode = null, ?int $status = null)
    {
        parent::__construct();

        $this->setStreetName($streetName);
        $this->setCity($city);
        $this->setHouseNumber($houseNumber);
        $this->setPostalCode($postalCode);
        $this->setAreaCode($areaCode);
        $this->setStatus($status);
    }

    /**
     * Deserialize JSON
     *
     * @noinspection PhpDocRedundantThrowsInspection
     *
     * @param array $json JSON as associative array
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since        2.0.0
     */
    public static function jsonDeserialize(array $json)
    {
        reset($json);
        $shortClassName = key($json);
        $object = new static();
        foreach ($json[$shortClassName] as $key => $value) {
            if (!is_array($value) || !empty($value)) {
                $object->{"set$key"}($value);
            }
        }

        return $object;
    }

    /**
     * Return a serializable array for `json_encode`
     *
     * @return array
     *
     * @since 2.0.0
     */
    public function jsonSerialize(): array
    {
        $json = [];
        foreach (array_keys(get_class_vars(static::class)) as $propertyName) {
            if (in_array(ucfirst($propertyName), ['Id'])) {
                continue;
            }
            if (isset($this->{$propertyName})) {
                $json[lcfirst($propertyName)] = $this->{$propertyName};
            }
        }

        return $json;
    }

    /**
     * Get status
     *
     * @return int|null
     *
     * @since 2.0.0
     *
     * @see   BasicNationalAddressCheckResponse::$status
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @pattern ^(?:0|1)$
     *
     * @example 1
     *
     * @param int|string|float|null $status
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     *
     * @see     BasicNationalAddressCheckResponse::$status
     */
    public function setStatus($status): BasicNationalAddressCheckResponse
    {
        $this->status = ValidateAndFix::integer($status);

        return $this;
    }

    /**
     * Get street name
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   BasicNationalAddressCheckResponse::$streetName
     */
    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    /**
     * Set street name
     *
     * @pattern ^.{0,95}$
     *
     * @example Prinses Beatrixlaan
     *
     * @param string|null $streetName
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     *
     * @see     BasicNationalAddressCheckResponse::$streetName
     *
     *
     */
    public function setStreetName(?string $streetName): BasicNationalAddressCheckResponse
    {
        $this->streetName = ValidateAndFix::street($streetName);

        return $this;
    }

    /**
     * Get house number
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   BasicNationalAddressCheckResponse::$houseNumber
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
     * @example 23
     *
     * @param string|int|null $houseNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     *
     * @see     BasicNationalAddressCheckResponse::$houseNumber
     */
    public function setHouseNumber($houseNumber): BasicNationalAddressCheckResponse
    {
        $this->houseNumber = ValidateAndFix::houseNumber($houseNumber);

        return $this;
    }

    /**
     * Get postal code
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   BasicNationalAddressCheckResponse::$postalCode
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
     * @example 2595AK
     *
     * @param string|null $postalCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     *
     * @see     BasicNationalAddressCheckResponse::$postalCode
     */
    public function setPostalCode(?string $postalCode): BasicNationalAddressCheckResponse
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
     * @see   BasicNationalAddressCheckResponse::$city
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Set city
     *
     * @pattern {0,35}$
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
     * @see     BasicNationalAddressCheckResponse::$city
     */
    public function setCity(?string $city): BasicNationalAddressCheckResponse
    {
        $this->city = ValidateAndFix::city($city);

        return $this;
    }

    /**
     * Get telephone area code
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   BasicNationalAddressCheckResponse::$areaCode
     */
    public function getAreaCode(): ?string
    {
        return $this->areaCode;
    }

    /**
     * Set telephone area code
     *
     * @pattern {0,35}$
     *
     * @example 070
     *
     * @param string|null $areaCode
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     BasicNationalAddressCheckResponse::$areaCode
     */
    public function setAreaCode(?string $areaCode): BasicNationalAddressCheckResponse
    {
        $this->areaCode = $areaCode;

        return $this;
    }
}
