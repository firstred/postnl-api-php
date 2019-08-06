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
 * Class Geocode
 */
class Geocode extends AbstractEntity
{
    /**
     * Latitude
     *
     * @var float|null $latitude
     *
     * @since 2.0.0
     */
    protected $latitude;

    /**
     * Longitude
     *
     * @var float|null $longitude
     *
     * @since 2.0.0
     */
    protected $longitude;

    /**
     * Rijksdriehoek X coordinate
     *
     * @var float|null $rdxCoordinate
     *
     * @since 2.0.0
     */
    protected $rdxCoordinate;

    /**
     * Rijksdriehoek Y coordinate
     *
     * @var float|null $rdyCoordinate
     *
     * @since 2.0.0
     */
    protected $rdyCoordinate;

    /**
     * Geocode constructor.
     *
     * @since 2.0.0
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return float|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float|null $latitude
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLatitude(?float $latitude): Geocode
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return float|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLongitude(?float $longitude): Geocode
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return float|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getRdxCoordinate(): ?float
    {
        return $this->rdxCoordinate;
    }

    /**
     * @param float|null $rdxCoordinate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setRdxCoordinate(?float $rdxCoordinate): Geocode
    {
        $this->rdxCoordinate = $rdxCoordinate;

        return $this;
    }

    /**
     * @return float|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getRdyCoordinate(): ?float
    {
        return $this->rdyCoordinate;
    }

    /**
     * @param float|null $rdyCoordinate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setRdyCoordinate(?float $rdyCoordinate): Geocode
    {
        $this->rdyCoordinate = $rdyCoordinate;

        return $this;
    }
}
