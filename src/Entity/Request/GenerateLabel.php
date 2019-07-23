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
use Firstred\PostNL\Entity\LabellingMessage;
use Firstred\PostNL\Entity\Message;
use Firstred\PostNL\Entity\Shipment;
use TypeError;

/**
 * Class GenerateLabel
 */
class GenerateLabel extends AbstractEntity
{
    /**
     * @var Customer|null $customer
     *
     * @since 1.0.0
     *
     * @see Customer
     */
    protected $customer;

    /**
     * @var LabellingMessage|null $message
     *
     * @since 1.0.0
     *
     * @see Message
     */
    protected $message;

    /**
     * @var Shipment[]|null $shipments
     *
     * @since 1.0.0
     *
     * @see Shipment
     */
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
            if (in_array(ucfirst($propertyName), ['Id'])) {
                continue;
            }
            if (isset($this->{$propertyName})) {
                // The REST API only seems to accept one shipment per request at the moment of writing (Sep. 24th, 2017)
                if ('Shipments' === $propertyName && count($this->{$propertyName}) >= 1) {
                    $json[ucfirst($propertyName)] = $this->{$propertyName}[0];
                } else {
                    $json[ucfirst($propertyName)] = $this->{$propertyName};
                }
            }
        }

        return $json;
    }

    /**
     * Get customer
     *
     * @return Customer|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Customer
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
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Customer
     */
    public function setCustomer(?Customer $customer): GenerateLabel
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get message
     *
     * @return LabellingMessage|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Message
     */
    public function getMessage(): ?LabellingMessage
    {
        return $this->message;
    }

    /**
     * Set message
     *
     * @param LabellingMessage|null $message
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Message
     */
    public function setMessage(?LabellingMessage $message): GenerateLabel
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get shipments
     *
     * @return Shipment[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Shipment
     */
    public function getShipments(): ?array
    {
        return $this->shipments;
    }

    /**
     * Set shipments
     *
     * @param Shipment[]|null $shipments
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Shipment
     */
    public function setShipments(?array $shipments): GenerateLabel
    {
        $this->shipments = $shipments;

        return $this;
    }
}
