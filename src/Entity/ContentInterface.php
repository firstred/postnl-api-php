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
 * Class Content.
 */
interface ContentInterface extends EntityInterface
{
    /**
     * Get country of origin.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Content::$countryOfOrigin
     */
    public function getCountryOfOrigin(): ?string;

    /**
     * Set country of origin.
     *
     * @pattern ^[A-Z]{2}$
     *
     * @param string|null $countryOfOrigin
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example NL
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Content::$countryOfOrigin
     */
    public function setCountryOfOrigin(?string $countryOfOrigin): ContentInterface;

    /**
     * Get description.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Content::$description
     */
    public function getDescription(): ?string;

    /**
     * Set description.
     *
     * @pattern ^.{1,35}$
     *
     * @param string|null $description
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example Powdered milk
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Content::$description
     */
    public function setDescription(?string $description): ContentInterface;

    /**
     * Get EAN.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   Content::$EAN
     */
    public function getEAN(): ?string;

    /**
     * Set EAN.
     *
     * @pattern ^\d{8}\d{5}?$
     *
     * @param string|null $ean
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 7501031311309
     *
     * @since   2.0.0 Strict typing
     * @see     Content::$EAN
     */
    public function setEAN(?string $ean): ContentInterface;

    /**
     * Get product URL.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   Content::$productUrl
     */
    public function getProductUrl(): ?string;

    /**
     * Set product URL.
     *
     * @pattern N/A
     *
     * @example https://www.example.com/product
     *
     * @param string|null $productUrl
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0 Strict typing
     * @see     Content::$productUrl
     */
    public function setProductUrl(?string $productUrl): ContentInterface;

    /**
     * Get the Harmonized System Tariff Number.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Content::$HSTariffNr
     */
    public function getHSTariffNr(): ?string;

    /**
     * Set the Harmonized System Tariff Number.
     *
     * @pattern ^\d{6}$
     *
     * @param string|null $HSTariffNr
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 950306
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Content::$HSTariffNr
     */
    public function setHSTariffNr(?string $HSTariffNr): ContentInterface;

    /**
     * Get quantity.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Content::$quantity
     */
    public function getQuantity(): ?string;

    /**
     * Set quantity.
     *
     * @pattern ^\d{1,10}$
     *
     * @param string|int|float|null $quantity
     *
     * @return static
     *
     * @throws InvalidArgumentException
     * @throws InvalidArgumentException
     *
     * @example 12
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Content::$quantity
     */
    public function setQuantity($quantity): ContentInterface;

    /**
     * Get value.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Content::$value
     */
    public function getValue(): ?string;

    /**
     * Set value.
     *
     * @pattern ^\d{1,9}\.\d{2}$
     *
     * @param string|float|int|null $value
     *
     * @return static
     *
     * @example 12.00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Content::$value
     */
    public function setValue($value): ContentInterface;

    /**
     * Get weight.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Content::$weight
     */
    public function getWeight(): ?string;

    /**
     * Set weight.
     *
     * @pattern ^\d{1,20}$
     *
     * @param string|int|float|null $weight
     *
     * @return static
     *
     * @example 2600
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Content::$weight
     */
    public function setWeight(?string $weight): ContentInterface;
}
