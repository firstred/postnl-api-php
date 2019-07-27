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

use Firstred\PostNL\Misc\ValidateAndFix;
use libphonenumber\Leniency\Valid;
use ReflectionException;
use TypeError;

/**
 * Class Status
 */
class Status extends AbstractEntity
{
    /**
     * Current phase code
     *
     * @pattern ^\d{2}$
     *
     * @example 02
     *
     * @var string|null $currentPhaseCode
     *
     * @since 1.0.0
     */
    protected $currentPhaseCode;

    /**
     * Current phase description
     *
     * @pattern ^.{0,35}$
     *
     * @example N/A
     *
     * @var string|null $currentPhaseDescription
     *
     * @since 1.0.0
     */
    protected $currentPhaseDescription;

    /**
     * Current status code
     *
     * @pattern ^\d{2}$
     *
     * @example 02
     *
     * @var string|null $currentStatusCode
     *
     * @since 1.0.0
     */
    protected $currentStatusCode;

    /**
     * Current status description
     *
     * @pattern ^.{0,35}$
     *
     * @example N/A
     *
     * @var string|null $currentStatusDescription
     *
     * @since 1.0.0
     */
    protected $currentStatusDescription;

    /**
     * Current status timestamp
     *
     * @pattern ^(?:[0-3]\d-[01]\d-[12]\d{3}\s+)[0-2]\d:[0-5]\d(?:[0-5]\d)$
     *
     * @example 03-07-2019 17:00:00
     *
     * @var string|null $currentStatusTimeStamp
     *
     * @since 1.0.0
     */
    protected $currentStatusTimeStamp;

    /**
     * Status constructor.
     *
     * @param null|string $phaseCode
     * @param null|string $phaseDesc
     * @param null|string $statusCode
     * @param null|string $statusDesc
     * @param null|string $timeStamp
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $phaseCode = null, ?string $phaseDesc = null, ?string $statusCode = null, ?string $statusDesc = null, ?string $timeStamp = null)
    {
        parent::__construct();

        $this->setCurrentPhaseCode($phaseCode);
        $this->setCurrentPhaseDescription($phaseDesc);
        $this->setCurrentStatusCode($statusCode);
        $this->setCurrentStatusDescription($statusDesc);
        $this->setCurrentStatusTimeStamp($timeStamp);
    }

    /**
     * Get current phase code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Status::$currentPhaseCode
     */
    public function getCurrentPhaseCode(): ?string
    {
        return $this->currentPhaseCode;
    }

    /**
     * Set current phase code
     *
     * @pattern ^\d{2}$
     *
     * @param string|null $currentPhaseCode
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 02
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Status::$currentPhaseCode
     */
    public function setCurrentPhaseCode(?string $currentPhaseCode): Status
    {
        $this->currentPhaseCode = ValidateAndFix::numericType($currentPhaseCode);

        return $this;
    }

    /**
     * Get current phase description
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Status::$currentPhaseDescription
     */
    public function getCurrentPhaseDescription(): ?string
    {
        return $this->currentPhaseDescription;
    }

    /**
     * Set current phase description
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $currentPhaseDescription
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Status::$currentPhaseDescription
     */
    public function setCurrentPhaseDescription(?string $currentPhaseDescription): Status
    {
        $this->currentPhaseDescription = ValidateAndFix::genericString($currentPhaseDescription);

        return $this;
    }

    /**
     * Get current status code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Status::$currentStatusCode
     */
    public function getCurrentStatusCode(): ?string
    {
        return $this->currentStatusCode;
    }

    /**
     * Set current status code
     *
     * @pattern ^\d{2}$
     *
     * @param string|null $currentStatusCode
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 02
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Status::$currentStatusCode
     */
    public function setCurrentStatusCode(?string $currentStatusCode): Status
    {
        $this->currentStatusCode = ValidateAndFix::numericType($currentStatusCode);

        return $this;
    }

    /**
     * Get current status description
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Status::$currentStatusDescription
     */
    public function getCurrentStatusDescription(): ?string
    {
        return $this->currentStatusDescription;
    }

    /**
     * Set current status description
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $currentStatusDescription
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Status::$currentStatusDescription
     */
    public function setCurrentStatusDescription(?string $currentStatusDescription): Status
    {
        $this->currentStatusDescription = ValidateAndFix::genericString($currentStatusDescription);

        return $this;
    }

    /**
     * Get current status timestamp
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Status::$currentStatusTimeStamp
     */
    public function getCurrentStatusTimeStamp(): ?string
    {
        return $this->currentStatusTimeStamp;
    }

    /**
     * Set current status timestamp
     *
     * @pattern ^(?:[0-3]\d-[01]\d-[12]\d{3}\s+)[0-2]\d:[0-5]\d(?:[0-5]\d)$
     *
     * @param string|null $currentStatusTimeStamp
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 03-07-2019 17:00:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Status::$currentStatusTimeStamp
     */
    public function setCurrentStatusTimeStamp(?string $currentStatusTimeStamp): Status
    {
        $this->currentStatusTimeStamp = ValidateAndFix::dateTime($currentStatusTimeStamp);

        return $this;
    }
}
