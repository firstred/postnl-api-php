<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2022 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2022 Michael Dekker
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
 * Class StatusAddress.
 *
 * @method string|null getAddressType()
 * @method string|null getBuilding()
 * @method string|null getCity()
 * @method string|null getCompanyName()
 * @method string|null getCountryCode()
 * @method string|null getDepartmentName()
 * @method string|null getDistrict()
 * @method string|null getFirstName()
 * @method string|null getFloor()
 * @method string|null getHouseNumber()
 * @method string|null getHouseNumberSuffix()
 * @method string|null getLastName()
 * @method string|null getRegion()
 * @method string|null getRegistrationDate()
 * @method string|null getRemark()
 * @method string|null getStreet()
 * @method string|null getZipcode()
 * @method StatusAddress setBuilding(string|null $Building = null)
 * @method StatusAddress setCity(string|null $City = null)
 * @method StatusAddress setCompanyName(string|null $CompanyName = null)
 * @method StatusAddress setCountryCode(string|null $CountryCode = null)
 * @method StatusAddress setDepartmentName(string|null $DepartmentName = null)
 * @method StatusAddress setDistrict(string|null $District = null)
 * @method StatusAddress setFirstName(string|null $FirstName = null)
 * @method StatusAddress setFloor(string|null $Floor = null)
 * @method StatusAddress setHouseNumber(string|null $HouseNumber = null)
 * @method StatusAddress setHouseNumberSuffix(string|null $HouseNumberSuffix = null)
 * @method StatusAddress setLastName(string|null $LastName = null)
 * @method StatusAddress setRegion(string|null $Region = null)
 * @method StatusAddress setRegistrationDate(string|null $RegistrationDate = null)
 * @method StatusAddress setRemark(string|null $Remark = null)
 * @method StatusAddress setStreet(string|null $Street = null)
 *
 * @since 1.0.0
 */
