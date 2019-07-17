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

namespace Firstred\PostNL\Entity;

/**
 * Class Dimension
 */
class Dimension extends AbstractEntity
{
    /** @var string|null $height */
    protected $height;
    /** @var string|null $length */
    protected $length;
    /** @var string|null $volume */
    protected $volume;
    /** @var string|null $weight */
    protected $weight;
    /** @var string|null $width */
    protected $width;

    /**
     * @param int $weight
     * @param int $height
     * @param int $length
     * @param int $volume
     * @param int $width
     */
    public function __construct(?int $weight = null, ?int $height = null, ?int $length = null, ?int $volume = null, ?int $width = null)
    {
        parent::__construct();

        $this->setWeight($weight);

        // Optional parameters.
        $this->setHeight($height);
        $this->setLength($length);
        $this->setVolume($volume);
        $this->setWidth($width);
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getHeight(): ?string
    {
        return $this->height;
    }

    /**
     * @param string|null $height
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setHeight(?string $height): Dimension
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getLength(): ?string
    {
        return $this->length;
    }

    /**
     * @param string|null $length
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLength(?string $length): Dimension
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getVolume(): ?string
    {
        return $this->volume;
    }

    /**
     * @param string|null $volume
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setVolume(?string $volume): Dimension
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getWeight(): ?string
    {
        return $this->weight;
    }

    /**
     * @param string|null $weight
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setWeight(?string $weight): Dimension
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getWidth(): ?string
    {
        return $this->width;
    }

    /**
     * @param string|null $width
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setWidth(?string $width): Dimension
    {
        $this->width = $width;

        return $this;
    }
}
