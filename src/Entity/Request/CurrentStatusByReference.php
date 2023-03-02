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

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;
use Sabre\Xml\Writer;

/**
 * Class CurrentStatusByReference.
 *
 * @method Message|null             getMessage()
 * @method Customer|null            getCustomer()
 * @method Shipment|null            getShipment()
 * @method CurrentStatusByReference setMessage(Message|null $Message = null)
 * @method CurrentStatusByReference setCustomer(Customer|null $Customer = null)
 * @method CurrentStatusByReference setShipment(Shipment|null $Shipment = null)
 *
 * @since 1.0.0
 */
class CurrentStatusByReference extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode' => [
            'Message'  => BarcodeService::DOMAIN_NAMESPACE,
            'Customer' => BarcodeService::DOMAIN_NAMESPACE,
            'Shipment' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Message'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Customer' => ConfirmingService::DOMAIN_NAMESPACE,
            'Shipment' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Message'  => LabellingService::DOMAIN_NAMESPACE,
            'Customer' => LabellingService::DOMAIN_NAMESPACE,
            'Shipment' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Message'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Customer' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Shipment' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Message'  => LocationService::DOMAIN_NAMESPACE,
            'Customer' => LocationService::DOMAIN_NAMESPACE,
            'Shipment' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Message'  => TimeframeService::DOMAIN_NAMESPACE,
            'Customer' => TimeframeService::DOMAIN_NAMESPACE,
            'Shipment' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Message|null */
    protected $Message;
    /** @var Customer|null */
    protected $Customer;
    /** @var Shipment|null */
    protected $Shipment;
    // @codingStandardsIgnoreEnd

    /**
     * CurrentStatusByReference constructor.
     *
     * @param Shipment|null $Shipment
     * @param Customer|null $Customer
     * @param Message|null  $Message
     */
    public function __construct(Shipment $Shipment = null, Customer $Customer = null, Message $Message = null)
    {
        parent::__construct();

        $this->setMessage($Message ?: new Message());
        $this->setShipment($Shipment);
        $this->setCustomer($Customer);
    }

    /**
     * Return a serializable array for the XMLWriter.
     *
     * @param Writer $writer
     *
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        $xml = [];
        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
            $writer->write($xml);

            return;
        }

        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if (isset($this->$propertyName)) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}
