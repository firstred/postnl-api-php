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

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\ValidateAndFix;

/**
 * Class FindLocationsInAreaRequest
 *
 * This class is both the container and can be the actual FindLocationsInAreaRequest object itself!
 */
class FindLocationsInAreaRequest extends AbstractEntity
{
    /**
     * Latitude north
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 52.156439
     *
     * @var float|null $latitudeNorth
     *
     * @since 2.0.0
     */
    protected $latitudeNorth;

    /**
     * Longitude west
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 52.156439
     *
     * @var float|null $longitudeWest
     *
     * @since 2.0.0
     */
    protected $longitudeWest;

    /**
     * Latitude south
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 52.156439
     *
     * @var float|null $latitudeSouth
     *
     * @since 2.0.0
     */
    protected $latitudeSouth;

    /**
     * Longitude east
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 52.156439
     *
     * @var float|null $longitudeEast
     *
     * @since 2.0.0
     */
    protected $longitudeEast;

    /**
     * Country code
     *
     * @pattern ^(?:NL|BE)$
     *
     * @example NL
     *
     * @var string|null $countryCode
     *
     * @since 2.0.0
     */
    protected $countryCode;

    /**
     * Delivery options
     *
     * @pattern ^(?:PG|PGE)$
     *
     * @example PGE
     *
     * @var array|null $deliveryOptions
     *
     * @since   2.0.0
     */
    protected $deliveryOptions;

    /**
     * Delivery date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @example 03-07-2019
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    protected $deliveryDate;

    /**
     * Opening time
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 09:00:00
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    protected $openingTime;

    /**
     * FindLocationsInAreaRequest constructor.
     *
     * @param float|string|null $latitudeNorth
     * @param float|string|null $longitudeWest
     * @param float|string|null $latitudeSouth
     * @param float|string|null $longitudeEast
     * @param string            $countryCode
     * @param string|null       $deliveryDate
     * @param string|null       $openingTime
     * @param array             $deliveryOptions
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0
     */
    public function __construct($latitudeNorth = null, $longitudeWest = null, $latitudeSouth = null, $longitudeEast = null, string $countryCode = 'NL', ?string $deliveryDate = null, ?string $openingTime = null, array $deliveryOptions = ['PG'])
    {
        parent::__construct();

        $this->setLatitudeNorth($latitudeNorth);
        $this->setLongitudeWest($longitudeWest);
        $this->setLatitudeSouth($latitudeSouth);
        $this->setLongitudeEast($longitudeEast);
        $this->setCountryCode($countryCode);
        $this->setDeliveryDate($deliveryDate);
        $this->setOpeningTime($openingTime);
        $this->setDeliveryOptions($deliveryOptions);
    }

    /**
     * Get country code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0
     *
     * @see   FindLocationsInAreaRequest::$countrycode
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * Set country code
     *
     * @pattern ^(?:NL|BE)$
     *
     * @param string|null $countrycode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example NL
     *
     * @since   1.0.0
     * @since   2.0.0
     *
     * @see     FindLocationsInAreaRequest::$countrycode
     */
    public function setCountryCode(?string $countrycode): FindLocationsInAreaRequest
    {
        $this->countryCode = ValidateAndFix::isoAlpha2CountryCodeNlBe($countrycode);

        return $this;
    }

    /**
     * Get delivery date
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   FindLocationsInAreaRequest::$deliveryDateq
     */
    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    /**
     * Set delivery date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @param string|null $deliveryDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 03-07-2019
     *
     * @since   2.0.0
     *
     * @see     FindLocationsInAreaRequest::$deliveryDate
     */
    public function setDeliveryDate(?string $deliveryDate): FindLocationsInAreaRequest
    {
        $this->deliveryDate = ValidateAndFix::date($deliveryDate);

        return $this;
    }

    /**
     * Get opening time
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   FindLocationsInAreaRequest::$openingTime
     */
    public function getOpeningTime(): ?string
    {
        return $this->openingTime;
    }

