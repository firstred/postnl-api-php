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

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Cache\CacheableRequestEntityInterface;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Exception\InvalidArgumentException;
use function in_array;

/**
 * @since 1.0.0
 */
class GetDeliveryDate extends AbstractEntity implements CacheableRequestEntityInterface
{
    /** @var bool|null $AllowSundaySorting */
    #[SerializableProperty(type: 'bool')]
    protected ?bool $AllowSundaySorting = null;

    /** @var string|null $City */
    #[SerializableProperty(type: 'string')]
    protected ?string $City = null;

    /** @var string|null $CountryCode */
    #[SerializableProperty(type: 'string')]
    protected ?string $CountryCode = null;

    /** @var CutOffTime[]|null $CutOffTimes */
    #[SerializableProperty(type: CutOffTime::class)]
    protected ?array $CutOffTimes = null;

    /** @var string|null $HouseNr */
    #[SerializableProperty(type: 'string')]
    protected ?string $HouseNr = null;

    /** @var string|null $HouseNrExt */
    #[SerializableProperty(type: 'string')]
    protected ?string $HouseNrExt = null;

    /** @var string[]|null $Options */
    #[SerializableProperty(type: 'string', isArray: true)]
    protected ?array $Options = null;

    /** @var string|null $OriginCountryCode */
    #[SerializableProperty(type: 'string')]
    protected ?string $OriginCountryCode = null;

    /** @var string|null $PostalCode */
    #[SerializableProperty(type: 'string')]
    protected ?string $PostalCode = null;

    /** @var DateTimeInterface|null $ShippingDate */
    #[SerializableProperty(type: DateTimeInterface::class)]
    protected ?DateTimeInterface $ShippingDate = null;

    /** @var string|null $ShippingDuration */
    #[SerializableProperty(type: 'string')]
    protected ?string $ShippingDuration = null;

    /** @var string|null $Street */
    #[SerializableProperty(type: 'string')]
    protected ?string $Street = null;

    /** @var self|null $GetDeliveryDate */
    #[SerializableProperty(type: self::class)]
    protected ?self $GetDeliveryDate = null;

