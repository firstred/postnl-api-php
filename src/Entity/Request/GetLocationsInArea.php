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

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Cache\CacheableRequestEntityInterface;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Entity\Message\Message;

/**
 * @since 1.0.0
 */
class GetLocationsInArea extends AbstractEntity implements CacheableRequestEntityInterface
{
    /** @var string|null $Countrycode */
    #[SerializableProperty(type: 'string')]
    protected ?string $Countrycode = null;

    /** @var Location|null $Location */
    #[SerializableProperty(type: Location::class)]
    protected ?Location $Location = null;

    /** @var Message|null $Message */
    #[SerializableProperty(type: Message::class)]
    protected ?Message $Message = null;

    /**
     * @param string|null   $Countrycode
     * @param Location|null $Location
     * @param Message|null  $Message
     */
    public function __construct(
        ?string $Countrycode = null,
        ?Location $Location = null,
        ?Message $Message = null
    ) {
        parent::__construct();

        $this->setCountrycode(Countrycode: $Countrycode);
        $this->setLocation(Location: $Location);
        $this->setMessage(Message: $Message ?: new Message());
    }

    /**
     * @return string|null
     */
    public function getCountrycode(): ?string
    {
        return $this->Countrycode;
    }

    /**
     * @param string|null $Countrycode
     *
     * @return static
     */
    public function setCountrycode(?string $Countrycode): static
    {
        $this->Countrycode = $Countrycode;

        return $this;
    }

    /**
     * @return Location|null
     */
    public function getLocation(): ?Location
    {
        return $this->Location;
    }

    /**
     * @param Location|null $Location
     *
     * @return static
     */
    public function setLocation(?Location $Location): static
    {
        $this->Location = $Location;

        return $this;
    }

    /**
     * @return Message|null
     */
    public function getMessage(): ?Message
    {
        return $this->Message;
    }

    /**
     * @param Message|null $Message
     *
     * @return static
     */
    public function setMessage(?Message $Message): static
    {
        $this->Message = $Message;

        return $this;
    }

    /**
     * This method returns a unique cache key for every unique cacheable request as defined by PSR-6.
     *
     * @see https://www.php-fig.org/psr/psr-6/#definitions
     *
     * @return string
     */
    public function getCacheKey(): string
    {
        $cacheKey = "GetLocationsInArea.{$this->getLocation()?->getAllowSundaySorting()}";
        $cacheKey .= ".{$this->getLocation()?->getDeliveryDate()?->format(format: 'Y-m-d')}";
        $cacheKey .= '.'.implode(separator: '_', array: $this->getLocation()?->getOptions() ?? []);
        $cacheKey .= ".{$this->getLocation()?->getCoordinatesNorthWest()?->getLatitude()}_{$this->getLocation()?->getCoordinatesNorthWest()?->getLongitude()}";
        $cacheKey .= ".{$this->getLocation()?->getCoordinatesSouthEast()?->getLatitude()}_{$this->getLocation()?->getCoordinatesNorthWest()?->getLongitude()}";

        return hash(
            algo: 'xxh128',
            data: $cacheKey,
        );
    }
}
