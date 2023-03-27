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
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\ServiceNotSetException;
use Sabre\Xml\Writer;

/**
 * @since 1.0.0
 */
class CurrentStatusResponse extends AbstractEntity
{
    /** @var CurrentStatusResponseShipment[]|null $Shipments */
    #[SerializableEntityArrayProperty(namespace: SoapNamespace::Domain, entityFqcn: CurrentStatusResponseShipment::class)]
    protected ?array $Shipments = null;

    /** @var Warning[]|null $Warnings */
    #[SerializableEntityArrayProperty(namespace: SoapNamespace::Domain, entityFqcn: Warning::class)]
    protected ?array $Warnings = null;

    /**
     * @param array|null $Shipments
     * @param array|null $Warnings
     */
    public function __construct(
        /** @param CurrentStatusResponseShipment[]|null $Shipments */
        ?array $Shipments = null,
        /** @param Warning[]|null $Warnings */
        ?array $Warnings = null
    ) {
        parent::__construct();

        $this->setShipments(Shipments: $Shipments);
        $this->setWarnings(Warnings: $Warnings);
    }

    /**
     * @return CurrentStatusResponseShipment[]|null
     */
    public function getShipments(): ?array
    {
        return $this->Shipments;
    }

    /**
     * @param CurrentStatusResponseShipment[]|null $Shipments
     *
     * @return static
     */
    public function setShipments(?array $Shipments): static
    {
        if (is_array(value: $Shipments)) {
            foreach ($Shipments as $shipment) {
                if (!$shipment instanceof CurrentStatusResponseShipment) {
                    throw new \TypeError(message: 'Expected instance of `CurrentStatusResponseShipment`');
                }
            }
        }

        $this->Shipments = $Shipments;

        return $this;
    }

    /**
     * @return Warning[]|null
     */
    public function getWarnings(): ?array
    {
        return $this->Warnings;
    }

    /**
     * @param Warning[]|null $Warnings
     *
     * @return static
     */
    public function setWarnings(?array $Warnings): static
    {
        if (is_array(value: $Warnings)) {
            foreach ($Warnings as $warning) {
                if (!$warning instanceof Warning) {
                    throw new \TypeError(message: 'Expected instance of `Warning`');
                }
            }
        }

        $this->Warnings = $Warnings;

        return $this;
    }

    /**
     * @param Writer $writer
     *
     * @return void
     * @throws ServiceNotSetException
     */
    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        if (!isset($this->currentService)) {
            throw new ServiceNotSetException(message: 'Service not set before serialization');
        }

        foreach ($this->getSerializableProperties() as $propertyName => $namespace) {
            if (!isset($this->$propertyName)) {
                continue;
            }

            if ('Shipments' === $propertyName) {
                $shipments = [];
                foreach ($this->Shipments as $shipment) {
                    $shipments[] = ["{{$namespace}}Shipment" => $shipment];
                }
                $xml["{{$namespace}}Shipments"] = $shipments;
            } else {
                $xml["{{$namespace}}{$propertyName}"] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write(value: $xml);
    }
}
