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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Dimension.
 */
class Dimension extends SerializableObject
{
    /**
     * Dimension constructor.
     *
     * @param string      $service
     * @param string      $propType
     * @param string|null $Height
     * @param string|null $Length
     * @param string|null $Volume
     * @param string|null $Weight
     * @param string|null $Width
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        protected string|null $Height = null,
        protected string|null $Length = null,
        protected string|null $Volume = null,
        protected string|null $Weight = null,
        protected string|null $Width = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setWeight(weight: $Weight);

        // Optional parameters.
        $this->setHeight(height: $Height);
        $this->setLength(length: $Length);
        $this->setVolume(volume: $Volume);
        $this->setWidth(width: $Width);
    }

    /**
     * @return string|null
     */
    public function getHeight(): string|null
    {
        return $this->Height;
    }

    /**
     * @param string|null $Height
     *
     * @return static
     */
    public function setHeight(string|null $Height = null): static
    {
        $this->Height = $Height;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLength(): string|null
    {
        return $this->Length;
    }

    /**
     * @param string|null $Length
     *
     * @return static
     */
    public function setLength(string|null $Length = null): static
    {
        $this->Length = $Length;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVolume(): string|null
    {
        return $this->Volume;
    }

    /**
     * @param string|null $Volume
     *
     * @return static
     */
    public function setVolume(string|null $Volume = null): static
    {
        $this->Volume = $Volume;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWeight(): string|null
    {
        return $this->Weight;
    }

    /**
     * @param string|null $Weight
     *
     * @return static
     */
    public function setWeight(string|null $Weight = null): static
    {
        $this->Weight = $Weight;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWidth(): string|null
    {
        return $this->Width;
    }

    /**
     * @param string|null $Width
     *
     * @return static
     */
    public function setWidth(string|null $Width = null): static
    {
        $this->Width = $Width;

        return $this;
    }
}
