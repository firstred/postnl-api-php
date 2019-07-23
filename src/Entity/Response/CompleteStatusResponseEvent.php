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

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use TypeError;

/**
 * Class CompleteStatusResponseEvent
 */
class CompleteStatusResponseEvent extends AbstractEntity
{
    /**
     * @var string|null $code
     *
     * @since 1.0.0
     */
    protected $code;

    /**
     * @var string|null $description
     *
     * @since 1.0.0
     */
    protected $description;

    /**
     * @var string|null $destinationLocationCode
     *
     * @since 1.0.0
     */
    protected $destinationLocationCode;

    /**
     * @var string|null $locationCode
     *
     * @since 1.0.0
     */
    protected $locationCode;

    /**
     * @var string|null $routeCode
     *
     * @since 1.0.0
     */
    protected $routeCode;

    /**
     * @var string|null $routeName
     *
     * @since 1.0.0
     */
    protected $routeName;

    /**
     * @var string|null $timeStamp
     *
     * @since 1.0.0
     */
    protected $timeStamp;

    /**
     * CompleteStatusResponseEvent constructor.
     *
     * @param string|null $code
     * @param string|null $description
     * @param string|null $destinationLocationCode
     * @param string|null $locationCode
     * @param string|null $routeCode
     * @param string|null $routeName
     * @param string|null $timeStamp
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $code = null, ?string $description = null, ?string $destinationLocationCode = null, ?string $locationCode = null, ?string $routeCode = null, ?string $routeName = null, ?string $timeStamp = null)
    {
        parent::__construct();

        $this->setCode($code);
        $this->setDescription($description);
        $this->setDestinationLocationCode($destinationLocationCode);
        $this->setLocationCode($locationCode);
        $this->setRouteCode($routeCode);
        $this->setRouteName($routeName);
        $this->setTimeStamp($timeStamp);
    }

    /**
     * Get code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Set code
     *
     * @param string|null $code
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setCode(?string $code): CompleteStatusResponseEvent
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get description
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string|null $description
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setDescription(?string $description): CompleteStatusResponseEvent
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get destination location code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getDestinationLocationCode(): ?string
    {
        return $this->destinationLocationCode;
    }

    /**
     * Set destination location code
     *
     * @param string|null $destinationLocationCode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setDestinationLocationCode(?string $destinationLocationCode): CompleteStatusResponseEvent
    {
        $this->destinationLocationCode = $destinationLocationCode;

        return $this;
    }

    /**
     * Get location code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getLocationCode(): ?string
    {
        return $this->locationCode;
    }

    /**
     * Set location code
     *
     * @param string|null $locationCode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setLocationCode(?string $locationCode): CompleteStatusResponseEvent
    {
        $this->locationCode = $locationCode;

        return $this;
    }

    /**
     * Get route code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getRouteCode(): ?string
    {
        return $this->routeCode;
    }

    /**
     * Set route code
     *
     * @param string|null $routeCode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setRouteCode(?string $routeCode): CompleteStatusResponseEvent
    {
        $this->routeCode = $routeCode;

        return $this;
    }

    /**
     * Get route name
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getRouteName(): ?string
    {
        return $this->routeName;
    }

    /**
     * Set route name
     *
     * @param string|null $routeName
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setRouteName(?string $routeName): CompleteStatusResponseEvent
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getTimeStamp(): ?string
    {
        return $this->timeStamp;
    }

    /**
     * Set timestamp
     *
     * @param string|null $timeStamp
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setTimeStamp(?string $timeStamp): CompleteStatusResponseEvent
    {
        $this->timeStamp = $timeStamp;

        return $this;
    }
}
