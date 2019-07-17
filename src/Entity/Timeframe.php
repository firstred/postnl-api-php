<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

/**
 * Class Timeframe
 */
class Timeframe extends AbstractEntity
{
    /** @var string|null $city */
    protected $city;
    /** @var string|null $countryCode */
    protected $countryCode;
    /** @var string|null $date */
    protected $date;
    /** @var string|null $endDate */
    protected $endDate;
    /** @var string|null $houseNr */
    protected $houseNr;
    /** @var string|null $houseNrExt */
    protected $houseNrExt;
    /** @var string[]|null $options */
    protected $options;
    /** @var string|null $postalCode */
    protected $postalCode;
    /** @var string|null $startDate */
    protected $startDate;
    /** @var string|null $street */
    protected $street;
    /** @var string|null $sundaySorting */
    protected $sundaySorting;
    /** @var string|null $interval */
    protected $interval;
    /** @var string|null $timeframeRange */
    protected $timeframeRange;
    /** @var TimeframeTimeFrame[]|Timeframe[]|null $timeframes */
    protected $timeframes;

    /**
     * Timeframe constructor.
     *
     * @param string|null      $city
     * @param string|null      $countryCode
     * @param string|null      $date
     * @param string|null      $endDate
     * @param string|null      $houseNr
     * @param string|null      $houseNrExt
     * @param array|null       $options
     * @param string|null      $postalCode
     * @param string|null      $street
     * @param bool|null        $sundaySorting
     * @param string|null      $interval
     * @param string|null      $range
     * @param Timeframe[]|null $timeframes
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $city = null, ?string $countryCode = null, ?string $date = null, ?string $endDate = null, ?string $houseNr = null, ?string $houseNrExt = null, ?array $options = [], ?string $postalCode = null, ?string $street = null, ?bool $sundaySorting = false, ?string $interval = null, ?string $range = null, ?array $timeframes = null)
    {
        parent::__construct();

        $this->setCity($city);
        $this->setCountryCode($countryCode);
        $this->setDate($date);
        $this->setEndDate($endDate);
        $this->setHouseNr($houseNr);
        $this->setHouseNrExt($houseNrExt);
        $this->setOptions($options);
        $this->setPostalCode($postalCode);
        $this->setStreet($street);
        $this->setSundaySorting($sundaySorting);
        $this->setInterval($interval);
        $this->setTimeframeRange($range);
        $this->setTimeframes($timeframes);
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Set the postcode
     *
     * @param string|null $postcode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setPostalCode(?string $postcode = null): Timeframe
    {
        if (is_null($postcode)) {
            $this->postalCode = null;
        } else {
            $this->postalCode = strtoupper(str_replace(' ', '', $postcode));
        }

        return $this;
    }

    /**
     * Return a serializable array for `json_encode`
     *
     * @return array
     *
     * @since 1.0.0
     */
    public function jsonSerialize(): array
    {
        $json = [];
        foreach (array_keys(get_class_vars(static::class)) as $propertyName) {
            if (isset($this->{$propertyName})) {
                if ('Options' === $propertyName) {
                    $json[$propertyName] = $this->{$propertyName};
                } elseif ('Timeframes' === $propertyName) {
                    $timeframes = [];
                    foreach ($this->timeframes as $timeframe) {
                        $timeframes[] = $timeframe;
                    }
                    $json['Timeframes'] = ['TimeframeTimeFrame' => $timeframes];
                } elseif ('SundaySorting' === $propertyName) {
                    if (isset($this->{$propertyName})) {
                        if (is_bool($this->{$propertyName})) {
                            $value = $this->{$propertyName} ? 'true' : 'false';
                        } else {
                            $value = $this->{$propertyName};
                        }

                        $json[$propertyName] = $value;
                    }
                } else {
                    $json[$propertyName] = $this->{$propertyName};
                }
            }
        }

        return $json;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCity(?string $city): Timeframe
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @param string|null $countryCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCountryCode(?string $countryCode): Timeframe
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string|null $date
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDate(?string $date): Timeframe
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    /**
     * @param string|null $endDate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setEndDate(?string $endDate): Timeframe
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getHouseNr(): ?string
    {
        return $this->houseNr;
    }

    /**
     * @param string|null $houseNr
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setHouseNr(?string $houseNr): Timeframe
    {
        $this->houseNr = $houseNr;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getHouseNrExt(): ?string
    {
        return $this->houseNrExt;
    }

    /**
     * @param string|null $houseNrExt
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setHouseNrExt(?string $houseNrExt): Timeframe
    {
        $this->houseNrExt = $houseNrExt;

        return $this;
    }

    /**
     * @return string[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * @param string[]|null $options
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setOptions(?array $options): Timeframe
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * @param string|null $startDate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setStartDate(?string $startDate): Timeframe
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setStreet(?string $street): Timeframe
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getSundaySorting(): ?string
    {
        return $this->sundaySorting;
    }

    /**
     * @param bool|null $sundaySorting
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setSundaySorting(?bool $sundaySorting): Timeframe
    {
        $this->sundaySorting = $sundaySorting;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getInterval(): ?string
    {
        return $this->interval;
    }

    /**
     * @param string|null $interval
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setInterval(?string $interval): Timeframe
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getTimeframeRange(): ?string
    {
        return $this->timeframeRange;
    }

    /**
     * @param string|null $timeframeRange
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setTimeframeRange(?string $timeframeRange): Timeframe
    {
        $this->timeframeRange = $timeframeRange;

        return $this;
    }

    /**
     * @return Timeframe[]|TimeframeTimeFrame[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getTimeframes()
    {
        return $this->timeframes;
    }

    /**
     * @param Timeframe[]|TimeframeTimeFrame[]|null $timeframes
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setTimeframes($timeframes): Timeframe
    {
        $this->timeframes = $timeframes;

        return $this;
    }
}
