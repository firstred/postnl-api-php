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
 * Class CalculateDeliveryDateResponse
 */
class CalculateDeliveryDateResponse extends AbstractResponse
{
    /**
     * Delivery date
     *
     * @pattern ^(([0-3]\d-[0-1]\d-[1-2]\d{3})|([1-2]\d{3}-[0-1]\d-[0-3]\d))$
     *
     * @example 02-01-2019
     *
     * @var string|null $deliveryDate
     *
     * @since 1.0.0
     */
    protected $deliveryDate;

    /**
     * Options
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string[]|null $options
     *
     * @since 1.0.0
     */
    protected $options;

    /**
     * CalculateDeliveryDateResponse constructor.
     *
     * @param string|null   $date    Delivery date
     * @param string[]|null $options Delivery options
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct($date = null, array $options = null)
    {
        parent::__construct();

        $this->setDeliveryDate($date);
        $this->setOptions($options);
    }

    /**
     * Get delivery date
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CalculateDeliveryDateResponse::$deliveryDate
     */
    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    /**
     * Set delivery date
     *
     * @pattern ^(([0-3]\d-[0-1]\d-[1-2]\d{3})|([1-2]\d{3}-[0-1]\d-[0-3]\d))$
     *
     * @example 02-01-2019
     *
     * @param string|null $deliveryDate
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CalculateDeliveryDateResponse::$deliveryDate
     */
    public function setDeliveryDate(?string $deliveryDate): CalculateDeliveryDateResponse
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * Get options
     *
     * @return string[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CalculateDeliveryDateResponse::$options
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * Set options
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string[]|null $options
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CalculateDeliveryDateResponse::$options
     */
    public function setOptions(?array $options): CalculateDeliveryDateResponse
    {
        $this->options = $options;

        return $this;
    }
}
