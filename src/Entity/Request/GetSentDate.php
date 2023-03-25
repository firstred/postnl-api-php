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
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Sabre\Xml\Writer;
use function in_array;

/**
 * @since 1.0.0
 */
class GetSentDate extends AbstractEntity
{
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?bool $AllowSundaySorting = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $City = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CountryCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $DeliveryDate = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $HouseNr = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $HouseNrExt = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Options = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $PostalCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $ShippingDuration = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Street = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?bool                         $AllowSundaySorting = false,
        ?string                       $City = null,
        ?string                       $CountryCode = null,
        ?string                       $HouseNr = null,
        ?string                       $HouseNrExt = null,
        ?array                        $Options = null,
        ?string                       $PostalCode = null,
        DateTimeInterface|string|null $DeliveryDate = null,
        ?string                       $Street = null,
        ?string                       $ShippingDuration = null
    ) {
        parent::__construct();

        $this->setAllowSundaySorting(AllowSundaySorting: $AllowSundaySorting);
        $this->setCity(City: $City);
        $this->setCountryCode(CountryCode: $CountryCode);
        $this->setHouseNr(HouseNr: $HouseNr);
        $this->setHouseNrExt(HouseNrExt: $HouseNrExt);
        $this->setOptions(Options: $Options);
        $this->setPostalCode(postcode: $PostalCode);
        $this->setDeliveryDate(deliveryDate: $DeliveryDate);
        $this->setStreet(Street: $Street);
        $this->setShippingDuration(ShippingDuration: $ShippingDuration);
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(?string $City): static
    {
        $this->City = $City;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->CountryCode;
    }

    public function setCountryCode(?string $CountryCode): static
    {
        $this->CountryCode = $CountryCode;

        return $this;
    }

    public function getHouseNr(): ?string
    {
        return $this->HouseNr;
    }

    public function setHouseNr(?string $HouseNr): static
    {
        $this->HouseNr = $HouseNr;

        return $this;
    }

    public function getHouseNrExt(): ?string
    {
        return $this->HouseNrExt;
    }

    public function setHouseNrExt(?string $HouseNrExt): static
    {
        $this->HouseNrExt = $HouseNrExt;

        return $this;
    }

    public function getOptions(): ?array
    {
        return $this->Options;
    }

    public function setOptions(?array $Options): static
    {
        $this->Options = $Options;

        return $this;
    }

    public function getShippingDuration(): ?string
    {
        return $this->ShippingDuration;
    }

    public function setShippingDuration(?string $ShippingDuration): static
    {
        $this->ShippingDuration = $ShippingDuration;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->Street;
    }

    public function setStreet(?string $Street): static
    {
        $this->Street = $Street;

        return $this;
    }

    public function getAllowSundaySorting(): ?bool
    {
        return $this->AllowSundaySorting;
    }

    public function getDeliveryDate(): ?DateTimeInterface
    {
        return $this->DeliveryDate;
    }

    public function getPostalCode(): ?string
    {
        return $this->PostalCode;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDeliveryDate(string|DateTimeInterface|null $deliveryDate = null): static
    {
        if (is_string(value: $deliveryDate)) {
            try {
                $deliveryDate = new DateTimeImmutable(datetime: $deliveryDate, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->DeliveryDate = $deliveryDate;

        return $this;
    }

    public function setPostalCode(?string $postcode = null): static
    {
        if (is_null(value: $postcode)) {
            $this->PostalCode = null;
        } else {
            $this->PostalCode = strtoupper(string: str_replace(search: ' ', replace: '', subject: $postcode));
        }

        return $this;
    }

    /**
     * @since 1.0.0
     * @since 1.3.0 Accept bool and int
     */
    public function setAllowSundaySorting(string|bool|int|null $AllowSundaySorting = null): static
    {
        if (null !== $AllowSundaySorting) {
            $AllowSundaySorting = in_array(needle: $AllowSundaySorting, haystack: [true, 'true', 1], strict: true);
        }

        $this->AllowSundaySorting = $AllowSundaySorting;

        return $this;
    }

    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        if (!$this->currentService || !in_array(needle: $this->currentService, haystack: array_keys(array: static::$defaultProperties))) {
            $writer->write(value: $xml);

            return;
        }

        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if ('DeliveryDate' === $propertyName) {
                if ($this->DeliveryDate instanceof DateTimeInterface) {
                    $xml["{{$namespace}}DeliveryDate"] = $this->DeliveryDate->format(format: 'd-m-Y');
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
                $xml["{{$namespace}}AllowSundaySorting"] = $this->AllowSundaySorting ? 'true' : 'false';
            } elseif (isset($this->$propertyName)) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write(value: $xml);
    }
}
