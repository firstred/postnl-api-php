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

namespace Firstred\PostNL\Entity;

/**
 * Class Content
 */
class Content extends AbstractEntity
{
    /** @var string|null $countryOfOrigin */
    protected $countryOfOrigin;
    /** @var string|null $description */
    protected $description;
    /** @var string|null $HSTariffNr */
    protected $HSTariffNr;
    /** @var string|null $quantity */
    protected $quantity;
    /** @var string|null $value */
    protected $value;
    /** @var string|null $weight */
    protected $weight;
    /** @var Content[]|null $content */
    protected $content;

    /**
     * @param string|null    $countryOfOrigin
     * @param string|null    $description
     * @param string|null    $hsTariffNr
     * @param string|null    $qty
     * @param string|null    $val
     * @param string|null    $weight
     * @param Content[]|null $content
     */
    public function __construct(?string $countryOfOrigin = null, ?string $description = null, ?string $hsTariffNr = null, ?string $qty = null, ?string $val = null, ?string $weight = null, ?array $content = null)
    {
        parent::__construct();

        $this->setCountryOfOrigin($countryOfOrigin);
        $this->setDescription($description);
        $this->setHSTariffNr($hsTariffNr);
        $this->setQuantity($qty);
        $this->setValue($val);
        $this->setWeight($weight);
        $this->setContent($content);
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCountryOfOrigin(): ?string
    {
        return $this->countryOfOrigin;
    }

    /**
     * @param string|null $countryOfOrigin
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCountryOfOrigin(?string $countryOfOrigin): Content
    {
        $this->countryOfOrigin = $countryOfOrigin;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDescription(?string $description): Content
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getHSTariffNr(): ?string
    {
        return $this->HSTariffNr;
    }

    /**
     * @param string|null $HSTariffNr
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setHSTariffNr(?string $HSTariffNr): Content
    {
        $this->HSTariffNr = $HSTariffNr;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    /**
     * @param string|null $quantity
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setQuantity(?string $quantity): Content
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setValue(?string $value): Content
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getWeight(): ?string
    {
        return $this->weight;
    }

    /**
     * @param string|null $weight
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setWeight(?string $weight): Content
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return Content[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getContent(): ?array
    {
        return $this->content;
    }

    /**
     * @param Content[]|null $content
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setContent(?array $content): Content
    {
        $this->content = $content;

        return $this;
    }
}
