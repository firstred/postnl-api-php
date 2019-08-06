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
 * Class BasicNationalAddressCheckRequest
 */
class BasicNationalAddressCheckRequest extends AbstractEntity
{
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
     * House number
     *
     * @var string|null $houseNumber
     *
     * @since 2.0.0
     */
    protected $houseNumber;

    /**
     * BasicNationalAddressCheckRequest constructor.
     *
     * @param string|null $postalCode
     * @param string|null $houseNumber
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function __construct(?string $postalCode = null, ?string $houseNumber = null)
    {
        parent::__construct();

        $this->setPostalCode($postalCode);
        $this->setHouseNumber($houseNumber);
    }

    /**
     * Get postal code
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   BasicNationalAddressCheckRequest::$postalCode
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
     * @param string|null $postalCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 2132WT
     *
     * @since   2.0.0
     *
     * @see     BasicNationalAddressCheckRequest::$postalCode
     */
    public function setPostalCode(?string $postalCode): BasicNationalAddressCheckRequest
    {
        $this->postalCode = ValidateAndFix::postcode($postalCode);

        return $this;
    }

    /**
     * Get house number
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   BasicNationalAddressCheckRequest::$houseNumber
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
     * @param string|int|null $houseNumber
     *
     * @return static
     *
     * @example 42
     *
     * @since   2.0.0
     *
     * @see     BasicNationalAddressCheckRequest::$houseNumber
     */
    public function setHouseNumber($houseNumber): BasicNationalAddressCheckRequest
    {
        $this->houseNumber = (string) $houseNumber;

        return $this;
    }
}
