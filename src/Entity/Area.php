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
class Area extends AbstractEntity
{
    /** @var CoordinatesNorthWest|null $CoordinatesNorthWest */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: CoordinatesNorthWest::class)]
    protected ?CoordinatesNorthWest $CoordinatesNorthWest = null;

    /** @var CoordinatesSouthEast|null $CoordinatesSouthEast */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: CoordinatesSouthEast::class)]
    protected ?CoordinatesSouthEast $CoordinatesSouthEast = null;

    /**
     * @param CoordinatesNorthWest|null $CoordinatesNorthWest
     * @param CoordinatesSouthEast|null $CoordinatesSouthEast
     */
    public function __construct(
        ?CoordinatesNorthWest $CoordinatesNorthWest = null,
        ?CoordinatesSouthEast $CoordinatesSouthEast = null,
    ) {
        parent::__construct();

        $this->setCoordinatesNorthWest(CoordinatesNorthWest: $CoordinatesNorthWest);
        $this->setCoordinatesSouthEast(CoordinatesSouthEast: $CoordinatesSouthEast);
    }

    /**
     * @return CoordinatesNorthWest|null
     */
    public function getCoordinatesNorthWest(): ?CoordinatesNorthWest
    {
        return $this->CoordinatesNorthWest;
    }

    /**
     * @param CoordinatesNorthWest|null $CoordinatesNorthWest
     *
     * @return static
     */
    public function setCoordinatesNorthWest(?CoordinatesNorthWest $CoordinatesNorthWest): static
    {
        $this->CoordinatesNorthWest = $CoordinatesNorthWest;

        return $this;
    }

    /**
     * @return CoordinatesSouthEast|null
     */
    public function getCoordinatesSouthEast(): ?CoordinatesSouthEast
    {
        return $this->CoordinatesSouthEast;
    }

    /**
     * @param CoordinatesSouthEast|null $CoordinatesSouthEast
     *
     * @return static
     */
    public function setCoordinatesSouthEast(?CoordinatesSouthEast $CoordinatesSouthEast): static
    {
        $this->CoordinatesSouthEast = $CoordinatesSouthEast;

        return $this;
    }
}
