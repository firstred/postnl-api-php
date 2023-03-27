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

namespace Firstred\PostNL\Entity\Soap;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * NOTE: this class has been introduced for deserializing
 *
 * @since 1.0.0
 * @deprecated 2.0.0
 */
class Envelope extends AbstractEntity
{
    /** @var Header|null $Header */
    #[SerializableProperty(namespace: SoapNamespace::Envelope)]
    protected ?Header $Header = null;

    /** @var Body|null $Body */
    #[SerializableProperty(namespace: SoapNamespace::Envelope)]
    protected ?Body $Body = null;

    /**
     * @param Header|null $Header
     * @param Body|null   $Body
     */
    public function __construct(Header $Header = null, Body $Body = null)
    {
        parent::__construct();

        if ($Header) {
            $this->setHeader(Header: $Header);
        }
        if ($Body) {
            $this->setBody(Body: $Body);
        }
    }

    /**
     * @return Header|null
     */
    public function getHeader(): ?Header
    {
        return $this->Header;
    }

    /**
     * @param Header|null $Header
     *
     * @return $this
     */
    public function setHeader(?Header $Header): static
    {
        $this->Header = $Header;

        return $this;
    }

    /**
     * @return Body|null
     */
    public function getBody(): ?Body
    {
        return $this->Body;
    }

    /**
     * @param Body|null $Body
     *
     * @return $this
     */
    public function setBody(?Body $Body): static
    {
        $this->Body = $Body;

        return $this;
    }
}
