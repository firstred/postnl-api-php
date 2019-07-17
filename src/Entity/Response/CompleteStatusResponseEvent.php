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

/**
 * Class CompleteStatusResponseEvent
 */
class CompleteStatusResponseEvent extends AbstractEntity
{
    /** @var string|null $code */
    protected $code;
    /** @var string|null $description */
    protected $description;
    /** @var string|null $destinationLocationCode */
    protected $destinationLocationCode;
    /** @var string|null $locationCode */
    protected $locationCode;
    /** @var string|null $routeCode */
    protected $routeCode;
    /** @var string|null $routeName */
    protected $routeName;
    /** @var string|null $timeStamp */
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
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCode(?string $code): CompleteStatusResponseEvent
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDescription(?string $description): CompleteStatusResponseEvent
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDestinationLocationCode(): ?string
    {
        return $this->destinationLocationCode;
    }

    /**
     * @param string|null $destinationLocationCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDestinationLocationCode(?string $destinationLocationCode): CompleteStatusResponseEvent
    {
        $this->destinationLocationCode = $destinationLocationCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getLocationCode(): ?string
    {
        return $this->locationCode;
    }

    /**
     * @param string|null $locationCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLocationCode(?string $locationCode): CompleteStatusResponseEvent
    {
        $this->locationCode = $locationCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getRouteCode(): ?string
    {
        return $this->routeCode;
    }

    /**
     * @param string|null $routeCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setRouteCode(?string $routeCode): CompleteStatusResponseEvent
    {
        $this->routeCode = $routeCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getRouteName(): ?string
    {
        return $this->routeName;
    }

    /**
     * @param string|null $routeName
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setRouteName(?string $routeName): CompleteStatusResponseEvent
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getTimeStamp(): ?string
    {
        return $this->timeStamp;
    }

    /**
     * @param string|null $timeStamp
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setTimeStamp(?string $timeStamp): CompleteStatusResponseEvent
    {
        $this->timeStamp = $timeStamp;

        return $this;
    }
}
