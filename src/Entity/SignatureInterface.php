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
 * Class Signature.
 */
interface SignatureInterface extends EntityInterface
{
    /**
     * Get barcode.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   Signature::$barcode
     */
    public function getBarcode(): ?string;

    /**
     * Set barcode.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $barcode
     *
     * @return static
     *
     * @example 3SDEV2345234
     *
     * @since   2.0.0 Strict typing
     * @see     Signature::$barcode
     */
    public function setBarcode(?string $barcode): SignatureInterface;

    /**
     * Get signature date.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   Signature::$signatureDate
     */
    public function getSignatureDate(): ?string;

    /**
     * Set signature date.
     *
     * @param string|null $signatureDate
     *
     * @return static
     *
     * @example 2018-03-07T13:52:45.000+01:00
     *
     * @pattern N/A
     *
     * @since   2.0.0 Strict typing
     * @see     Signature::$signatureDate
     */
    public function setSignatureDate(?string $signatureDate): SignatureInterface;

    /**
     * Get signature image.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   Signature::$signatureImage
     */
    public function getSignatureImage(): ?string;

    /**
     * Set signature image.
     *
     * @pattern N/A
     *
     * @param string|null $signatureImage
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0 Strict typing
     * @see     Signature::$signatureImage
     */
    public function setSignatureImage(?string $signatureImage): SignatureInterface;
}
