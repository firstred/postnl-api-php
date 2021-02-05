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

declare(strict_types=1);

namespace Firstred\PostNL\DTO\Request;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\DTO\CacheableDTO;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\DeliveryDateServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\ExpectedValues;
use TypeError;
use function date;
use function is_array;
use function is_numeric;
use function is_string;
use function strtotime;

/**
 * Class CalculateDeliveryDateRequestDTO.
 *
 * @see https://developer.postnl.nl/browse-apis/delivery-options/deliverydate-webservice/testtool-rest/
 */
class CalculateDeliveryDateRequestDTO extends CacheableDTO
{
    public const CUTOFF_TIME_ARRAY_SHAPE = [
        CutOffTime::MONDAY    => CutOffTime::class,
        CutOffTime::TUESDAY   => CutOffTime::class,
        CutOffTime::WEDNESDAY => CutOffTime::class,
        CutOffTime::THURSDAY  => CutOffTime::class,
        CutOffTime::FRIDAY    => CutOffTime::class,
        CutOffTime::SATURDAY  => CutOffTime::class,
        CutOffTime::SUNDAY    => CutOffTime::class,
    ];

    /**
     * Date/time of preparing the shipment for sending.
     *
     * Format: 29-05-2017 14:00:00
     *
     * @var string|null
     */
    #[RequestProp(requiredFor: [DeliveryDateServiceInterface::class])]
    protected string|null $ShippingDate = null;

    /**
     * The duration it takes for the shipment to be delivered to PostNL in days. A value of 1 means that the parcel will be delivered to PostNL on the same day as the date specified in ShippingDate. A value of 2 means the parcel will arrive at PostNL a day later etc.
     *
     * Format: 1
     *
     * @var int|null
     */
    #[RequestProp(requiredFor: [DeliveryDateServiceInterface::class])]
    protected int|null $ShippingDuration = null;

    /**
     * Cut off times per day. At least one cut off time must be specified.
     *
     * @var string|null
     */
    #[RequestProp(requiredFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTime = null;

    /**
     * Zipcode of the address.
     *
     * @var string|null
     */
    #[RequestProp(requiredFor: [DeliveryDateServiceInterface::class])]
    protected string|null $PostalCode = null;

    /**
     * The ISO2 country codes.
     *
     * Available values: NL, BE
     *
     * Default value: NL
     *
     * @var string|null
     */
    #[ExpectedValues(values: ['NL', 'BE'])]
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CountryCode = null;

    /**
     * The ISO2 country codes of the origin country.
     *
     * Available values: NL, BE
     *
     * Default value: NL
     *
     * @var string|null
     */
    #[ExpectedValues(values: ['NL', 'BE'])]
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $OriginCountryCode = null;

