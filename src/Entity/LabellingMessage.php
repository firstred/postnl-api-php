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
use ReflectionClass;
use ReflectionException;
use TypeError;

/**
 * Class LabellingMessage
 */
class LabellingMessage extends Message
{
    /**
     * Printer type that will be used to process the label, e.g. Zebra printer or PDF See Guidelines for the available printer types.
     *
     * @pattern ^.{0,35}$
     *
     * @example GraphicFile|PDF
     *
     * @var string|null $printerType
     *
     * @since   1.0.0
     */
    protected $printerType;

    /**
     * LabellingMessage constructor
     *
     * @param string|null $printerType Printer type
     * @param string|null $mid         Message ID
     * @param string|null $timestamp   Timestamp
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $printerType = 'GraphicFile|PDF', ?string $mid = null, ?string $timestamp = null)
    {
        parent::__construct($mid, $timestamp);

        $this->setPrintertype($printerType);
    }

    /**
     * Get printer type
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   LabellingMessage::$printerType
     */
    public function getPrinterType(): ?string
    {
        return $this->printerType;
    }

    /**
     * Set printer type
     *
     * @param string|null $printertype
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   LabellingMessage::$printerType
     */
    public function setPrinterType(?string $printertype): LabellingMessage
    {
        static $maxLength = 35;
        if (is_string($printertype) && mb_strlen($printertype) > $maxLength) {
            throw new InvalidTypeException(sprintf('%s::%s - Invalid printer type given, must be max 35 characters long', (new ReflectionClass($this))->getShortName(), __METHOD__));
        }

        $this->printerType = $printertype;

        return $this;
    }
}
