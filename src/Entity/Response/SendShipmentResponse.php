<?php
declare(strict_types=1);
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Attribute\SerializableEntityArrayProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * @since 1.0.0
 */
class SendShipmentResponse extends AbstractEntity
{
    /** @var MergedLabel[]|null $MergedLabels */
    #[SerializableEntityArrayProperty(namespace: SoapNamespace::Domain, type: MergedLabel::class)]
    protected ?array $MergedLabels = null;

    /** @var ResponseShipment[]|null $ResponseShipments */
    #[SerializableEntityArrayProperty(namespace: SoapNamespace::Domain, type: ResponseShipment::class)]
    protected ?array $ResponseShipments = null;

    /**
     * @param array|null $MergedLabels
     * @param array|null $ResponseShipments
     */
    public function __construct(
        /** @param MergedLabel[]|null $MergedLabels */
        array $MergedLabels = null,
        /** @param ResponseShipment[]|null $ResponseShipments */
        array $ResponseShipments = null,
    ) {
        parent::__construct();

        $this->setMergedLabels(MergedLabels: $MergedLabels);
        $this->setResponseShipments(ResponseShipments: $ResponseShipments);
    }

    /**
     * @return MergedLabel[]|null
     */
    public function getMergedLabels(): ?array
    {
        return $this->MergedLabels;
    }

    /**
     * @param MergedLabel[]|null $MergedLabels
     *
     * @return static
     */
    public function setMergedLabels(?array $MergedLabels): static
    {
        $this->MergedLabels = $MergedLabels;

        return $this;
    }

    /**
     * @return ResponseShipment[]|null
     */
    public function getResponseShipments(): ?array
    {
        return $this->ResponseShipments;
    }

    /**
     * @param ResponseShipment[]|null $ResponseShipments
     *
     * @return static
     */
    public function setResponseShipments(?array $ResponseShipments): static
    {
        $this->ResponseShipments = $ResponseShipments;

        return $this;
    }
}
