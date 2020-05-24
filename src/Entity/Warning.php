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

/**
 * Class Warning.
 */
final class Warning extends AbstractEntity implements WarningInterface
{
    /**
     * Code.
     *
     * @pattern ^.*$
     *
     * @example N/A
     *
     * @var string|int|null
     *
     * @since   1.0.0
     */
    private $code;

    /**
     * Description.
     *
     * @pattern ^.*$
     *
     * @example N/A
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $description;

    /**
     * Get code.
     *
     * @return string|int|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Warning::$code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set code.
     *
     * @pattern ^.*$
     *
     * @example N/A
     *
     * @param string|int|null $code
     *
     * @return static
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Warning::$code
     */
    public function setCode($code): WarningInterface
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Warning::$description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set description.
     *
     * @pattern ^.*$
     *
     * @example N/A
     *
     * @param string|null $description
     *
     * @return static
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Warning::$description
     */
    public function setDescription(?string $description): WarningInterface
    {
        $this->description = $description;

        return $this;
    }
}
