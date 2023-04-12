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
    #[SerializableProperty(type: 'string', aliases: ['Contenttype'])]
    protected ?string $OutputType = null;

    /** @var string|null $Labeltype */
    #[SerializableProperty(type: 'string')]
    protected ?string $Labeltype = null;

    /**
     * @param string|null $Content
     * @param string|null $OutputType
     * @param string|null $Labeltype
     */
    public function __construct(
        ?string $Content = null,
        ?string $OutputType = null,
        ?string $Labeltype = null,
    ) {
        parent::__construct();

        $this->setContent(Content: $Content);
        $this->setOutputType(OutputType: $OutputType);
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
     *
     * @since 1.4.2
     */
    public function getOutputType(): ?string
    {
        return $this->OutputType;
    }

    /**
     * @param string|null $OutputType
     *
     * @return static
     *
     * @since 1.4.2
     */
    public function setOutputType(?string $OutputType): static
    {
        $this->OutputType = $OutputType;

        return $this;
    }

    /**
     * @return string|null
     *
     * @deprecated 1.4.2
     */
    public function getContenttype(): ?string
    {
        return $this->getOutputType();
    }

    /**
     * @param string|null $Contenttype
     *
     * @return static
     *
     * @deprecated 1.4.2
     */
    public function setContenttype(?string $Contenttype): static
    {
        return $this->setOutputType(OutputType: $Contenttype);
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
