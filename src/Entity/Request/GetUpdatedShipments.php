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

use DateTimeInterface;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Cache\CacheableRequestEntityInterface;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Customer;

/**
 * @since 2.0.0
 */
class GetUpdatedShipments extends AbstractEntity implements CacheableRequestEntityInterface
{
    /** @var Customer|null $Customer */
    #[SerializableProperty(type: Customer::class)]
    protected ?Customer $Customer = null;

    /** @var DateTimeInterface|null $DateTimeFrom */
    #[SerializableProperty(type: DateTimeInterface::class)]
    protected ?DateTimeInterface $DateTimeFrom = null;

    /** @var DateTimeInterface|null $DateTimeTo */
    #[SerializableProperty(type: DateTimeInterface::class)]
    protected ?DateTimeInterface $DateTimeTo = null;

    /**
     * @param Customer|null          $Customer
     * @param DateTimeInterface|null $DateTimeFrom
     * @param DateTimeInterface|null $DateTimeTo
     */
    public function __construct(
        ?Customer $Customer = null,
        ?DateTimeInterface $DateTimeFrom = null,
        ?DateTimeInterface $DateTimeTo = null
    ) {
        parent::__construct();

        $this->setCustomer(Customer: $Customer);
        $this->setDateTimeFrom(DateTimeFrom: $DateTimeFrom);
        $this->setDateTimeTo(DateTimeTo: $DateTimeTo);
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->Customer;
    }

    /**
     * @param Customer|null $Customer
     *
     * @return static
     */
    public function setCustomer(?Customer $Customer): static
    {
        $this->Customer = $Customer;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDateTimeFrom(): ?DateTimeInterface
    {
        return $this->DateTimeFrom;
    }

    /**
     * @param DateTimeInterface|null $DateTimeFrom
     *
     * @return static
     */
    public function setDateTimeFrom(?DateTimeInterface $DateTimeFrom): static
    {
        $this->DateTimeFrom = $DateTimeFrom;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDateTimeTo(): ?DateTimeInterface
    {
        return $this->DateTimeTo;
    }

    /**
     * @param DateTimeInterface|null $DateTimeTo
     *
     * @return static
     */
    public function setDateTimeTo(?DateTimeInterface $DateTimeTo): static
    {
        $this->DateTimeTo = $DateTimeTo;

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
        $cacheKey = "GetUpdatedShipments.{$this->getCustomer()?->getCustomerCode()}";
        $cacheKey .= ".{$this->getCustomer()?->getCustomerNumber()}";
        $cacheKey .= ".{$this->getDateTimeFrom()->format(format: 'U')}.{$this->getDateTimeTo()->format(format: 'U')}";

        return hash(
            algo: 'xxh128',
            data: $cacheKey,
        );
    }
}
