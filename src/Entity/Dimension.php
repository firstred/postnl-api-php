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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * @since 1.0.0
 */
class Dimension extends AbstractEntity
{
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Height = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Length = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Volume = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Weight = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Width = null;

    public function __construct(
        ?string $Weight = null,
        ?string $Height = null,
        ?string $Length = null,
        ?string $Volume = null,
        ?string $Width = null,
    ) {
        parent::__construct();

        $this->setWeight(Weight: $Weight);

        // Optional parameters.
        $this->setHeight(Height: $Height);
        $this->setLength(Length: $Length);
        $this->setVolume(Volume: $Volume);
        $this->setWidth(Width: $Width);
    }

    public function getHeight(): ?string
    {
        return $this->Height;
    }

    public function setHeight(?string $Height): static
    {
        $this->Height = $Height;

        return $this;
    }

    public function getLength(): ?string
    {
        return $this->Length;
    }

    public function setLength(?string $Length): static
    {
        $this->Length = $Length;

        return $this;
    }

    public function getVolume(): ?string
    {
        return $this->Volume;
    }

    public function setVolume(?string $Volume): static
    {
        $this->Volume = $Volume;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->Weight;
    }

    public function setWeight(?string $Weight): static
    {
        $this->Weight = $Weight;

        return $this;
    }

    public function getWidth(): ?string
    {
        return $this->Width;
    }

    public function setWidth(?string $Width): static
    {
        $this->Width = $Width;

        return $this;
    }
}
