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
 * Class Label.
 */
interface LabelInterface extends EntityInterface
{
    /**
     * Get content.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Label::$content
     */
    public function getContent(): ?string;

    /**
     * Set content.
     *
     * @pattern N/A
     *
     * @param string|null $content
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Label::$content
     */
    public function setContent(?string $content): LabelInterface;

    /**
     * Get content type.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Label::$contenttype
     */
    public function getContenttype(): ?string;

    /**
     * Set content type.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $contenttype
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example PDF
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Label::$contenttype
     */
    public function setContenttype(?string $contenttype): LabelInterface;

    /**
     * Get label type.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Label::$labeltype
     */
    public function getLabeltype(): ?string;

    /**
     * Set label type.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $labeltype
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example Label (A6)
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Label::$labeltype
     */
    public function setLabeltype(?string $labeltype): LabelInterface;
}
