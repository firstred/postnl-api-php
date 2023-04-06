<?php

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Entity\Soap;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Response\GenerateBarcodeResponse;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * NOTE: this class has been introduced for deserializing
 *
 * @since 1.0.0
 * @deprecated 2.0.0
 */
class Body extends AbstractEntity
{
    /** @var GenerateBarcodeResponse|null $GenerateBarcodeResponse */
    #[SerializableProperty(namespace: SoapNamespace::Envelope)]
    protected ?GenerateBarcodeResponse $GenerateBarcodeResponse = null;

    /**
     * @return GenerateBarcodeResponse|null
     */
    public function getGenerateBarcodeResponse(): ?GenerateBarcodeResponse
    {
        return $this->GenerateBarcodeResponse;
    }

    /**
     * @param GenerateBarcodeResponse|null $GenerateBarcodeResponse
     *
     * @return static
     */
    public function setGenerateBarcodeResponse(?GenerateBarcodeResponse $GenerateBarcodeResponse): static
    {
        $this->GenerateBarcodeResponse = $GenerateBarcodeResponse;

        return $this;
    }
}
