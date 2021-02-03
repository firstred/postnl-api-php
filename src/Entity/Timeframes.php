<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

use ArrayAccess;
use Countable;
use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ServiceInterface;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use Iterator;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;
use function count;

class Timeframes extends SerializableObject implements ArrayAccess, Countable, Iterator
{
    protected int $idx = 0;

    /** @psalm-var list<Timeframe|TimeframeTimeFrame>|null */
    #[ResponseProp(requiredFor: [TimeframeServiceInterface::class])]
    protected array|null $Timeframes = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        array|null $Timeframes = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setTimeframes(Timeframes: $Timeframes);
    }

    public function getTimeframes(): array|null
    {
        return $this->Timeframes;
    }

    public function setTimeframes(array|null $Timeframes = null): static
    {
        if (!empty($Timeframes['Timeframe'])) {
            $newTimeframes = [];
            foreach ($Timeframes['Timeframe'] ?? [] as $idx => $timeframe) {
                if (!$timeframe instanceof Timeframe && isset($timeframe['From'])) {
                    $timeframe['service'] = $this->service;
                    $timeframe['propType'] = $this->propType;

                    /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
                    $newTimeframes[$idx] = new TimeframeTimeFrame(...$timeframe);
                } elseif (isset($timeframe['Date'])) {
                    $timeframe['service'] = $this->service;
                    $timeframe['propType'] = $this->propType;

                    /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
                    $newTimeframes[$idx] = new Timeframe(...$timeframe);
                }
            }
            $Timeframes = $newTimeframes;
        }

        $this->Timeframes = $Timeframes;

        return $this;
    }

    public function current(): Timeframe|null
    {
        return $this->getTimeframes()[$this->idx] ?? null;
    }

    public function next(): void
    {
        ++$this->idx;
    }

    public function key(): int
    {
        return $this->idx;
    }

    public function valid(): bool
    {
        return null !== $this->current();
    }

    public function rewind(): void
    {
        $this->idx = 0;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function offsetExists(mixed $offset): bool
    {
        if (!is_int(value: $offset)) {
            throw new InvalidArgumentException(message: 'Invalid offset passed, should be int');
        }

        return (bool) ($this->getTimeframes()[$offset] ?? false);
    }

    public function offsetGet($offset): Timeframe|null
    {
        return $this->getTimeframes()[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        $this->Timeframes[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        if (isset($this->Timeframes[$offset])) {
            unset($this->Timeframes[$offset]);
        }
    }

    #[Pure]
    public function count(): int
    {
        return count(value: $this->Timeframes ?? []);
    }

    #[ArrayShape(shape: ['Timeframe' => "array[]|null"])]
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        unset($json['Timeframes']);

        $timeframes = $this->getTimeframes();

        return $json + [
            'Timeframe' => is_null(value: $timeframes) ? null : array_map(
                callback: fn(SerializableObject $item) => $item->jsonSerialize(),
                array: $timeframes,
            ),
        ];
    }
}
