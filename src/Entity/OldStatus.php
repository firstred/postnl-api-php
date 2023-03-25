<?php
declare(strict_types=1);
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * @since 1.0.0
 */
class OldStatus extends AbstractEntity
{
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CurrentPhaseCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CurrentPhaseDescription = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CurrentOldStatusCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CurrentOldStatusDescription = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CurrentOldStatusTimeStamp = null;

    public function __construct(
        ?string $PhaseCode = null,
        ?string $PhaseDescription = null,
        ?string $OldStatusCode = null,
        ?string $OldStatusDescription = null,
        ?string $TimeStamp = null
    ) {
        parent::__construct();

        $this->setCurrentPhaseCode(CurrentPhaseCode: $PhaseCode);
        $this->setCurrentPhaseDescription(CurrentPhaseDescription: $PhaseDescription);
        $this->setCurrentOldStatusCode(CurrentOldStatusCode: $OldStatusCode);
        $this->setCurrentOldStatusDescription(CurrentOldStatusDescription: $OldStatusDescription);
        $this->setCurrentOldStatusTimeStamp(CurrentOldStatusTimeStamp: $TimeStamp);
    }

    public function getCurrentPhaseCode(): ?string
    {
        return $this->CurrentPhaseCode;
    }

    public function setCurrentPhaseCode(?string $CurrentPhaseCode): static
    {
        $this->CurrentPhaseCode = $CurrentPhaseCode;

        return $this;
    }

    public function getCurrentPhaseDescription(): ?string
    {
        return $this->CurrentPhaseDescription;
    }

    public function setCurrentPhaseDescription(?string $CurrentPhaseDescription): static
    {
        $this->CurrentPhaseDescription = $CurrentPhaseDescription;

        return $this;
    }

    public function getCurrentOldStatusCode(): ?string
    {
        return $this->CurrentOldStatusCode;
    }

    public function setCurrentOldStatusCode(?string $CurrentOldStatusCode): static
    {
        $this->CurrentOldStatusCode = $CurrentOldStatusCode;

        return $this;
    }

    public function getCurrentOldStatusDescription(): ?string
    {
        return $this->CurrentOldStatusDescription;
    }

    public function setCurrentOldStatusDescription(?string $CurrentOldStatusDescription): static
    {
        $this->CurrentOldStatusDescription = $CurrentOldStatusDescription;

        return $this;
    }

    public function getCurrentOldStatusTimeStamp(): ?string
    {
        return $this->CurrentOldStatusTimeStamp;
    }

    public function setCurrentOldStatusTimeStamp(?string $CurrentOldStatusTimeStamp): static
    {
        $this->CurrentOldStatusTimeStamp = $CurrentOldStatusTimeStamp;

        return $this;
    }
}
