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

namespace Firstred\PostNL\Entity\Response;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;
use function is_string;

/**
 * @since 1.0.0
 */
class CompleteStatusResponseOldStatus extends AbstractEntity
{
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $StatusCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $StatusDescription = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $PhaseCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $PhaseDescription = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $TimeStamp = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string                       $StatusCode = null,
        ?string                       $StatusDescription = null,
        ?string                       $PhaseCode = null,
        ?string                       $PhaseDescription = null,
        DateTimeInterface|string|null $TimeStamp = null
    ) {
        parent::__construct();

        $this->setStatusCode(StatusCode: $StatusCode);
        $this->setStatusDescription(StatusDescription: $StatusDescription);
        $this->setPhaseCode(PhaseCode: $PhaseCode);
        $this->setPhaseDescription(PhaseDescription: $PhaseDescription);
        $this->setTimeStamp(TimeStamp: $TimeStamp);
    }

    /**
     * @return string|null
     */
    public function getStatusCode(): ?string
    {
        return $this->StatusCode;
    }

    public function setStatusCode(?string $StatusCode): static
    {
        $this->StatusCode = $StatusCode;

        return $this;
    }

    public function getStatusDescription(): ?string
    {
        return $this->StatusDescription;
    }

    public function setStatusDescription(?string $StatusDescription): static
    {
        $this->StatusDescription = $StatusDescription;

        return $this;
    }

    public function getPhaseCode(): ?string
    {
        return $this->PhaseCode;
    }

    public function setPhaseCode(?string $PhaseCode): static
    {
        $this->PhaseCode = $PhaseCode;

        return $this;
    }

    public function getPhaseDescription(): ?string
    {
        return $this->PhaseDescription;
    }

    public function setPhaseDescription(?string $PhaseDescription): static
    {
        $this->PhaseDescription = $PhaseDescription;

        return $this;
    }

    public function getTimeStamp(): ?DateTimeInterface
    {
        return $this->TimeStamp;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setTimeStamp(DateTimeInterface|string|null $TimeStamp = null): static
    {
        if (is_string(value: $TimeStamp)) {
            try {
                $TimeStamp = new DateTimeImmutable(datetime: $TimeStamp, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->TimeStamp = $TimeStamp;

        return $this;
    }
}
