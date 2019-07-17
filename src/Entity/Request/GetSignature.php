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
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Shipment;

/**
 * Class GetSignature
 */
class GetSignature extends AbstractEntity
{
    /** @var Message|null $message */
    protected $message;
    /** @var Customer|null $customer */
    protected $customer;
    /** @var Shipment|null $shipment */
    protected $shipment;

    /**
     * GetSignature constructor.
     *
     * @param Shipment|null $shipment
     * @param Customer|null $customer
     * @param Message|null  $message
     *
     * @throws Exception
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(Shipment $shipment = null, Customer $customer = null, Message $message = null)
    {
        parent::__construct();

        $this->setMessage($message ?: new Message());
        $this->setShipment($shipment);
        $this->setCustomer($customer);
    }

    /**
     * @return Message|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getMessage(): ?Message
    {
        return $this->message;
    }

    /**
     * @param Message|null $message
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setMessage(?Message $message): GetSignature
    {
        $this->message = $message;

        return $this;
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
    public function setCustomer(?Customer $customer): GetSignature
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Shipment|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getShipment(): ?Shipment
    {
        return $this->shipment;
    }

    /**
     * @param Shipment|null $shipment
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setShipment(?Shipment $shipment): GetSignature
    {
        $this->shipment = $shipment;

        return $this;
    }
}
