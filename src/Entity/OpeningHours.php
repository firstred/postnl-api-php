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
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

class OpeningHours extends JsonSerializableObject
{
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        protected string|null $Monday = '',
        protected string|null $Tuesday = '',
        protected string|null $Wednesday = '',
        protected string|null $Thursday = '',
        protected string|null $Friday = '',
        protected string|null $Saturday = '',
        protected string|null $Sunday = '',
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

    public function getMonday(): string
    {
        return $this->Monday;
    }

    public function setMonday(string $Monday = null): static
    {
        $this->Monday = $Monday;

        return $this;
    }

    public function getTuesday(): string
    {
        return $this->Tuesday;
    }

    public function setTuesday(string $Tuesday = null): static
    {
        $this->Tuesday = $Tuesday;

        return $this;
    }

    public function getWednesday(): string
    {
        return $this->Wednesday;
    }

    public function setWednesday(string $Wednesday = null): static
    {
        $this->Wednesday = $Wednesday;

        return $this;
    }

    public function getThursday(): string
    {
        return $this->Thursday;
    }

    public function setThursday(string $Thursday = null): static
    {
        $this->Thursday = $Thursday;

        return $this;
    }

    public function getFriday(): string
    {
        return $this->Friday;
    }

    public function setFriday(string $Friday = null): static
    {
        $this->Friday = $Friday;

        return $this;
    }

    public function getSaturday(): string
    {
        return $this->Saturday;
    }

    public function setSaturday(string $Saturday = null): static
    {
        $this->Saturday = $Saturday;

        return $this;
    }

    public function getSunday(): string
    {
        return $this->Sunday;
    }

    public function setSunday(string $Sunday = null): static
    {
        $this->Sunday = $Sunday;

        return $this;
    }

    public function toArray(): array
    {
        $array = [];
//        foreach (array_keys(array: static::$defaultProperties['Barcode']) as $property) {
//            if (isset($this->{$property})) {
//                $array[$property] = $this->{$property};
//            }
//        }

        return $array;
    }
}
