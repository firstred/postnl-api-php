<?php
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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class Customer.
 *
 * @method string|null getCustomerNumber()
 * @method string|null getCustomerCode()
 * @method string|null getCollectionLocation()
 * @method string|null getContactPerson()
 * @method string|null getEmail()
 * @method string|null getName()
 * @method string|null getAddress()
 * @method string|null getGlobalPackCustomerCode()
 * @method string|null getGlobalPackBarcodeType()
 * @method Customer    setCustomerNumber(string|null $CustomerNumber = null)
 * @method Customer    setCustomerCode(string|null $CustomerCode = null)
 * @method Customer    setCollectionLocation(string|null $CollectionLocation = null)
 * @method Customer    setContactPerson(string|null $ContactPerson = null)
 * @method Customer    setEmail(string|null $Email = null)
 * @method Customer    setName(string|null $Name = null)
 * @method Customer    setAddress(Address|null $Address = null)
 * @method Customer    setGlobalPackCustomerCode(string|null $GlobalPackCustomerCode = null)
 * @method Customer    setGlobalPackBarcodeType(string|null $GlobalPackBarcodeType = null)
 *
 * @since 1.0.0
 */
class Customer extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'CustomerCode'   => BarcodeService::DOMAIN_NAMESPACE,
            'CustomerNumber' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Address'            => ConfirmingService::DOMAIN_NAMESPACE,
            'CollectionLocation' => ConfirmingService::DOMAIN_NAMESPACE,
            'ContactPerson'      => ConfirmingService::DOMAIN_NAMESPACE,
            'CustomerCode'       => ConfirmingService::DOMAIN_NAMESPACE,
            'CustomerNumber'     => ConfirmingService::DOMAIN_NAMESPACE,
            'Email'              => ConfirmingService::DOMAIN_NAMESPACE,
            'Name'               => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Address'            => LabellingService::DOMAIN_NAMESPACE,
            'CollectionLocation' => LabellingService::DOMAIN_NAMESPACE,
            'ContactPerson'      => LabellingService::DOMAIN_NAMESPACE,
            'CustomerCode'       => LabellingService::DOMAIN_NAMESPACE,
            'CustomerNumber'     => LabellingService::DOMAIN_NAMESPACE,
            'Email'              => LabellingService::DOMAIN_NAMESPACE,
            'Name'               => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Address'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'CollectionLocation' => DeliveryDateService::DOMAIN_NAMESPACE,
            'ContactPerson'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'CustomerCode'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'CustomerNumber'     => DeliveryDateService::DOMAIN_NAMESPACE,
            'Email'              => DeliveryDateService::DOMAIN_NAMESPACE,
            'Name'               => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Address'            => LocationService::DOMAIN_NAMESPACE,
            'CollectionLocation' => LocationService::DOMAIN_NAMESPACE,
            'ContactPerson'      => LocationService::DOMAIN_NAMESPACE,
            'CustomerCode'       => LocationService::DOMAIN_NAMESPACE,
            'CustomerNumber'     => LocationService::DOMAIN_NAMESPACE,
            'Email'              => LocationService::DOMAIN_NAMESPACE,
            'Name'               => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Address'            => TimeframeService::DOMAIN_NAMESPACE,
            'CollectionLocation' => TimeframeService::DOMAIN_NAMESPACE,
            'ContactPerson'      => TimeframeService::DOMAIN_NAMESPACE,
            'CustomerCode'       => TimeframeService::DOMAIN_NAMESPACE,
            'CustomerNumber'     => TimeframeService::DOMAIN_NAMESPACE,
            'Email'              => TimeframeService::DOMAIN_NAMESPACE,
            'Name'               => TimeframeService::DOMAIN_NAMESPACE,
        ],
        'Shipping' => [
            'Address'            => ShippingService::DOMAIN_NAMESPACE,
            'CollectionLocation' => ShippingService::DOMAIN_NAMESPACE,
            'ContactPerson'      => ShippingService::DOMAIN_NAMESPACE,
            'CustomerCode'       => ShippingService::DOMAIN_NAMESPACE,
            'CustomerNumber'     => ShippingService::DOMAIN_NAMESPACE,
            'Email'              => ShippingService::DOMAIN_NAMESPACE,
            'Name'               => ShippingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Address|null */
    protected $Address;
    /** @var string|null */
    protected $CollectionLocation;
    /** @var string|null */
    protected $ContactPerson;
    /** @var string|null */
    protected $CustomerCode;
    /** @var string|null */
    protected $CustomerNumber;
    /** @var string|null */
    protected $GlobalPackCustomerCode;
    /** @var string|null */
    protected $GlobalPackBarcodeType;
    /** @var string|null */
    protected $Email;
    /** @var string|null */
    protected $Name;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null  $CustomerNumber
     * @param string|null  $CustomerCode
     * @param string|null  $CollectionLocation
     * @param string|null  $ContactPerson
     * @param string|null  $Email
     * @param string|null  $Name
     * @param Address|null $Address
     * @param string|null  $GlobalPackCustomerCode
     * @param string|null  $GlobalPackBarcodeType
     */
    public function __construct(
        $CustomerNumber = null,
        $CustomerCode = null,
        $CollectionLocation = null,
        $ContactPerson = null,
        $Email = null,
        $Name = null,
        Address $Address = null,
        $GlobalPackCustomerCode = null,
        $GlobalPackBarcodeType = null
    ) {
        parent::__construct();

        $this->setCustomerNumber($CustomerNumber);
        $this->setCustomerCode($CustomerCode);
        $this->setCollectionLocation($CollectionLocation);
        $this->setContactPerson($ContactPerson);
        $this->setEmail($Email);
        $this->setName($Name);
        $this->setAddress($Address);
        $this->setGlobalPackCustomerCode($GlobalPackCustomerCode);
        $this->setGlobalPackBarcodeType($GlobalPackBarcodeType);
    }
}
