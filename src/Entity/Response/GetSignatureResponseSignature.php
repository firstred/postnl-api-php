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

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use TypeError;

/**
 * Class GetSignatureResponseSignature
 */
class GetSignatureResponseSignature extends AbstractEntity
{
    /**
     * @var string|null $barcode
     *
     * @since 1.0.0
     */
    protected $barcode;

    /**
     * @var string|null $signatureDate
     *
     * @since 1.0.0
     */
    protected $signatureDate;

    /**
     * @var string|null $signatureImage
     *
     * @since 1.0.0
     */
    protected $signatureImage;

    /**
     * GetSignatureResponseSignature constructor.
     *
     * @param string|null $barcode
     * @param string|null $signatureDate
     * @param string|null $signatureImage
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct($barcode = null, $signatureDate = null, $signatureImage = null)
    {
        parent::__construct();

        $this->setBarcode($barcode);
        $this->setSignatureDate($signatureDate);
        $this->setSignatureImage($signatureImage);
    }

    /**
     * Get barcode
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * Set barcode
     *
     * @param string|null $barcode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setBarcode(?string $barcode): GetSignatureResponseSignature
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get signature date
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getSignatureDate(): ?string
    {
        return $this->signatureDate;
    }

    /**
     * Set signature date
     *
     * @param string|null $signatureDate
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setSignatureDate(?string $signatureDate): GetSignatureResponseSignature
    {
        $this->signatureDate = $signatureDate;

        return $this;
    }

    /**
     * Get signature image
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getSignatureImage(): ?string
    {
        return $this->signatureImage;
    }

    /**
     * Set signature image
     *
     * @param string|null $signatureImage
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setSignatureImage(?string $signatureImage): GetSignatureResponseSignature
    {
        $this->signatureImage = $signatureImage;

        return $this;
    }
}
