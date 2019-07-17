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
 * Class Area
 */
class Area extends AbstractEntity
{
    /** @var Coordinates|null $coordinatesNorthWest */
    protected $coordinatesNorthWest;
    /** @var Coordinates|null $coordinatesSouthEast */
    protected $coordinatesSouthEast;

    /**
     * @param Coordinates|null $NW
     * @param Coordinates|null $SE
     *
     * @since 2.0.0 Strict typing
     */
    public function __construct($NW = null, $SE = null)
    {
        parent::__construct();

        $this->setCoordinatesNorthWest($NW);
        $this->setCoordinatesSouthEast($SE);
    }

    /**
     * @return Coordinates|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCoordinatesNorthWest(): ?Coordinates
    {
        return $this->coordinatesNorthWest;
    }

    /**
     * @param Coordinates|null $coordinatesNorthWest
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCoordinatesNorthWest(?Coordinates $coordinatesNorthWest): Area
    {
        $this->coordinatesNorthWest = $coordinatesNorthWest;

        return $this;
    }

    /**
     * @return Coordinates|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCoordinatesSouthEast(): ?Coordinates
    {
        return $this->coordinatesSouthEast;
    }

    /**
     * @param Coordinates|null $coordinatesSouthEast
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCoordinatesSouthEast(?Coordinates $coordinatesSouthEast): Area
    {
        $this->coordinatesSouthEast = $coordinatesSouthEast;

        return $this;
    }
}
