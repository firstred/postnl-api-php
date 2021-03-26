<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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

namespace ThirtyBees\PostNL\Entity\Response;

use stdClass;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\OpeningHours;
use ThirtyBees\PostNL\Entity\Warning;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class ResponseLocation.
 *
 * @method Address|null     getAddress()
 * @method string[]|null    getDeliveryOptions()
 * @method string|null      getDistance()
 * @method string|null      getLatitude()
 * @method string|null      getLongitude()
 * @method string|null      getName()
 * @method string[][]|null  getOpeningHours()
 * @method string|null      getPartnerName()
 * @method string|null      getPhoneNumber()
 * @method string|null      getRetailNetworkID()
 * @method string|null      getLocationCode()
 * @method string|null      getSaleschannel()
 * @method string|null      getTerminalType()
 * @method Warning[]|null   getWarnings()
 * @method string|null      getDownPartnerID()
 * @method string|null      getDownPartnerLocation()
 * @method ResponseLocation setAddress(Address|null $address = null)
 * @method ResponseLocation setDeliveryOptions(string[]|null $options)
 * @method ResponseLocation setDistance(string|null $dist = null)
 * @method ResponseLocation setLatitude(string|null $lat = null)
 * @method ResponseLocation setLongitude(string|null $long = null)
 * @method ResponseLocation setName(string|null $name = null)
 * @method ResponseLocation setOpeningHours(string[]|null $hours = null)
 * @method ResponseLocation setPartnerName(string|null $partnerName = null)
 * @method ResponseLocation setPhoneNumber(string|null $number = null)
 * @method ResponseLocation setRetailNetworkID(string|null $id = null)
 * @method ResponseLocation setLocationCode(string|null $code = null)
 * @method ResponseLocation setSaleschannel(string|null $channel = null)
 * @method ResponseLocation setTerminalType(string|null $type = null)
 * @method ResponseLocation setWarnings(Warning[]|null $warnings = null)
 * @method ResponseLocation setDownPartnerID(string|null $downPartnerID = null)
 * @method ResponseLocation setDownPartnerLocation(string|null $downPartnerLocation = null)
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
        'ShippingStatus' => [
            'Address'             => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryOptions'     => ShippingStatusService::DOMAIN_NAMESPACE,
            'Distance'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'Latitude'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'Longitude'           => ShippingStatusService::DOMAIN_NAMESPACE,
            'Name'                => ShippingStatusService::DOMAIN_NAMESPACE,
            'OpeningHours'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'PartnerName'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'PhoneNumber'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'LocationCode'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'RetailNetworkID'     => ShippingStatusService::DOMAIN_NAMESPACE,
            'Saleschannel'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'TerminalType'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'Warnings'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'DownPartnerID'       => ShippingStatusService::DOMAIN_NAMESPACE,
            'DownPartnerLocation' => ShippingStatusService::DOMAIN_NAMESPACE,
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
    /** @var string[]|null */
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
     * @param Address|null   $address
     * @param string[]|null  $deliveryOptions
     * @param string|null    $distance
     * @param string|null    $latitude
     * @param string|null    $longitude
     * @param string|null    $name
     * @param string[]|null  $openingHours
     * @param string|null    $partnerName
     * @param string|null    $phoneNumber
     * @param string|null    $locationCode
     * @param string|null    $retailNetworkId
     * @param string|null    $saleschannel
     * @param string|null    $terminalType
     * @param Warning[]|null $warnings
     * @param string|null    $downPartnerID
     * @param string|null    $downPartnerLocation
     */
    public function __construct(
        Address $address = null,
        array $deliveryOptions = null,
        $distance = null,
        $latitude = null,
        $longitude = null,
        $name = null,
        $openingHours = null,
        $partnerName = null,
        $phoneNumber = null,
        $locationCode = null,
        $retailNetworkId = null,
        $saleschannel = null,
        $terminalType = null,
        $warnings = null,
        $downPartnerID = null,
        $downPartnerLocation = null
    ) {
        parent::__construct();

        $this->setAddress($address);
        $this->setDeliveryOptions($deliveryOptions);
        $this->setDistance($distance);
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
        $this->setName($name);
        $this->setOpeningHours($openingHours);
        $this->setPartnerName($partnerName);
        $this->setPhoneNumber($phoneNumber);
        $this->setLocationCode($locationCode);
        $this->setRetailNetworkID($retailNetworkId);
        $this->setSaleschannel($saleschannel);
        $this->setTerminalType($terminalType);
        $this->setWarnings($warnings);
        $this->setDownPartnerID($downPartnerID);
        $this->setDownPartnerLocation($downPartnerLocation);
    }
}
