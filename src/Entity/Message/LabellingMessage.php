<?php
declare(strict_types=1);
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

namespace Firstred\PostNL\Entity\Message;

use DateTimeInterface;
use Firstred\PostNL\Attribute\SerializableScalarProperty;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * @since 1.0.0
 * @deprecated 2.0.0
 */
class LabellingMessage extends Message
{
    /** @var string|null $Printertype */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Printertype = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string                       $Printertype = 'GraphicFile|PDF',
        ?string                       $MessageID = null,
        string|DateTimeInterface|null $MessageTimeStamp = null
    ) {
        parent::__construct(MessageID: $MessageID, MessageTimeStamp: $MessageTimeStamp);

        $this->setPrintertype(Printertype: $Printertype);
    }

    /**
     * @return string|null
     */
    public function getPrintertype(): ?string
    {
        return $this->Printertype;
    }

    /**
     * @param string|null $Printertype
     *
     * @return static
     */
    public function setPrintertype(?string $Printertype): static
    {
        $this->Printertype = $Printertype;

        return $this;
    }
}
