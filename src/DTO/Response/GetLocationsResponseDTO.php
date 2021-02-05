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
use Firstred\PostNL\Entity\ResponseLocation;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\LocationServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;
use OutOfBoundsException;
use SeekableIterator;
use function is_int;
use function is_string;

/**
 * Class GetLocationsResponseDTO
 */
class GetLocationsResponseDTO extends CacheableDTO implements ArrayAccess, Countable, SeekableIterator
{
    /**
     * @var int
     */
    protected int $idx = 0;

    /**
     * @var mixed[]|\Firstred\PostNL\Entity\ResponseLocation[]|null $GetLocationsResult
     * @psalm-var array<int|string, ResponseLocation> $GetLocationsResult
     */
    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected array $GetLocationsResult;

    /**
     * @var null|mixed[] $Warnings
     * @psalm-var array<int|string, Warning> $Warnings
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected array|null $Warnings = null;

    /**
     * GetLocationsResponseDTO constructor.
     *
     * @param string     $service
     * @param string     $propType
     * @param string     $cacheKey
     * @param array      $GetLocationsResult
     * @param array|null $Warnings
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = LocationServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = ResponseProp::class,
        string $cacheKey = '',

        /** @psalm-var list<GetLocationResponseDTO>|array */
        array $GetLocationsResult = [],

        /** @psalm-var list<Warning>|array */
        array|null $Warnings = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setGetLocationsResult(GetLocationsResult: $GetLocationsResult);
        $this->setWarnings(Warnings: $Warnings);

    }

    #[Pure]
    /**
     * @return ResponseLocation|null
     */
    public function current(): ResponseLocation|null
    {
        return array_values(array: $this->GetLocationsResult)[$this->idx] ?? null;
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
        return array_keys(array: $this->GetLocationsResult)[$this->idx] ?? null;
    }

    #[Pure]
    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset(array_values(array: $this->GetLocationsResult)[$this->idx]);
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

        return isset($this->GetLocationsResult[$offset]);
    }

    #[Pure]
    /**
     * @param mixed $offset
     *
     * @return ResponseLocation|null
     */
    public function offsetGet(mixed $offset): ResponseLocation|null
    {
        if (!$this->offsetExists(offset: $offset)) {
            return null;
        }

        return $this->GetLocationsResult[$offset] ?? null;
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

        if (!$value instanceof ResponseLocation) {
            throw new InvalidArgumentException('Invalid `GenerateBarcodeResponse` given');
        }

        $this->GetLocationsResult[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        if (!$this->offsetExists(offset: $offset)) {
            return;
        }

        unset($this->GetLocationsResult[$offset]);
    }

    /**
     * @param ResponseLocation $generateBarcodeResponseDTO
     */
    public function add(ResponseLocation $generateBarcodeResponseDTO): void
    {
        $this->GetLocationsResult[] = $generateBarcodeResponseDTO;
    }

    #[Pure]
    /**
     * @return int
     */
    public function count(): int
    {
        return count(value: $this->GetLocationsResult);
    }

    /**
     * @return array
     */
    public function getGetLocationsResult(): array
    {
        return $this->GetLocationsResult;
    }

    /**
     * @param array|null $GetLocationsResult
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setGetLocationsResult(array $GetLocationsResult = null): static
    {
        if (isset($GetLocationsResult['ResponseLocation']) && is_array(value: $GetLocationsResult['ResponseLocation'])) {
            $this->GetLocationsResult = [];
            foreach ($GetLocationsResult['ResponseLocation'] as $idx => $response) {
                if (!$response instanceof ResponseLocation) {
                    $response['service'] = LocationServiceInterface::class;
                    $response['propType'] = ResponseProp::class;

                    /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
                    $this->GetLocationsResult[$idx] = new ResponseLocation(...$response);
                } else {
                    $this->GetLocationsResult[$idx] = $response;
                }
            }
        } else {
            $this->GetLocationsResult = [];
        }

        return $this;
    }

    /**
     * @return array|null
     */
    public function getWarnings(): array|null
    {
        return $this->Warnings;
    }

    /**
     * @param array|null $Warnings
     *
     * @return static
     */
    public function setWarnings(array|null $Warnings = null): static
    {
        $this->Warnings = $Warnings;
        return $this;
    }

    /**
     * @return array
     *
     * @throws InvalidArgumentException
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();

        $json['GetLocationsResult'] = ['ResponseLocation' => array_map(
            callback: fn (ResponseLocation $location): array => $location->jsonSerialize(),
            array: $this->getGetLocationsResult(),
        )];

        return $json;
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
