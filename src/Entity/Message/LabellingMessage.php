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

namespace Firstred\PostNL\Entity\Message;

use Exception;

/**
 * Class LabellingMessage
 */
class LabellingMessage extends Message
{
    /**
     * @var string|null $printerType
     */
    protected $printerType;
    /**
     * @var string|null $Printertype
     */

    /**
     * LabellingMessage constructor
     *
     * @param string|null $printerType Printer type
     * @param string|null $mid         Message ID
     * @param string|null $timestamp   Timestamp
     *
     * @throws Exception
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
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getPrinterType(): ?string
    {
        return $this->printerType;
    }

    /**
     * @param string|null $printertype
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setPrinterType(?string $printertype): LabellingMessage
    {
        $this->printerType = $printertype;

        return $this;
    }
}
