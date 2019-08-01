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

use Firstred\PostNL\Misc\ValidateAndFix;
use ReflectionException;
use TypeError;

/**
 * Class Dimension
 */
class Dimension extends AbstractEntity
{
    /**
     * Height of the shipment in millimeters (mm).
     *
     * @pattern ^\d{1,20}$
     *
     * @example 1400
     *
     * @var string|null $height
     *
     * @since 1.0.0
     */
    protected $height;

    /**
     * Length of the shipment in millimeters (mm).
     *
     * @pattern ^\d{1,20}$
     *
     * @example 2000
     *
     * @var string|null $length
     *
     * @since 1.0.0
     */
    protected $length;

    /**
     * Volume of the shipment in centimeters (cm3).
     * Mandatory for E@H-products
     *
     * @pattern ^\d{1,20}$
     *
     * @example 30000
     *
     * @var string|null $volume
     *
     * @since 1.0.0
     */
    protected $volume;

    /**
     * Weight of the shipment in grams
     * Approximate weight suffices
     *
     * @pattern ^\d{1,20}$
     *
     * @example 4300
     *
     * @var string|null $weight
     *
     * @since 1.0.0
     */
    protected $weight;

    /**
     * Width of the shipment in millimeters (mm).
     *
     * @pattern ^\d{1,20}$
     *
     * @example 1500
     *
     * @var string|null $width
     *
     * @since 1.0.0
     */
    protected $width;

    /**
     * Dimension constructor.
     *
     * @param int|float|string|null $weight
     * @param int|float|string|null $height
     * @param int|float|string|null $length
     * @param int|float|string|null $width
     * @param int|float|string|null $volume
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct($weight = null, $height = null, $length = null, $width = null, $volume = null)
    {
        parent::__construct();

        $this->setWeight($weight);

        // Optional parameters.
        $this->setHeight($height);
        $this->setLength($length);
        $this->setWidth($width);
        $this->setVolume($volume);
    }

    /**
     * Get height
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Dimension::$height
     */
    public function getHeight(): ?string
    {
        return $this->height;
    }

    /**
     * Set height
     *
     * @pattern ^\d{1,20}$
     *
     * @param string|int|float|null $height
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example 1400
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Dimension::$height
     */
    public function setHeight($height): Dimension
    {
        $this->height = ValidateAndFix::numericString($height);

        return $this;
    }

    /**
     * Get length
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Dimension::$length
     */
    public function getLength(): ?string
    {
        return $this->length;
    }

    /**
     * Set length
     *
     * @pattern ^\d{1,20}$
     *
     * @param string|float|int|null $length
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example 2000
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Dimension::$length
     */
    public function setLength($length): Dimension
    {
        $this->length = ValidateAndFix::numericString($length);

        return $this;
    }

    /**
     * Get weight
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Dimension::$weight
     */
    public function getWeight(): ?string
    {
        return $this->weight;
    }

    /**
     * Set weight
     *
     * @pattern ^\d{1,20}$
     *
     * @param string|float|int|null $weight
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example 4300
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Dimension::$weight
     */
    public function setWeight($weight): Dimension
    {
        $this->weight = ValidateAndFix::numericString($weight);

        return $this;
    }

    /**
     * Get weight
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Dimension::$width
     */
    public function getWidth(): ?string
    {
        return $this->width;
    }

    /**
     * Get width
     *
     * @pattern ^\d{1,20}$
     *
     * @param string|int|float|null $width
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example 1500
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Dimension::$width
     */
    public function setWidth($width): Dimension
    {
        $this->width = ValidateAndFix::numericString($width);

        return $this;
    }

    /**
     * Get volume
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Dimension::$volume
     */
    public function getVolume(): ?string
    {
        return $this->volume;
    }

    /**
     * Set volume
     *
     * @pattern ^\d{1,20}$
     *
     * @param string|null $volume
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example 30000
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Dimension::$volume
     */
    public function setVolume($volume): Dimension
    {
        $this->volume = ValidateAndFix::numericString($volume);

        return $this;
    }
}
