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
use TypeError;

/**
 * Class LookupLocationRequest
 *
 * This class is both the container and can be the actual LookupLocationRequest object itself!
 */
class LookupLocationRequest extends AbstractEntity
{
    /**
     * Location code
     *
     * @pattern ^.{0,35}$
     *
     * @example 161503
     *
     * @var string|null $locationCode
     *
     * @since 1.0.0
     */
    protected $locationCode;

    /**
     * RetailNetworkID information. Always PNPNL-01 for Dutch locations. For Belgium locations use LD-01.
     *
     * @pattern ^.{0,35}$
     *
     * @example PNPNL-01
     *
     * @var string|null $retailNetworkID
     *
     * @since 1.0.0
     */
    protected $retailNetworkID;

    /**
     * LookupLocationRequest constructor.
     *
     * @param string|null $location
     * @param string|null $networkId
     *
     * @throws Exception
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $location = null, ?string $networkId = null)
    {
        parent::__construct();

        $this->setLocationCode($location);
        $this->setRetailNetworkID($networkId);
    }

    /**
     * Get location code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   LookupLocationRequest::$locationCode
     */
    public function getLocationCode(): ?string
    {
        return $this->locationCode;
    }

    /**
     * Set location code
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $locationCode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example 161503
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     Location::$locationCode
     */
    public function setLocationCode(?string $locationCode): LookupLocationRequest
    {
        $this->locationCode = $locationCode;

        return $this;
    }

    /**
     * Get retail network ID
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   LookupLocationRequest::$retailNetworkID
     */
    public function getRetailNetworkID(): ?string
    {
        return $this->retailNetworkID;
    }

    /**
     * Set retail network ID
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $retailNetworkID
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example PNPNL-01
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     LookupLocationRequest::$retailNetworkID
     */
    public function setRetailNetworkID(?string $retailNetworkID): LookupLocationRequest
    {
        $this->retailNetworkID = $retailNetworkID;

        return $this;
    }
}
