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

use Firstred\PostNL\Entity\Response\AbstractResponse;

/**
 * Class Signature
 */
class Signature extends AbstractResponse
{
    /**
     * Barcode
     *
     * @var string|null $barcode
     *
     * @since 2.0.0
     */
    protected $barcode;

    /**
     * Signature date/time
     *
     * @var string|null $signatureDate
     *
     * @since 2.0.0
     */
    protected $signatureDate;

    /**
     * Base64 encoded signature image
     *
     * @var string|null $signatureImage
     *
     * @since 2.0.0
     */
    protected $signatureImage;

    /**
     * Signature constructor.
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * @param string|null $barcode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setBarcode(?string $barcode): Signature
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getSignatureDate(): ?string
    {
        return $this->signatureDate;
    }

    /**
     * @param string|null $signatureDate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setSignatureDate(?string $signatureDate): Signature
    {
        $this->signatureDate = $signatureDate;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getSignatureImage(): ?string
    {
        return $this->signatureImage;
    }

    /**
     * @param string|null $signatureImage
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setSignatureImage(?string $signatureImage): Signature
    {
        $this->signatureImage = $signatureImage;

        return $this;
    }
}
