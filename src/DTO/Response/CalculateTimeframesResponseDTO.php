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
use Firstred\PostNL\Entity\ReasonNoTimeframes;
use Firstred\PostNL\Entity\Timeframes;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\ServiceInterface;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class CalculateTimeframesResponseDTO.
 */
class CalculateTimeframesResponseDTO extends CacheableDTO
{
    /**
     * @var null|\Firstred\PostNL\Entity\Timeframes
     */
    #[ResponseProp(requiredFor: [TimeframeServiceInterface::class])]
    protected Timeframes|null $Timeframes = null;

    /**
     * @var null|\Firstred\PostNL\Entity\ReasonNoTimeframes
     */
    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class])]
    protected ReasonNoTimeframes|null $ReasonNoTimeframes = null;

    /**
     * CalculateTimeframesResponseDTO constructor.
     *
     * @param string                        $service
     * @param string                        $propType
     * @param string                        $cacheKey
     * @param Timeframes|array|null         $Timeframes
     * @param ReasonNoTimeframes|array|null $ReasonNoTimeframes
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service = TimeframeServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType = ResponseProp::class,
        string $cacheKey = '',

        Timeframes|array|null $Timeframes = null,
        ReasonNoTimeframes|array|null $ReasonNoTimeframes = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setTimeframes(Timeframes: $Timeframes);
        $this->setReasonNoTimeframes(ReasonNoTimeframes: $ReasonNoTimeframes);
    }

    /**
     * @return Timeframes|null
     */
    public function getTimeframes(): Timeframes|null
    {
        return $this->Timeframes;
    }

    /**
     * @param Timeframes|array|null $Timeframes
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setTimeframes(Timeframes|array|null $Timeframes = null): static
    {
        if (is_array(value: $Timeframes)) {
            $Timeframes = new Timeframes(
                service: $this->service,
                propType: $this->propType,
                Timeframes: $Timeframes,
            );
        }

        $this->Timeframes = $Timeframes;

        $this->Timeframes?->setService(service: $this->getService());
        $this->Timeframes?->setPropType(propType: $this->getPropType());

        return $this;
    }

    /**
     * @return ReasonNoTimeframes|null
     */
    public function getReasonNoTimeframes(): ReasonNoTimeframes|null
    {
        return $this->ReasonNoTimeframes;
    }

    /**
     * @param ReasonNoTimeframes|array|null $ReasonNoTimeframes
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setReasonNoTimeframes(ReasonNoTimeframes|array|null $ReasonNoTimeframes = null): static
    {
        if (is_array(value: $ReasonNoTimeframes)) {
            $ReasonNoTimeframes = new ReasonNoTimeframes(
                service: $this->service,
                propType: $this->propType,
                ReasonNoTimeframes: $ReasonNoTimeframes,
            );
        }

        $this->ReasonNoTimeframes = $ReasonNoTimeframes;

        $this->ReasonNoTimeframes?->setService(service: $this->getService());
        $this->ReasonNoTimeframes?->setPropType(propType: $this->getPropType());

        return $this;
    }
}
