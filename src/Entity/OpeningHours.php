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
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\LocationServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;
use function is_array;

class OpeningHours extends SerializableObject
{
    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected array $Monday = [];

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected array $Tuesday = [];

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected array $Wednesday = [];

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected array $Thursday = [];

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected array $Friday = [];

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected array $Saturday = [];

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected array $Sunday = [];

    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        string|array $Monday = ['string' => []],
        string|array $Tuesday = ['string' => []],
        string|array $Wednesday = ['string' => []],
        string|array $Thursday = ['string' => []],
        string|array $Friday = ['string' => []],
        string|array $Saturday = ['string' => []],
        string|array $Sunday = ['string' => []],
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setMonday(Monday: $Monday);
        $this->setTuesday(Tuesday: $Tuesday);
        $this->setWednesday(Wednesday: $Wednesday);
        $this->setThursday(Thursday: $Thursday);
        $this->setFriday(Friday: $Friday);
        $this->setSaturday(Saturday: $Saturday);
        $this->setSunday(Sunday: $Sunday);
    }

    public function getMonday(): array
    {
        return $this->Monday;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setMonday(array|string $Monday): static
    {
        if (is_array(value: $Monday)) {
            if (isset($Monday['string'])) {
                $Monday = is_string(value: $Monday['string']) ? [$Monday['string']] : $Monday['string'];
            } else {
                throw new InvalidArgumentException(message: 'Invalid `Monday` value passed');
            }
        }

        $this->Monday = $Monday;

        return $this;
    }

    public function getTuesday(): array
    {
        return $this->Tuesday;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setTuesday(array|string $Tuesday): static
    {
        if (is_array(value: $Tuesday)) {
            if (isset($Tuesday['string'])) {
                $Tuesday = is_string(value: $Tuesday['string']) ? [$Tuesday['string']] : $Tuesday['string'];
            } else {
                throw new InvalidArgumentException(message: 'Invalid `Tuesday` value passed');
            }
        }

        $this->Tuesday = $Tuesday;

        return $this;
    }

    public function getWednesday(): array
    {
        return $this->Wednesday;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setWednesday(array|string $Wednesday): static
    {
        if (is_array(value: $Wednesday)) {
            if (isset($Wednesday['string'])) {
                $Wednesday = is_string(value: $Wednesday['string']) ? [$Wednesday['string']] : $Wednesday['string'];
            } else {
                throw new InvalidArgumentException(message: 'Invalid `Wednesday` value passed');
            }
        }

        $this->Wednesday = $Wednesday;

        return $this;
    }

    public function getThursday(): array
    {
        return $this->Thursday;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setThursday(array|string $Thursday): static
    {
        if (is_array(value: $Thursday)) {
            if (isset($Thursday['string'])) {
                $Thursday = is_string(value: $Thursday['string']) ? [$Thursday['string']] : $Thursday['string'];
            } else {
                throw new InvalidArgumentException(message: 'Invalid `Thursday` value passed');
            }
        }

        $this->Thursday = $Thursday;

        return $this;
    }

    public function getFriday(): array
    {
        return $this->Friday;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setFriday(array|string $Friday): static
    {
        if (is_array(value: $Friday)) {
            if (isset($Friday['string'])) {
                $Friday = is_string(value: $Friday['string']) ? [$Friday['string']] : $Friday['string'];
            } else {
                throw new InvalidArgumentException(message: 'Invalid `Friday` value passed');
            }
        }

        $this->Friday = $Friday;

        return $this;
    }

    public function getSaturday(): array
    {
        return $this->Saturday;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setSaturday(array|string $Saturday): static
    {
        if (is_array(value: $Saturday)) {
            if (isset($Saturday['string'])) {
                $Saturday = is_string(value: $Saturday['string']) ? [$Saturday['string']] : $Saturday['string'];
            } else {
                throw new InvalidArgumentException(message: 'Invalid `Saturday` value passed');
            }
        }

        $this->Saturday = $Saturday;

        return $this;
    }

    public function getSunday(): array
    {
        return $this->Sunday;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setSunday(array|string $Sunday): static
    {
        if (is_array(value: $Sunday)) {
            if (isset($Sunday['string'])) {
                $Sunday = is_string(value: $Sunday['string']) ? [$Sunday['string']] : $Sunday['string'];
            } else {
                throw new InvalidArgumentException(message: 'Invalid `Sunday` value passed');
            }
        }

        $this->Sunday = $Sunday;

        return $this;
    }

    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();

        $json['Monday'] = ['string' => 1 === count(value: $this->getMonday()) ? $this->getMonday()[0] : $this->getMonday()];
        $json['Tuesday'] = ['string' => 1 === count(value: $this->getTuesday()) ? $this->getTuesday()[0] : $this->getTuesday()];
        $json['Wednesday'] = ['string' => 1 === count(value: $this->getWednesday()) ? $this->getWednesday()[0] : $this->getWednesday()];
        $json['Thursday'] = ['string' => 1 === count(value: $this->getThursday()) ? $this->getThursday()[0] : $this->getThursday()];
        $json['Friday'] = ['string' => 1 === count(value: $this->getFriday()) ? $this->getFriday()[0] : $this->getFriday()];
        $json['Saturday'] = ['string' => 1 === count(value: $this->getSaturday()) ? $this->getSaturday()[0] : $this->getSaturday()];
        $json['Sunday'] = ['string' => 1 === count(value: $this->getSunday()) ? $this->getSunday()[0] : $this->getSunday()];

        return $json;
    }
}
