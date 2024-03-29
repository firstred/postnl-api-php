<?php

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

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\SerializableProperty;

/**
 * @since 1.0.0
 */
class Coordinates extends AbstractEntity
{
    /** @var string|null $Latitude */
    #[SerializableProperty(type: 'string')]
    protected ?string $Latitude = null;

    /** @var string|null $Longitude */
    #[SerializableProperty(type: 'string')]
    protected ?string $Longitude = null;

    /**
     * @param string|null $Latitude
     * @param string|null $Longitude
     */
    public function __construct(?string $Latitude = null, ?string $Longitude = null)
    {
        parent::__construct();

        $this->setLatitude(Latitude: $Latitude);
        $this->setLongitude(Longitude: $Longitude);
    }

    /**
     * @return string|null
     */
    public function getLatitude(): ?string
    {
        return $this->Latitude;
    }

    /**
     * @param string|null $Latitude
     *
     * @return static
     */
    public function setLatitude(?string $Latitude): static
    {
        $this->Latitude = $Latitude;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLongitude(): ?string
    {
        return $this->Longitude;
    }

    /**
     * @param string|null $Longitude
     *
     * @return static
     */
    public function setLongitude(?string $Longitude): static
    {
        $this->Longitude = $Longitude;

        return $this;
    }
}
