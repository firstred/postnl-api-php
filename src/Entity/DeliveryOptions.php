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
use Firstred\PostNL\DTO\CacheableDTO;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use Firstred\PostNL\Service\CheckoutServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;
use OutOfBoundsException;
use SeekableIterator;
use function array_keys;
use function array_values;
use function count;
use function is_int;
use function is_string;

/**
 * Class DeliveryOptions.
 */
class DeliveryOptions extends CacheableDTO implements SeekableIterator, ArrayAccess, Countable
{
    /**
     * @var int
     */
    private int $idx = 0;

    /**
     * @psalm-var array<array-key, DeliveryOption> $responses
     * @var DeliveryOption[]
     */
    #[ResponseProp(requiredFor: [CheckoutServiceInterface::class])]
    protected array $DeliveryOptions = [];

    /**
     * GenerateBarcodesResponseDTO constructor.
     *
     * @param string           $service
     * @param string           $propType
     * @param string           $cacheKey
     * @param DeliveryOption[] $DeliveryOptions
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service = BarcodeServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType = ResponseProp::class,
        string $cacheKey = '',

        /** @psalm-var array<array-key, DeliveryOption> $DeliveryOptions */
        array $DeliveryOptions = [],
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setDeliveryOptions(DeliveryOptions: $DeliveryOptions);
    }

    #[Pure]
    /**
     * @return DeliveryOption|null
     */
    public function current(): DeliveryOption|null
    {
        return array_values(array: $this->DeliveryOptions)[$this->idx] ?? null;
    }

    public function next(): void
    {
        ++$this->idx;
    }

    #[Pure]
    /**
     * @return string|null
     */
    public function key(): string|null
    {
        return array_keys(array: $this->DeliveryOptions)[$this->idx] ?? null;
    }

    #[Pure]
    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset(array_values(array: $this->DeliveryOptions)[$this->idx]);
    }

    public function rewind(): void
    {
        $this->idx = 0;
    }

    #[Pure]
    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        if (!is_int(value: $offset) && !is_string(value: $offset)) {
            return false;
        }

        return isset($this->DeliveryOptions[$offset]);
    }

    #[Pure]
    /**
     * @param mixed $offset
     *
     * @return DeliveryOption|null
     */
    public function offsetGet(mixed $offset): DeliveryOption|null
    {
        if (!$this->offsetExists(offset: $offset)) {
            return null;
        }

        return $this->DeliveryOptions[$offset] ?? null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!is_int(value: $offset) && !is_string(value: $offset)) {
            throw new InvalidArgumentException('Invalid offset given');
        }

        if (!$value instanceof DeliveryOption) {
            throw new InvalidArgumentException('Invalid `DeliveryOption` given');
        }

        $this->DeliveryOptions[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        if (!$this->offsetExists(offset: $offset)) {
            return;
        }

        unset($this->DeliveryOptions[$offset]);
    }

    /**
     * @param DeliveryOption $option
     */
    public function add(DeliveryOption $option): void
    {
        $this->DeliveryOptions[] = $option;
    }

    /**
     * @return int
     */
    #[Pure]
    public function count(): int
    {
        return count(value: $this->DeliveryOptions);
    }

    /**
     * @return DeliveryOption[]
     */
    public function getDeliveryOptions(): array
    {
        return $this->DeliveryOptions;
    }

    /**
     * @param DeliveryOption[] $DeliveryOptions
     *
     * @return static
     */
    public function setDeliveryOptions(array $DeliveryOptions): static
    {
        foreach ($DeliveryOptions as $idx => $option) {
            $DeliveryOptions[$idx] = $option;
        }

        $this->DeliveryOptions = $DeliveryOptions;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->DeliveryOptions;
    }

    /**
     * @param mixed $position
     *
     * @throws OutOfBoundsException
     */
    public function seek(mixed $position): void
    {
        if (!is_int(value: $position) || !isset($this->array[$position])) {
            throw new OutOfBoundsException("invalid seek position ($position)");
        }

        $this->idx = $position;
    }
}
