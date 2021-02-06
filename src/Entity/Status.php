<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Status.
 */
class Status extends SerializableObject
{
    /**
     * @var string|null
     */
    protected string|null $CurrentPhaseCode = null;

    /**
     * @var string|null
     */
    protected string|null $CurrentPhaseDescription = null;

    /**
     * @var string|null
     */
    protected string|null $CurrentStatusCode = null;

    /**
     * @var string|null
     */
    protected string|null $CurrentStatusDescription = null;

    /**
     * @var string|null
     */
    protected string|null $CurrentStatusTimeStamp = null;

    /**
     * Status constructor.
     *
     * @param string      $service
     * @param string      $propType
     * @param string|null $CurrentPhaseCode
     * @param string|null $CurrentPhaseDescription
     * @param string|null $CurrentStatusCode
     * @param string|null $CurrentStatusDescription
     * @param string|null $CurrentStatusTimeStamp
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType,

        string|null $CurrentPhaseCode = null,
        string|null $CurrentPhaseDescription = null,
        string|null $CurrentStatusCode = null,
        string|null $CurrentStatusDescription = null,
        string|null $CurrentStatusTimeStamp = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setCurrentPhaseCode(CurrentPhaseCode: $CurrentPhaseCode);
        $this->setCurrentPhaseDescription(CurrentPhaseDescription: $CurrentPhaseDescription);
        $this->setCurrentStatusCode(CurrentStatusCode: $CurrentStatusCode);
        $this->setCurrentStatusDescription(CurrentStatusDescription: $CurrentStatusDescription);
        $this->setCurrentStatusTimeStamp(CurrentStatusTimeStamp: $CurrentStatusTimeStamp);
    }

    /**
     * @return string|null
     */
    public function getCurrentPhaseCode(): string|null
    {
        return $this->CurrentPhaseCode;
    }

    /**
     * @param string|null $CurrentPhaseCode
     *
     * @return static
     */
    public function setCurrentPhaseCode(string|null $CurrentPhaseCode = null): static
    {
        $this->CurrentPhaseCode = $CurrentPhaseCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrentPhaseDescription(): string|null
    {
        return $this->CurrentPhaseDescription;
    }

    /**
     * @param string|null $CurrentPhaseDescription
     *
     * @return static
     */
    public function setCurrentPhaseDescription(string|null $CurrentPhaseDescription = null): static
    {
        $this->CurrentPhaseDescription = $CurrentPhaseDescription;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrentStatusCode(): string|null
    {
        return $this->CurrentStatusCode;
    }

    /**
     * @param string|null $CurrentStatusCode
     *
     * @return static
     */
    public function setCurrentStatusCode(string|null $CurrentStatusCode = null): static
    {
        $this->CurrentStatusCode = $CurrentStatusCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrentStatusDescription(): string|null
    {
        return $this->CurrentStatusDescription;
    }

    /**
     * @param string|null $CurrentStatusDescription
     *
     * @return static
     */
    public function setCurrentStatusDescription(string|null $CurrentStatusDescription = null): static
    {
        $this->CurrentStatusDescription = $CurrentStatusDescription;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrentStatusTimeStamp(): string|null
    {
        return $this->CurrentStatusTimeStamp;
    }

    /**
     * @param string|null $CurrentStatusTimeStamp
     *
     * @return static
     */
    public function setCurrentStatusTimeStamp(string|null $CurrentStatusTimeStamp = null): static
    {
        $this->CurrentStatusTimeStamp = $CurrentStatusTimeStamp;

        return $this;
    }
}
