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
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

class GenerateBarcodeRequestDTO extends CacheableDTO
{
    #[RequestProp(requiredFor: [BarcodeServiceInterface::class])]
    protected string|null $Type = null;

    #[RequestProp(requiredFor: [BarcodeServiceInterface::class])]
    protected string|null $Serie = null;

    #[RequestProp(optionalFor: [BarcodeServiceInterface::class])]
    protected string|null $Range = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service = BarcodeServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType = RequestProp::class,
        string $cacheKey = '',

        string|null $Type = null,
        string|null $Serie = null,
        string|null $Range = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setType(Type: $Type);
        $this->setSerie(Serie: $Serie);
        $this->setRange(Range: $Range);
    }

    public function getType(): string|null
    {
        return $this->Type;
    }

    public function setType(string|null $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getSerie(): string|null
    {
        return $this->Serie;
    }

    public function setSerie(string|null $Serie): static
    {
        $this->Serie = $Serie;

        return $this;
    }

    public function getRange(): string|null
    {
        return $this->Range;
    }

    public function setRange(string|null $Range = null): static
    {
        $this->Range = $Range;

        return $this;
    }
}
