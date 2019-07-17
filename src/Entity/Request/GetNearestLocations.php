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

use Exception;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Entity\Message\Message;

/**
 * Class GetNearestLocations
 *
 * This class is both the container and can be the actual GetNearestLocations object itself!
 */
class GetNearestLocations extends AbstractEntity
{
    /** @var string|null $countrycode */
    protected $countrycode;
    /** @var Location|null $location */
    protected $location;
    /** @var Message|null $message */
    protected $message;

    /**
     * GetNearestLocations constructor.
     *
     * @param string|null   $countryCode
     * @param Location|null $location
     * @param Message|null  $message
     *
     * @throws Exception
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct($countryCode = null, Location $location = null, Message $message = null)
    {
        parent::__construct();

        $this->setCountrycode($countryCode);
        $this->setLocation($location);
        $this->setMessage($message ?: new Message());
    }

    /**
     * @return string|null
     */
    public function getCountrycode(): ?string
    {
        return $this->countrycode;
    }

    /**
     * @param string|null $countrycode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCountrycode(?string $countrycode): GetNearestLocations
    {
        $this->countrycode = $countrycode;

        return $this;
    }

    /**
     * @return Location|null
     */
    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * @param Location|null $location
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLocation(?Location $location): GetNearestLocations
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Message|null
     */
    public function getMessage(): ?Message
    {
        return $this->message;
    }

    /**
     * @param Message|null $message
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setMessage(?Message $message): GetNearestLocations
    {
        $this->message = $message;

        return $this;
    }
}
