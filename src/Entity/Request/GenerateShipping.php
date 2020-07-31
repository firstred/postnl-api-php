<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 KeenDelivery, LLC
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
 * @author    Jan-Wilco peters <info@keendelivery.com>
 * @copyright 2017-2020 KeenDelivery, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Entity\Request;

use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\Message\LabellingMessage;
use ThirtyBees\PostNL\Entity\Message\Message;
use ThirtyBees\PostNL\Entity\Shipment;
use ThirtyBees\PostNL\Service\ShippingService;

/**
 * Class GenerateShipping.
 *
 * @method Customer|null    getCustomer()
 * @method Message|null     getMessage()
 * @method Shipment[]|null  getShipments()
 * @method GenerateShipping setCustomer(Customer|null $customer = null)
 * @method GenerateShipping setMessage(Message|null $message = null)
 * @method GenerateShipping setShipments(Shipment[]|null $shipments = null)
 */
class GenerateShipping extends AbstractEntity
{
    /**
     * @var array
     */
    public static $defaultProperties = [
        'Shipping' => [
            'Customer'  => ShippingService::DOMAIN_NAMESPACE,
            'Message'   => ShippingService::DOMAIN_NAMESPACE,
            'Shipments' => ShippingService::DOMAIN_NAMESPACE,
        ],
    ];

    // @codingStandardsIgnoreStart
    /** @var Customer|null */
    protected $Customer;
    /** @var LabellingMessage|null */
    protected $Message;
    /** @var Shipment[]|null */
    protected $Shipments;
    // @codingStandardsIgnoreEnd

    /**
     * GenerateShipping constructor.
     *
     * @param Shipment[]|null       $shipments
     * @param LabellingMessage|null $message
     * @param Customer|null         $customer
     */
    public function __construct(array $shipments = null, LabellingMessage $message = null, Customer $customer = null)
    {
        parent::__construct();

        $this->setShipments($shipments);
        $this->setMessage($message ?: new LabellingMessage());
        $this->setCustomer($customer);
    }

    /**
     * Return a serializable array for `json_encode`.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $json = [];
        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
            return $json;
        }

        foreach (array_keys(static::$defaultProperties[$this->currentService]) as $propertyName) {
            if (isset($this->{$propertyName})) {
                if ('Shipments' === $propertyName && count($this->{$propertyName}) >= 1) {
                    $properties = [];
                    foreach ($this->{$propertyName} as $property) {
                        $properties[] = $property;
                    }
                    $json[$propertyName] = $properties;
                } else {
                    $json[$propertyName] = $this->{$propertyName};
                }
            }
        }

        return $json;
    }
}
