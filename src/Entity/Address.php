<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
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
 * @author    Michael Dekker <michael@thirtybees.com>
 * @copyright 2017 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Entity;

use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\LabellingService;

/**
 * Class Address
 *
 * @package ThirtyBeesPostNL\Entity\Address
 *
 * @method string getAddressType()
 * @method string getFirstName()
 * @method string getName()
 * @method string getCompanyName()
 * @method string getStreet()
 * @method string getHouseNr()
 * @method string getHouseNrExt()
 * @method string getZipcode()
 * @method string getCity()
 * @method string getCountrycode()
 * @method string getArea()
 * @method string getBuildingname()
 * @method string getDepartment()
 * @method string getDoorcode()
 * @method string getFloor()
 * @method string getRegion()
 * @method string getRemark()
 *
 * @method Address setAddressType(string $addressType)
 * @method Address setFirstName(string $firstName)
 * @method Address setName(string $name)
 * @method Address setCompanyName(string $companyName)
 * @method Address setStreet(string $street)
 * @method Address setHouseNr(string $houseNr)
 * @method Address setHouseNrExt(string $houseNrExt)
 * @method Address setZipcode(string $zipcode)
 * @method Address setCity(string $city)
 * @method Address setCountrycode(string $countrycode)
 * @method Address setArea(string $area)
 * @method Address setBuildingname(string $buildingName)
 * @method Address setDepartment(string $department)
 * @method Address setDoorcode(string $doorcode)
 * @method Address setFloor(string $floor)
 * @method Address setRegion(string $region)
 * @method Address setRemark(string $remark)
 */
