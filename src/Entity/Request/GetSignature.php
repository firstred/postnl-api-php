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
use Firstred\PostNL\Entity\Shipment;
use TypeError;

/**
 * Class GetSignature
 */
class GetSignature extends AbstractEntity
{
    /**
     * Customer
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var Customer|null $customer
     *
     * @since 1.0.0
     */
    protected $customer;

    /**
     * Shipment
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var Shipment|null $shipment
     *
     * @since 1.0.0
     */
    protected $shipment;

    /**
     * GetSignature constructor.
     *
     * @param Shipment|null $shipment
     * @param Customer|null $customer
     *
     * @throws Exception
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(Shipment $shipment = null, Customer $customer = null)
    {
        parent::__construct();

        $this->setShipment($shipment);
        $this->setCustomer($customer);
    }

    /**
     * Get Customer
     *
     * @return Customer|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Customer
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * Set Customer
     *
     * @pattern N/A
     *
     * @param Customer|null $customer
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
     * @see     Customer
     */
    public function setCustomer(?Customer $customer): GetSignature
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get Shipment
     *
     * @return Shipment|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Shipment
     */
    public function getShipment(): ?Shipment
    {
        return $this->shipment;
    }

    /**
     * Set Shipment
     *
     * @pattern N/A
     *
     * @param Shipment|null $shipment
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
     * @see     Shipment
     */
    public function setShipment(?Shipment $shipment): GetSignature
    {
        $this->shipment = $shipment;

        return $this;
    }
}
