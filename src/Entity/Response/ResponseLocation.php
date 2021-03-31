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
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\OpeningHours;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;
use stdClass;

/**
 * Class ResponseLocation.
 *
 * @method Address|null      getAddress()
 * @method string[]|null     getDeliveryOptions()
 * @method string|null       getDistance()
 * @method string|null       getLatitude()
 * @method string|null       getLongitude()
 * @method string|null       getName()
 * @method OpeningHours|null getOpeningHours()
 * @method string|null       getPartnerName()
 * @method string|null       getPhoneNumber()
 * @method string|null       getRetailNetworkID()
 * @method string|null       getLocationCode()
 * @method string|null       getSaleschannel()
 * @method string|null       getTerminalType()
 * @method Warning[]|null    getWarnings()
 * @method string|null       getDownPartnerID()
 * @method string|null       getDownPartnerLocation()
 * @method ResponseLocation  setAddress(Address|null $Address = null)
 * @method ResponseLocation  setDeliveryOptions(string[]|null $DeliveryOptions)
 * @method ResponseLocation  setDistance(string|null $Distance = null)
 * @method ResponseLocation  setLatitude(string|null $Latitude = null)
 * @method ResponseLocation  setLongitude(string|null $Longitude = null)
 * @method ResponseLocation  setName(string|null $Name = null)
 * @method ResponseLocation  setOpeningHours(string[]|null $Hours = null)
 * @method ResponseLocation  setPartnerName(string|null $PartnerName = null)
 * @method ResponseLocation  setPhoneNumber(string|null $PhoneNumber = null)
 * @method ResponseLocation  setRetailNetworkID(string|null $RetailNetworkID = null)
 * @method ResponseLocation  setLocationCode(string|null $LocationCode = null)
 * @method ResponseLocation  setSaleschannel(string|null $Saleschannel = null)
 * @method ResponseLocation  setTerminalType(string|null $TerminalType = null)
 * @method ResponseLocation  setWarnings(Warning[]|null $Warnings = null)
 * @method ResponseLocation  setDownPartnerID(string|null $DownPartnerID = null)
 * @method ResponseLocation  setDownPartnerLocation(string|null $DownPartnerLocation = null)
 *
 * @since 1.0.0
 */
