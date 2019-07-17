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
 * Class Timeframes
 */
class Timeframes extends AbstractEntity
{
    /** @var Timeframe[]|null $timeframes */
    protected $timeframes;
    /** @var TimeframeTimeFrame[]|null $timeframeTimeFrames */
    protected $timeframeTimeFrames;

    /**
     * Timeframes constructor.
     *
     * @param array|null                $timeframes
     * @param TimeframeTimeFrame[]|null $timeframetimeframes
     */
    public function __construct(?array $timeframes = null, ?array $timeframetimeframes = null)
    {
        parent::__construct();

        $this->setTimeframes($timeframes);
        $this->setTimeframeTimeFrames($timeframetimeframes);
    }

    /**
     * Return a serializable array for `json_encode`
     *
     * @return array
     *
     * @since 1.0.0
     */
    public function jsonSerialize(): array
    {
        $json = [];
        foreach (array_keys(get_class_vars(static::class)) as $propertyName) {
            if (isset($this->{$propertyName})) {
                if ('Timeframes' === $propertyName) {
                    $timeframes = [];
                    foreach ($this->timeframes as $timeframe) {
                        $timeframes[] = $timeframe;
                    }
                    $json[$propertyName] = ['TimeframeTimeFrame' => $timeframes];
                } elseif ('TimeframeTimeFrames' === $propertyName) {
                    $timeframes = [];
                    foreach ($this->timeframeTimeFrames as $timeframe) {
                        $timeframes[] = $timeframe;
                    }
                    $json[$propertyName] = ['TimeframeTimeFrame' => $timeframes];
                } else {
                    $json[$propertyName] = $this->{$propertyName};
                }
            }
        }

        return $json;
    }

    /**
     * @return Timeframe[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getTimeframes(): ?array
    {
        return $this->timeframes;
    }

    /**
     * @param Timeframe[]|null $timeframes
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setTimeframes(?array $timeframes): Timeframes
    {
        $this->timeframes = $timeframes;

        return $this;
    }

    /**
     * @return TimeframeTimeFrame[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getTimeframeTimeFrames(): ?array
    {
        return $this->timeframeTimeFrames;
    }

    /**
     * @param TimeframeTimeFrame[]|null $timeframeTimeFrames
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setTimeframeTimeFrames(?array $timeframeTimeFrames): Timeframes
    {
        $this->timeframeTimeFrames = $timeframeTimeFrames;

        return $this;
    }
}