class Address extends AbstractEntity
{
    /** @var string[] $defaultProperties */
    public static $defaultProperties = [
        'Barcode' => [
            'AddressType'  => BarcodeService::DOMAIN_NAMESPACE,
            'Area'         => BarcodeService::DOMAIN_NAMESPACE,
            'Buildingname' => BarcodeService::DOMAIN_NAMESPACE,
            'City'         => BarcodeService::DOMAIN_NAMESPACE,
            'CompanyName'  => BarcodeService::DOMAIN_NAMESPACE,
            'Countrycode'  => BarcodeService::DOMAIN_NAMESPACE,
            'Department'   => BarcodeService::DOMAIN_NAMESPACE,
            'Doorcode'     => BarcodeService::DOMAIN_NAMESPACE,
            'FirstName'    => BarcodeService::DOMAIN_NAMESPACE,
            'Floor'        => BarcodeService::DOMAIN_NAMESPACE,
            'HouseNr'      => BarcodeService::DOMAIN_NAMESPACE,
            'HouseNrExt'   => BarcodeService::DOMAIN_NAMESPACE,
            'Name'         => BarcodeService::DOMAIN_NAMESPACE,
            'Region'       => BarcodeService::DOMAIN_NAMESPACE,
            'Remark'       => BarcodeService::DOMAIN_NAMESPACE,
            'Street'       => BarcodeService::DOMAIN_NAMESPACE,
            'Zipcode'      => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'AddressType'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Area'         => ConfirmingService::DOMAIN_NAMESPACE,
            'Buildingname' => ConfirmingService::DOMAIN_NAMESPACE,
            'City'         => ConfirmingService::DOMAIN_NAMESPACE,
            'CompanyName'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Countrycode'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Department'   => ConfirmingService::DOMAIN_NAMESPACE,
            'Doorcode'     => ConfirmingService::DOMAIN_NAMESPACE,
            'FirstName'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Floor'        => ConfirmingService::DOMAIN_NAMESPACE,
            'HouseNr'      => ConfirmingService::DOMAIN_NAMESPACE,
            'HouseNrExt'   => ConfirmingService::DOMAIN_NAMESPACE,
            'Name'         => ConfirmingService::DOMAIN_NAMESPACE,
            'Region'       => ConfirmingService::DOMAIN_NAMESPACE,
            'Remark'       => ConfirmingService::DOMAIN_NAMESPACE,
            'Street'       => ConfirmingService::DOMAIN_NAMESPACE,
            'Zipcode'      => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'AddressType'  => LabellingService::DOMAIN_NAMESPACE,
            'Area'         => LabellingService::DOMAIN_NAMESPACE,
            'Buildingname' => LabellingService::DOMAIN_NAMESPACE,
            'City'         => LabellingService::DOMAIN_NAMESPACE,
            'CompanyName'  => LabellingService::DOMAIN_NAMESPACE,
            'Countrycode'  => LabellingService::DOMAIN_NAMESPACE,
            'Department'   => LabellingService::DOMAIN_NAMESPACE,
            'Doorcode'     => LabellingService::DOMAIN_NAMESPACE,
            'FirstName'    => LabellingService::DOMAIN_NAMESPACE,
            'Floor'        => LabellingService::DOMAIN_NAMESPACE,
            'HouseNr'      => LabellingService::DOMAIN_NAMESPACE,
            'HouseNrExt'   => LabellingService::DOMAIN_NAMESPACE,
            'Name'         => LabellingService::DOMAIN_NAMESPACE,
            'Region'       => LabellingService::DOMAIN_NAMESPACE,
            'Remark'       => LabellingService::DOMAIN_NAMESPACE,
            'Street'       => LabellingService::DOMAIN_NAMESPACE,
            'Zipcode'      => LabellingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /**
     * @var string $AddressType
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
    protected $AddressType = null;
    /** @var string $Area */
    protected $Area = null;
    /** @var string $Buildingname */
    protected $Buildingname = null;
    /** @var string $City */
    protected $City = null;
    /** @var string $CompanyName */
    protected $CompanyName = null;
    /** @var string $Countrycode */
    protected $Countrycode = null;
    /** @var string $Department */
    protected $Department = null;
    /** @var string $Doorcode */
    protected $Doorcode = null;
    /** @var string $FirstName */
    protected $FirstName = null;
    /** @var string $Floor */
    protected $Floor = null;
    /** @var string $HouseNr */
    protected $HouseNr = null;
    /** @var string $HouseNrExt */
    protected $HouseNrExt = null;
    /** @var string $Name */
    protected $Name = null;
    /** @var string $Region */
    protected $Region = null;
    /** @var string $Remark */
    protected $Remark = null;
    /** @var string $Street */
    protected $Street = null;
    /** @var string $Zipcode */
    protected $Zipcode = null;
    /** @var array Array with optional properties */
    protected $other = [];
    // @codingStandardsIgnoreEnd

    /**
     * @param string      $addressType
     * @param string      $firstName
     * @param string      $name
     * @param string      $companyName
     * @param string      $street
     * @param string      $houseNr
     * @param string      $houseNrExt
     * @param string      $zipcode
     * @param string      $city
     * @param string      $countryCode
     * @param string|null $area
     * @param string|null $buildingName
     * @param string|null $department
     * @param string|null $doorcode
     * @param string|null $floor
     * @param string|null $region
     * @param string|null $remark
     */
    public function __construct(
        $addressType,
        $firstName,
        $name,
        $companyName,
        $street,
        $houseNr,
        $houseNrExt,
        $zipcode,
        $city,
        $countryCode,
        $area = null,
        $buildingName = null,
        $department = null,
        $doorcode = null,
        $floor = null,
        $region = null,
        $remark = null
    ) {
        parent::__construct();

        $this->setAddressType($addressType);
        $this->setFirstName($firstName);
        $this->setName($name);
        $this->setCompanyName($companyName);
        $this->setStreet($street);
        $this->setHouseNr($houseNr);
        $this->setHouseNrExt($houseNrExt);
        $this->setZipcode($zipcode);
        $this->setCity($city);
        $this->setCountrycode($countryCode);

        // Optional parameters.
        $this->setArea($area);
        $this->setBuildingname($buildingName);
        $this->setDepartment($department);
        $this->setDoorcode($doorcode);
        $this->setFloor($floor);
        $this->setRegion($region);
        $this->setRemark($remark);
    }
}
