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
 * Class GetSentDateResponse
 */
class CalculateShippingDateResponse extends AbstractResponse
{
    /**
     * Sent date
     *
     * @pattern ^(([0-3]\d-[0-1]\d-[1-2]\d{3})|([1-2]\d{3}-[0-1]\d-[0-3]\d))$
     *
     * @example 31-07-2019
     *
     * @var string|null $sentDate
     *
     * @since 1.0.0
     */
    protected $sentDate;

    /**
     * GetSentDateResponse constructor.
     *
     * @param string|null $sentDate
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $sentDate = null)
    {
        parent::__construct();

        $this->setSentDate($sentDate);
    }

    /**
     * Get sent date
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CalculateShippingDateResponse::$sentDate
     */
    public function getSentDate(): ?string
    {
        return $this->sentDate;
    }

    /**
     * Set sent date
     *
     * @pattern ^(([0-3]\d-[0-1]\d-[1-2]\d{3})|([1-2]\d{3}-[0-1]\d-[0-3]\d))$
     *
     * @param string|null $sentDate
     *
     * @return static
     *
     * @example 31-12-2018
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     CalculateShippingDateResponse::$sentDate
     */
    public function setSentDate(?string $sentDate): CalculateShippingDateResponse
    {
        $this->sentDate = $sentDate;

        return $this;
    }
}
