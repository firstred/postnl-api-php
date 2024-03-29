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
class Barcode extends AbstractEntity
{
    /** @var string|null $Type */
    #[SerializableProperty(type: 'string')]
    protected ?string $Type = null;

    /** @var string|null $Range */
    #[SerializableProperty(type: 'string')]
    protected ?string $Range = null;

    /** @var string|null $Serie */
    #[SerializableProperty(type: 'string')]
    protected ?string $Serie = null;

    /**
     * @param string|null $Type
     * @param string|null $Range
     * @param string|null $Serie
     */
    public function __construct(
        ?string $Type = null,
        ?string $Range = null,
        ?string $Serie = '000000000-999999999'
    ) {
        parent::__construct();

        $this->setType(Type: $Type);
        $this->setRange(Range: $Range);
        $this->setSerie(Serie: $Serie);
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->Type;
    }

    /**
     * @param string|null $Type
     *
     * @return static
     */
    public function setType(?string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRange(): ?string
    {
        return $this->Range;
    }

    /**
     * @param string|null $Range
     *
     * @return static
     */
    public function setRange(?string $Range): static
    {
        $this->Range = $Range;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSerie(): ?string
    {
        return $this->Serie;
    }

    /**
     * @param string|null $Serie
     *
     * @return static
     */
    public function setSerie(?string $Serie): static
    {
        $this->Serie = $Serie;

        return $this;
    }
}
