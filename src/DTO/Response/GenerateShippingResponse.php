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

class GenerateShippingResponse
{
    protected array|null $MergedLabels = null;
    protected array|null $ResponseShipments = null;

    public function __construct(array|null $mergedLabels = null, array|null $responseShipments = null)
    {
        $this->setMergedLabels(mergedLabels: $mergedLabels);
        $this->setResponseShipments(responseShipments: $responseShipments);
    }

    public function getMergedLabels(): array|null
    {
        return $this->MergedLabels;
    }

    public function setMergedLabels(array|null $mergedLabels = null): static
    {
        $this->MergedLabels = $mergedLabels;

        return $this;
    }

    public function getResponseShipments(): array|null
    {
        return $this->ResponseShipments;
    }

    public function setResponseShipments(array|null $responseShipments = null): static
    {
        $this->ResponseShipments = $responseShipments;

        return $this;
    }
}
