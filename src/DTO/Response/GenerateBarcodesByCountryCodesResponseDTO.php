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

namespace Firstred\PostNL\DTO\Response;

use ArrayAccess;
use Countable;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Iterator;
use JetBrains\PhpStorm\Pure;

class GenerateBarcodesByCountryCodesResponseDTO implements ArrayAccess, Countable, Iterator
{
    private int $idx;

    public function __construct(
        private array $countries = [],
    ) {
        foreach ($this->countries as $iso => $barcodes) {
            $this->countries[$iso] = new GenerateBarcodesResponseDTO(responses: $barcodes);
        }
    }

    public function offsetExists(mixed $offset): bool
    {
        if (!static::isCountryIso(countryIso: $offset)) {
            return false;
        }

        return isset($this->countries[$offset]);
    }

    public function offsetGet(mixed $offset): ?GenerateBarcodesResponseDTO
    {
        if (!$this->offsetExists(offset: $offset)) {
            return null;
        }

        return $this->countries[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!static::isCountryIso(countryIso: $offset)) {
            throw new InvalidArgumentException('Invalid country iso code given');
        }

        if (!$value instanceof GenerateBarcodesResponseDTO) {
            throw new InvalidArgumentException('Invalid `GenerateBarcodeResponse` given');
        }

        $this->countries[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        if (!$this->offsetExists(offset: $offset)) {
            return;
        }

        unset($this->countries[$offset]);
    }

    private static function isCountryIso(string $countryIso): bool
    {
        return is_string(value: $countryIso) && 2 === strlen(string: $countryIso);
    }

    public function current(): array|null
    {
        $currentIso = array_keys(array: $this->countries)[$this->idx] ?? null;
        if (!$currentIso) {
            return null;
        }

        return $this->countries[$currentIso];
    }

    public function next(): void
    {
        ++$this->idx;
    }

    public function key(): string|null
    {
        return array_keys(array: $this->countries)[$this->idx] ?? null;
    }

    public function valid(): bool
    {
        return (bool) $this->key();
    }

    public function rewind(): void
    {
        $this->idx = 0;
    }

    #[Pure]
    public function count(): int
    {
        return count(value: $this->countries);
    }
}
