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
 * Class Barcode
 */
class Barcode extends AbstractEntity
{
    /** @var string|null $type */
    protected $type;
    /** @var string|null $range */
    protected $range;
    /** @var string|null $serie */
    protected $serie;

    /**
     * @param string|null $type
     * @param string|null $range
     * @param string|null $serie
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
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setType(?string $type): Barcode
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getRange(): ?string
    {
        return $this->range;
    }

    /**
     * @param string|null $range
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setRange(?string $range): Barcode
    {
        $this->range = $range;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getSerie(): ?string
    {
        return $this->serie;
    }

    /**
     * @param string|null $serie
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setSerie(?string $serie): Barcode
    {
        $this->serie = $serie;

        return $this;
    }
}
