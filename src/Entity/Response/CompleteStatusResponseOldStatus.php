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
 * Class CompleteStatusResponseOldStatus
 */
class CompleteStatusResponseOldStatus extends AbstractEntity
{
    /**
     * @var string|null $statusCode
     *
     * @since 1.0.0
     */
    protected $statusCode;

    /**
     * @var string|null $statusDescription
     *
     * @since 1.0.0
     */
    protected $statusDescription;

    /**
     * @var string|null $phaseCode
     *
     * @since 1.0.0
     */
    protected $phaseCode;

    /**
     * @var string|null $phaseDescription
     *
     * @since 1.0.0
     */
    protected $phaseDescription;

    /**
     * @var string|null $timeStamp
     *
     * @since 1.0.0
     */
    protected $timeStamp;

    /**
     * CompleteStatusResponseOldStatus constructor.
     *
     * @param string|null $code
     * @param string|null $description
     * @param string|null $phaseCode
     * @param string|null $phaseDescription
     * @param string|null $timeStamp
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $code = null, ?string $description = null, ?string $phaseCode = null, ?string $phaseDescription = null, ?string $timeStamp = null)
    {
        parent::__construct();

        $this->setStatusCode($code);
        $this->setStatusDescription($description);
        $this->setPhaseCode($phaseCode);
        $this->setPhaseDescription($phaseDescription);
        $this->setTimeStamp($timeStamp);
    }

    /**
     * Get status code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getStatusCode(): ?string
    {
        return $this->statusCode;
    }

    /**
     * Set status code
     *
     * @param string|null $statusCode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setStatusCode(?string $statusCode): CompleteStatusResponseOldStatus
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Get status description
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getStatusDescription(): ?string
    {
        return $this->statusDescription;
    }

    /**
     * Set status description
     *
     * @param string|null $statusDescription
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setStatusDescription(?string $statusDescription): CompleteStatusResponseOldStatus
    {
        $this->statusDescription = $statusDescription;

        return $this;
    }

    /**
     * Get phase code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getPhaseCode(): ?string
    {
        return $this->phaseCode;
    }

    /**
     * Set phase code
     *
     * @param string|null $phaseCode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setPhaseCode(?string $phaseCode): CompleteStatusResponseOldStatus
    {
        $this->phaseCode = $phaseCode;

        return $this;
    }

    /**
     * Get phase description
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getPhaseDescription(): ?string
    {
        return $this->phaseDescription;
    }

    /**
     * @param string|null $phaseDescription
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setPhaseDescription(?string $phaseDescription): CompleteStatusResponseOldStatus
    {
        $this->phaseDescription = $phaseDescription;

        return $this;
    }

    /**
     * Get time stamp
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
     * @param string|null $timeStamp
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setTimeStamp(?string $timeStamp): CompleteStatusResponseOldStatus
    {
        $this->timeStamp = $timeStamp;

        return $this;
    }
}
