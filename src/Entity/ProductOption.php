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

use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\ValidateAndFix;

/**
 * Class ProductOption
 */
class ProductOption extends AbstractEntity
{
    /**
     * The characteristic of the ProductOption. Mandatory for some products.
     *
     * @pattern \d{3}$
     *
     * @example 118
     *
     * @var string|null $characteristic
     *
     * @since   1.0.0
     */
    protected $characteristic;

    /**
     * The product option code for this ProductOption. Mandatory for some products.
     *
     * @pattern ^\d{3}$
     *
     * @example 006
     *
     * @var string|null $option
     *
     * @since   1.0.0
     */
    protected $option;

    /**
     * ProductOption constructor.
     *
     * @param string|null $characteristic
     * @param string|null $option
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct($characteristic = null, $option = null)
    {
        parent::__construct();

        $this->setCharacteristic($characteristic);
        $this->setOption($option);
    }

    /**
     * Get characteristic
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   ProductOption::$characteristic
     */
    public function getCharacteristic(): ?string
    {
        return $this->characteristic;
    }

    /**
     * Set characteristic
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
     *
     * @see     ProductOption::$characteristic
     */
    public function setCharacteristic(?string $characteristic): ProductOption
    {
        $this->characteristic = ValidateAndFix::productOption($characteristic);

        return $this;
    }

    /**
     * Get option
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   ProductOption::$option
     */
    public function getOption(): ?string
    {
        return $this->option;
    }

    /**
     * Set option
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
     *
     * @see     ProductOption::$option
     */
    public function setOption(?string $option): ProductOption
    {
        $this->option = ValidateAndFix::productOption($option);

        return $this;
    }
}
