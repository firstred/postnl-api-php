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
use Firstred\PostNL\Entity\MergedLabel;
use Firstred\PostNL\Entity\Shipment;
use TypeError;

/**
 * Class GenerateLabelResponse
 */
class GenerateLabelResponse extends AbstractEntity
{
    /**
     * @var MergedLabel[] $mergedLabels
     *
     * @since 1.0.0
     */
    protected $mergedLabels = [];

    /**
     * @var Shipment[] $responseShipments
     *
     * @since 1.0.0
     */
    protected $responseShipments = [];

    /**
     * GenerateLabelResponse constructor.
     *
     * @param MergedLabel[] $mergedLabels
     * @param Shipment[]    $responseShipments
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(array $mergedLabels = [], array $responseShipments = [])
    {
        parent::__construct();

        $this->setMergedlabels($mergedLabels);
        $this->setResponseShipments($responseShipments);
    }

    /**
     * Get merged labels
     *
     * @return MergedLabel[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getMergedlabels(): array
    {
        return $this->mergedLabels;
    }

    /**
     * Add merged label
     *
     * @param MergedLabel $mergedLabel
     *
     * @return GenerateLabelResponse
     *
     * @see MergedLabel
     */
    public function addMergedLabel(MergedLabel $mergedLabel): GenerateLabelResponse
    {
        $this->mergedLabels[] = $mergedLabel;

        return $this;
    }

    /**
     * Set merged labels
     *
     * @pattern N/A
     *
     * @param MergedLabel[] $mergedLabels
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example N/A
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see MergedLabel
     */
    public function setMergedlabels(array $mergedLabels): GenerateLabelResponse
    {
        $this->mergedLabels = $mergedLabels;

        return $this;
    }

    /**
     * Add response shipment
     *
     * @param Shipment $responseShipment
     *
     * @return GenerateLabelResponse
     *
     * @see Shipment
     */
    public function addResponseShipment(Shipment $responseShipment): GenerateLabelResponse
    {
        $this->responseShipments[] = $responseShipment;

        return $this;
    }

    /**
     * Get response shipments
     *
     * @return Shipment[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Shipment
     */
    public function getResponseShipments(): array
    {
        return $this->responseShipments;
    }

    /**
     * Set response shipments
     *
     * @pattern N/A
     *
     * @param Shipment[] $responseShipments
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example N/A
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Shipment
     */
    public function setResponseShipments(array $responseShipments): GenerateLabelResponse
    {
        $this->responseShipments = $responseShipments;

        return $this;
    }

    /**
     * Deserialize JSON
     *
     * @param array $json
     *
     * @return GenerateLabelResponse
     *
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \ReflectionException
     * @since 2.0.0
     */
    public static function jsonDeserialize(array $json): GenerateLabelResponse
    {
        $object = new static();
        if (isset($json['GenerateLabelResponse'])) {
            if (isset($json['GenerateLabelResponse']['MergedLabels'])
                && is_array($json['GenerateLabelResponse']['MergedLabels'])
            ) {
                foreach ($json['GenerateLabelResponse']['MergedLabels'] as $shipment) {
                    $object->addMergedLabel(MergedLabel::jsonDeserialize(['MergedLabel' => $shipment]));
                }
            }
            if (isset($json['GenerateLabelResponse']['ResponseShipments'])
                && is_array($json['GenerateLabelResponse']['ResponseShipments'])
            ) {
                foreach ($json['GenerateLabelResponse']['ResponseShipments'] as $shipment) {
                    $object->addResponseShipment(Shipment::jsonDeserialize(['Shipment' => $shipment]));
                }
            }
        }

        return $object;
    }
}