    /**
     * Set opening time
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @param string|null $openingTime
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 09:00:00
     *
     * @since   2.0.0
     *
     * @see     FindLocationsInAreaRequest::$openingTime
     */
    public function setOpeningTime(?string $openingTime): FindLocationsInAreaRequest
    {
        $this->openingTime = ValidateAndFix::time($openingTime);

        return $this;
    }

    /**
     * Get delivery options
     *
     * @return array|null
     *
     * @since 2.0.0
     *
     * @see   FindLocationsInAreaRequest::$deliveryOptions
     */
    public function getDeliveryOptions(): ?array
    {
        return $this->deliveryOptions;
    }

    /**
     * Set delivery options
     *
     * @pattern ^(?:PG|PGE)$
     *
     * @param array $deliveryOptions
     *
     * @return static
     *
     * @example PGE
     *
     * @since   2.0.0
     *
     * @see     FindLocationsInAreaRequest::$deliveryOptions
     */
    public function setDeliveryOptions(array $deliveryOptions): FindLocationsInAreaRequest
    {
        $this->deliveryOptions = $deliveryOptions;

        return $this;
    }

    /**
     * Get latitude north
     *
     * @return float|null
     *
     * @since 2.0.0 Strict typing
     *
     * @see   FindLocationsInAreaRequest::$latitudeNorth
     */
    public function getLatitudeNorth(): ?float
    {
        return $this->latitudeNorth;
    }

    /**
     * Set latitude north
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 52.156439
     *
     * @param float|string|null $latitudeNorth
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0 Strict typing
     *
     * @see   FindLocationsInAreaRequest::$latitudeNorth
     */
    public function setLatitudeNorth($latitudeNorth): FindLocationsInAreaRequest
    {
        $this->latitudeNorth = ValidateAndFix::coordinate($latitudeNorth);

        return $this;
    }

    /**
     * Get longitude west
     *
     * @return float|null
     *
     * @since 2.0.0 Strict typing
     *
     * @see   FindLocationsInAreaRequest::$longitudeWest
     */
    public function getLongitudeWest(): ?float
    {
        return $this->longitudeWest;
    }

    /**
     * Set longitude west
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 52.156439
     *
     * @param float|string|null $longitudeWest
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0 Strict typing
     *
     * @see   FindLocationsInAreaRequest::$longitudeWest
     */
    public function setLongitudeWest($longitudeWest): FindLocationsInAreaRequest
    {
        $this->longitudeWest = ValidateAndFix::coordinate($longitudeWest);

        return $this;
    }

    /**
     * Get latitude south
     *
     * @return float|null
     *
     * @since 2.0.0 Strict typing
     *
     * @see   FindLocationsInAreaRequest::$latitudeSouth
     */
    public function getLatitudeSouth(): ?float
    {
        return $this->latitudeSouth;
    }

    /**
     * Set latitude south
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 52.156439
     *
     * @param float|string|null $latitudeSouth
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0 Strict typing
     *
     * @see   FindLocationsInAreaRequest::$latitudeSouth
     */
    public function setLatitudeSouth($latitudeSouth): FindLocationsInAreaRequest
    {
        $this->latitudeSouth = ValidateAndFix::coordinate($latitudeSouth);

        return $this;
    }

    /**
     * Get longitude east
     *
     * @return float|null
     *
     * @since 2.0.0 Strict typing
     *
     * @see   FindLocationsInAreaRequest::$longitudeEast
     */
    public function getLongitudeEast(): ?float
    {
        return $this->longitudeEast;
    }

    /**
     * Set longitude east
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 52.156439
     *
     * @param float|string|null $longitudeEast
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0 Strict typing
     *
     * @see   FindLocationsInAreaRequest::$longitudeEast
     */
    public function setLongitudeEast($longitudeEast): FindLocationsInAreaRequest
    {
        $this->longitudeEast = ValidateAndFix::coordinate($longitudeEast);

        return $this;
    }
}
