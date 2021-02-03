<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\DTO\Response;

class GetSignatureResponseSignature
{
    protected string|null $Barcode = null;
    protected string|null $SignatureDate = null;
    protected string|null $SignatureImage = null;

    public function __construct(string|null $barcode = null, string|null $signatureDate = null, string|null $signatureImage = null)
    {
        $this->setBarcode(barcode: $barcode);
        $this->setSignatureDate(signatureDate: $signatureDate);
        $this->setSignatureImage(signatureImage: $signatureImage);
    }

    public function getBarcode(): string|null
    {
        return $this->Barcode;
    }

    public function setBarcode(string|null $barcode = null): static
    {
        $this->Barcode = $barcode;

        return $this;
    }

    public function getSignatureDate(): string|null
    {
        return $this->SignatureDate;
    }

    public function setSignatureDate(string|null $signatureDate = null): static
    {
        $this->SignatureDate = $signatureDate;

        return $this;
    }

    public function getSignatureImage(): string|null
    {
        return $this->SignatureImage;
    }

    public function setSignatureImage(string|null $signatureImage = null): static
    {
        $this->SignatureImage = $signatureImage;

        return $this;
    }
}
