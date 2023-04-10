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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\SerializableProperty;

/**
 * @since 1.0.0
 */
class Label extends AbstractEntity
{
    public const FORMAT_A4 = 1;
    public const FORMAT_A6 = 2;

    /**
     * Base 64 encoded content.
     *
     * @var string|null $Content
     */
    #[SerializableProperty(type: 'string')]
    protected ?string $Content = null;

    /** @var string|null $Contenttype */
    #[SerializableProperty(type: 'string')]
    protected ?string $Contenttype = null;

    /** @var string|null $Labeltype */
    #[SerializableProperty(type: 'string')]
    protected ?string $Labeltype = null;

    /**
     * @param string|null $Content
     * @param string|null $ContentType
     * @param string|null $Labeltype
     */
    public function __construct(
        ?string $Content = null,
        ?string $ContentType = null,
        ?string $Labeltype = null,
    ) {
        parent::__construct();

        $this->setContent(Content: $Content);
        $this->setContenttype(Contenttype: $ContentType);
        $this->setLabeltype(Labeltype: $Labeltype);
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->Content;
    }

    /**
     * @param string|null $Content
     *
     * @return static
     */
    public function setContent(?string $Content): static
    {
        $this->Content = $Content;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContenttype(): ?string
    {
        return $this->Contenttype;
    }

    /**
     * @param string|null $Contenttype
     *
     * @return static
     */
    public function setContenttype(?string $Contenttype): static
    {
        $this->Contenttype = $Contenttype;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabeltype(): ?string
    {
        return $this->Labeltype;
    }

    /**
     * @param string|null $Labeltype
     *
     * @return static
     */
    public function setLabeltype(?string $Labeltype): static
    {
        $this->Labeltype = $Labeltype;

        return $this;
    }
}
