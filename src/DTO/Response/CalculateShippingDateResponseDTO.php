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

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\DTO\CacheableDTO;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\DeliveryDateServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;
use Stringable;

/**
 * Class CalculateShippingDateResponseDTO.
 */
class CalculateShippingDateResponseDTO extends CacheableDTO implements Stringable
{
    #[ResponseProp(requiredFor: [DeliveryDateServiceInterface::class])]
    protected string|null $SentDate = null;

    /**
     * CalculateShippingDateResponseDTO constructor.
     *
     * @param string      $service
     * @param string      $propType
     * @param string      $cacheKey
     * @param string|null $SentDate
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType,
        string $cacheKey = '',

        string|null $SentDate = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setSentDate(SentDate: $SentDate);
    }

    /**
     * @return string|null
     */
    public function getSentDate(): string|null
    {
        return $this->SentDate;
    }

    /**
     * @param string|null $SentDate
     *
     * @return $this
     */
    public function setSentDate(string|null $SentDate = null): static
    {
        $this->SentDate = $SentDate;

        return $this;
    }

    #[Pure]
    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->getSentDate();
    }
}
