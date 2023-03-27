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

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Enum\SoapNamespace;
use Sabre\Xml\Writer;

/**
 * @since 1.0.0
 */
class Confirming extends AbstractEntity
{
    /** @var Customer|null $Customer */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?Customer $Customer = null;

    /** @var Message|null $Message */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?Message $Message = null;

    /** @var Shipment[]|null $Shipments */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Shipments = null;

    /**
     * @param Shipment[]|null $Shipments
     * @param Customer|null   $Customer
     * @param Message|null    $Message
     */
    public function __construct(
        ?array    $Shipments = null,
        ?Customer $Customer = null,
        ?Message  $Message = null,
    ) {
        parent::__construct();

        $this->setShipments(Shipments: $Shipments);
        $this->setMessage(Message: $Message ?: new Message());
        $this->setCustomer(Customer: $Customer);
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->Customer;
    }

    /**
     * @param Customer|null $Customer
     *
     * @return $this
     */
    public function setCustomer(?Customer $Customer): static
    {
        $this->Customer = $Customer;

        return $this;
    }

    /**
     * @return Message|null
     */
    public function getMessage(): ?Message
    {
        return $this->Message;
    }

    /**
     * @param Message|null $Message
     *
     * @return $this
     */
    public function setMessage(?Message $Message): static
    {
        $this->Message = $Message;

        return $this;
    }

    /**
     * @return Shipment[]|null
     */
    public function getShipments(): ?array
    {
        return $this->Shipments;
    }

    /**
     * @param Shipment[]|null $Shipments
     *
     * @return static
     */
    public function setShipments(?array $Shipments): static
    {
        if (is_array(value: $Shipments)) {
            foreach ($Shipments as $shipment) {
                if (!$shipment instanceof Shipment) {
                    throw new \TypeError(message: 'Expected instanceof Shipment');
                }
            }
        }

        $this->Shipments = $Shipments;

        return $this;
    }

    /**
     * @param Writer $writer
     *
     * @return void
     */
    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        if (!$this->currentService || !in_array(needle: $this->currentService, haystack: array_keys(array: static::$defaultProperties))) {
            $writer->write(value: $xml);

            return;
        }

        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if ('Shipments' === $propertyName) {
                $shipments = [];
                foreach ($this->Shipments as $shipment) {
                    $shipments[] = ["{{$namespace}}Shipment" => $shipment];
                }
                $xml["{{$namespace}}Shipments"] = $shipments;
            } elseif (isset($this->$propertyName)) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write(value: $xml);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [];
        foreach (array_keys(array: $this->getSerializableProperties()) as $propertyName) {
            if (isset($this->$propertyName)) {
                // The REST API only seems to accept one shipment per request at the moment of writing (Sep. 24th, 2017)
                if ('Shipments' === $propertyName && count(value: $this->$propertyName) >= 1) {
                    $json[$propertyName] = $this->{$propertyName}[0];
                } else {
                    $json[$propertyName] = $this->$propertyName;
                }
            }
        }

        return $json;
    }
}
