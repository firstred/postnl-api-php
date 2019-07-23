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

use Firstred\PostNL\Exception\InvalidTypeException;

/**
 * Class Dimension
 */
class Dimension extends AbstractEntity
{
    /**
     * @var string|null $height
     *
     * @since 1.0.0
     */
    protected $height;

    /**
     * @var string|null $length
     *
     * @since 1.0.0
     */
    protected $length;

    /**
     * @var string|null $volume
     *
     * @since 1.0.0
     */
    protected $volume;

    /**
     * @var string|null $weight
     *
     * @since 1.0.0
     */
    protected $weight;

    /**
     * @var string|null $width
     *
     * @since 1.0.0
     */
    protected $width;

    /**
     * Dimension constructor.
     *
     * @param string $weight
     * @param string $height
     * @param string $length
     * @param string $volume
     * @param string $width
     *
     * @throws InvalidTypeException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $weight = null, ?string $height = null, ?string $length = null, ?string $volume = null, ?string $width = null)
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
     * @since 1.0.0
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
     * @throws InvalidTypeException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setHeight(?string $height): Dimension
    {
        if (is_string($height) && !is_numeric($height)) {
            throw new InvalidTypeException('Invalid height, must be a numeric string or null');
        }

        $this->height = $height;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
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
     * @throws InvalidTypeException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setLength(?string $length): Dimension
    {
        if (is_string($length) && !is_numeric($length)) {
            throw new InvalidTypeException('Invalid length, must be numeric string or null');
        }

        $this->length = $length;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
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
     * @throws InvalidTypeException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setVolume(?string $volume): Dimension
    {
        if (is_string($volume) && !is_numeric($volume)) {
            throw new InvalidTypeException('Invalid volume, must be a numeric string or null');
        }

        $this->volume = $volume;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
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
     * @throws InvalidTypeException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setWeight(?string $weight): Dimension
    {
        if (is_string($weight) && !is_numeric($weight)) {
            throw new InvalidTypeException('Invalid weight, must be a numeric string or null');
        }

        $this->weight = $weight;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
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
     * @throws InvalidTypeException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setWidth(?string $width): Dimension
    {
        if (is_string($width) && !is_numeric($width)) {
            throw new InvalidTypeException('Invalid width, must be a numeric string or null');
        }

        $this->width = $width;

        return $this;
    }
}
