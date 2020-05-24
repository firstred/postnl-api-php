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
final class Content extends AbstractEntity implements ContentInterface
{
    /**
     * Description of the goods.
     *
     * @pattern ^.{1,35}$
     *
     * @example Powdered milk
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $description;

    /**
     * A unique code for a product. Together with HS number this is mandatory for product code 4992.
     *
     * @pattern ^\d{8}\d{5}?$
     *
     * @example 7501031311309
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $EAN;

    /**
     * Webshop URL of the product which is being shipped. Mandatory for product code 4992.
     *
     * @pattern N/A
     *
     * @example https://www.example.com/product
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $productUrl;

    /**
     * Country code.
     *
     * @pattern ^[A-Z]{2}$
     *
     * @example NL
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $countryOfOrigin;

    /**
     * Harmonized System Tariff Number.
     *
     * First 6 digits of Harmonized System Code
     *
     * @pattern ^\d{6}$
     *
     * @example 950306
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $HSTariffNr;

    /**
     * Quantity.
     *
     * Quantity of items in description
     *
     * @pattern ^\d{1,10}$
     *
     * @example 12
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $quantity;

    /**
     * Value.
     *
     * Commercial (customs) value of goods.
     *
     * @pattern ^\d{1,9}\.\d{2}$
     *
     * @example 12.00
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $value;

    /**
     * Weight.
     *
     * Net weight of goods in gram (gr)
     *
     * @pattern ^\d{1,20}$
     *
     * @example 2600
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $weight;

    /**
     * Get country of origin.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Content::$countryOfOrigin
     */
    public function getCountryOfOrigin(): ?string
    {
        return $this->countryOfOrigin;
    }

    /**
     * Set country of origin.
     *
     * @pattern ^[A-Z]{2}$
     *
     * @example NL
     *
     * @param string|null $countryOfOrigin
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Content::$countryOfOrigin
     */
    public function setCountryOfOrigin(?string $countryOfOrigin): ContentInterface
    {
        $this->countryOfOrigin = $this->validate->isoAlpha2CountryCode($countryOfOrigin);

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Content::$description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set description.
     *
     * @pattern ^.{1,35}$
     *
     * @example Powdered milk
     *
     * @param string|null $description
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Content::$description
     */
    public function setDescription(?string $description): ContentInterface
    {
        $this->description = $this->validate->genericString($description);

        return $this;
    }

    /**
     * Get EAN.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   Content::$EAN
     */
    public function getEAN(): ?string
    {
        return $this->EAN;
    }

    /**
     * Set EAN.
     *
     * @pattern ^\d{8}\d{5}?$
     *
     * @example 7501031311309
     *
     * @param string|null $ean
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0 Strict typing
     * @see     Content::$EAN
     */
    public function setEAN(?string $ean): ContentInterface
    {
        $this->EAN = $this->validate->ean($ean);

        return $this;
    }

    /**
     * Get product URL.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   Content::$productUrl
     */
    public function getProductUrl(): ?string
    {
        return $this->productUrl;
    }

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
    public function setProductUrl(?string $productUrl): ContentInterface
    {
        $this->productUrl = $this->validate->url($productUrl);

        return $this;
    }

    /**
     * Get the Harmonized System Tariff Number.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Content::$HSTariffNr
     */
    public function getHSTariffNr(): ?string
    {
        return $this->HSTariffNr;
    }

    /**
     * Set the Harmonized System Tariff Number.
     *
     * @pattern ^\d{6}$
     *
     * @example 950306
     *
     * @param string|null $HSTariffNr
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Content::$HSTariffNr
     */
    public function setHSTariffNr(?string $HSTariffNr): ContentInterface
    {
        $this->HSTariffNr = $this->validate->harmonizedSystemTariffNumber($HSTariffNr);

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Content::$quantity
     */
    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    /**
     * Set quantity.
     *
     * @pattern ^\d{1,10}$
     *
     * @example 12
     *
     * @param string|int|float|null $quantity
     *
     * @return static
     *
     * @throws InvalidArgumentException
     * @throws InvalidArgumentException
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Content::$quantity
     */
    public function setQuantity($quantity): ContentInterface
    {
        $this->quantity = $this->validate->numericString($quantity);

        return $this;
    }

    /**
     * Get value.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Content::$value
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Set value.
     *
     * @pattern ^\d{1,9}\.\d{2}$
     *
     * @example 12.00
     *
     * @param string|float|int|null $value
     *
     * @return static
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Content::$value
     */
    public function setValue($value): ContentInterface
    {
        if (is_int($value) || is_float($value)) {
            $value = number_format($value, 2);
        }

        $this->value = $value;

        return $this;
    }

    /**
     * Get weight.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Content::$weight
     */
    public function getWeight(): ?string
    {
        return $this->weight;
    }

    /**
     * Set weight.
     *
     * @pattern ^\d{1,20}$
     *
     * @example 2600
     *
     * @param string|int|float|null $weight
     *
     * @return static
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Content::$weight
     */
    public function setWeight(?string $weight): ContentInterface
    {
        if (is_int($weight) || is_float($weight)) {
            $weight = number_format($weight, 0);
        }

        $this->weight = $weight;

        return $this;
    }
}
