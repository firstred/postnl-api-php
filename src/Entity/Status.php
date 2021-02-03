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
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

class Status extends SerializableObject
{
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        protected string|null $CurrentPhaseCode = null,
        protected string|null $CurrentPhaseDescription = null,
        protected string|null $CurrentStatusCode = null,
        protected string|null $CurrentStatusDescription = null,
        protected string|null $CurrentStatusTimeStamp = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setCurrentPhaseCode(CurrentPhaseCode: $CurrentPhaseCode);
        $this->setCurrentPhaseDescription(CurrentPhaseDescription: $CurrentPhaseDescription);
        $this->setCurrentStatusCode(CurrentStatusCode: $CurrentStatusCode);
        $this->setCurrentStatusDescription(CurrentStatusDescription: $CurrentStatusDescription);
        $this->setCurrentStatusTimeStamp(CurrentStatusTimeStamp: $CurrentStatusTimeStamp);
    }

    public function getCurrentPhaseCode(): string|null
    {
        return $this->CurrentPhaseCode;
    }

    public function setCurrentPhaseCode(string|null $CurrentPhaseCode = null): static
    {
        $this->CurrentPhaseCode = $CurrentPhaseCode;

        return $this;
    }

    public function getCurrentPhaseDescription(): string|null
    {
        return $this->CurrentPhaseDescription;
    }

    public function setCurrentPhaseDescription(string|null $CurrentPhaseDescription = null): static
    {
        $this->CurrentPhaseDescription = $CurrentPhaseDescription;

        return $this;
    }

    public function getCurrentStatusCode(): string|null
    {
        return $this->CurrentStatusCode;
    }

    public function setCurrentStatusCode(string|null $CurrentStatusCode = null): static
    {
        $this->CurrentStatusCode = $CurrentStatusCode;

        return $this;
    }

    public function getCurrentStatusDescription(): string|null
    {
        return $this->CurrentStatusDescription;
    }

    public function setCurrentStatusDescription(string|null $CurrentStatusDescription = null): static
    {
        $this->CurrentStatusDescription = $CurrentStatusDescription;

        return $this;
    }

    public function getCurrentStatusTimeStamp(): string|null
    {
        return $this->CurrentStatusTimeStamp;
    }

    public function setCurrentStatusTimeStamp(string|null $CurrentStatusTimeStamp = null): static
    {
        $this->CurrentStatusTimeStamp = $CurrentStatusTimeStamp;

        return $this;
    }
}
