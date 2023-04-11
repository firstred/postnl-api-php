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

namespace Firstred\PostNL\Service\RequestBuilder;

use Firstred\PostNL\Entity\Request\GetLocation;
use Firstred\PostNL\Entity\Request\GetLocationsInArea;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Psr\Http\Message\RequestInterface;

/**
 * @since 2.0.0
 *
 * @internal
 */
interface LocationServiceRequestBuilderInterface
{
    /**
     * Build the 'get nearest locations' HTTP request.
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     * @since 2.0.0
     */
    public function buildGetNearestLocationsRequest(GetNearestLocations $getNearestLocations): RequestInterface;

    /**
     * Build the 'get locations in area' HTTP.
     *
     * @param GetLocationsInArea $getLocations
     *
     * @return RequestInterface
     *
     * @since 2.0.0
     *
     * @throws InvalidConfigurationException
     * @throws InvalidArgumentException
     */
    public function buildGetLocationsInAreaRequest(GetLocationsInArea $getLocations): RequestInterface;

    /**
     * Build the 'get single location' HTTP request.
     *
     * @param GetLocation $getLocation
     *
     * @return RequestInterface
     *
     * @throws InvalidConfigurationException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function buildGetLocationRequest(GetLocation $getLocation): RequestInterface;
}
