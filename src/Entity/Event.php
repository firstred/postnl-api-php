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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class Event.
 */
final class Event extends AbstractEntity implements EventInterface
{
    /**
     * Event code.
     *
     * @pattern ^.{0,35}$
     *
     * @example I01
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $code;

    /**
     * Event description.
     *
     * @pattern ^.{0,1000}$
     *
     * @example Zending is bezorgd
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $description;

    /**
     * Destination location code.
     *
     * @pattern ^.{0,35}$
     *
     * @example 981223
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $destinationLocationCode;

    /**
     * Location code.
     *
     * @pattern ^.{0,95}$
     *
     * @example 2394082
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $locationCode;

    /**
     * Route code.
     *
     * @pattern ^.{0,1000}$
     *
     * @example 217 PostNL Spiegelstraat
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $routeCode;

    /**
     * Route name.
     *
     * @pattern ${0,1000}$
     *
     * @example 217 PostNL Spiegelstraat
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $routeName;

    /**
     * Timestamp.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @example 31-07-2019 09:36:42
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $timeStamp;

    /**
     * Get code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Event::$code
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Set code.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $code
     *
     * @return static
     *
     * @example I01
     *
     * @since   2.0.0
     * @see     Event::$code
     */
    public function setCode(?string $code): EventInterface
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Event::$description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set description.
     *
     * @pattern ^.{0,1000}$
     *
     * @param string|null $description
     *
     * @return static
     *
     * @example Zending is bezorgd
     *
     * @since   2.0.0
     * @see     Event::$description
     */
    public function setDescription(?string $description): EventInterface
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get destination location code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Event::$destinationLocationCode
     */
    public function getDestinationLocationCode(): ?string
    {
        return $this->destinationLocationCode;
    }

    /**
     * Set destination location code.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $destinationLocationCode
     *
     * @return static
     *
     * @example 981223
     *
     * @since   2.0.0
     * @see     Event::$destinationLocationCode
     */
    public function setDestinationLocationCode(?string $destinationLocationCode): EventInterface
    {
        $this->destinationLocationCode = $destinationLocationCode;

        return $this;
    }

    /**
     * Get route code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Event::$routeCode
     */
    public function getRouteCode(): ?string
    {
        return $this->routeCode;
    }

    /**
     * Set route code.
     *
     * @pattern ^.{0,1000}$
     *
     * @param string|null $routeCode
     *
     * @return static
     *
     * @example 217 PostNL Spiegelstraat
     *
     * @since   2.0.0
     * @see     Event::$routeCode
     */
    public function setRouteCode(?string $routeCode): EventInterface
    {
        $this->routeCode = $routeCode;

        return $this;
    }

    /**
     * Get route name.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Event::$routeName
     */
    public function getRouteName(): ?string
    {
        return $this->routeName;
    }

    /**
     * Set route name.
     *
     * @pattern ${0,1000}$
     *
     * @example 217 PostNL Spiegelstraat
     *
     * @param string|null $routeName
     *
     * @return static
     *
     * @since   2.0.0
     * @see     Event::$routeName
     */
    public function setRouteName(?string $routeName): EventInterface
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * Get timestamp.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Event::$timeStamp
     */
    public function getTimeStamp(): ?string
    {
        return $this->timeStamp;
    }

    /**
     * Set timestamp.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @param string|null $timeStamp
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 03-07-2019 08:00:00
     *
     * @since   2.0.0
     * @see     Event::$timeStamp
     */
    public function setTimeStamp(?string $timeStamp): EventInterface
    {
        $this->timeStamp = $this->validate->dateTime($timeStamp);

        return $this;
    }

    /**
     * Get location code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Event::$locationCode
     */
    public function getLocationCode(): ?string
    {
        return $this->locationCode;
    }

    /**
     * Set location code.
     *
     * @pattern ^.{0,95}$
     *
     * @param string|null $locationCode
     *
     * @return static
     *
     * @example 2394082
     *
     * @since   2.0.0
     * @see     Event::$locationCode
     */
    public function setLocationCode(?string $locationCode): EventInterface
    {
        $this->locationCode = $locationCode;

        return $this;
    }
}
