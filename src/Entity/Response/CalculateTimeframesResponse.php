<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\ReasonNoTimeframes;
use Firstred\PostNL\Entity\ReasonNoTimeframesInterface;
use Firstred\PostNL\Entity\Timeframe;
use Firstred\PostNL\Entity\Timeframes;
use Firstred\PostNL\Entity\TimeframesInterface;

/**
 * Class CalculateTimeframesResponse.
 */
final class CalculateTimeframesResponse extends AbstractResponse
{
    /**
     * ReasonNoTimeframes.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var ReasonNoTimeframesInterface|null
     *
     * @since   2.0.0
     */
    private $reasonNoTimeframes;

    /**
     * Timeframes.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var TimeframesInterface|null
     *
     * @since   2.0.0
     */
    private $timeframes;

    /**
     * Return a serializable array for `json_encode`.
     *
     * @return array
     *
     * @since 2.0.0
     */
    public function jsonSerialize(): array
    {
        $json = [];
        foreach (array_keys(get_class_vars(static::class)) as $propertyName) {
            if (in_array(ucfirst($propertyName), ['Id'])) {
                continue;
            }
            if (in_array(ucfirst($propertyName), ['Warnings', 'Errors'])) {
                continue;
            }
            if (isset($this->{$propertyName})) {
                if ('ReasonNoTimeframes' === $propertyName) {
                    $noTimeframes = [];
                    foreach ($this->reasonNoTimeframes as $noTimeframe) {
                        $noTimeframes[] = $noTimeframe;
                    }
                    $json['ReasonNotimeframes'] = ['ReasonNoTimeframe' => $noTimeframes];
                } elseif ('Timeframes' === $propertyName) {
                    $timeframes = [];
                    foreach ($this->timeframes as $timeframe) {
                        $timeframes[] = $timeframe;
                    }
                    $json[ucfirst($propertyName)] = ['Timeframe' => $timeframes];
                } else {
                    $json[ucfirst($propertyName)] = $this->{$propertyName};
                }
            }
        }

        return $json;
    }

    /**
     * Get ReasonNoTimeframes.
     *
     * @return ReasonNoTimeframesInterface|null
     *
     * @since 2.0.0
     * @see   ReasonNoTimeframe
     * @see   ReasonNoTimeframes
     */
    public function getReasonNoTimeframes(): ?ReasonNoTimeframesInterface
    {
        return $this->reasonNoTimeframes;
    }

    /**
     * Set ReasonNoTimeframes.
     *
     * @pattern N/A
     *
     * @param ReasonNoTimeframesInterface|null $reasonNoTimeframes
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     * @see     ReasonNoTimeframe
     * @see     ReasonNoTimeframes
     */
    public function setReasonNoTimeframes(?ReasonNoTimeframesInterface $reasonNoTimeframes): CalculateTimeframesResponse
    {
        $this->reasonNoTimeframes = $reasonNoTimeframes;

        return $this;
    }

    /**
     * Get timeframes.
     *
     * @return TimeframesInterface|null
     *
     * @since 2.0.0
     * @see   Timeframe
     * @see   Timeframes
     */
    public function getTimeframes(): ?TimeframesInterface
    {
        return $this->timeframes;
    }

    /**
     * Set timeframes.
     *
     * @pattern N/A
     *
     * @param TimeframesInterface|null $timeframes
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     * @see     Timeframe
     * @see     Timeframes
     */
    public function setTimeframes(?TimeframesInterface $timeframes): CalculateTimeframesResponse
    {
        $this->timeframes = $timeframes;

        return $this;
    }
}