class ResponseLocation extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode' => [
            'Address'             => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryOptions'     => BarcodeService::DOMAIN_NAMESPACE,
            'Distance'            => BarcodeService::DOMAIN_NAMESPACE,
            'Latitude'            => BarcodeService::DOMAIN_NAMESPACE,
            'Longitude'           => BarcodeService::DOMAIN_NAMESPACE,
            'Name'                => BarcodeService::DOMAIN_NAMESPACE,
            'OpeningHours'        => BarcodeService::DOMAIN_NAMESPACE,
            'PartnerName'         => BarcodeService::DOMAIN_NAMESPACE,
            'PhoneNumber'         => BarcodeService::DOMAIN_NAMESPACE,
            'LocationCode'        => BarcodeService::DOMAIN_NAMESPACE,
            'RetailNetworkID'     => BarcodeService::DOMAIN_NAMESPACE,
            'Saleschannel'        => BarcodeService::DOMAIN_NAMESPACE,
            'TerminalType'        => BarcodeService::DOMAIN_NAMESPACE,
            'Warnings'            => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerID'       => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerLocation' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Address'             => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryOptions'     => ConfirmingService::DOMAIN_NAMESPACE,
            'Distance'            => ConfirmingService::DOMAIN_NAMESPACE,
            'Latitude'            => ConfirmingService::DOMAIN_NAMESPACE,
            'Longitude'           => ConfirmingService::DOMAIN_NAMESPACE,
            'Name'                => ConfirmingService::DOMAIN_NAMESPACE,
            'OpeningHours'        => ConfirmingService::DOMAIN_NAMESPACE,
            'PartnerName'         => ConfirmingService::DOMAIN_NAMESPACE,
            'PhoneNumber'         => ConfirmingService::DOMAIN_NAMESPACE,
            'LocationCode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'RetailNetworkID'     => ConfirmingService::DOMAIN_NAMESPACE,
            'Saleschannel'        => ConfirmingService::DOMAIN_NAMESPACE,
            'TerminalType'        => ConfirmingService::DOMAIN_NAMESPACE,
            'Warnings'            => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerID'       => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerLocation' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Address'             => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryOptions'     => LabellingService::DOMAIN_NAMESPACE,
            'Distance'            => LabellingService::DOMAIN_NAMESPACE,
            'Latitude'            => LabellingService::DOMAIN_NAMESPACE,
            'Longitude'           => LabellingService::DOMAIN_NAMESPACE,
            'Name'                => LabellingService::DOMAIN_NAMESPACE,
            'OpeningHours'        => LabellingService::DOMAIN_NAMESPACE,
            'PartnerName'         => LabellingService::DOMAIN_NAMESPACE,
            'PhoneNumber'         => LabellingService::DOMAIN_NAMESPACE,
            'LocationCode'        => LabellingService::DOMAIN_NAMESPACE,
            'RetailNetworkID'     => LabellingService::DOMAIN_NAMESPACE,
            'Saleschannel'        => LabellingService::DOMAIN_NAMESPACE,
            'TerminalType'        => LabellingService::DOMAIN_NAMESPACE,
            'Warnings'            => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerID'       => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerLocation' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Address'             => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryOptions'     => DeliveryDateService::DOMAIN_NAMESPACE,
            'Distance'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'Latitude'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'Longitude'           => DeliveryDateService::DOMAIN_NAMESPACE,
            'Name'                => DeliveryDateService::DOMAIN_NAMESPACE,
            'OpeningHours'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'PartnerName'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'PhoneNumber'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'LocationCode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'RetailNetworkID'     => DeliveryDateService::DOMAIN_NAMESPACE,
            'Saleschannel'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'TerminalType'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'Warnings'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'DownPartnerID'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'DownPartnerLocation' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Address'             => LocationService::DOMAIN_NAMESPACE,
            'DeliveryOptions'     => LocationService::DOMAIN_NAMESPACE,
            'Distance'            => LocationService::DOMAIN_NAMESPACE,
            'Latitude'            => LocationService::DOMAIN_NAMESPACE,
            'Longitude'           => LocationService::DOMAIN_NAMESPACE,
            'Name'                => LocationService::DOMAIN_NAMESPACE,
            'OpeningHours'        => LocationService::DOMAIN_NAMESPACE,
            'PartnerName'         => LocationService::DOMAIN_NAMESPACE,
            'PhoneNumber'         => LocationService::DOMAIN_NAMESPACE,
            'LocationCode'        => LocationService::DOMAIN_NAMESPACE,
            'RetailNetworkID'     => LocationService::DOMAIN_NAMESPACE,
            'Saleschannel'        => LocationService::DOMAIN_NAMESPACE,
            'TerminalType'        => LocationService::DOMAIN_NAMESPACE,
            'Warnings'            => LocationService::DOMAIN_NAMESPACE,
            'DownPartnerID'       => LocationService::DOMAIN_NAMESPACE,
            'DownPartnerLocation' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Address'             => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryOptions'     => TimeframeService::DOMAIN_NAMESPACE,
            'Distance'            => TimeframeService::DOMAIN_NAMESPACE,
            'Latitude'            => TimeframeService::DOMAIN_NAMESPACE,
            'Longitude'           => TimeframeService::DOMAIN_NAMESPACE,
            'Name'                => TimeframeService::DOMAIN_NAMESPACE,
            'OpeningHours'        => TimeframeService::DOMAIN_NAMESPACE,
            'PartnerName'         => TimeframeService::DOMAIN_NAMESPACE,
            'PhoneNumber'         => TimeframeService::DOMAIN_NAMESPACE,
            'LocationCode'        => TimeframeService::DOMAIN_NAMESPACE,
            'RetailNetworkID'     => TimeframeService::DOMAIN_NAMESPACE,
            'Saleschannel'        => TimeframeService::DOMAIN_NAMESPACE,
            'TerminalType'        => TimeframeService::DOMAIN_NAMESPACE,
            'Warnings'            => TimeframeService::DOMAIN_NAMESPACE,
            'DownPartnerID'       => TimeframeService::DOMAIN_NAMESPACE,
            'DownPartnerLocation' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];

    // @codingStandardsIgnoreStart
    /** @var Address|null */
    protected $Address;
    /** @var string[]|null */
    protected $DeliveryOptions;
    /** @var string|null */
    protected $Distance;
    /** @var string|null */
    protected $Latitude;
    /** @var string|null */
    protected $Longitude;
    /** @var string|null */
    protected $Name;
    /** @var OpeningHours|null */
    protected $OpeningHours;
    /** @var string|null */
    protected $PartnerName;
    /** @var string|null */
    protected $PhoneNumber;
    /** @var string|null */
    protected $LocationCode;
    /** @var string|null */
    protected $RetailNetworkID;
    /** @var string|null */
    protected $Saleschannel;
    /** @var string|null */
    protected $TerminalType;
    /** @var Warning[]|null */
    protected $Warnings;
    /** @var string|null */
    protected $DownPartnerID;
    /** @var string|null */
    protected $DownPartnerLocation;
    // @codingStandardsIgnoreEnd

    /**
     * ResponseLocation constructor.
     *
     * @param Address|null   $Address
     * @param string[]|null  $DeliveryOptions
     * @param string|null    $Distance
     * @param string|null    $Latitude
     * @param string|null    $Longitude
     * @param string|null    $Name
     * @param string[]|null  $OpeningHours
     * @param string|null    $PartnerName
     * @param string|null    $PhoneNumber
     * @param string|null    $LocationCode
     * @param string|null    $RetailNetworkID
     * @param string|null    $Saleschannel
     * @param string|null    $TerminalType
     * @param Warning[]|null $Warnings
     * @param string|null    $DownPartnerID
     * @param string|null    $DownPartnerLocation
     */
    public function __construct(
        Address $Address = null,
        array $DeliveryOptions = null,
        $Distance = null,
        $Latitude = null,
        $Longitude = null,
        $Name = null,
        $OpeningHours = null,
        $PartnerName = null,
        $PhoneNumber = null,
        $LocationCode = null,
        $RetailNetworkID = null,
        $Saleschannel = null,
        $TerminalType = null,
        $Warnings = null,
        $DownPartnerID = null,
        $DownPartnerLocation = null
    ) {
        parent::__construct();

        $this->setAddress($Address);
        $this->setDeliveryOptions($DeliveryOptions);
        $this->setDistance($Distance);
        $this->setLatitude($Latitude);
        $this->setLongitude($Longitude);
        $this->setName($Name);
        $this->setOpeningHours($OpeningHours);
        $this->setPartnerName($PartnerName);
        $this->setPhoneNumber($PhoneNumber);
        $this->setLocationCode($LocationCode);
        $this->setRetailNetworkID($RetailNetworkID);
        $this->setSaleschannel($Saleschannel);
        $this->setTerminalType($TerminalType);
        $this->setWarnings($Warnings);
        $this->setDownPartnerID($DownPartnerID);
        $this->setDownPartnerLocation($DownPartnerLocation);
    }

    public static function jsonDeserialize(stdClass $json)
    {
        if (isset($json->ResponseLocation->DeliveryOptions)) {
            /** @psalm-var list<string> $deliveryOptions */
            $deliveryOptions = [];
            if (!is_array($json->ResponseLocation->DeliveryOptions)){
                $json->ResponseLocation->DeliveryOptions = [$json->ResponseLocation->DeliveryOptions];
            }

            foreach ($json->ResponseLocation->DeliveryOptions as $deliveryOption) {
                if (isset($deliveryOption->string)) {
                    if (!is_array($deliveryOption->string)) {
                        $deliveryOption->string = [$deliveryOption->string];
                    }
                    foreach ($deliveryOption->string as $optionString) {
                        $deliveryOptions[] = $optionString;
                    }
                } elseif (is_array($deliveryOption)) {
                    $deliveryOptions = array_merge($deliveryOptions, $deliveryOption);
                } elseif (is_string($deliveryOption)) {
                    $deliveryOptions[] = $deliveryOption;
                }
            }

            $json->ResponseLocation->DeliveryOptions = $deliveryOptions;
        }

        return parent::jsonDeserialize($json);
    }
}
