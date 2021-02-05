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

namespace Firstred\PostNL\Entity;

/**
 * Class Shipping
 */
class Shipping
{
    protected Customer|null $Customer = null;
    protected LabellingMessage|null $Message = null;
    protected array|null $Shipments = null;

    /**
     * Shipping constructor.
     *
     * @param array|null            $shipments
     * @param LabellingMessage|null $message
     * @param Customer|null         $customer
     */
    public function __construct(
        array|null $shipments = null,
        LabellingMessage|null $message = null,
        Customer|null $customer = null,
    ) {
        $this->setShipments(shipments: $shipments);
        $this->setMessage(message: $message ?: new LabellingMessage());
        $this->setCustomer(customer: $customer);
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): Customer|null
    {
        return $this->Customer;
    }

    /**
     * @param Customer|null $customer
     *
     * @return $this
     */
    public function setCustomer(Customer|null $customer = null): static
    {
        $this->Customer = $customer;

        return $this;
    }

    /**
     * @return LabellingMessage|null
     */
    public function getMessage(): LabellingMessage|null
    {
        return $this->Message;
    }

    /**
     * @param LabellingMessage|null $message
     *
     * @return $this
     */
    public function setMessage(LabellingMessage|null $message = null): static
    {
        $this->Message = $message;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getShipments(): array|null
    {
        return $this->Shipments;
    }

    /**
     * @param array|null $shipments
     *
     * @return $this
     */
    public function setShipments(array|null $shipments = null): static
    {
        $this->Shipments = $shipments;

        return $this;
    }

    // TODO: check serializing
//    public function jsonSerialize(): array
//    {
//        $json = [];
//        if (!$this->currentService || !in_array(needle: $this->currentService, haystack: array_keys(array: static::$defaultProperties))) {
//            return $json;
//        }
//
//        foreach (array_keys(array: static::$defaultProperties[$this->currentService]) as $propertyName) {
//            if (isset($this->{$propertyName})) {
//                if ('Shipments' === $propertyName && count(value: $this->{$propertyName}) >= 1) {
//                    $properties = [];
//                    foreach ($this->{$propertyName} as $property) {
//                        $properties[] = $property;
//                    }
//                    $json[$propertyName] = $properties;
//                } else {
//                    $json[$propertyName] = $this->{$propertyName};
//                }
//            }
//        }
//
//        return $json;
//    }
}
