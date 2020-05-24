<?php

declare(strict_types=1);

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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class FindNearestLocationsGeocodeRequest.
 *
 * This class is both the container and can be the actual GetLocationsInArea object itself!
 */
final class FindNearestLocationsGeocodeRequest extends AbstractEntity
{
    /**
     * Latitude.
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 52.156439
     *
     * @var float|null
     *
     * @since   2.0.0
     */
    private $latitude;

    /**
     * Longitude.
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 52.156439
     *
     * @var float|null
     *
     * @since   2.0.0
     */
    private $longitude;

    /**
     * Country code.
     *
     * @pattern ^(?:NL|BE)$
     *
     * @example NL
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $countrycode;

    /**
     * Delivery options.
     *
     * Available values are:
     * - PG: pickup from 3PM
     * - PGE: pickup from 9AM
     *
     * @pattern ^(?:PG|PGE)$
     *
     * @example PG
     *
     * @var array
     *
     * @since   2.0.0
     */
    private $deliveryOptions = [];

    /**
     * Delivery date.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @example 03-07-2019
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $deliveryDate;

    /**
     * Opening time.
     *
     * @pattern ^(?:[0-3]\d-[01]\d-[12]\d{3}\s+)[0-2]\d:[0-5]\d(?:[0-5]\d)$
     *
     * @example 10:00:00
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $openingTime;

    /**
     * Get country code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   FindNearestLocationsGeocodeRequest::$countrycode
     */
    public function getCountrycode(): ?string
    {
        return $this->countrycode;
    }

    /**
     * Set country code.
     *
     * @pattern ^(?:NL|BE)$
     *
     * @example NL
     *
     * @param string|null $countrycode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     FindNearestLocationsGeocodeRequest::$countrycode
     */
    public function setCountrycode(?string $countrycode): FindNearestLocationsGeocodeRequest
    {
        $this->countrycode = $this->validate->isoAlpha2CountryCodeNlBe($countrycode);

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return float|null
     *
     * @since 2.0.0 Strict typing
     * @see   FindNearestLocationsGeocodeRequest::$latitude
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * Set latitude.
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 52.156439
     *
     * @param float|string|null $latitude
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0 Strict typing
     * @see     FindNearestLocationsGeocodeRequest::$latitude
     */
    public function setLatitude($latitude): FindNearestLocationsGeocodeRequest
    {
        $this->latitude = $this->validate->coordinate($latitude);

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return float|null
     *
     * @since 2.0.0 Strict typing
     * @see   FindNearestLocationsGeocodeRequest::$longitude
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * Set longitude.
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 52.156439
     *
     * @param float|string|null $longitude
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0 Strict typing
     * @see     FindNearestLocationsGeocodeRequest::$longitude
     */
    public function setLongitude($longitude): FindNearestLocationsGeocodeRequest
    {
        $this->longitude = $this->validate->coordinate($longitude);

        return $this;
    }

    /**
     * Get delivery options.
     *
     * @return array
     *
     * @since 2.0.0 Strict typing
     * @see   FindNearestLocationsGeocodeRequest::$deliveryOptions
     */
    public function getDeliveryOptions(): array
    {
        return $this->deliveryOptions;
    }

    /**
     * Set delivery options.
     *
     * @pattern ^(?:PG|PGE)$
     *
     * @example PG
     *
     * @param array $deliveryOptions
     *
     * @return static
     *
     * @since   2.0.0 Strict typing
     * @see     FindNearestLocationsGeocodeRequest::$deliveryOptions
     */
    public function setDeliveryOptions(array $deliveryOptions): FindNearestLocationsGeocodeRequest
    {
        $this->deliveryOptions = $deliveryOptions;

        return $this;
    }

    /**
     * Get delivery date.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   FindNearestLocationsGeocodeRequest::$deliveryDate
     */
    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    /**
     * Set delivery date.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @example 03-07-2019
     *
     * @param string|null $deliveryDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0 Strict typing
     * @see     FindNearestLocationsGeocodeRequest::$deliveryDate
     */
    public function setDeliveryDate(?string $deliveryDate): FindNearestLocationsGeocodeRequest
    {
        $this->deliveryDate = $this->validate->date($deliveryDate);

        return $this;
    }

    /**
     * Get opening time.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   FindNearestLocationsGeocodeRequest::$openingTime
     */
    public function getOpeningTime(): ?string
    {
        return $this->openingTime;
    }

    /**
     * Set opening time.
     *
     * @pattern ^(?:[0-3]\d-[01]\d-[12]\d{3}\s+)[0-2]\d:[0-5]\d(?:[0-5]\d)$
     *
     * @example 10:00:00
     *
     * @param string|null $openingTime
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0 Strict typing
     * @see     FindNearestLocationsGeocodeRequest::$openingTime
     */
    public function setOpeningTime(?string $openingTime): FindNearestLocationsGeocodeRequest
    {
        $this->openingTime = $this->validate->time($openingTime);

        return $this;
    }
}
