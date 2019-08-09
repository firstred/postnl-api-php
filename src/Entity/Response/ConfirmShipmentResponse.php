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

namespace Firstred\PostNL\Entity\Response;

/**
 * Class ConfirmShipmentResponse
 */
class ConfirmShipmentResponse extends AbstractResponse
{
    /**
     * Barcode
     *
     * @pattern ^.{1,35}$
     *
     * @example 3SDEVC2016112104
     *
     * @var string|null $barcode
     *
     * @since   1.0.0
     */
    protected $barcode;

    /**
     * ConfirmShipmentResponse constructor.
     *
     * @param string|null $barcode
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $barcode = null)
    {
        parent::__construct();

        $this->setBarcode($barcode);
    }

    /**
     * Get barcode
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   GenerateBarcodeRequest
     */
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * Set barcode
     *
     * @pattern ^.{1,35}$
     *
     * @example 3SDEVC2016112104
     *
     * @param string|null $barcode
     *
     * @return static
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     GenerateBarcodeRequest
     */
    public function setBarcode(?string $barcode): ConfirmShipmentResponse
    {
        $this->barcode = $barcode;

        return $this;
    }
}
