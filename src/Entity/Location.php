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
 * @copyright 2017-2018 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Entity;

use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class Location
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string   getPostalcode()
 * @method string   getCoordinates()
 * @method string   getCity()
 * @method string   getStreet()
 * @method string   getHouseNr()
 * @method string   getHouseNrExt()
 * @method string   getAllowSundaySorting()
 * @method string   getDeliveryDate()
 * @method string[] getDeliveryOptions()
 * @method string[] getOptions()
 *
 * @method Location setPostalcode(string $postcode)
 * @method Location setCoordinates(Coordinates $coordinates)
 * @method Location setCity(string $city)
 * @method Location setStreet(string $street)
 * @method Location setHouseNr(string $houseNr)
 * @method Location setHouseNrExt(string $houseNrExt)
 * @method Location setAllowSundaySorting(string $sundaySorting)
 * @method Location setDeliveryDate(string $deliveryDate)
 * @method Location setDeliveryOptions(string[] $deliveryOptions)
 * @method Location setOptions(string[] $options)
 */
class Location extends AbstractEntity
{
    /** @var string[] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'City'               => BarcodeService::DOMAIN_NAMESPACE,
            'Coordinates'        => BarcodeService::DOMAIN_NAMESPACE,
            'HouseNr'            => BarcodeService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => BarcodeService::DOMAIN_NAMESPACE,
            'PostalCode'         => BarcodeService::DOMAIN_NAMESPACE,
            'Street'             => BarcodeService::DOMAIN_NAMESPACE,
            'AllowSundaySorting' => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryDate'       => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryOptions'    => BarcodeService::DOMAIN_NAMESPACE,
            'OpeningTime'        => BarcodeService::DOMAIN_NAMESPACE,
            'Options'            => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'City'               => ConfirmingService::DOMAIN_NAMESPACE,
            'Coordinates'        => ConfirmingService::DOMAIN_NAMESPACE,
            'HouseNr'            => ConfirmingService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => ConfirmingService::DOMAIN_NAMESPACE,
            'PostalCode'         => ConfirmingService::DOMAIN_NAMESPACE,
            'Street'             => ConfirmingService::DOMAIN_NAMESPACE,
            'AllowSundaySorting' => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryDate'       => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryOptions'    => ConfirmingService::DOMAIN_NAMESPACE,
            'OpeningTime'        => ConfirmingService::DOMAIN_NAMESPACE,
            'Options'            => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'City'               => LabellingService::DOMAIN_NAMESPACE,
            'Coordinates'        => LabellingService::DOMAIN_NAMESPACE,
            'HouseNr'            => LabellingService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => LabellingService::DOMAIN_NAMESPACE,
            'PostalCode'         => LabellingService::DOMAIN_NAMESPACE,
            'Street'             => LabellingService::DOMAIN_NAMESPACE,
            'AllowSundaySorting' => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryDate'       => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryOptions'    => LabellingService::DOMAIN_NAMESPACE,
            'OpeningTime'        => LabellingService::DOMAIN_NAMESPACE,
            'Options'            => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'City'               => ShippingStatusService::DOMAIN_NAMESPACE,
            'Coordinates'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'HouseNr'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'PostalCode'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'Street'             => ShippingStatusService::DOMAIN_NAMESPACE,
            'AllowSundaySorting' => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryDate'       => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryOptions'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'OpeningTime'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'Options'            => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'City'               => DeliveryDateService::DOMAIN_NAMESPACE,
            'Coordinates'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'HouseNr'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'PostalCode'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'Street'             => DeliveryDateService::DOMAIN_NAMESPACE,
            'AllowSundaySorting' => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryDate'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryOptions'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'OpeningTime'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'Options'            => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'City'               => LocationService::DOMAIN_NAMESPACE,
            'Coordinates'        => LocationService::DOMAIN_NAMESPACE,
            'HouseNr'            => LocationService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => LocationService::DOMAIN_NAMESPACE,
            'PostalCode'         => LocationService::DOMAIN_NAMESPACE,
            'Street'             => LocationService::DOMAIN_NAMESPACE,
            'AllowSundaySorting' => LocationService::DOMAIN_NAMESPACE,
            'DeliveryDate'       => LocationService::DOMAIN_NAMESPACE,
            'DeliveryOptions'    => LocationService::DOMAIN_NAMESPACE,
            'OpeningTime'        => LocationService::DOMAIN_NAMESPACE,
            'Options'            => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'City'               => TimeframeService::DOMAIN_NAMESPACE,
            'Coordinates'        => TimeframeService::DOMAIN_NAMESPACE,
            'HouseNr'            => TimeframeService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => TimeframeService::DOMAIN_NAMESPACE,
            'PostalCode'         => TimeframeService::DOMAIN_NAMESPACE,
            'Street'             => TimeframeService::DOMAIN_NAMESPACE,
            'AllowSundaySorting' => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryDate'       => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryOptions'    => TimeframeService::DOMAIN_NAMESPACE,
            'OpeningTime'        => TimeframeService::DOMAIN_NAMESPACE,
            'Options'            => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string $City */
    protected $City = null;
    /** @var Coordinates $Coordinates */
    protected $Coordinates = null;
    /** @var string $HouseNr */
    protected $HouseNr = null;
    /** @var string $HouseNrExt */
    protected $HouseNrExt = null;
    /** @var string $Postalcode */
    protected $Postalcode = null;
    /** @var string $Street */
    protected $Street = null;
    /** @var string $AllowSundaySorting */
    protected $AllowSundaySorting = null;
    /** @var string $DeliveryDate */
    protected $DeliveryDate = null;
    /** @var string[] $DeliveryOptions */
    protected $DeliveryOptions = null;
    /** @var string $OpeningTime */
    protected $OpeningTime = null;
    /** @var string[] $Options */
    protected $Options = null;
    // @codingStandardsIgnoreEnd

    /**
     * @param string      $zipcode
     * @param string      $allowSundaySorting
     * @param string      $deliveryDate
     * @param array       $deliveryOptions
     * @param array       $options
     * @param Coordinates $coordinates
     * @param string      $city
     * @param string      $street
     * @param string      $houseNr
     * @param string      $houseNrExt
     */
    public function __construct(
        $zipcode,
        $allowSundaySorting,
        $deliveryDate = null,
        array $deliveryOptions = ['PG'],
        array $options = ['Daytime'],
        Coordinates $coordinates = null,
        $city = null,
        $street = null,
        $houseNr = null,
        $houseNrExt = null
    ) {
        parent::__construct();

        $this->setAllowSundaySorting($allowSundaySorting);
        $this->setDeliveryDate($deliveryDate ?: (new \DateTime('next monday'))->format('d-m-Y'));
        $this->setDeliveryOptions($deliveryOptions);
        $this->setOptions($options);
        $this->setPostalcode($zipcode);
        $this->setCoordinates($coordinates);
        $this->setCity($city);
        $this->setStreet($street);
        $this->setHouseNr($houseNr);
        $this->setHouseNrExt($houseNrExt);
    }
}
