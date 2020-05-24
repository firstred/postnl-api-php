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
 * Class ProductOption.
 */
final class ProductOption extends AbstractEntity implements ProductOptionInterface
{
    /**
     * The characteristic of the ProductOption. Mandatory for some products.
     *
     * @pattern \d{3}$
     *
     * @example 118
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $characteristic;

    /**
     * The product option code for this ProductOption. Mandatory for some products.
     *
     * @pattern ^\d{3}$
     *
     * @example 006
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $option;

    /**
     * Get characteristic.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   ProductOption::$characteristic
     */
    public function getCharacteristic(): ?string
    {
        return $this->characteristic;
    }

    /**
     * Set characteristic.
     *
     * @pattern \d{3}$
     *
     * @example 118
     *
     * @param string|null $characteristic
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     ProductOption::$characteristic
     */
    public function setCharacteristic(?string $characteristic): ProductOptionInterface
    {
        $this->characteristic = $this->validate->productOption($characteristic);

        return $this;
    }

    /**
     * Get option.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   ProductOption::$option
     */
    public function getOption(): ?string
    {
        return $this->option;
    }

    /**
     * Set option.
     *
     * @pattern ^\d{3}$
     *
     * @example 006
     *
     * @param string|null $option
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     ProductOption::$option
     */
    public function setOption(?string $option): ProductOptionInterface
    {
        $this->option = $this->validate->productOption($option);

        return $this;
    }
}
