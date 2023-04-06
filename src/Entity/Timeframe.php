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

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\ServiceNotSetException;
use InvalidArgumentException;
use Sabre\Xml\Writer;

use function in_array;
use function is_string;

/**
 * @since 1.0.0
 */
class Timeframe extends AbstractEntity
{
    /** @var string|null $City */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $City = null;

    /** @var string|null $CountryCode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $CountryCode = null;

    /** @var DateTimeInterface|null $Date */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: DateTimeInterface::class)]
    protected ?DateTimeInterface $Date = null;

    /** @var DateTimeInterface|null $EndDate */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: DateTimeInterface::class)]
    protected ?DateTimeInterface $EndDate = null;

    /** @var string|null $HouseNr */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $HouseNr = null;

    /** @var string|null $HouseNrExt */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $HouseNrExt = null;

    /** @var string[]|null $Options */
    #[SerializableProperty(isArray: true, namespace: SoapNamespace::Domain, type: 'string')]
    protected ?array $Options = null;

    /** @var string|null $PostalCode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $PostalCode = null;

    /** @var DateTimeInterface|null $StartDate */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?DateTimeInterface $StartDate = null;

    /** @var string|null $Street */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Street = null;

    /** @var bool|null $SundaySorting */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'bool')]
    protected ?bool $SundaySorting = null;

    /** @var string|null $Interval */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Interval = null;

    /** @var string|null $TimeframeRange */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $TimeframeRange = null;

    /** @var TimeframeTimeFrame[]|Timeframe[]|null $Timeframes */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: TimeframeTimeFrame::class, isArray: true)]
    protected ?array $Timeframes = null;

    /**
     * @throws PostNLInvalidArgumentException
     */
    public function __construct(
        ?string                       $City = null,
        ?string                       $CountryCode = null,
        string|DateTimeInterface|null $Date = null,
        string|DateTimeInterface|null $EndDate = null,
        ?string                       $HouseNr = null,
        ?string                       $HouseNrExt = null,
        /** @param string[]|null $Options */
        ?array                        $Options = [],
        ?string                       $PostalCode = null,
        ?string                       $Street = null,
        ?string                       $SundaySorting = 'false',
        ?string                       $Interval = null,
        $Range = null,
        /** @param TimeframeTimeFrame[]|Timeframe[]|null $Timeframes */
        ?array                        $Timeframes = null,
        string|DateTimeInterface|null $StartDate = null
    ) {
        parent::__construct();

        $this->setCity(City: $City);
        $this->setCountryCode(CountryCode: $CountryCode);
        $this->setDate(Date: $Date);
        $this->setEndDate(EndDate: $EndDate);
        $this->setHouseNr(HouseNr: $HouseNr);
        $this->setHouseNrExt(HouseNrExt: $HouseNrExt);
        $this->setOptions(Options: $Options);
        $this->setPostalCode(PostalCode: $PostalCode);
        $this->setStreet(Street: $Street);
        $this->setSundaySorting(SundaySorting: $SundaySorting);
        $this->setInterval(Interval: $Interval);
        $this->setTimeframeRange(TimeframeRange: $Range);
        $this->setTimeframes(Timeframes: $Timeframes);
        $this->setStartDate(StartDate: $StartDate);
    }

    /**
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDate(string|DateTimeInterface|null $Date = null): static
    {
        if (is_string(value: $Date)) {
            try {
                $Date = new DateTimeImmutable(datetime: $Date, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new PostNLInvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->Date = $Date;

        return $this;
    }

    /**
     *
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setStartDate(string|DateTimeInterface|null $StartDate = null): static
    {
        if (is_string(value: $StartDate)) {
            try {
                $StartDate = new DateTimeImmutable(datetime: $StartDate, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new PostNLInvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->StartDate = $StartDate;

        return $this;
    }

    /**
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setEndDate(string|DateTimeInterface|null $EndDate = null): static
    {
        if (is_string(value: $EndDate)) {
            try {
                $EndDate = new DateTimeImmutable(datetime: $EndDate, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new PostNLInvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->EndDate = $EndDate;

        return $this;
    }

    /**
     * @param string|null $PostalCode
     *
     * @return static
     */
    public function setPostalCode(?string $PostalCode = null): static
    {
        if (is_null(value: $PostalCode)) {
            $this->PostalCode = null;
        } else {
            $this->PostalCode = strtoupper(string: str_replace(search: ' ', replace: '', subject: $PostalCode));
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->City;
    }

    /**
     * @param string|null $City
     *
     * @return Timeframe
     */
    public function setCity(?string $City): Timeframe
    {
        $this->City = $City;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->CountryCode;
    }

    /**
     * @param string|null $CountryCode
     *
     * @return Timeframe
     */
    public function setCountryCode(?string $CountryCode): Timeframe
    {
        $this->CountryCode = $CountryCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNr(): ?string
    {
        return $this->HouseNr;
    }

    /**
     * @param string|null $HouseNr
     *
     * @return Timeframe
     */
    public function setHouseNr(?string $HouseNr): Timeframe
    {
        $this->HouseNr = $HouseNr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNrExt(): ?string
    {
        return $this->HouseNrExt;
    }

    /**
     * @param string|null $HouseNrExt
     *
     * @return Timeframe
     */
    public function setHouseNrExt(?string $HouseNrExt): Timeframe
    {
        $this->HouseNrExt = $HouseNrExt;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getOptions(): ?array
    {
        return $this->Options;
    }

    /**
     * @param array|null $Options
     *
     * @return Timeframe
     */
    public function setOptions(?array $Options): Timeframe
    {
        $this->Options = $Options;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->Street;
    }

    /**
     * @param string|null $Street
     *
     * @return static
     */
    public function setStreet(?string $Street): static
    {
        $this->Street = $Street;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInterval(): ?string
    {
        return $this->Interval;
    }

    /**
     * @param string|null $Interval
     *
     * @return static
     */
    public function setInterval(?string $Interval): static
    {
        $this->Interval = $Interval;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTimeframeRange(): ?string
    {
        return $this->TimeframeRange;
    }

    /**
     * @param string|null $TimeframeRange
     *
     * @return static
     */
    public function setTimeframeRange(?string $TimeframeRange): static
    {
        $this->TimeframeRange = $TimeframeRange;

        return $this;
    }

    /**
     * @return TimeframeTimeFrame[]|Timeframe[]|null
     */
    public function getTimeframes(): ?array
    {
        return $this->Timeframes;
    }

    /**
     * @param TimeframeTimeFrame[]|Timeframe[]|null $Timeframes
     *
     * @return static
     */
    public function setTimeframes(?array $Timeframes): static
    {
        $this->Timeframes = $Timeframes;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDate(): ?DateTimeInterface
    {
        return $this->Date;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getEndDate(): ?DateTimeInterface
    {
        return $this->EndDate;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->PostalCode;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getStartDate(): ?DateTimeInterface
    {
        return $this->StartDate;
    }

    /**
     * @return bool|null
     */
    public function getSundaySorting(): ?bool
    {
        return $this->SundaySorting;
    }

    /**
     * @since 1.0.0
     * @since 1.3.0 Accept bool and int
     */
    public function setSundaySorting(string|bool|int|null $SundaySorting = null): static
    {
        if (null !== $SundaySorting) {
            $SundaySorting = in_array(needle: $SundaySorting, haystack: [true, 'true', 1], strict: true);
        }

        $this->SundaySorting = $SundaySorting;

        return $this;
    }

    /**
     * @return array
     * @throws ServiceNotSetException
     */
    public function jsonSerialize(): array
    {
        $json = [];
        if (!isset($this->currentService)) {
            throw new ServiceNotSetException(message: 'Service not set before serialization');
        }

        foreach (array_keys(array: $this->getSerializableProperties()) as $propertyName) {
            if (!isset($this->$propertyName)) {
                continue;
            }

            if ('Options' === $propertyName) {
                $json[$propertyName] = $this->$propertyName;
            } elseif ('Timeframes' === $propertyName) {
                $timeframes = [];
                foreach ($this->Timeframes as $timeframe) {
                    $timeframes[] = $timeframe;
                }
                $json['Timeframes'] = ['TimeframeTimeFrame' => $timeframes];
            } elseif ('SundaySorting' === $propertyName) {
                if (isset($this->$propertyName)) {
                    if (is_bool(value: $this->$propertyName)) {
                        $value = $this->$propertyName ? 'true' : 'false';
                    } else {
                        $value = $this->$propertyName;
                    }

                    $json[$propertyName] = $value;
                }
            } else {
                $json[$propertyName] = $this->$propertyName;
            }
        }

        return $json;
    }

    /**
     * @throws InvalidArgumentException|ServiceNotSetException
     */
    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        if (!isset($this->currentService)) {
            throw new ServiceNotSetException(message: 'Service not set before serialization');
        }

        foreach ($this->getSerializableProperties() as $propertyName => $namespace) {
            if ('StartDate' === $propertyName) {
                if ($this->StartDate instanceof DateTimeInterface) {
                    $xml["{{$namespace}}StartDate"] = $this->StartDate->format(format: 'd-m-Y');
                }
            } elseif ('EndDate' === $propertyName) {
                if ($this->StartDate instanceof DateTimeInterface) {
                    $xml["{{$namespace}}EndDate"] = $this->EndDate->format(format: 'd-m-Y');
                }
            } elseif ('SundaySorting' === $propertyName) {
                if (isset($this->SundaySorting)) {
                    if (is_bool(value: $this->SundaySorting)) {
                        $xml["{{$namespace}}SundaySorting"] = $this->SundaySorting ? 'true' : 'false';
                    } else {
                        $xml["{{$namespace}}SundaySorting"] = $this->SundaySorting;
                    }
                }
            } elseif ('Options' === $propertyName) {
                if (isset($this->Options)) {
                    $options = [];
                    foreach ($this->Options as $option) {
                        $options[] = ['{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string' => $option];
                    }
                    $xml["{{$namespace}}Options"] = $options;
                }
            } else {
                $xml["{{$namespace}}{$propertyName}"] = $this->$propertyName;
            }
        }

        $writer->write(value: $xml);
    }
}
