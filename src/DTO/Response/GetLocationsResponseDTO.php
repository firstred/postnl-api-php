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
use Firstred\PostNL\Entity\ResponseLocation;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\LocationServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use Iterator;
use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;
use function is_int;
use function is_string;

class GetLocationsResponseDTO extends SerializableObject implements ArrayAccess, Countable, Iterator
{
    protected int $idx = 0;

    /** @psalm-var array<int|string, ResponseLocation> */
    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected array $GetLocationsResult;

    /** @psalm-var array<int|string, Warning> */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected array|null $Warnings = null;

    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        /** @psalm-var list<GetLocationResponseDTO>|array */
        array $GetLocationsResult = [],

        /** @psalm-var list<Warning>|array */
        array|null $Warnings = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setGetLocationsResult(GetLocationsResult: $GetLocationsResult);
        $this->setWarnings(Warnings: $Warnings);

    }

    #[Pure]
    public function current(): ResponseLocation|null
    {
        return array_values(array: $this->GetLocationsResult)[$this->idx] ?? null;
    }

    public function next(): void
    {
        ++$this->idx;
    }

    #[Pure]
    public function key(): string|null
    {
        return array_keys(array: $this->GetLocationsResult)[$this->idx] ?? null;
    }

    #[Pure]
    public function valid(): bool
    {
        return isset(array_values(array: $this->GetLocationsResult)[$this->idx]);
    }

    public function rewind(): void
    {
        $this->idx = 0;
    }

    #[Pure]
    public function offsetExists(mixed $offset): bool
    {
        if (!is_int(value: $offset) && !is_string(value: $offset)) {
            return false;
        }

        return isset($this->GetLocationsResult[$offset]);
    }

    #[Pure]
    public function offsetGet(mixed $offset): ResponseLocation|null
    {
        if (!$this->offsetExists(offset: $offset)) {
            return null;
        }

        return $this->GetLocationsResult[$offset] ?? null;
    }

    /**
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

    public function offsetUnset($offset): void
    {
        if (!$this->offsetExists(offset: $offset)) {
            return;
        }

        unset($this->GetLocationsResult[$offset]);
    }

    public function add(ResponseLocation $generateBarcodeResponseDTO): void
    {
        $this->GetLocationsResult[] = $generateBarcodeResponseDTO;
    }

    #[Pure]
    public function count(): int
    {
        return count(value: $this->GetLocationsResult);
    }

    public function getGetLocationsResult(): array
    {
        return $this->GetLocationsResult;
    }

    /**
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

    public function getWarnings(): array|null
    {
        return $this->Warnings;
    }

    public function setWarnings(array|null $Warnings = null): static
    {
        $this->Warnings = $Warnings;
        return $this;
    }

    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();

        $json['GetLocationsResult'] = array_map(
            callback: fn (ResponseLocation $location): array => $location->jsonSerialize(),
            array: $this->getGetLocationsResult(),
        );

        return $json;
    }
}