    /**
     * City of the address
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $City = null;

    /**
     * The street name of the delivery address.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $Street = null;

    /**
     * The house number of the delivery address.
     *
     * @var int|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected int|null $HouseNumber = null;

    /**
     * House number extension.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $HouseNrExt = null;

    /**
     * Specify zero or more delivery options.
     *
     * Available values : Daytime, Evening, Morning, Noon, Sunday, Sameday, Afternoon, MyTime, Pickup
     *
     * @var array|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected array|null $Options = null;

    /**
     * Override cutoff time for mondays.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTimeMonday = null;

    /**
     * Specifies if you are available to ship to PostNL on mondays.
     *
     * @var bool|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected bool|null $AvailableMonday = null;

    /**
     * Override cutoff time for tuesdays.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTimeTuesday = null;

    /**
     * Specifies if you are available to ship to PostNL on tuesdays.
     *
     * @var bool|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected bool|null $AvailableTuesday = null;

    /**
     * Override cutoff time for wednesdays.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTimeWednesday = null;

    /**
     * Specifies if you are available to ship to PostNL on wednesdays.
     *
     * @var bool|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected bool|null $AvailableWednesday = null;

    /**
     * Override cutoff time for thursdays.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTimeThursday = null;

    /**
     * Specifies if you are available to ship to PostNL on thursdays.
     *
     * @var bool|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected bool|null $AvailableThursday = null;

    /**
     * Override cutoff time for fridays.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTimeFriday = null;

    /**
     * Specifies if you are available to ship to PostNL on fridays.
     *
     * @var bool|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected bool|null $AvailableFriday = null;

    /**
     * Override cutoff time for saturdays.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTimeSaturday = null;

    /**
     * Specifies if you are available to ship to PostNL on saturdays.
     *
     * @var bool|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected bool|null $AvailableSaturday = null;

    /**
     * Override cutoff time for sundays.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTimeSunday = null;

    /**
     * Specifies if you are available to ship to PostNL on sundays.
     *
     * @var bool|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected bool|null $AvailableSunday = null;

    /**
     * CalculateDeliveryDateRequestDTO constructor.
     *
     * @param string          $service
     * @param string          $propType
     * @param string          $cacheKey
     * @param string|null     $ShippingDate
     * @param int|string|null $ShippingDuration
     * @param string|null     $CutOffTime
     * @param string|null     $PostalCode
     * @param string|null     $CountryCode
     * @param string|null     $OriginCountryCode
     * @param string|null     $City
     * @param string|null     $Street
     * @param int|string|null $HouseNumber
     * @param string|null     $HouseNrExt
     * @param array|null      $Options
     * @param string|null     $CutOffTimeMonday
     * @param bool|null       $AvailableMonday
     * @param string|null     $CutOffTimeTuesday
     * @param bool|null       $AvailableTuesday
     * @param string|null     $CutOffTimeWednesday
     * @param bool|null       $AvailableWednesday
     * @param string|null     $CutOffTimeThursday
     * @param bool|null       $AvailableThursday
     * @param string|null     $CutOffTimeFriday
     * @param bool|null       $AvailableFriday
     * @param string|null     $CutOffTimeSaturday
     * @param bool|null       $AvailableSaturday
     * @param string|null     $CutOffTimeSunday
     * @param bool|null       $AvailableSunday
     * @param array|null      $cutOffTimes
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service = DeliveryDateServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType = RequestProp::class,
        string $cacheKey = '',

        string|null $ShippingDate = null,
        int|string|null $ShippingDuration = null,
        string|null $CutOffTime = null,
        string|null $PostalCode = null,
        string|null $CountryCode = null,
        string|null $OriginCountryCode = null,
        string|null $City = null,
        string|null $Street = null,
        int|string|null $HouseNumber = null,
        string|null $HouseNrExt = null,
        array|null $Options = null,
        string|null $CutOffTimeMonday = null,
        bool|null $AvailableMonday = null,
        string|null $CutOffTimeTuesday = null,
        bool|null $AvailableTuesday = null,
        string|null $CutOffTimeWednesday = null,
        bool|null $AvailableWednesday = null,
        string|null $CutOffTimeThursday = null,
        bool|null $AvailableThursday = null,
        string|null $CutOffTimeFriday = null,
        bool|null $AvailableFriday = null,
        string|null $CutOffTimeSaturday = null,
        bool|null $AvailableSaturday = null,
        string|null $CutOffTimeSunday = null,
        bool|null $AvailableSunday = null,
        array|null $cutOffTimes = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setShippingDate(ShippingDate: $ShippingDate);
        $this->setShippingDuration(ShippingDuration: $ShippingDuration);
        $this->setCutOffTime(CutOffTime: $CutOffTime);
        $this->setPostalCode(PostalCode: $PostalCode);
        $this->setCountryCode(CountryCode: $CountryCode);
        $this->setOriginCountryCode(OriginCountryCode: $OriginCountryCode);
        $this->setCity(City: $City);
        $this->setStreet(Street: $Street);
        $this->setHouseNumber(HouseNumber: $HouseNumber);
        $this->setHouseNrExt(HouseNrExt: $HouseNrExt);
        $this->setOptions(Options: $Options);
        $this->setCutOffTimeMonday(CutOffTimeMonday: $CutOffTimeMonday);
        $this->setAvailableMonday(AvailableMonday: $AvailableMonday);
        $this->setCutOffTimeTuesday(CutOffTimeTuesday: $CutOffTimeTuesday);
        $this->setAvailableTuesday(AvailableTuesday: $AvailableTuesday);
        $this->setCutOffTimeWednesday(CutOffTimeWednesday: $CutOffTimeWednesday);
        $this->setAvailableWednesday(AvailableWednesday: $AvailableWednesday);
        $this->setCutOffTimeThursday(CutOffTimeThursday: $CutOffTimeThursday);
        $this->setAvailableThursday(AvailableThursday: $AvailableThursday);
        $this->setCutOffTimeFriday(CutOffTimeFriday: $CutOffTimeFriday);
        $this->setAvailableFriday(AvailableFriday: $AvailableFriday);
        $this->setCutOffTimeSaturday(CutOffTimeSaturday: $CutOffTimeSaturday);
        $this->setAvailableSaturday(AvailableSaturday: $AvailableSaturday);
        $this->setCutOffTimeSunday(CutOffTimeSunday: $CutOffTimeSunday);
        $this->setAvailableSunday(AvailableSunday: $AvailableSunday);

        if (is_array(value: $cutOffTimes)) {
            $this->resetCutOffTimes();
            $this->setCutOffTimes(cutOffTimes: $cutOffTimes);
        }
    }

    /**
     * @return string|null
     */
    public function getShippingDate(): string|null
    {
        return $this->ShippingDate;
    }

