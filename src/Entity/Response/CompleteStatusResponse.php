<?php

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

declare(strict_types=1);

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotSupportedException;
use stdClass;
use TypeError;

/**
 * @since 1.0.0
 */
class CompleteStatusResponse extends AbstractEntity
{
    /** @var CompleteStatusResponseShipment[]|null $Shipments */
    #[SerializableProperty(type: CompleteStatusResponseShipment::class, isArray: true)]
    protected ?array $Shipments = null;

    /** @var Warning|null $Warnings */
    #[SerializableProperty(type: Warning::class, isArray: true)]
    protected ?Warning $Warnings = null;

    /**
     * @param array|null $Shipments
     * @param array|null $Warnings
     */
    public function __construct(
        ?array $Shipments = null,
        ?array $Warnings = null
    ) {
        parent::__construct();

        $this->setShipments(Shipments: $Shipments);
        $this->setWarnings(Warnings: $Warnings);
    }

    /**
     * @return CompleteStatusResponseShipment[]|null
     */
    public function getShipments(): ?array
    {
        return $this->Shipments;
    }

    /**
     * @param CompleteStatusResponseShipment[]|null $Shipments
     *
     * @return static
     */
    public function setShipments(?array $Shipments): static
    {
        if (is_array(value: $Shipments)) {
            foreach ($Shipments as $shipment) {
                if (!$shipment instanceof CompleteStatusResponseShipment) {
                    throw new TypeError(message: 'Expected instance of `CompleteStatusResponseShipment`');
                }
            }
        }

        $this->Shipments = $Shipments;

        return $this;
    }

    /**
     * @return Warning|null
     */
    public function getWarnings(): ?Warning
    {
        return $this->Warnings;
    }

    /**
     * @param Warning|null $Warnings
     *
     * @return static
     */
    public function setWarnings(?Warning $Warnings): static
    {
        $this->Warnings = $Warnings;

        return $this;
    }

    /**
     * @param stdClass $json
     *
     * @return static
     *
     * @throws DeserializationException
     * @throws NotSupportedException
     * @throws InvalidConfigurationException
     */
    public static function jsonDeserialize(stdClass $json): static
    {
        if (isset($json->CompleteStatusResponse->Shipments) && !is_array(value: $json->CompleteStatusResponse->Shipments)) {
            $json->CompleteStatusResponse->Shipments = [$json->CompleteStatusResponse->Shipments];
        }

        $completeStatusResponse = new static();
        $shipments = [];
        if (!empty($json->CompleteStatusResponse->Shipments)) {
            foreach ($json->CompleteStatusResponse->Shipments as $shipment) {
                $shipments[] = CompleteStatusResponseShipment::jsonDeserialize(json: (object) ['CompleteStatusResponseShipment' => $shipment]);
            }
        }
        $completeStatusResponse->setShipments(Shipments: $shipments);

        return $completeStatusResponse;
    }
}
