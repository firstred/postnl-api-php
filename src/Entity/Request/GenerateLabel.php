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

namespace Firstred\PostNL\Entity\Request;

use Exception;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Message\LabellingMessage;
use Firstred\PostNL\Entity\Shipment;

/**
 * Class GenerateLabel
 */
class GenerateLabel extends AbstractEntity
{
    /** @var Customer|null $customer */
    protected $customer;
    /** @var LabellingMessage|null $message */
    protected $message;
    /** @var Shipment[]|null $shipments */
    protected $shipments;

    /**
     * GenerateLabel constructor.
     *
     * @param Shipment[]|null       $shipments
     * @param LabellingMessage|null $message
     * @param Customer|null         $customer
     *
     * @throws Exception
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(array $shipments = null, LabellingMessage $message = null, Customer $customer = null)
    {
        parent::__construct();

        $this->setShipments($shipments);
        $this->setMessage($message ?: new LabellingMessage());
        $this->setCustomer($customer);
    }

    /**
     * Return a serializable array for `json_encode`
     *
     * @return array
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function jsonSerialize(): array
    {
        $json = [];
        foreach (array_keys(get_class_vars(static::class)) as $propertyName) {
            if (isset($this->{$propertyName})) {
                // The REST API only seems to accept one shipment per request at the moment of writing (Sep. 24th, 2017)
                if ('Shipments' === $propertyName && count($this->{$propertyName}) >= 1) {
                    $json[$propertyName] = $this->{$propertyName}[0];
                } else {
                    $json[$propertyName] = $this->{$propertyName};
                }
            }
        }

        return $json;
    }

    /**
     * @return Customer|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer|null $customer
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCustomer(?Customer $customer): GenerateLabel
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return LabellingMessage|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getMessage(): ?LabellingMessage
    {
        return $this->message;
    }

    /**
     * @param LabellingMessage|null $message
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setMessage(?LabellingMessage $message): GenerateLabel
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return Shipment[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getShipments(): ?array
    {
        return $this->shipments;
    }

    /**
     * @param Shipment[]|null $shipments
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setShipments(?array $shipments): GenerateLabel
    {
        $this->shipments = $shipments;

        return $this;
    }
}
