<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
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
 * @copyright 2017-2019 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class GenerateBarcodeRequest.
 */
final class GenerateBarcodeRequestEntity extends AbstractEntity implements GenerateBarcodeRequestEntityInterface
{
    /**
     * GenerateBarcodeRequest type.
     *
     * Accepted values are:
     * - 2S
     * - 3S
     * - CC
     * - CP
     * - CD
     * - CF
     * - LA
     * - CX
     *
     * @pattern ^(?:2S|3S|CC|CP|CD|CF|LA|CX)$
     *
     * @example 3S
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $type;

    /**
     * Range used when generating generic S10 barcodes (without a customer-specific component). If this is the case, please use ‘NL’ for this field in combination with Serie '00000000-99999999’. If
     * you leave this field blank, the CustomerCode value will be used for the barcode.
     *
     * @pattern ^.{0,35}$
     *
     * @example NL
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $range;

    /**
     * GenerateBarcodeRequest serie in the format '###000000-###000000’, for example 100000000-500000000. The range must consist of a minimal difference of 100.000. Minimum length of the serie is 6
     * characters; maximum length is 9 characters. It is allowed to add extra leading zeros at the beginning of the serie. See Guidelines for more information.
     *
     * @pattern ^\d{0,3}\d{6}-\d{0,3}\d{6}$
     *
     * @example 100000000-500000000
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $serie;

    /**
     * Get type.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   GenerateBarcodeRequestEntity::$type
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Set type.
     *
     * @pattern ^(?:2S|3S|CC|CP|CD|CF|LA|CX)$
     *
     * @param string|null $type
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 3S
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     GenerateBarcodeRequestEntity::$type
     */
    public function setType(?string $type): GenerateBarcodeRequestEntity
    {
        $this->type = $this->validate->barcodeType($type);

        return $this;
    }

    /**
     * Get range.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   GenerateBarcodeRequestEntity::$range
     */
    public function getRange(): ?string
    {
        return $this->range;
    }

    /**
     * Set range.
     *
     * @pattern ^[A-Z0-9]{1,4}$
     *
     * @param string|null $range
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example NL
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     GenerateBarcodeRequestEntity::$range
     */
    public function setRange(?string $range): GenerateBarcodeRequestEntity
    {
        $this->range = $this->validate->barcodeRange($range);

        return $this;
    }

    /**
     * Set serie.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   GenerateBarcodeRequestEntity::$serie
     */
    public function getSerie(): ?string
    {
        return $this->serie;
    }

    /**
     * Set serie.
     *
     * @pattern ^\d{0,3}\d{6}-\d{0,3}\d{6}$
     *
     * @param string|null $serie
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 100000000-500000000
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     GenerateBarcodeRequestEntity::$serie
     */
    public function setSerie(?string $serie): GenerateBarcodeRequestEntity
    {
        $this->serie = $this->validate->barcodeSerie($serie);

        return $this;
    }
}
