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

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\DTO\CacheableDTO;
use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\LocationServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;
use function is_numeric;

class LookupLocationRequestDTO extends CacheableDTO
{
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected int|null $LocationCode = null;

    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $RetailNetworkID = null;

    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = LocationServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = RequestProp::class,
        string $cacheKey = '',

        int|string|null $LocationCode = null,

        #[ExpectedValues(values: Location::AVAILABLE_NETWORKS + [null])]
        string|null $RetailNetworkID = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setLocationCode(LocationCode: $LocationCode);
        $this->setRetailNetworkID(RetailNetworkID: $RetailNetworkID);
    }

    public function getLocationCode(): int|null
    {
        return $this->LocationCode;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setLocationCode(int|string|null $LocationCode = null): static
    {
        if (is_string(value: $LocationCode)) {
            if (!is_numeric(value: $LocationCode)) {
                throw new InvalidArgumentException(message: "Invalid `LocationCode` value passed: $LocationCode");
            }

            $LocationCode = (int) $LocationCode;
        }

        $this->LocationCode = $LocationCode;

        return $this;
    }

    public function getRetailNetworkID(): string|null
    {
        return $this->RetailNetworkID;
    }

    public function setRetailNetworkID(string|null $RetailNetworkID = null): static
    {
        $this->RetailNetworkID = $RetailNetworkID;

        return $this;
    }
}
