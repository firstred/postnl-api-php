<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\DTO\Response;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\DTO\CacheableDTO;
use Firstred\PostNL\Entity\MergedLabel;
use Firstred\PostNL\Entity\ResponseShipment;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\LabellingServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class GenerateLabelsResponseDTO.
 */
class GenerateLabelsResponseDTO extends CacheableDTO
{
    /**
     * @var MergedLabel[]|null
     */
    #[ResponseProp(optionalFor: [LabellingServiceInterface::class])]
    protected array|null $MergedLabels = null;

    /**
     * @var ResponseShipment[]|null
     */
    #[ResponseProp(optionalFor: [LabellingServiceInterface::class])]
    protected array|null $ResponseShipments = null;

    /**
     * GenerateLabelResponseDTO constructor.
     *
     * @param string     $service
     * @param string     $propType
     * @param string     $cacheKey
     * @param array|null $MergedLabels
     * @param array|null $ResponseShipments
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service = LabellingServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType = ResponseProp::class,
        string $cacheKey = '',

        array|null $MergedLabels = null,
        array|null $ResponseShipments = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setMergedLabels(MergedLabels: $MergedLabels);
        $this->setResponseShipments(ResponseShipments: $ResponseShipments);
    }

    /**
     * @return MergedLabel[]|null
     */
    public function getMergedLabels(): array|null
    {
        return $this->MergedLabels;
    }

    /**
     * @param array|null $MergedLabels
     *
     * @return static
     */
    public function setMergedLabels(array|null $MergedLabels = null): static
    {
        $this->MergedLabels = $MergedLabels;

        return $this;
    }

    /**
     * @return ResponseShipment[]|null
     */
    public function getResponseShipments(): array|null
    {
        return $this->ResponseShipments;
    }

    /**
     * @param array|null $ResponseShipments
     *
     * @return static
     */
    public function setResponseShipments(array|null $ResponseShipments = null): static
    {
        $this->ResponseShipments = $ResponseShipments;

        return $this;
    }
}
