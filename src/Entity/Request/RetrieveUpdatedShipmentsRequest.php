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

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\ValidateAndFix;
use ReflectionException;
use TypeError;

/**
 * Class RetrieveUpdatedShipmentsRequest
 */
class RetrieveUpdatedShipmentsRequest extends AbstractEntity
{
    /**
     * Start date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @example 03-07-2019 08:00:00
     *
     * @var string|null $startDate
     *
     * @since   2.0.0
     */
    protected $startDate;

    /**
     * End date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @example 04-07-2019 10:00:00
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    protected $endDate;

    /**
     * RetrieveUpdatedShipmentsRequest constructor.
     *
     * @param string|null $startDate
     * @param string|null $endDate
     *
     * @throws TypeError
     * @throws InvalidArgumentException
     * @throws ReflectionException
     *
     * @since 2.0.0
     */
    public function __construct(?string $startDate = null, ?string $endDate = null)
    {
        parent::__construct();

        $this->setStartDate($startDate);
        $this->setEndDate($endDate);
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     *
     * @see   RetrieveUpdatedShipmentsRequest::$startDate
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * Set start date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @param string|null $startDate
     *
     * @return static
     *
     * @throws TypeError
     * @throws InvalidArgumentException
     * @throws ReflectionException
     *
     * @example 03-07-2019 08:00:00
     *
     * @since 2.0.0 Strict typing
     *
     * @see     RetrieveUpdatedShipmentsRequest::$startDate
     */
    public function setStartDate(?string $startDate): RetrieveUpdatedShipmentsRequest
    {
        $this->startDate = ValidateAndFix::dateTime($startDate);

        return $this;
    }

    /**
     * Get end date
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     *
     * @see   RetrieveUpdatedShipmentsRequest::$endDate
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    /**
     * Set end date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @param string|null $endDate
     *
     * @return static
     *
     * @throws TypeError
     * @throws InvalidArgumentException
     * @throws ReflectionException
     *
     * @example 04-07-2019 10:00:00
     *
     * @since 2.0.0 Strict typing
     *
     * @see     RetrieveUpdatedShipmentsRequest::$endDate
     */
    public function setEndDate(?string $endDate): RetrieveUpdatedShipmentsRequest
    {
        $this->endDate = ValidateAndFix::dateTime($endDate);

        return $this;
    }
}
