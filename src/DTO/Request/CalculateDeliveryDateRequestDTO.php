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

    #[RequestProp(requiredFor: [DeliveryDateServiceInterface::class])]
    protected string|null $ShippingDate = null;

    #[RequestProp(requiredFor: [DeliveryDateServiceInterface::class])]
    protected int|null $ShippingDuration = null;

    #[RequestProp(requiredFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTime = null;

    #[RequestProp(requiredFor: [DeliveryDateServiceInterface::class])]
    protected string|null $PostalCode = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CountryCode = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $OriginCountryCode = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $City = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $Street = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected int|null $HouseNumber = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $HouseNrExt = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected array|null $Options = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTimeMonday = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected bool|null $AvailableMonday = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTimeTuesday = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected bool|null $AvailableTuesday = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTimeWednesday = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected bool|null $AvailableWednesday = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTimeThursday = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected bool|null $AvailableThursday = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTimeFriday = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected bool|null $AvailableFriday = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTimeSaturday = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected bool|null $AvailableSaturday = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CutOffTimeSunday = null;

    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected bool|null $AvailableSunday = null;

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

    public function getShippingDate(): string|null
    {
        return $this->ShippingDate;
    }

    public function setShippingDate(string|null $ShippingDate = null): static
    {
        $this->ShippingDate = $ShippingDate;

        return $this;
    }

    public function getShippingDuration(): int|null
    {
        return $this->ShippingDuration;
    }

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

    public function getCutOffTime(): string|null
    {
        return $this->CutOffTime;
    }

    public function setCutOffTime(string|null $CutOffTime = null): static
    {
        $this->CutOffTime = $CutOffTime;

        return $this;
    }

    public function getPostalCode(): string|null
    {
        return $this->PostalCode;
    }

    public function setPostalCode(string|null $PostalCode = null): static
    {
        $this->PostalCode = $PostalCode;

        return $this;
    }

    public function getCountryCode(): string|null
    {
        return $this->CountryCode;
    }

    public function setCountryCode(string|null $CountryCode = null): static
    {
        $this->CountryCode = $CountryCode;

        return $this;
    }

    public function getOriginCountryCode(): string|null
    {
        return $this->OriginCountryCode;
    }

    public function setOriginCountryCode(string|null $OriginCountryCode = null): static
    {
        $this->OriginCountryCode = $OriginCountryCode;

        return $this;
    }

    public function getCity(): string|null
    {
        return $this->City;
    }

    public function setCity(string|null $City = null): static
    {
        $this->City = $City;

        return $this;
    }

    public function getStreet(): string|null
    {
        return $this->Street;
    }

    public function setStreet(string|null $Street = null): static
    {
        $this->Street = $Street;

        return $this;
    }

    public function getHouseNumber(): int|null
    {
        return $this->HouseNumber;
    }

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

    public function getHouseNrExt(): string|null
    {
        return $this->HouseNrExt;
    }

    public function setHouseNrExt(string|null $HouseNrExt = null): static
    {
        $this->HouseNrExt = $HouseNrExt;

        return $this;
    }

    public function getOptions(): array|null
    {
        return $this->Options;
    }

    public function setOptions(array|null $Options = null): static
    {
        $this->Options = $Options;

        return $this;
    }

    public function getCutOffTimeMonday(): string|null
    {
        return $this->CutOffTimeMonday;
    }

    public function setCutOffTimeMonday(string|null $CutOffTimeMonday = null): static
    {
        $this->CutOffTimeMonday = $CutOffTimeMonday;

        return $this;
    }

    public function getAvailableMonday(): bool|null
    {
        return $this->AvailableMonday;
    }

    public function setAvailableMonday(bool|null $AvailableMonday = null): static
    {
        $this->AvailableMonday = $AvailableMonday;

        return $this;
    }

    public function getCutOffTimeTuesday(): string|null
    {
        return $this->CutOffTimeTuesday;
    }

    public function setCutOffTimeTuesday(string|null $CutOffTimeTuesday = null): static
    {
        $this->CutOffTimeTuesday = $CutOffTimeTuesday;

        return $this;
    }

    public function getAvailableTuesday(): bool|null
    {
        return $this->AvailableTuesday;
    }

    public function setAvailableTuesday(bool|null $AvailableTuesday = null): static
    {
        $this->AvailableTuesday = $AvailableTuesday;

        return $this;
    }

    public function getCutOffTimeWednesday(): string|null
    {
        return $this->CutOffTimeWednesday;
    }

    public function setCutOffTimeWednesday(string|null $CutOffTimeWednesday = null): static
    {
        $this->CutOffTimeWednesday = $CutOffTimeWednesday;

        return $this;
    }

    public function getAvailableWednesday(): bool|null
    {
        return $this->AvailableWednesday;
    }

    public function setAvailableWednesday(bool|null $AvailableWednesday = null): static
    {
        $this->AvailableWednesday = $AvailableWednesday;

        return $this;
    }

    public function getCutOffTimeThursday(): string|null
    {
        return $this->CutOffTimeThursday;
    }

    public function setCutOffTimeThursday(string|null $CutOffTimeThursday = null): static
    {
        $this->CutOffTimeThursday = $CutOffTimeThursday;

        return $this;
    }

    public function getAvailableThursday(): bool|null
    {
        return $this->AvailableThursday;
    }

    public function setAvailableThursday(bool|null $AvailableThursday = null): static
    {
        $this->AvailableThursday = $AvailableThursday;

        return $this;
    }

    public function getCutOffTimeFriday(): string|null
    {
        return $this->CutOffTimeFriday;
    }

    public function setCutOffTimeFriday(string|null $CutOffTimeFriday = null): static
    {
        $this->CutOffTimeFriday = $CutOffTimeFriday;

        return $this;
    }

    public function getAvailableFriday(): bool|null
    {
        return $this->AvailableFriday;
    }

    public function setAvailableFriday(bool|null $AvailableFriday = null): static
    {
        $this->AvailableFriday = $AvailableFriday;

        return $this;
    }

    public function getCutOffTimeSaturday(): string|null
    {
        return $this->CutOffTimeSaturday;
    }

    public function setCutOffTimeSaturday(string|null $CutOffTimeSaturday = null): static
    {
        $this->CutOffTimeSaturday = $CutOffTimeSaturday;

        return $this;
    }

    public function getAvailableSaturday(): bool|null
    {
        return $this->AvailableSaturday;
    }

    public function setAvailableSaturday(bool|null $AvailableSaturday = null): static
    {
        $this->AvailableSaturday = $AvailableSaturday;

        return $this;
    }

    public function getCutOffTimeSunday(): string|null
    {
        return $this->CutOffTimeSunday;
    }

    public function setCutOffTimeSunday(string|null $CutOffTimeSunday = null): static
    {
        $this->CutOffTimeSunday = $CutOffTimeSunday;

        return $this;
    }

    public function getAvailableSunday(): bool|null
    {
        return $this->AvailableSunday;
    }

    public function setAvailableSunday(bool|null $AvailableSunday = null): static
    {
        $this->AvailableSunday = $AvailableSunday;

        return $this;
    }

    #[ArrayShape(shape: self::CUTOFF_TIME_ARRAY_SHAPE)]
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
