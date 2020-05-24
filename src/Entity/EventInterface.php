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
interface EventInterface extends EntityInterface
{
    /**
     * Get code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Event::$code
     */
    public function getCode(): ?string;

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
    public function setCode(?string $code): EventInterface;

    /**
     * Get description.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Event::$description
     */
    public function getDescription(): ?string;

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
    public function setDescription(?string $description): EventInterface;

    /**
     * Get destination location code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Event::$destinationLocationCode
     */
    public function getDestinationLocationCode(): ?string;

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
    public function setDestinationLocationCode(?string $destinationLocationCode): EventInterface;

    /**
     * Get route code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Event::$routeCode
     */
    public function getRouteCode(): ?string;

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
    public function setRouteCode(?string $routeCode): EventInterface;

    /**
     * Get route name.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Event::$routeName
     */
    public function getRouteName(): ?string;

    /**
     * Set route name.
     *
     * @pattern ${0,1000}$
     *
     * @param string|null $routeName
     *
     * @return static
     *
     * @example 217 PostNL Spiegelstraat
     *
     * @since   2.0.0
     * @see     Event::$routeName
     */
    public function setRouteName(?string $routeName): EventInterface;

    /**
     * Get timestamp.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Event::$timeStamp
     */
    public function getTimeStamp(): ?string;

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
    public function setTimeStamp(?string $timeStamp): EventInterface;

    /**
     * Get location code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Event::$locationCode
     */
    public function getLocationCode(): ?string;

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
    public function setLocationCode(?string $locationCode): EventInterface;
}
