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
use ReflectionException;
use TypeError;

/**
 * Class OldStatus
 */
class OldStatus extends AbstractEntity
{
    /**
     * Current phase code
     *
     * @pattern ^.{0,95}$
     *
     * @example N/A
     *
     * @var string|null $currentPhaseCode
     *
     * @since 1.0.0
     */
    protected $currentPhaseCode;

    /**
     * Current phase description
     *
     * @pattern ^.{0,95}$
     *
     * @example N/A
     *
     * @var string|null $currentPhaseDescription
     *
     * @since 1.0.0
     */
    protected $currentPhaseDescription;

    /**
     * Current old status code
     *
     * @pattern ^.{0,95}$
     *
     * @example N/A
     *
     * @var string|null $currentOldStatusCode
     *
     * @since 1.0.0
     */
    protected $currentOldStatusCode;

    /**
     * Current old status description
     *
     * @pattern ^.{0,95}$
     *
     * @example N/A
     *
     * @var string|null $currentOldStatusDescription
     *
     * @since 1.0.0
     */
    protected $currentOldStatusDescription;

    /**
     * Current old status timestamp
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @example 03-07-2019 14:00:00
     *
     * @var string|null $currentOldStatusTimeStamp
     *
     * @since 1.0.0
     */
    protected $currentOldStatusTimeStamp;

    /**
     * OldStatus constructor.
     *
     * @param null|string $phaseCode
     * @param null|string $phaseDesc
     * @param null|string $oldStatusCode
     * @param null|string $oldStatusDesc
     * @param null|string $timeStamp
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $phaseCode = null, ?string $phaseDesc = null, ?string $oldStatusCode = null, ?string $oldStatusDesc = null, ?string $timeStamp = null)
    {
        parent::__construct();

        $this->setCurrentPhaseCode($phaseCode);
        $this->setCurrentPhaseDescription($phaseDesc);
        $this->setCurrentOldStatusCode($oldStatusCode);
        $this->setCurrentOldStatusDescription($oldStatusDesc);
        $this->setCurrentOldStatusTimeStamp($timeStamp);
    }

    /**
     * Get current phase code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   OldStatus::$currentPhaseCode
     */
    public function getCurrentPhaseCode(): ?string
    {
        return $this->currentPhaseCode;
    }

    /**
     * Set current phase code
     *
     * @pattern ^.{0,95}$
     *
     * @param string|null $currentPhaseCode
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example N/A
     *
     * @since   2.0.0 Strict typing
     *
     * @see     OldStatus::$currentPhaseCode
     */
    public function setCurrentPhaseCode(?string $currentPhaseCode): OldStatus
    {
        $this->currentPhaseCode = ValidateAndFix::genericString($currentPhaseCode, 95);

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
     * @see   OldStatus::$currentPhaseDescription
     */
    public function getCurrentPhaseDescription(): ?string
    {
        return $this->currentPhaseDescription;
    }

    /**
     * Set current phase description
     *
     * @pattern ^.{0,95}$
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
     * @see     OldStatus::$currentPhaseDescription
     */
    public function setCurrentPhaseDescription(?string $currentPhaseDescription): OldStatus
    {
        $this->currentPhaseDescription = ValidateAndFix::genericString($currentPhaseDescription, 95);

        return $this;
    }

    /**
     * Get current old status code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   OldStatus::$currentOldStatusCode
     */
    public function getCurrentOldStatusCode(): ?string
    {
        return $this->currentOldStatusCode;
    }

    /**
     * Set current old status code
     *
     * @pattern ^.{0,95}$
     *
     * @param string|null $currentOldStatusCode
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
     * @see     OldStatus::$currentOldStatusCode
     */
    public function setCurrentOldStatusCode(?string $currentOldStatusCode): OldStatus
    {
        $this->currentOldStatusCode = ValidateAndFix::genericString($currentOldStatusCode,95);

        return $this;
    }

    /**
     * Get current old status description
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   OldStatus::$currentOldStatusDescription
     */
    public function getCurrentOldStatusDescription(): ?string
    {
        return $this->currentOldStatusDescription;
    }

    /**
     * Set current old status description
     *
     * @pattern ^.{0,95}$
     *
     * @param string|null $currentOldStatusDescription
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
     * @see     OldStatus::$currentOldStatusDescription
     */
    public function setCurrentOldStatusDescription(?string $currentOldStatusDescription): OldStatus
    {
        $this->currentOldStatusDescription = ValidateAndFix::genericString($currentOldStatusDescription, 95);

        return $this;
    }

    /**
     * Get current old status timestamp
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   OldStatus::$currentOldStatusTimeStamp
     */
    public function getCurrentOldStatusTimeStamp(): ?string
    {
        return $this->currentOldStatusTimeStamp;
    }

    /**
     * Set current old status timestamp
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @param string|null $currentOldStatusTimeStamp
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 03-07-2019 14:00:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     OldStatus::$currentOldStatusTimeStamp
     */
    public function setCurrentOldStatusTimeStamp(?string $currentOldStatusTimeStamp): OldStatus
    {
        $this->currentOldStatusTimeStamp = ValidateAndFix::dateTime($currentOldStatusTimeStamp);

        return $this;
    }
}