    /** @var Message|null $Message */
    #[SerializableProperty(type: Message::class)]
    protected ?Message $Message = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?bool $AllowSundaySorting = null,
        ?string $City = null,
        ?string $CountryCode = null,
        ?array $CutOffTimes = null,
        ?string $HouseNr = null,
        ?string $HouseNrExt = null,
        ?array $Options = null,
        ?string $OriginCountryCode = null,
        ?string $PostalCode = null,
        DateTimeInterface|string|null $ShippingDate = null,
        ?string $ShippingDuration = null,
        ?string $Street = null,
        ?GetDeliveryDate $GetDeliveryDate = null,
        ?Message $Message = null
    ) {
        parent::__construct();

        $this->setAllowSundaySorting(AllowSundaySorting: $AllowSundaySorting);
        $this->setCity(City: $City);
        $this->setCountryCode(CountryCode: $CountryCode);
        $this->setCutOffTimes(CutOffTimes: $CutOffTimes);
        $this->setHouseNr(HouseNr: $HouseNr);
        $this->setHouseNrExt(HouseNrExt: $HouseNrExt);
        $this->setOptions(Options: $Options);
        $this->setOriginCountryCode(OriginCountryCode: $OriginCountryCode);
        $this->setPostalCode(PostalCode: $PostalCode);
        $this->setShippingDate(shippingDate: $ShippingDate);
        $this->setShippingDuration(ShippingDuration: $ShippingDuration);
        $this->setStreet(Street: $Street);
        $this->setGetDeliveryDate(GetDeliveryDate: $GetDeliveryDate);
        $this->setMessage(Message: $Message);
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->City;
    }

    /**
     * @param string|null $City
     *
     * @return static
     */
    public function setCity(?string $City): static
    {
        $this->City = $City;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->CountryCode;
    }

    /**
     * @param string|null $CountryCode
     *
     * @return static
     */
    public function setCountryCode(?string $CountryCode): static
    {
        $this->CountryCode = $CountryCode;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getCutOffTimes(): ?array
    {
        return $this->CutOffTimes;
    }

    /**
     * @param array|null $CutOffTimes
     *
     * @return static
     */
    public function setCutOffTimes(?array $CutOffTimes): static
    {
        $this->CutOffTimes = $CutOffTimes;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNr(): ?string
    {
        return $this->HouseNr;
    }

    /**
     * @param string|null $HouseNr
     *
     * @return static
     */
    public function setHouseNr(?string $HouseNr): static
    {
        $this->HouseNr = $HouseNr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNrExt(): ?string
    {
        return $this->HouseNrExt;
    }

    /**
     * @param string|null $HouseNrExt
     *
     * @return static
     */
    public function setHouseNrExt(?string $HouseNrExt): static
    {
        $this->HouseNrExt = $HouseNrExt;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getOptions(): ?array
    {
        return $this->Options;
    }

    /**
     * @param string[]|null $Options
     *
     * @return static
     */
    public function setOptions(?array $Options): static
    {
        $this->Options = $Options;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOriginCountryCode(): ?string
    {
        return $this->OriginCountryCode;
    }

    /**
     * @param string|null $OriginCountryCode
     *
     * @return static
     */
    public function setOriginCountryCode(?string $OriginCountryCode): static
    {
        $this->OriginCountryCode = $OriginCountryCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingDuration(): ?string
    {
        return $this->ShippingDuration;
    }

    /**
     * @param string|null $ShippingDuration
     *
     * @return static
     */
    public function setShippingDuration(?string $ShippingDuration): static
    {
        $this->ShippingDuration = $ShippingDuration;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->Street;
    }

    /**
     * @param string|null $Street
     *
     * @return static
     */
    public function setStreet(?string $Street): static
    {
        $this->Street = $Street;

        return $this;
    }

    /**
     * @return static|null
     */
    public function getGetDeliveryDate(): ?self
    {
        return $this->GetDeliveryDate;
    }

    /**
     * @param GetDeliveryDate|null $GetDeliveryDate
     *
     * @return static
     */
    public function setGetDeliveryDate(?GetDeliveryDate $GetDeliveryDate): static
    {
        $this->GetDeliveryDate = $GetDeliveryDate;

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
     * @return DateTimeInterface|null
     */
    public function getShippingDate(): ?DateTimeInterface
    {
        return $this->ShippingDate;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setShippingDate(DateTimeInterface|string|null $shippingDate = null): static
    {
        if (is_string(value: $shippingDate)) {
            try {
                $shippingDate = new DateTimeImmutable(datetime: $shippingDate, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->ShippingDate = $shippingDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->PostalCode;
    }

    /**
     * @param string|null $PostalCode
     *
     * @return static
     */
    public function setPostalCode(?string $PostalCode = null): static
    {
        if (is_null(value: $PostalCode)) {
            $this->PostalCode = null;
        } else {
            $this->PostalCode = strtoupper(string: str_replace(search: ' ', replace: '', subject: $PostalCode));
        }

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAllowSundaySorting(): ?bool
    {
        return $this->AllowSundaySorting;
    }

    /**
     * @since 1.0.0
     * @since 1.3.0 Accept bool and int
     */
    public function setAllowSundaySorting(bool|int|string|null $AllowSundaySorting = null): static
    {
        if (null !== $AllowSundaySorting) {
            $AllowSundaySorting = in_array(needle: $AllowSundaySorting, haystack: [true, 'true', 1], strict: true);
        }

        $this->AllowSundaySorting = $AllowSundaySorting;

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
        $cacheKey = "GetDeliveryDate.{$this->getAllowSundaySorting()}.{$this->getShippingDuration()}.{$this->getShippingDate()?->format(format: 'Y-m-d')}";
        foreach ($this->getOptions() as $option) {
            $cacheKey .= ".$option";
        }
        $cutOffTimes = $this->getCutOffTimes();

        if (isset($cutOffTimes[0])) {
            $cacheKey .= ".$cutOffTimes[0]";
        } else {
            $cacheKey .= '.';
            foreach ($cutOffTimes as $day => $cutOffTime) {
                $cacheKey .= "{$day}_{$cutOffTime->getTime()}_";
            }
        }
        $cacheKey .= ".{$this->getOriginCountryCode()}.{$this->getPostalCode()}.{$this->getHouseNr()}.{$this->getHouseNrExt()}";

        return hash(
            algo: 'xxh128',
            data: $cacheKey,
        );
    }
}
