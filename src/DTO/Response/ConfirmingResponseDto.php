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

use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Message;

class ConfirmingResponseDto
{
    public function __construct(
        protected array|null $Shipments = null,
        protected Customer|null $Customer = null,
        protected Message|null $Message = null,
    ) {
        $this->setShipments(Shipments: $Shipments);
        $this->setMessage(Message: $Message ?: new Message());
        $this->setCustomer(Customer: $Customer);
    }

    public function getCustomer(): ?Customer
    {
        return $this->Customer;
    }

    public function setCustomer(?Customer $Customer = null): static
    {
        $this->Customer = $Customer;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->Message;
    }

    public function setMessage(?Message $Message = null): static
    {
        $this->Message = $Message;

        return $this;
    }

    public function getShipments(): array|null
    {
        return $this->Shipments;
    }

    public function setShipments(array|null $Shipments = null): static
    {
        $this->Shipments = $Shipments;

        return $this;
    }

    /**
     * Return a serializable array for `json_encode`.
     */
    public function jsonSerialize(): array
    {
        $json = [];
//        if (!$this->currentService || !in_array(needle: $this->currentService, haystack: array_keys(array: static::$defaultProperties))) {
//            return $json;
//        }
//
//        foreach (array_keys(array: static::$defaultProperties[$this->currentService]) as $propertyName) {
//            if (isset($this->{$propertyName})) {
//                // The REST API only seems to accept one shipment per request at the moment of writing (Sep. 24th, 2017)
//                if ('Shipments' === $propertyName && count(value: $this->{$propertyName}) >= 1) {
//                    $json[$propertyName] = $this->{$propertyName}[0];
//                } else {
//                    $json[$propertyName] = $this->{$propertyName};
//                }
//            }
//        }

        return $json;
    }
}
