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

/**
 * @since 1.0.0
 */
class CompleteStatusResponseEvent extends AbstractEntity
{
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Code = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Description = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $DestinationLocationCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $LocationCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $RouteCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $RouteName = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $TimeStamp = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string $Code = null,
        ?string $Description = null,
        ?string $DestinationLocationCode = null,
        ?string $LocationCode = null,
        ?string $RouteCode = null,
        ?string $RouteName = null,
        ?string $TimeStamp = null
    ) {
        parent::__construct();

        $this->setCode(Code: $Code);
        $this->setDescription(Description: $Description);
        $this->setDestinationLocationCode(DestinationLocationCode: $DestinationLocationCode);
        $this->setLocationCode(LocationCode: $LocationCode);
        $this->setRouteCode(RouteCode: $RouteCode);
        $this->setRouteName(RouteName: $RouteName);
        $this->setTimeStamp(TimeStamp: $TimeStamp);
    }

    public function getCode(): ?string
    {
        return $this->Code;
    }

    public function setCode(?string $Code): static
    {
        $this->Code = $Code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getDestinationLocationCode(): ?string
    {
        return $this->DestinationLocationCode;
    }

    public function setDestinationLocationCode(?string $DestinationLocationCode): static
    {
        $this->DestinationLocationCode = $DestinationLocationCode;

        return $this;
    }

    public function getLocationCode(): ?string
    {
        return $this->LocationCode;
    }

    public function setLocationCode(?string $LocationCode): static
    {
        $this->LocationCode = $LocationCode;

        return $this;
    }

    public function getRouteCode(): ?string
    {
        return $this->RouteCode;
    }

    public function setRouteCode(?string $RouteCode): static
    {
        $this->RouteCode = $RouteCode;

        return $this;
    }

    public function getRouteName(): ?string
    {
        return $this->RouteName;
    }

    public function setRouteName(?string $RouteName): static
    {
        $this->RouteName = $RouteName;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setTimeStamp(string|DateTimeInterface|null $TimeStamp = null): static
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
