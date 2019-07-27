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
 * Class GetNearestLocationsGeocode
 *
 * This class is both the container and can be the actual GetLocationsInArea object itself!
 */
class GetNearestLocationsGeocode extends AbstractEntity
{
    /**
     * @pattern ^(?:NL|BE)$
     *
     * @example NL
     *
     * @var string|null $countrycode
     *
     * @since 1.0.0
     */
    protected $countrycode;

    /**
     * GetLocationsInArea constructor.
     *
     * @param string|null $countryCode
     *
     * @throws Exception
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct($countryCode = null)
    {
        parent::__construct();

        $this->setCountrycode($countryCode);
    }

    /**
     * Get country code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   GetNearestLocationsGeocode::$countrycode
     */
    public function getCountrycode(): ?string
    {
        return $this->countrycode;
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
     * @throws TypeError
     *
     * @example NL
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     GetNearestLocationsGeocode::$countrycode
     */
    public function setCountrycode(?string $countrycode): GetNearestLocationsGeocode
    {
        $this->countrycode = $countrycode;

        return $this;
    }
}
