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
 * Class Barcode
 */
class Barcode extends AbstractEntity
{
    /**
     * Accepted values are: 2S, 3S, CC, CP, CD, CF, LA
     *
     * @var string|null $type
     *
     * @since 1.0.0
     */
    protected $type;

    /**
     * Range used when generating generic S10 barcodes (without a customer-specific component). If this is the case, please use ‘NL’ for this field in combination with Serie '00000000-99999999’. If you leave this field blank, the CustomerCode value will be used for the barcode.
     *
     * @var string|null $range
     *
     * @since 1.0.0
     */
    protected $range;

    /**
     * Barcode serie in the format '###000000-###000000’, for example 100000000-500000000. The range must consist of a minimal difference of 100.000. Minimum length of the serie is 6 characters; maximum length is 9 characters. It is allowed to add extra leading zeros at the beginning of the serie. See Guidelines for more information.
     *
     * @var string|null $serie
     *
     * @since 1.0.0
     */
    protected $serie;

    /**
     * @param string|null $type
     * @param string|null $range
     * @param string|null $serie
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct($type = null, $range = null, $serie = '000000000-999999999')
    {
        parent::__construct();

        $this->setType($type);
        $this->setRange($range);
        $this->setSerie($serie);
    }

    /**
     * Get type
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Barcode::$type
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param string|null $type
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Barcode::$type
     */
    public function setType(?string $type): Barcode
    {
        if (is_string($type) && !in_array($type, ['2S', '3S', 'CC', 'CP', 'CD', 'CF', 'LA', 'CX'])) {
            throw new InvalidTypeException(sprintf('%s::%s - Invalid barcode type given, must be one of: 2S, 3S, CC, CP, CD, CF, LA', 'CX', (new ReflectionClass($this))->getShortName(), __METHOD__));
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Get range
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Barcode::$range
     */
    public function getRange(): ?string
    {
        return $this->range;
    }

    /**
     * Set range
     *
     * @param string|null $range
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Barcode::$range
     */
    public function setRange(?string $range): Barcode
    {
        $this->range = $range;

        return $this;
    }

    /**
     * Set serie
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Barcode::$serie
     */
    public function getSerie(): ?string
    {
        return $this->serie;
    }

    /**
     * Get serie
     *
     * @param string|null $serie
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Barcode::$serie
     */
    public function setSerie(?string $serie): Barcode
    {
        if (!is_string($serie) && (!is_numeric($serie) || mb_strlen($serie) < 6 || mb_strlen($serie) > 9)) {
            throw new InvalidTypeException(sprintf('%s::%s - Invalid range given, must be a numeric string of 6 to 9 characters', (new ReflectionClass($this))->getShortName(), __METHOD__));
        }

        $this->serie = $serie;

        return $this;
    }
}
