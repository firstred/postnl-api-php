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

namespace Firstred\PostNL\Entity\Request;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Attribute\SerializableDateTimeProperty;
use Firstred\PostNL\Attribute\SerializableEntityArrayProperty;
use Firstred\PostNL\Attribute\SerializableEntityProperty;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Attribute\SerializableScalarProperty;
use Firstred\PostNL\Attribute\SerializableStringArrayProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\ServiceNotSetException;
use Sabre\Xml\Writer;
use function in_array;

/**
 * @since 1.0.0
 */
class GetDeliveryDate extends AbstractEntity
{
    /** @var bool|null $AllowSundaySorting */
    #[SerializableEntityProperty(namespace: SoapNamespace::Domain)]
    protected ?bool $AllowSundaySorting = null;

    /** @var string|null $City */
    #[SerializableEntityProperty(namespace: SoapNamespace::Domain)]
    protected ?string $City = null;

    /** @var string|null $CountryCode */
    #[SerializableEntityProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CountryCode = null;

    /** @var CutOffTime[]|null $CutOffTimes */
    #[SerializableEntityArrayProperty(namespace: SoapNamespace::Domain, entityFqcn: CutOffTime::class)]
    protected ?array $CutOffTimes = null;

    /** @var string|null $HouseNr */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $HouseNr = null;

    /** @var string|null $HouseNrExt */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $HouseNrExt = null;

    /** @var string[]|null $Options */
    #[SerializableStringArrayProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Options = null;

    /** @var string|null $OriginCountryCode */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $OriginCountryCode = null;

    /** @var string|null $PostalCode */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $PostalCode = null;

    /** @var DateTimeInterface|null $ShippingDate */
    #[SerializableDateTimeProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $ShippingDate = null;

    /** @var string|null $ShippingDuration */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $ShippingDuration = null;

    /** @var string|null $Street */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Street = null;

    /** @var self|null $GetDeliveryDate */
    #[SerializableEntityProperty(namespace: SoapNamespace::Domain)]
    protected ?self $GetDeliveryDate = null;

    /** @var Message|null $Message  */
    #[SerializableEntityProperty(namespace: SoapNamespace::Domain)]
    protected ?Message $Message = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?bool                         $AllowSundaySorting = null,
        ?string                       $City = null,
        ?string                       $CountryCode = null,
        ?array                        $CutOffTimes = null,
        ?string                       $HouseNr = null,
        ?string                       $HouseNrExt = null,
        ?array                        $Options = null,
        ?string                       $OriginCountryCode = null,
        ?string                       $PostalCode = null,
        DateTimeInterface|string|null $ShippingDate = null,
        ?string                       $ShippingDuration = null,
        ?string                       $Street = null,
        ?GetDeliveryDate              $GetDeliveryDate = null,
        ?Message                      $Message = null
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
     * @param array|null $Options
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
     * @param Writer $writer
     *
     * @return void
     * @throws ServiceNotSetException
     */
    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        if (!isset($this->currentService)) {
            throw new ServiceNotSetException(message: 'Service not set before serialization');
        }

        foreach ($this->getSerializableProperties() as $propertyName => $namespace) {
            if (!isset($this->$propertyName)) {
                continue;
            }

            if ('CutOffTimes' === $propertyName) {
                if (isset($this->CutOffTimes)) {
                    $cutOffTimes = [];
                    foreach ($this->CutOffTimes as $cutOffTime) {
                        $cutOffTimes[] = ["{{$namespace}}CutOffTime" => $cutOffTime];
                    }
                    $xml["{{$namespace}}CutOffTimes"] = $cutOffTimes;
                }
            } elseif ('Options' === $propertyName) {
                if (isset($this->Options)) {
                    $options = [];
                    foreach ($this->Options as $option) {
                        $options[] = ['{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string' => $option];
                    }
                    $xml["{{$namespace}}Options"] = $options;
                }
            } elseif ('AllowSundaySorting' === $propertyName) {
                if (isset($this->AllowSundaySorting)) {
                    if (is_bool(value: $this->AllowSundaySorting)) {
                        $xml["{{$namespace}}AllowSundaySorting"] = $this->AllowSundaySorting ? 'true' : 'false';
                    } else {
                        $xml["{{$namespace}}AllowSundaySorting"] = $this->AllowSundaySorting;
                    }
                }
            } else {
                $xml["{{$namespace}}{$propertyName}"] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write(value: $xml);
    }
}