class StatusAddress extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'AddressType'       => BarcodeService::DOMAIN_NAMESPACE,
            'Building'          => BarcodeService::DOMAIN_NAMESPACE,
            'City'              => BarcodeService::DOMAIN_NAMESPACE,
            'CompanyName'       => BarcodeService::DOMAIN_NAMESPACE,
            'CountryCode'       => BarcodeService::DOMAIN_NAMESPACE,
            'DepartmentName'    => BarcodeService::DOMAIN_NAMESPACE,
            'District'          => BarcodeService::DOMAIN_NAMESPACE,
            'FirstName'         => BarcodeService::DOMAIN_NAMESPACE,
            'Floor'             => BarcodeService::DOMAIN_NAMESPACE,
            'HouseNumber'       => BarcodeService::DOMAIN_NAMESPACE,
            'HouseNumberSuffix' => BarcodeService::DOMAIN_NAMESPACE,
            'LastName'          => BarcodeService::DOMAIN_NAMESPACE,
            'Region'            => BarcodeService::DOMAIN_NAMESPACE,
            'RegistrationDate'  => BarcodeService::DOMAIN_NAMESPACE,
            'Remark'            => BarcodeService::DOMAIN_NAMESPACE,
            'Street'            => BarcodeService::DOMAIN_NAMESPACE,
            'Zipcode'           => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'AddressType'       => ConfirmingService::DOMAIN_NAMESPACE,
            'Building'          => ConfirmingService::DOMAIN_NAMESPACE,
            'City'              => ConfirmingService::DOMAIN_NAMESPACE,
            'CompanyName'       => ConfirmingService::DOMAIN_NAMESPACE,
            'CountryCode'       => ConfirmingService::DOMAIN_NAMESPACE,
            'DepartmentName'    => ConfirmingService::DOMAIN_NAMESPACE,
            'District'          => ConfirmingService::DOMAIN_NAMESPACE,
            'FirstName'         => ConfirmingService::DOMAIN_NAMESPACE,
            'Floor'             => ConfirmingService::DOMAIN_NAMESPACE,
            'HouseNumber'       => ConfirmingService::DOMAIN_NAMESPACE,
            'HouseNumberSuffix' => ConfirmingService::DOMAIN_NAMESPACE,
            'LastName'          => ConfirmingService::DOMAIN_NAMESPACE,
            'Region'            => ConfirmingService::DOMAIN_NAMESPACE,
            'RegistrationDate'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Remark'            => ConfirmingService::DOMAIN_NAMESPACE,
            'Street'            => ConfirmingService::DOMAIN_NAMESPACE,
            'Zipcode'           => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'AddressType'       => LabellingService::DOMAIN_NAMESPACE,
            'Building'          => LabellingService::DOMAIN_NAMESPACE,
            'City'              => LabellingService::DOMAIN_NAMESPACE,
            'CompanyName'       => LabellingService::DOMAIN_NAMESPACE,
            'CountryCode'       => LabellingService::DOMAIN_NAMESPACE,
            'DepartmentName'    => LabellingService::DOMAIN_NAMESPACE,
            'District'          => LabellingService::DOMAIN_NAMESPACE,
            'FirstName'         => LabellingService::DOMAIN_NAMESPACE,
            'Floor'             => LabellingService::DOMAIN_NAMESPACE,
            'HouseNumber'       => LabellingService::DOMAIN_NAMESPACE,
            'HouseNumberSuffix' => LabellingService::DOMAIN_NAMESPACE,
            'LastName'          => LabellingService::DOMAIN_NAMESPACE,
            'Region'            => LabellingService::DOMAIN_NAMESPACE,
            'RegistrationDate'  => LabellingService::DOMAIN_NAMESPACE,
            'Remark'            => LabellingService::DOMAIN_NAMESPACE,
            'Street'            => LabellingService::DOMAIN_NAMESPACE,
            'Zipcode'           => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'AddressType'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'Building'          => DeliveryDateService::DOMAIN_NAMESPACE,
            'City'              => DeliveryDateService::DOMAIN_NAMESPACE,
            'CompanyName'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'CountryCode'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'DepartmentName'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'District'          => DeliveryDateService::DOMAIN_NAMESPACE,
            'FirstName'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'Floor'             => DeliveryDateService::DOMAIN_NAMESPACE,
            'HouseNumber'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'HouseNumberSuffix' => DeliveryDateService::DOMAIN_NAMESPACE,
            'LastName'          => DeliveryDateService::DOMAIN_NAMESPACE,
            'Region'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'RegistrationDate'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Remark'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'Street'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'Zipcode'           => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'AddressType'       => LocationService::DOMAIN_NAMESPACE,
            'Building'          => LocationService::DOMAIN_NAMESPACE,
            'City'              => LocationService::DOMAIN_NAMESPACE,
            'CompanyName'       => LocationService::DOMAIN_NAMESPACE,
            'CountryCode'       => LocationService::DOMAIN_NAMESPACE,
            'DepartmentName'    => LocationService::DOMAIN_NAMESPACE,
            'District'          => LocationService::DOMAIN_NAMESPACE,
            'FirstName'         => LocationService::DOMAIN_NAMESPACE,
            'Floor'             => LocationService::DOMAIN_NAMESPACE,
            'HouseNumber'       => LocationService::DOMAIN_NAMESPACE,
            'HouseNumberSuffix' => LocationService::DOMAIN_NAMESPACE,
            'LastName'          => LocationService::DOMAIN_NAMESPACE,
            'Region'            => LocationService::DOMAIN_NAMESPACE,
            'RegistrationDate'  => LocationService::DOMAIN_NAMESPACE,
            'Remark'            => LocationService::DOMAIN_NAMESPACE,
            'Street'            => LocationService::DOMAIN_NAMESPACE,
            'Zipcode'           => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'AddressType'       => TimeframeService::DOMAIN_NAMESPACE,
            'Building'          => TimeframeService::DOMAIN_NAMESPACE,
            'City'              => TimeframeService::DOMAIN_NAMESPACE,
            'CompanyName'       => TimeframeService::DOMAIN_NAMESPACE,
            'CountryCode'       => TimeframeService::DOMAIN_NAMESPACE,
            'DepartmentName'    => TimeframeService::DOMAIN_NAMESPACE,
            'District'          => TimeframeService::DOMAIN_NAMESPACE,
            'FirstName'         => TimeframeService::DOMAIN_NAMESPACE,
            'Floor'             => TimeframeService::DOMAIN_NAMESPACE,
            'HouseNumber'       => TimeframeService::DOMAIN_NAMESPACE,
            'HouseNumberSuffix' => TimeframeService::DOMAIN_NAMESPACE,
            'LastName'          => TimeframeService::DOMAIN_NAMESPACE,
            'Region'            => TimeframeService::DOMAIN_NAMESPACE,
            'RegistrationDate'  => TimeframeService::DOMAIN_NAMESPACE,
            'Remark'            => TimeframeService::DOMAIN_NAMESPACE,
            'Street'            => TimeframeService::DOMAIN_NAMESPACE,
            'Zipcode'           => TimeframeService::DOMAIN_NAMESPACE,
        ],
        'Shipping' => [
            'AddressType'       => ShippingService::DOMAIN_NAMESPACE,
            'Building'          => ShippingService::DOMAIN_NAMESPACE,
            'City'              => ShippingService::DOMAIN_NAMESPACE,
            'CompanyName'       => ShippingService::DOMAIN_NAMESPACE,
            'CountryCode'       => ShippingService::DOMAIN_NAMESPACE,
            'DepartmentName'    => ShippingService::DOMAIN_NAMESPACE,
            'District'          => ShippingService::DOMAIN_NAMESPACE,
            'FirstName'         => ShippingService::DOMAIN_NAMESPACE,
            'Floor'             => ShippingService::DOMAIN_NAMESPACE,
            'HouseNumber'       => ShippingService::DOMAIN_NAMESPACE,
            'HouseNumberSuffix' => ShippingService::DOMAIN_NAMESPACE,
            'LastName'          => ShippingService::DOMAIN_NAMESPACE,
            'Region'            => ShippingService::DOMAIN_NAMESPACE,
            'RegistrationDate'  => ShippingService::DOMAIN_NAMESPACE,
            'Remark'            => ShippingService::DOMAIN_NAMESPACE,
            'Street'            => ShippingService::DOMAIN_NAMESPACE,
            'Zipcode'           => ShippingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /**
     * @var string|null
     *
     * PostNL internal applications validate the receiver address. In case the spelling of
     * addresses should be different according to our PostNL information, the address details will
     * be corrected. This can be noticed in Track & Trace.
     *
     * Please note that the webservice will not add address details. Street and City fields will
     * only be printed when they are in the call towards the labeling webservice.
     *
     * The element Address type is a code in the request. Possible values are:
     *
     * Code Description
     * 01   Receiver
     * 02   Sender
     * 03   Alternative sender address
     * 04   Collection address (In the orders need to be collected first)
     * 08   Return address*
     * 09   Drop off location (for use with Pick up at PostNL location)
     *
     * > * When using the ‘label in the box return label’, it is mandatory to use an
     * >   `Antwoordnummer` in AddressType 08.
     * >   This cannot be a regular address
     *
     * The following rules apply:
     * If there is no Address specified with AddressType = 02, the data from Customer/Address
     * will be added to the list as AddressType 02.
     * If there is no Customer/Address, the message will be rejected.
     *
     * At least one other AddressType must be specified, other than AddressType 02
     * In most cases this will be AddressType 01, the receiver address.
     */
    protected $AddressType;
    /** @var string|null */
    protected $Building;
    /** @var string|null */
    protected $City;
    /** @var string|null */
    protected $CompanyName;
    /** @var string|null */
    protected $CountryCode;
    /** @var string|null */
    protected $DepartmentName;
    /** @var string|null */
    protected $District;
    /** @var string|null */
    protected $FirstName;
    /** @var string|null */
    protected $Floor;
    /** @var string|null */
    protected $HouseNumber;
    /** @var string|null */
    protected $HouseNumberSuffix;
    /** @var string|null */
    protected $LastName;
    /** @var string|null */
    protected $Region;
    /** @var string|null */
    protected $RegistrationDate;
    /** @var string|null */
    protected $Remark;
    /** @var string|null */
    protected $Street;
    /** @var string|null */
    protected $Zipcode;

    /** @var array|null Array with optional properties */
    protected $other;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null $AddressType
     * @param string|null $FirstName
     * @param string|null $LastName
     * @param string|null $CompanyName
     * @param string|null $DepartmentName
     * @param string|null $Street
     * @param string|null $HouseNumber
     * @param string|null $HouseNumberSuffix
     * @param string|null $Zipcode
     * @param string|null $City
     * @param string|null $CountryCode
     * @param string|null $Region
     * @param string|null $District
     * @param string|null $Building
     * @param string|null $Floor
     * @param string|null $Remark
     * @param string|null $RegistrationDate
     */
    public function __construct(
        $AddressType = null,
        $FirstName = null,
        $LastName = null,
        $CompanyName = null,
        $DepartmentName = null,
        $Street = null,
        $HouseNumber = null,
        $HouseNumberSuffix = null,
        $Zipcode = null,
        $City = null,
        $CountryCode = null,
        $Region = null,
        $District = null,
        $Building = null,
        $Floor = null,
        $Remark = null,
        $RegistrationDate = null
    ) {
        parent::__construct();

        $this->setAddressType($AddressType);
        $this->setBuilding($Building);
        $this->setCity($City);
        $this->setCompanyName($CompanyName);
        $this->setCountryCode($CountryCode);
        $this->setDepartmentName($DepartmentName);
        $this->setDistrict($District);
        $this->setFirstName($FirstName);
        $this->setFloor($Floor);
        $this->setHouseNumber($HouseNumber);
        $this->setHouseNumberSuffix($HouseNumberSuffix);
        $this->setLastName($LastName);
        $this->setRegion($Region);
        $this->setRegistrationDate($RegistrationDate);
        $this->setRemark($Remark);
        $this->setStreet($Street);
        $this->setZipcode($Zipcode);
    }

    /**
     * Set postcode.
     *
     * @param string|null $Zipcode
     *
     * @return static
     */
    public function setZipcode($Zipcode = null)
    {
        if (is_null($Zipcode)) {
            $this->Zipcode = null;
        } else {
            $this->Zipcode = strtoupper(str_replace(' ', '', $Zipcode));
        }

        return $this;
    }

    /**
     * Set the AddressType.
     *
     * @param int|string|null $AddressType
     *
     * @return static
     */
    public function setAddressType($AddressType = null)
    {
        if (is_null($AddressType)) {
            $this->AddressType = null;
        } else {
            $this->AddressType = str_pad($AddressType, 2, '0', STR_PAD_LEFT);
        }

        return $this;
    }
}