    /**
     * @param string|null $ShippingDate
     *
     * @return static
     */
    public function setShippingDate(string|null $ShippingDate = null): static
    {
        $this->ShippingDate = $ShippingDate;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getShippingDuration(): int|null
    {
        return $this->ShippingDuration;
    }

    /**
     * @param int|string|null $ShippingDuration
     *
     * @return static
     */
    public function setShippingDuration(int|string|null $ShippingDuration = null): static
    {
        if (is_string(value: $ShippingDuration)) {
            if (!is_numeric(value: $ShippingDuration)) {
                throw new TypeError("Invalid `ShippingDuration` value passed: $ShippingDuration");
            }

            $ShippingDuration = (int) $ShippingDuration;
        }

        $this->ShippingDuration = $ShippingDuration;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCutOffTime(): string|null
    {
        return $this->CutOffTime;
    }

    /**
     * @param string|null $CutOffTime
     *
     * @return static
     */
    public function setCutOffTime(string|null $CutOffTime = null): static
    {
        $this->CutOffTime = $CutOffTime;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): string|null
    {
        return $this->PostalCode;
    }

    /**
     * @param string|null $PostalCode
     *
     * @return static
     */
    public function setPostalCode(string|null $PostalCode = null): static
    {
        $this->PostalCode = $PostalCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): string|null
    {
        return $this->CountryCode;
    }

    /**
     * @param string|null $CountryCode
     *
     * @return static
     */
    public function setCountryCode(string|null $CountryCode = null): static
    {
        $this->CountryCode = $CountryCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOriginCountryCode(): string|null
    {
        return $this->OriginCountryCode;
    }

    /**
     * @param string|null $OriginCountryCode
     *
     * @return static
     */
    public function setOriginCountryCode(string|null $OriginCountryCode = null): static
    {
        $this->OriginCountryCode = $OriginCountryCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): string|null
    {
        return $this->City;
    }

    /**
     * @param string|null $City
     *
     * @return static
     */
    public function setCity(string|null $City = null): static
    {
        $this->City = $City;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): string|null
    {
        return $this->Street;
    }

    /**
     * @param string|null $Street
     *
     * @return static
     */
    public function setStreet(string|null $Street = null): static
    {
        $this->Street = $Street;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getHouseNumber(): int|null
    {
        return $this->HouseNumber;
    }

    /**
     * @param int|string|null $HouseNumber
     *
     * @return static
     */
    public function setHouseNumber(int|string|null $HouseNumber = null): static
    {
        if (is_string(value: $HouseNumber)) {
            if (!is_numeric(value: $HouseNumber)) {
                throw new TypeError("Invalid `HouseNumber` value passed: $HouseNumber");
            }

            $HouseNumber = (int) $HouseNumber;
        }

        $this->HouseNumber = $HouseNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNrExt(): string|null
    {
        return $this->HouseNrExt;
    }

    /**
     * @param string|null $HouseNrExt
     *
     * @return static
     */
    public function setHouseNrExt(string|null $HouseNrExt = null): static
    {
        $this->HouseNrExt = $HouseNrExt;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getOptions(): array|null
    {
        return $this->Options;
    }

    /**
     * @param array|null $Options
     *
     * @return static
     */
    public function setOptions(array|null $Options = null): static
    {
        $this->Options = $Options;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCutOffTimeMonday(): string|null
    {
        return $this->CutOffTimeMonday;
    }

    /**
     * @param string|null $CutOffTimeMonday
     *
     * @return static
     */
    public function setCutOffTimeMonday(string|null $CutOffTimeMonday = null): static
    {
        $this->CutOffTimeMonday = $CutOffTimeMonday;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAvailableMonday(): bool|null
    {
        return $this->AvailableMonday;
    }

    /**
     * @param bool|null $AvailableMonday
     *
     * @return static
     */
    public function setAvailableMonday(bool|null $AvailableMonday = null): static
    {
        $this->AvailableMonday = $AvailableMonday;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCutOffTimeTuesday(): string|null
    {
        return $this->CutOffTimeTuesday;
    }

    /**
     * @param string|null $CutOffTimeTuesday
     *
     * @return static
     */
    public function setCutOffTimeTuesday(string|null $CutOffTimeTuesday = null): static
    {
        $this->CutOffTimeTuesday = $CutOffTimeTuesday;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAvailableTuesday(): bool|null
    {
        return $this->AvailableTuesday;
    }

    /**
     * @param bool|null $AvailableTuesday
     *
     * @return static
     */
    public function setAvailableTuesday(bool|null $AvailableTuesday = null): static
    {
        $this->AvailableTuesday = $AvailableTuesday;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCutOffTimeWednesday(): string|null
    {
        return $this->CutOffTimeWednesday;
    }

    /**
     * @param string|null $CutOffTimeWednesday
     *
     * @return static
     */
    public function setCutOffTimeWednesday(string|null $CutOffTimeWednesday = null): static
    {
        $this->CutOffTimeWednesday = $CutOffTimeWednesday;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAvailableWednesday(): bool|null
    {
        return $this->AvailableWednesday;
    }

    /**
     * @param bool|null $AvailableWednesday
     *
     * @return static
     */
    public function setAvailableWednesday(bool|null $AvailableWednesday = null): static
    {
        $this->AvailableWednesday = $AvailableWednesday;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCutOffTimeThursday(): string|null
    {
        return $this->CutOffTimeThursday;
    }

    /**
     * @param string|null $CutOffTimeThursday
     *
     * @return static
     */
    public function setCutOffTimeThursday(string|null $CutOffTimeThursday = null): static
    {
        $this->CutOffTimeThursday = $CutOffTimeThursday;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAvailableThursday(): bool|null
    {
        return $this->AvailableThursday;
    }

    /**
     * @param bool|null $AvailableThursday
     *
     * @return static
     */
    public function setAvailableThursday(bool|null $AvailableThursday = null): static
    {
        $this->AvailableThursday = $AvailableThursday;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCutOffTimeFriday(): string|null
    {
        return $this->CutOffTimeFriday;
    }

    /**
     * @param string|null $CutOffTimeFriday
     *
     * @return static
     */
    public function setCutOffTimeFriday(string|null $CutOffTimeFriday = null): static
    {
        $this->CutOffTimeFriday = $CutOffTimeFriday;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAvailableFriday(): bool|null
    {
        return $this->AvailableFriday;
    }

    /**
     * @param bool|null $AvailableFriday
     *
     * @return static
     */
    public function setAvailableFriday(bool|null $AvailableFriday = null): static
    {
        $this->AvailableFriday = $AvailableFriday;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCutOffTimeSaturday(): string|null
    {
        return $this->CutOffTimeSaturday;
    }

    /**
     * @param string|null $CutOffTimeSaturday
     *
     * @return static
     */
    public function setCutOffTimeSaturday(string|null $CutOffTimeSaturday = null): static
    {
        $this->CutOffTimeSaturday = $CutOffTimeSaturday;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAvailableSaturday(): bool|null
    {
        return $this->AvailableSaturday;
    }

    /**
     * @param bool|null $AvailableSaturday
     *
     * @return static
     */
    public function setAvailableSaturday(bool|null $AvailableSaturday = null): static
    {
        $this->AvailableSaturday = $AvailableSaturday;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCutOffTimeSunday(): string|null
    {
        return $this->CutOffTimeSunday;
    }

    /**
     * @param string|null $CutOffTimeSunday
     *
     * @return static
     */
    public function setCutOffTimeSunday(string|null $CutOffTimeSunday = null): static
    {
        $this->CutOffTimeSunday = $CutOffTimeSunday;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAvailableSunday(): bool|null
    {
        return $this->AvailableSunday;
    }

    /**
     * @param bool|null $AvailableSunday
     *
     * @return static
     */
    public function setAvailableSunday(bool|null $AvailableSunday = null): static
    {
        $this->AvailableSunday = $AvailableSunday;

        return $this;
    }

    #[ArrayShape(shape: self::CUTOFF_TIME_ARRAY_SHAPE)]
    /**
     * @throws InvalidArgumentException
     *
     * @return array
     */
    public function getCutOffTimes(): array
    {
        $service = DeliveryDateServiceInterface::class;
        $propType = RequestProp::class;

        return [
            CutOffTime::MONDAY => new CutOffTime(
                service: $service,
                propType: $propType,
                Day: CutOffTime::MONDAY,
                Time: $this->getCutOffTimeMonday(),
                Available: $this->getAvailableMonday(),
            ),
            CutOffTime::TUESDAY => new CutOffTime(
                service: $service,
                propType: $propType,
                Day: CutOffTime::TUESDAY,
                Time: $this->getCutOffTimeTuesday(),
                Available: $this->getAvailableTuesday(),
            ),
            CutOffTime::WEDNESDAY => new CutOffTime(
                service: $service,
                propType: $propType,
                Day: CutOffTime::WEDNESDAY,
                Time: $this->getCutOffTimeWednesday(),
                Available: $this->getAvailableWednesday(),
            ),
            CutOffTime::THURSDAY => new CutOffTime(
                service: $service,
                propType: $propType,
                Day: CutOffTime::THURSDAY,
                Time: $this->getCutOffTimeThursday(),
                Available: $this->getAvailableThursday(),
            ),
            CutOffTime::FRIDAY => new CutOffTime(
                service: $service,
                propType: $propType,
                Day: CutOffTime::FRIDAY,
                Time: $this->getCutOffTimeFriday(),
                Available: $this->getAvailableFriday(),
            ),
            CutOffTime::SATURDAY => new CutOffTime(
                service: $service,
                propType: $propType,
                Day: CutOffTime::SATURDAY,
                Time: $this->getCutOffTimeSaturday(),
                Available: $this->getAvailableSaturday(),
            ),
            CutOffTime::SUNDAY => new CutOffTime(
                service: $service,
                propType: $propType,
                Day: CutOffTime::SUNDAY,
                Time: $this->getCutOffTimeSunday(),
                Available: $this->getAvailableSunday(),
            ),
        ];
    }

    /**
     * @param array $cutOffTimes
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setCutOffTimes(array $cutOffTimes): static
    {
        foreach ($cutOffTimes as $dayOfWeek => $cutOffTime) {
            if (!$cutOffTime instanceof CutOffTime) {
                throw new InvalidArgumentException(message: 'Invalid CutOffTime passed');
            }

            switch ($dayOfWeek) {
                case CutOffTime::MONDAY:
                    $this->setAvailableMonday(AvailableMonday: $cutOffTime->getAvailable());
                    $this->setCutOffTimeMonday(CutOffTimeMonday: $cutOffTime->getTime());
                    break;
                case CutOffTime::TUESDAY:
                    $this->setAvailableTuesday(AvailableTuesday: $cutOffTime->getAvailable());
                    $this->setCutOffTimeTuesday(CutOffTimeTuesday: $cutOffTime->getTime());
                    break;
                case CutOffTime::WEDNESDAY:
                    $this->setAvailableWednesday(AvailableWednesday: $cutOffTime->getAvailable());
                    $this->setCutOffTimeWednesday(CutOffTimeWednesday: $cutOffTime->getTime());
                    break;
                case CutOffTime::THURSDAY:
                    $this->setAvailableThursday(AvailableThursday: $cutOffTime->getAvailable());
                    $this->setCutOffTimeThursday(CutOffTimeThursday: $cutOffTime->getTime());
                    break;
                case CutOffTime::FRIDAY:
                    $this->setAvailableFriday(AvailableFriday: $cutOffTime->getAvailable());
                    $this->setCutOffTimeFriday(CutOffTimeFriday: $cutOffTime->getTime());
                    break;
                case CutOffTime::SATURDAY:
                    $this->setAvailableSaturday(AvailableSaturday: $cutOffTime->getAvailable());
                    $this->setCutOffTimeSaturday(CutOffTimeSaturday: $cutOffTime->getTime());
                    break;
                case CutOffTime::SUNDAY:
                    $this->setAvailableSunday(AvailableSunday: $cutOffTime->getAvailable());
                    $this->setCutOffTimeSunday(CutOffTimeSunday: $cutOffTime->getTime());
                    break;
            }
        }

        return $this;
    }

    /**
     * @return static
     */
    public function resetCutOffTimes(): static
    {
        $this->setCutOffTimeMonday();
        $this->setAvailableMonday();
        $this->setCutOffTimeTuesday();
        $this->setAvailableTuesday();
        $this->setCutOffTimeWednesday();
        $this->setAvailableWednesday();
        $this->setCutOffTimeThursday();
        $this->setAvailableThursday();
        $this->setCutOffTimeFriday();
        $this->setAvailableFriday();
        $this->setCutOffTimeSaturday();
        $this->setAvailableSaturday();
        $this->setCutOffTimeSunday();

        return $this;
    }

    /**
     * @return string
     */
    public function getUniqueId(): string
    {
        $optionsArray = implode(separator: '+', array: $this->getOptions() ?? []);

        return "{$this->getShortClassName()}-{$this->getShippingDate()}|{$this->getShippingDuration()}|{$this->getCutOffTime()}|{$this->getPostalCode()}|{$this->getCountryCode()}|{$this->getOriginCountryCode()}|{$this->getCity()}|{$this->getStreet()}|{$this->getHouseNumber()}|{$this->getHouseNrExt()}|{$optionsArray}|{$this->getAvailableMonday()}|{$this->getCutOffTimeMonday()}|{$this->getAvailableTuesday()}|{$this->getCutOffTimeTuesday()}|{$this->getAvailableWednesday()}|{$this->getCutOffTimeWednesday()}|{$this->getAvailableThursday()}|{$this->getCutOffTimeThursday()}|{$this->getAvailableFriday()}|{$this->getCutOffTimeFriday()}|{$this->getAvailableSaturday()}|{$this->getCutOffTimeSaturday()}|{$this->getAvailableSunday()}|{$this->getCutOffTimeSunday()}";
    }

    /**
     * @return array
     *
     * @throws InvalidArgumentException
     */
    public function jsonSerialize(): array
    {
        $query = parent::jsonSerialize();

        $query['Options'] = 'Daytime';
        $options = $this->getOptions();
        if (is_array(value: $options)) {
            foreach ($options as $option) {
                if ('Daytime' === $option) {
                    continue;
                }

                $query['Options'] .= ",$option";
            }
        }

        $query['CutOffTime'] = date(format: 'H:i:s', timestamp: strtotime(datetime: (string) $this->getCutOffTime()));
        foreach ($this->getCutOffTimes() as $idx => $time) {
            $day = (int) $idx + 1;
            $dayName = date(format: 'l', timestamp: strtotime(datetime: "Sunday +{$day} days"));
            if (null !== $this->{"getAvailable$dayName"}()) {
                $query["CutOffTime{$dayName}"] = date(format: 'H:i:s', timestamp: strtotime(datetime: $time->getTime() ?? '15:30:00'));
                $query["Available{$dayName}"] = 'true';
            }
        }

        return $query;
    }
}
