<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
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
 * @copyright 2017-2019 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Interface GenerateBarcodeRequestEntityInterface.
 */
interface GenerateBarcodeRequestEntityInterface
{
    /**
     * Get type.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   GenerateBarcodeRequestEntity::$type
     */
    public function getType(): ?string;

    /**
     * Set type.
     *
     * @pattern ^(?:2S|3S|CC|CP|CD|CF|LA|CX)$
     *
     * @param string|null $type
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 3S
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     GenerateBarcodeRequestEntity::$type
     */
    public function setType(?string $type): GenerateBarcodeRequestEntity;

    /**
     * Get range.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   GenerateBarcodeRequestEntity::$range
     */
    public function getRange(): ?string;

    /**
     * Set range.
     *
     * @pattern ^[A-Z0-9]{1,4}$
     *
     * @param string|null $range
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example NL
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     GenerateBarcodeRequestEntity::$range
     */
    public function setRange(?string $range): GenerateBarcodeRequestEntity;

    /**
     * Set serie.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   GenerateBarcodeRequestEntity::$serie
     */
    public function getSerie(): ?string;

    /**
     * Set serie.
     *
     * @pattern ^\d{0,3}\d{6}-\d{0,3}\d{6}$
     *
     * @param string|null $serie
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 100000000-500000000
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     GenerateBarcodeRequestEntity::$serie
     */
    public function setSerie(?string $serie): GenerateBarcodeRequestEntity;
}
