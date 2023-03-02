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

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class ResponseAddress.
 *
 * @method string|null     getAddressType()
 * @method string|null     getFirstName()
 * @method string|null     getName()
 * @method string|null     getCompanyName()
 * @method string|null     getStreet()
 * @method string|null     getHouseNr()
 * @method string|null     getHouseNrExt()
 * @method string|null     getZipcode()
 * @method string|null     getCity()
 * @method string|null     getCountrycode()
 * @method string|null     getArea()
 * @method string|null     getBuildingname()
 * @method string|null     getDepartment()
 * @method string|null     getDoorcode()
 * @method string|null     getFloor()
 * @method string|null     getRegion()
 * @method string|null     getRemark()
 * @method ResponseAddress setAddressType(string|null $AddressType = null)
 * @method ResponseAddress setFirstName(string|null $firstName = null)
 * @method ResponseAddress setName(string|null $Name = null)
 * @method ResponseAddress setCompanyName(string|null $CompanyName = null)
 * @method ResponseAddress setStreet(string|null $Street = null)
 * @method ResponseAddress setHouseNr(string|null $HouseNr = null)
 * @method ResponseAddress setHouseNrExt(string|null $HouseNrExt = null)
 * @method ResponseAddress setCity(string|null $City = null)
 * @method ResponseAddress setCountrycode(string|null $Countrycode = null)
 * @method ResponseAddress setArea(string|null $Area = null)
 * @method ResponseAddress setBuildingname(string|null $BuildingName = null)
 * @method ResponseAddress setDepartment(string|null $Department = null)
 * @method ResponseAddress setDoorcode(string|null $Doorcode = null)
 * @method ResponseAddress setFloor(string|null $Floor = null)
 * @method ResponseAddress setRegion(string|null $Region = null)
 * @method ResponseAddress setRemark(string|null $Remark = null)
 *
 * @since 1.0.0
 */
