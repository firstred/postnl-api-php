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

namespace Firstred\PostNL\DTO\Request;

use ArrayAccess;
use Countable;
use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\DTO\CacheableDTO;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use Iterator;
use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;
use function array_key_exists;
use function array_keys;

/**
 * Class GenerateBarcodesRequestDTO.
 */
class GenerateBarcodesRequestDTO extends CacheableDTO implements ArrayAccess, Countable, Iterator
{
    /**
     * @var int
     */
    private int $idx = 0;

    /**
     * @var array<int|string, GenerateBarcodeRequestDTO>
     */
    protected array $requests = [];

    /**
     * GenerateBarcodesRequestDTO constructor.
     *
     * @param string $service
     * @param string $propType
     * @param string $cacheKey
     * @param array  $requests
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service = BarcodeServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType = RequestProp::class,
        string $cacheKey = '',

        /** @psalm-param array<int|string, GenerateBarcodeRequestDTO> */
        array $requests = [],
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setRequests(requests: $requests);
    }

    /**
     * @return GenerateBarcodeRequestDTO
     */
    #[Pure]
    public function current(): GenerateBarcodeRequestDTO
    {
        return array_values(array: $this->requests)[$this->idx];
    }

    public function next(): void
    {
        ++$this->idx;
    }

    /**
     * @return string
     */
    #[Pure]
    public function key(): string
    {
        return array_keys(array: $this->requests)[$this->idx];
    }

    /**
     * @return bool
     */
    #[Pure]
    public function valid(): bool
    {
        return isset(array_keys(array: $this->requests)[$this->idx]);
    }

    public function rewind(): void
    {
        $this->idx = 0;
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    #[Pure]
    public function offsetExists(mixed $offset): bool
    {
        if (!is_string(value: $offset)) {
            return false;
        }

        return isset($this->requests[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return GenerateBarcodeRequestDTO|null
     */
    #[Pure]
    public function offsetGet(mixed $offset): GenerateBarcodeRequestDTO|null
    {
        if (!$this->offsetExists(offset: $offset)) {
            return null;
        }

        return $this->requests[$offset] ?? null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!is_string(value: $offset)) {
            throw new InvalidArgumentException(message: 'Invalid offset given');
        }

        if (is_array(value: $value)
            && array_key_exists(key: 'type', array: $value)
            && array_key_exists(key: 'serie', array: $value)
            && array_key_exists(key: 'range', array: $value)
        ) {
            $value = new GenerateBarcodeRequestDTO(
                service: BarcodeServiceInterface::class,
                propType: RequestProp::class,

                Type: $value['type'],
                Serie: $value['serie'],
                Range: $value['range'],
            );
        } elseif (!$value instanceof GenerateBarcodeRequestDTO) {
            throw new InvalidArgumentException(message: 'Invalid `GenerateBarcodeRequest` given');
        }

        $this->requests[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        if (!$this->offsetExists(offset: $offset)) {
            return;
        }

        unset($this->requests[$offset]);
    }

    /**
     * @return int
     */
    #[Pure]
    public function count(): int
    {
        return count(value: $this->requests);
    }

    /**
     * @return array<int|string, GenerateBarcodeRequestDTO>
     */
    public function getRequests(): array
    {
        return $this->requests;
    }

    /**
     * @param array $requests
     * @psalm-param array<int|string, GenerateBarcodeRequestDTO> $requests
     *
     * @return static
     */
    public function setRequests(array $requests): static
    {
        $this->requests = $requests;

        return $this;
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    public function jsonSerialize(): array
    {
        return array_map(
            callback: fn (GenerateBarcodeRequestDTO $dto) => $dto->jsonSerialize(),
            array: $this->requests,
        );
    }
}
