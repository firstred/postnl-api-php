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
use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\DTO\CacheableDTO;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;
use OutOfBoundsException;
use SeekableIterator;
use function is_int;
use function is_string;

/**
 * Class GenerateBarcodesResponseDTO.
 */
class GenerateBarcodesResponseDTO extends CacheableDTO implements SeekableIterator, ArrayAccess, Countable
{
    /**
     * @var int
     */
    private int $idx = 0;

    /** @psalm-var array<array-key, GenerateBarcodeResponseDTO> $responses
     * @var mixed[]|\Firstred\PostNL\DTO\Response\GenerateBarcodeResponseDTO[] */
    protected array $responses = [];

    /**
     * GenerateBarcodesResponseDTO constructor.
     *
     * @param string $service
     * @param string $propType
     * @param string $cacheKey
     * @param array  $responses
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service = BarcodeServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType = ResponseProp::class,
        string $cacheKey = '',

        /** @psalm-var array<array-key, GenerateBarcodeResponseDTO> $responses */
        array $responses = [],
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setResponses(responses: $responses);
    }

    #[Pure]
    /**
     * @return GenerateBarcodeResponseDTO|null
     */
    public function current(): GenerateBarcodeResponseDTO|null
    {
        return array_values(array: $this->responses)[$this->idx] ?? null;
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
        return array_keys(array: $this->responses)[$this->idx] ?? null;
    }

    #[Pure]
    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset(array_values(array: $this->responses)[$this->idx]);
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

        return isset($this->responses[$offset]);
    }

    #[Pure]
    /**
     * @param mixed $offset
     *
     * @return GenerateBarcodeResponseDTO|null
     */
    public function offsetGet(mixed $offset): GenerateBarcodeResponseDTO|null
    {
        if (!$this->offsetExists(offset: $offset)) {
            return null;
        }

        return $this->responses[$offset] ?? null;
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

        if (!$value instanceof GenerateBarcodeResponseDTO) {
            throw new InvalidArgumentException('Invalid `GenerateBarcodeResponse` given');
        }

        $this->responses[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        if (!$this->offsetExists(offset: $offset)) {
            return;
        }

        unset($this->responses[$offset]);
    }

    /**
     * @param GenerateBarcodeResponseDTO $generateBarcodeResponseDTO
     */
    public function add(GenerateBarcodeResponseDTO $generateBarcodeResponseDTO): void
    {
        $this->responses[] = $generateBarcodeResponseDTO;
    }

    /**
     * @return int
     */
    #[Pure]
 public function count(): int
 {
     return count(value: $this->responses);
 }

    /**
     * @return array|GenerateBarcodeResponseDTO[]
     */
    public function getResponses(): array
    {
        return $this->responses;
    }

    /**
     * @param array $responses
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setResponses(array $responses): static
    {
        foreach ($responses as $idx => $response) {
            if (!$response instanceof GenerateBarcodeResponseDTO) {
                $responses[$idx] = new GenerateBarcodeResponseDTO(Barcode: $response);
            }
        }

        $this->responses = $responses;

        return $this;
    }

    /**
     * @return array
     *
     * @throws InvalidArgumentException
     */
    public function jsonSerialize(): array
    {
        return array_map(
            callback: fn (SerializableObject $item) => $item->jsonSerialize(),
            array: $this->responses,
        );
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
