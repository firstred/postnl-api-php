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

use TypeError;

/**
 * Class OpeningHours
 */
class OpeningHours extends AbstractEntity
{
    /**
     * @var string|null $monday
     *
     * @since 1.0.0
     */
    protected $monday = '';

    /**
     * @var string|null $tuesday
     *
     * @since 1.0.0
     */
    protected $tuesday = '';

    /**
     * @var string|null $wednesday
     *
     * @since 1.0.0
     */
    protected $wednesday = '';

    /**
     * @var string|null $thursday
     *
     * @since 1.0.0
     */
    protected $thursday = '';

    /**
     * @var string|null $friday
     *
     * @since 1.0.0
     */
    protected $friday = '';

    /**
     * @var string|null $saturday
     *
     * @since 1.0.0
     */
    protected $saturday = '';

    /**
     * @var string|null $sunday
     *
     * @since 1.0.0
     */
    protected $sunday = '';

    /**
     * OpeningHours constructor.
     *
     * @param string|null $monday
     * @param string|null $tuesday
     * @param string|null $wednesday
     * @param string|null $thursday
     * @param string|null $friday
     * @param string|null $saturday
     * @param string|null $sunday
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $monday = '', ?string $tuesday = '', ?string $wednesday = '', ?string $thursday = '', ?string $friday = '', ?string $saturday = '', ?string $sunday = '')
    {
        parent::__construct();

        $this->setMonday($monday);
        $this->setTuesday($tuesday);
        $this->setWednesday($wednesday);
        $this->setThursday($thursday);
        $this->setFriday($friday);
        $this->setSaturday($saturday);
        $this->setSunday($sunday);
    }

    /**
     * @return array
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function toArray(): array
    {
        $array = [];
        foreach (array_keys(get_class_vars(static::class)) as $property) {
            if (isset($this->{$property})) {
                $array[$property] = $this->{$property};
            }
        }

        return $array;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getMonday(): ?string
    {
        return $this->monday;
    }

    /**
     * @param string|null $monday
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setMonday(?string $monday): OpeningHours
    {
        $this->monday = $monday;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getTuesday(): ?string
    {
        return $this->tuesday;
    }

    /**
     * @param string|null $tuesday
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setTuesday(?string $tuesday): OpeningHours
    {
        $this->tuesday = $tuesday;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getWednesday(): ?string
    {
        return $this->wednesday;
    }

    /**
     * @param string|null $wednesday
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setWednesday(?string $wednesday): OpeningHours
    {
        $this->wednesday = $wednesday;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getThursday(): ?string
    {
        return $this->thursday;
    }

    /**
     * @param string|null $thursday
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setThursday(?string $thursday): OpeningHours
    {
        $this->thursday = $thursday;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getFriday(): ?string
    {
        return $this->friday;
    }

    /**
     * @param string|null $friday
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setFriday(?string $friday): OpeningHours
    {
        $this->friday = $friday;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getSaturday(): ?string
    {
        return $this->saturday;
    }

    /**
     * @param string|null $saturday
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setSaturday(?string $saturday): OpeningHours
    {
        $this->saturday = $saturday;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getSunday(): ?string
    {
        return $this->sunday;
    }

    /**
     * @param string|null $sunday
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setSunday(?string $sunday): OpeningHours
    {
        $this->sunday = $sunday;

        return $this;
    }
}
