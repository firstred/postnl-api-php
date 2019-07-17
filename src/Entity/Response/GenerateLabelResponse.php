<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;

/**
 * Class GenerateLabelResponse
 */
class GenerateLabelResponse extends AbstractEntity
{
    /** @var MergedLabel[]|null $mergedLabels */
    protected $mergedLabels;
    /** @var ResponseShipment[]|null $responseShipments */
    protected $responseShipments;

    /**
     * GenerateLabelResponse constructor.
     *
     * @param MergedLabel[]|null      $mergedLabels
     * @param ResponseShipment[]|null $responseShipments
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(array $mergedLabels = null, array $responseShipments = null)
    {
        parent::__construct();

        $this->setMergedlabels($mergedLabels);
        $this->setResponseShipments($responseShipments);
    }

    /**
     * @return MergedLabel[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getMergedlabels(): ?array
    {
        return $this->mergedLabels;
    }

    /**
     * @param MergedLabel[]|null $mergedLabels
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setMergedlabels(?array $mergedLabels): GenerateLabelResponse
    {
        $this->mergedLabels = $mergedLabels;

        return $this;
    }

    /**
     * @return ResponseShipment[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getResponseShipments(): ?array
    {
        return $this->responseShipments;
    }

    /**
     * @param ResponseShipment[]|null $responseShipments
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setResponseShipments(?array $responseShipments): GenerateLabelResponse
    {
        $this->responseShipments = $responseShipments;

        return $this;
    }
}
