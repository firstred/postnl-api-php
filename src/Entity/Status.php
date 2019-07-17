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

/**
 * Class Status
 */
class Status extends AbstractEntity
{
    /** @var string|null $currentPhaseCode */
    protected $currentPhaseCode;
    /** @var string|null $currentPhaseDescription */
    protected $currentPhaseDescription;
    /** @var string|null $currentStatusCode */
    protected $currentStatusCode;
    /** @var string|null $currentStatusDescription */
    protected $currentStatusDescription;
    /** @var string|null $currentStatusTimeStamp */
    protected $currentStatusTimeStamp;

    /**
     * @param null|string $phaseCode
     * @param null|string $phaseDesc
     * @param null|string $statusCode
     * @param null|string $statusDesc
     * @param null|string $timeStamp
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
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCurrentPhaseCode(): ?string
    {
        return $this->currentPhaseCode;
    }

    /**
     * @param string|null $currentPhaseCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCurrentPhaseCode(?string $currentPhaseCode): Status
    {
        $this->currentPhaseCode = $currentPhaseCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCurrentPhaseDescription(): ?string
    {
        return $this->currentPhaseDescription;
    }

    /**
     * @param string|null $currentPhaseDescription
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCurrentPhaseDescription(?string $currentPhaseDescription): Status
    {
        $this->currentPhaseDescription = $currentPhaseDescription;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCurrentStatusCode(): ?string
    {
        return $this->currentStatusCode;
    }

    /**
     * @param string|null $currentStatusCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCurrentStatusCode(?string $currentStatusCode): Status
    {
        $this->currentStatusCode = $currentStatusCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCurrentStatusDescription(): ?string
    {
        return $this->currentStatusDescription;
    }

    /**
     * @param string|null $currentStatusDescription
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCurrentStatusDescription(?string $currentStatusDescription): Status
    {
        $this->currentStatusDescription = $currentStatusDescription;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCurrentStatusTimeStamp(): ?string
    {
        return $this->currentStatusTimeStamp;
    }

    /**
     * @param string|null $currentStatusTimeStamp
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCurrentStatusTimeStamp(?string $currentStatusTimeStamp): Status
    {
        $this->currentStatusTimeStamp = $currentStatusTimeStamp;

        return $this;
    }
}
