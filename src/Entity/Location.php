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

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Sabre\Xml\Writer;
use function in_array;

/**
 * @since 1.0.0
 */
class Location extends AbstractEntity
{
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $AllowSundaySorting = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $DeliveryDate = null;

    /** @var string[]|null $DeliveryOptions */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $DeliveryOptions = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $OpeningTime = null;

    /** @var string[]|null $Options */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Options = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $City = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $HouseNr = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $HouseNrExt = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Postalcode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Street = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?Coordinates $Coordinates = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?CoordinatesNorthWest $CoordinatesNorthWest = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?CoordinatesSouthEast $CoordinatesSouthEast = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $LocationCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Saleschannel = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $TerminalType = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $RetailNetworkID = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $DownPartnerID = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $DownPartnerLocation = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string                       $Postalcode = null,
        ?string                       $AllowSundaySorting = null,
        /** @param string|DateTimeInterface|null $DeliveryDate */
        string|DateTimeInterface|null $DeliveryDate = null,
        /** @param string[]|null $DeliveryOptions */
        array                         $DeliveryOptions = null,
        /** @param string[]|null $Options */
        array                         $Options = null,
        Coordinates                   $Coordinates = null,
        CoordinatesNorthWest          $CoordinatesNorthWest = null,
        CoordinatesSouthEast          $CoordinatesSouthEast = null,
        ?string                       $City = null,
        ?string                       $Street = null,
        ?string                       $HouseNr = null,
        ?string                       $HouseNrExt = null,
        ?string                       $LocationCode = null,
        ?string                       $Saleschannel = null,
        ?string                       $TerminalType = null,
        ?string                       $RetailNetworkID = null,
        ?string                       $DownPartnerID = null,
        ?string                       $DownPartnerLocation = null
    ) {
        parent::__construct();

        $this->setAllowSundaySorting(AllowSundaySorting: $AllowSundaySorting);
        try {
            $this->setDeliveryDate(DeliveryDate: $DeliveryDate ?: (new DateTimeImmutable(datetime: 'next monday', timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'))));
        } catch (Exception $e) {
            throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
        }
        $this->setDeliveryOptions(DeliveryOptions: $DeliveryOptions);
        $this->setOptions(Options: $Options);
        $this->setPostalcode(Postalcode: $Postalcode);
        $this->setCoordinates(Coordinates: $Coordinates);
        $this->setCoordinatesNorthWest(CoordinatesNorthWest: $CoordinatesNorthWest);
        $this->setCoordinatesSouthEast(CoordinatesSouthEast: $CoordinatesSouthEast);
        $this->setCity(City: $City);
        $this->setStreet(Street: $Street);
        $this->setHouseNr(HouseNr: $HouseNr);
        $this->setHouseNrExt(HouseNrExt: $HouseNrExt);
        $this->setLocationCode(LocationCode: $LocationCode);
        $this->setSaleschannel(Saleschannel: $Saleschannel);
        $this->setTerminalType(TerminalType: $TerminalType);
        $this->setRetailNetworkID(RetailNetworkID: $RetailNetworkID);
        $this->setDownPartnerID(DownPartnerID: $DownPartnerID);
        $this->setDownPartnerLocation(DownPartnerLocation: $DownPartnerLocation);
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDeliveryDate(string|DateTimeInterface|null $DeliveryDate = null): static
    {
        if (is_string(value: $DeliveryDate)) {
            try {
                $DeliveryDate = new DateTimeImmutable(datetime: $DeliveryDate, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->DeliveryDate = $DeliveryDate;

        return $this;
    }

    public function setPostalcode(?string $Postalcode = null): static
    {
        if (is_null(value: $Postalcode)) {
            $this->Postalcode = null;
        } else {
            $this->Postalcode = strtoupper(string: str_replace(search: ' ', replace: '', subject: $Postalcode));
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
            $AllowSundaySorting = in_array(needle: $AllowSundaySorting, haystack: [true, 'true', 1], strict: true) ? 'true' : 'false';
        }

        $this->AllowSundaySorting = $AllowSundaySorting;

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getDeliveryOptions(): ?array
    {
        return $this->DeliveryOptions;
    }

    /**
     * @param string[]|null $DeliveryOptions
     * @return static
     */
    public function setDeliveryOptions(?array $DeliveryOptions): static
    {
        if (is_array(value: $DeliveryOptions)) {
            foreach ($DeliveryOptions as $option) {
                if (!is_string(value: $option)) {
                    throw new \TypeError(message: 'Expected a string');
                }
            }
        }

        $this->DeliveryOptions = $DeliveryOptions;

        return $this;
    }

    public function getOpeningTime(): ?string
    {
        return $this->OpeningTime;
    }

    public function setOpeningTime(?string $OpeningTime): static
    {
        $this->OpeningTime = $OpeningTime;

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getOptions(): ?array
    {
        return $this->Options;
    }

    /**
     * @param string[]|null $Options
     * @return static
     */
    public function setOptions(?array $Options): static
    {
        if (is_array(value: $Options)) {
            foreach ($Options as $option) {
                if (!is_string(value: $option)) {
                    throw new \TypeError(message: 'Expected a string');
                }
            }
        }

        $this->Options = $Options;

        return $this;
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

    public function getStreet(): ?string
    {
        return $this->Street;
    }

    public function setStreet(?string $Street): static
    {
        $this->Street = $Street;

        return $this;
    }

    public function getCoordinates(): ?Coordinates
    {
        return $this->Coordinates;
    }

    public function setCoordinates(?Coordinates $Coordinates): static
    {
        $this->Coordinates = $Coordinates;

        return $this;
    }

    public function getCoordinatesNorthWest(): ?CoordinatesNorthWest
    {
        return $this->CoordinatesNorthWest;
    }

    public function setCoordinatesNorthWest(?CoordinatesNorthWest $CoordinatesNorthWest): static
    {
        $this->CoordinatesNorthWest = $CoordinatesNorthWest;

        return $this;
    }

    public function getCoordinatesSouthEast(): ?CoordinatesSouthEast
    {
        return $this->CoordinatesSouthEast;
    }

    public function setCoordinatesSouthEast(?CoordinatesSouthEast $CoordinatesSouthEast): static
    {
        $this->CoordinatesSouthEast = $CoordinatesSouthEast;

        return $this;
    }

    public function getLocationCode(): ?string
    {
        return $this->LocationCode;
    }

    public function setLocationCode(?string $LocationCode): static
    {
        $this->LocationCode = $LocationCode;

        return $this;
    }

    public function getSaleschannel(): ?string
    {
        return $this->Saleschannel;
    }

    public function setSaleschannel(?string $Saleschannel): static
    {
        $this->Saleschannel = $Saleschannel;

        return $this;
    }

    public function getTerminalType(): ?string
    {
        return $this->TerminalType;
    }

    public function setTerminalType(?string $TerminalType): static
    {
        $this->TerminalType = $TerminalType;

        return $this;
    }

    public function getRetailNetworkID(): ?string
    {
        return $this->RetailNetworkID;
    }

    public function setRetailNetworkID(?string $RetailNetworkID): static
    {
        $this->RetailNetworkID = $RetailNetworkID;

        return $this;
    }

    public function getDownPartnerID(): ?string
    {
        return $this->DownPartnerID;
    }

    public function setDownPartnerID(?string $DownPartnerID): static
    {
        $this->DownPartnerID = $DownPartnerID;

        return $this;
    }

    public function getDownPartnerLocation(): ?string
    {
        return $this->DownPartnerLocation;
    }

    public function setDownPartnerLocation(?string $DownPartnerLocation): static
    {
        $this->DownPartnerLocation = $DownPartnerLocation;

        return $this;
    }

    public function getAllowSundaySorting(): ?string
    {
        return $this->AllowSundaySorting;
    }

    public function getDeliveryDate(): ?DateTimeInterface
    {
        return $this->DeliveryDate;
    }

    public function getPostalcode(): ?string
    {
        return $this->Postalcode;
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
                if ($this->DeliveryDate instanceof DateTimeImmutable) {
                    $xml["{{$namespace}}DeliveryDate"] = $this->DeliveryDate->format(format: 'd-m-Y');
                }
            } elseif ('Options' === $propertyName) {
                if (is_array(value: $this->Options)) {
                    $options = [];
                    foreach ($this->Options as $option) {
                        $options[] = ['{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string' => $option];
                    }
                    $xml["{{$namespace}}Options"] = $options;
                }
            } elseif ('DeliveryOptions' === $propertyName) {
                if (is_array(value: $this->DeliveryOptions)) {
                    $options = [];
                    foreach ($this->DeliveryOptions as $option) {
                        $options[] = ['{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string' => $option];
                    }
                    $xml["{{$namespace}}DeliveryOptions"] = $options;
                }
            } elseif ('AllowSundaySorting' === $propertyName) {
                if (isset($this->AllowSundaySorting)) {
                    if (is_bool(value: $this->AllowSundaySorting)) {
                        $xml["{{$namespace}}AllowSundaySorting"] = $this->AllowSundaySorting ? 'true' : 'false';
                    } else {
                        $xml["{{$namespace}}AllowSundaySorting"] = $this->AllowSundaySorting;
                    }
                }
            } elseif (isset($this->$propertyName)) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write(value: $xml);
    }
}
