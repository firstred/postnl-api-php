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
 * Class Expectation
 */
class Expectation extends AbstractEntity
{
    /** @var string|null $ETAFrom */
    protected $ETAFrom;
    /** @var string|null $ETATo */
    protected $ETATo;

    /**
     * @param string $from
     * @param string $to
     */
    public function __construct($from = null, $to = null)
    {
        parent::__construct();

        $this->setETAFrom($from);
        $this->setETATo($to);
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getETAFrom(): ?string
    {
        return $this->ETAFrom;
    }

    /**
     * @param string|null $ETAFrom
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setETAFrom(?string $ETAFrom): Expectation
    {
        $this->ETAFrom = $ETAFrom;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getETATo(): ?string
    {
        return $this->ETATo;
    }

    /**
     * @param string|null $ETATo
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setETATo(?string $ETATo): Expectation
    {
        $this->ETATo = $ETATo;

        return $this;
    }
}
