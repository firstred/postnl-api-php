<?php
declare(strict_types=1);
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * @since 1.0.0
 */
class Timeframes extends AbstractEntity
{
    /** @var Timeframe[]|null */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Timeframes = null;

    /** @var TimeframeTimeFrame[]|null */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $TimeframeTimeFrames = null;

    public function __construct(
        /** @param Timeframe[]|null $timeframes */
        array $timeframes = null,
        /** @param TimeframeTimeFrame[]|null $timeframetimeframes */
        array $timeframetimeframes = null
    ) {
        parent::__construct();

        $this->setTimeframes(Timeframes: $timeframes);
        $this->setTimeframeTimeFrames(TimeframeTimeFrames: $timeframetimeframes);
    }

    /**
     * @return Timeframe[]|null
     */
    public function getTimeframes(): ?array
    {
        return $this->Timeframes;
    }

    /**
     * @param Timeframe[]|null $Timeframes
     * @return static
     */
    public function setTimeframes(?array $Timeframes): static
    {
        $this->Timeframes = $Timeframes;

        return $this;
    }

    /**
     * @return TimeframeTimeFrame[]|null
     */
    public function getTimeframeTimeFrames(): ?array
    {
        return $this->TimeframeTimeFrames;
    }

    /**
     * @param TimeframeTimeFrame[]|null $TimeframeTimeFrames
     * @return static
     */
    public function setTimeframeTimeFrames(?array $TimeframeTimeFrames): static
    {
        $this->TimeframeTimeFrames = $TimeframeTimeFrames;

        return $this;
    }

    public function jsonSerialize(): array
    {
        $json = [];
        if (!$this->currentService || !in_array(needle: $this->currentService, haystack: array_keys(array: static::$defaultProperties))) {
            return $json;
        }

        foreach (array_keys(array: static::$defaultProperties[$this->currentService]) as $propertyName) {
            if (isset($this->$propertyName)) {
                if ('Timeframes' === $propertyName) {
                    $timeframes = [];
                    foreach ($this->Timeframes as $timeframe) {
                        $timeframes[] = $timeframe;
                    }
                    $json[$propertyName] = ['TimeframeTimeFrame' => $timeframes];
                } elseif ('TimeframeTimeFrames' === $propertyName) {
                    $timeframes = [];
                    foreach ($this->TimeframeTimeFrames as $timeframe) {
                        $timeframes[] = $timeframe;
                    }
                    $json[$propertyName] = ['TimeframeTimeFrame' => $timeframes];
                } else {
                    $json[$propertyName] = $this->$propertyName;
                }
            }
        }

        return $json;
    }
}
