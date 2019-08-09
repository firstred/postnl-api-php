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
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\ValidateAndFix;

/**
 * Class PostalCodeCheckRequest
 */
class PostalCodeCheckRequest extends AbstractEntity
{
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
     * House number
     *
     * @pattern ^\d{1,10}$
     *
     * @example 42
     *
     * @var int|null $houseNumber
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
     * @var string|null $houseNumberAddition
     *
     * @since   2.0.0
     */
    protected $houseNumberAddition;

    /**
     * PostalCodeCheckRequest constructor.
     *
     * @param string|null $postalCode
     * @param null        $houseNumber
     * @param string|null $houseNumberAddition
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function __construct(?string $postalCode = null, $houseNumber = null, ?string $houseNumberAddition = null)
    {
        $this->setPostalCode($postalCode);
        $this->setHouseNumber($houseNumber);
        $this->setHouseNumberAddition($houseNumberAddition);

        parent::__construct();
    }

    /**
     * Serialize JSON
     *
     * @return array
     *
     * @since 2.0.0
     */
    public function jsonSerialize(): array
    {
        return [
            'postalcode'          => $this->postalCode,
            'housenumber'         => $this->houseNumber,
            'housenumberaddition' => $this->houseNumberAddition,
        ];
    }

    /**
     * Get postal code
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   PostalCodeCheckRequest::$postalCode
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
     * @see     PostalCodeCheckRequest::$postalCode
     */
    public function setPostalCode(?string $postalCode): PostalCodeCheckRequest
    {
        $this->postalCode = ValidateAndFix::postcode($postalCode);

        return $this;
    }

    /**
     * Get house number
     *
     * @return int|null
     *
     * @since 2.0.0
     *
     * @see   PostalCodeCheckRequest::$houseNumber
     */
    public function getHouseNumber(): ?int
    {
        return $this->houseNumber;
    }

    /**
     * Set house number
     *
     * @pattern ^\d{1,10}$
     *
     * @example 42
     *
     * @param int|float|string|null $houseNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     PostalCodeCheckRequest::$houseNumber
     *
     */
    public function setHouseNumber($houseNumber): PostalCodeCheckRequest
    {
        $this->houseNumber = ValidateAndFix::integer($houseNumber);

        return $this;
    }

    /**
     * Get house number addition
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   PostalCodeCheckRequest::$houseNumberAddition
     */
    public function getHouseNumberAddition(): ?string
    {
        return $this->houseNumberAddition;
    }

    /**
     * Set house number addition
     *
     * @pattern ^.{0,35}$
     *
     * @example A
     *
     * @param string|null $houseNumberAddition
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     PostalCodeCheckRequest::$houseNumberAddition
     */
    public function setHouseNumberAddition(?string $houseNumberAddition): PostalCodeCheckRequest
    {
        $this->houseNumberAddition = $houseNumberAddition;

        return $this;
    }
}