class ResponseAddress extends AbstractEntity
{
    /** @var string[][] */
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
        'DeliveryDate' => [
            'AddressType'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Area'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'Buildingname' => DeliveryDateService::DOMAIN_NAMESPACE,
            'City'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'CompanyName'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Countrycode'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Department'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'Doorcode'     => DeliveryDateService::DOMAIN_NAMESPACE,
            'FirstName'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Floor'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'HouseNr'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'HouseNrExt'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'Name'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'Region'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'Remark'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'Street'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'Zipcode'      => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'AddressType'  => LocationService::DOMAIN_NAMESPACE,
            'Area'         => LocationService::DOMAIN_NAMESPACE,
            'Buildingname' => LocationService::DOMAIN_NAMESPACE,
            'City'         => LocationService::DOMAIN_NAMESPACE,
            'CompanyName'  => LocationService::DOMAIN_NAMESPACE,
            'Countrycode'  => LocationService::DOMAIN_NAMESPACE,
            'Department'   => LocationService::DOMAIN_NAMESPACE,
            'Doorcode'     => LocationService::DOMAIN_NAMESPACE,
            'FirstName'    => LocationService::DOMAIN_NAMESPACE,
            'Floor'        => LocationService::DOMAIN_NAMESPACE,
            'HouseNr'      => LocationService::DOMAIN_NAMESPACE,
            'HouseNrExt'   => LocationService::DOMAIN_NAMESPACE,
            'Name'         => LocationService::DOMAIN_NAMESPACE,
            'Region'       => LocationService::DOMAIN_NAMESPACE,
            'Remark'       => LocationService::DOMAIN_NAMESPACE,
            'Street'       => LocationService::DOMAIN_NAMESPACE,
            'Zipcode'      => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'AddressType'  => TimeframeService::DOMAIN_NAMESPACE,
            'Area'         => TimeframeService::DOMAIN_NAMESPACE,
            'Buildingname' => TimeframeService::DOMAIN_NAMESPACE,
            'City'         => TimeframeService::DOMAIN_NAMESPACE,
            'CompanyName'  => TimeframeService::DOMAIN_NAMESPACE,
            'Countrycode'  => TimeframeService::DOMAIN_NAMESPACE,
            'Department'   => TimeframeService::DOMAIN_NAMESPACE,
            'Doorcode'     => TimeframeService::DOMAIN_NAMESPACE,
            'FirstName'    => TimeframeService::DOMAIN_NAMESPACE,
            'Floor'        => TimeframeService::DOMAIN_NAMESPACE,
            'HouseNr'      => TimeframeService::DOMAIN_NAMESPACE,
            'HouseNrExt'   => TimeframeService::DOMAIN_NAMESPACE,
            'Name'         => TimeframeService::DOMAIN_NAMESPACE,
            'Region'       => TimeframeService::DOMAIN_NAMESPACE,
            'Remark'       => TimeframeService::DOMAIN_NAMESPACE,
            'Street'       => TimeframeService::DOMAIN_NAMESPACE,
            'Zipcode'      => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /**
     * @var string|null
     *
     * PostNL internal applications validate the receiver ResponseAddress. In case the spelling of
     * ResponseAddresses should be different according to our PostNL information, the ResponseAddress details will
     * be corrected. This can be noticed in Track & Trace.
     *
     * Please note that the webservice will not add ResponseAddress details. Street and City fields will
     * only be printed when they are in the call towards the labeling webservice.
     *
     * The element ResponseAddress type is a code in the request. Possible values are:
     *
     * Code Description
     * 01   Receiver
     * 02   Sender
     * 03   Alternative sender ResponseAddress
     * 04   Collection ResponseAddress (In the orders need to be collected first)
     * 08   Return ResponseAddress*
     * 09   Drop off location (for use with Pick up at PostNL location)
     *
     * > * When using the ‘label in the box return label’, it is mandatory to use an
     * >   `Antwoordnummer` in AddressType 08.
     * >   This cannot be a regular ResponseAddress
     *
     * The following rules apply:
     * If there is no ResponseAddress specified with AddressType = 02, the data from Customer/ResponseAddress
     * will be added to the list as AddressType 02.
     * If there is no Customer/ResponseAddress, the message will be rejected.
     *
     * At least one other AddressType must be specified, other than AddressType 02
     * In most cases this will be AddressType 01, the receiver ResponseAddress.
     */
    protected $AddressType;
    /** @var string|null */
    protected $Area;
    /** @var string|null */
    protected $Buildingname;
    /** @var string|null */
    protected $City;
    /** @var string|null */
    protected $CompanyName;
    /** @var string|null */
    protected $Countrycode;
    /** @var string|null */
    protected $Department;
    /** @var string|null */
    protected $Doorcode;
    /** @var string|null */
    protected $FirstName;
    /** @var string|null */
    protected $Floor;
    /** @var string|null */
    protected $HouseNr;
    /** @var string|null */
    protected $HouseNrExt;
    /** @var string|null */
    protected $Name;
    /** @var string|null */
    protected $Region;
    /** @var string|null */
    protected $Remark;
    /** @var string|null */
    protected $Street;
    /** @var string|null */
    protected $Zipcode;
    /** @var array|null Array with optional properties */
    protected $other = [];
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null $AddressType
     * @param string|null $FirstName
     * @param string|null $Name
     * @param string|null $CompanyName
     * @param string|null $Street
     * @param string|null $HouseNr
     * @param string|null $HouseNrExt
     * @param string|null $Zipcode
     * @param string|null $City
     * @param string|null $Countrycode
     * @param string|null $Area
     * @param string|null $BuildingName
     * @param string|null $Department
     * @param string|null $Doorcode
     * @param string|null $Floor
     * @param string|null $Region
     * @param string|null $Remark
     */
    public function __construct(
        $AddressType = null,
        $FirstName = null,
        $Name = null,
        $CompanyName = null,
        $Street = null,
        $HouseNr = null,
        $HouseNrExt = null,
        $Zipcode = null,
        $City = null,
        $Countrycode = null,
        $Area = null,
        $BuildingName = null,
        $Department = null,
        $Doorcode = null,
        $Floor = null,
        $Region = null,
        $Remark = null
    ) {
        parent::__construct();

        $this->setAddressType($AddressType);
        $this->setFirstName($FirstName);
        $this->setName($Name);
        $this->setCompanyName($CompanyName);
        $this->setStreet($Street);
        $this->setHouseNr($HouseNr);
        $this->setHouseNrExt($HouseNrExt);
        $this->setZipcode($Zipcode);
        $this->setCity($City);
        $this->setCountrycode($Countrycode);

        // Optional parameters.
        $this->setArea($Area);
        $this->setBuildingname($BuildingName);
        $this->setDepartment($Department);
        $this->setDoorcode($Doorcode);
        $this->setFloor($Floor);
        $this->setRegion($Region);
        $this->setRemark($Remark);
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
}
