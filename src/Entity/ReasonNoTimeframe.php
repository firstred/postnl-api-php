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
use Firstred\PostNL\Attribute\SerializableDateTimeProperty;
use Firstred\PostNL\Attribute\SerializableScalarProperty;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ServiceNotSetException;
use Sabre\Xml\Writer;
use stdClass;
use TypeError;
use function array_merge;
use function is_array;
use function is_string;

/**
 * @since 1.0.0
 */
class ReasonNoTimeframe extends AbstractEntity
{
    /** @var string|null $Code */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Code = null;

    /** @var DateTimeInterface|null $Date */
    #[SerializableDateTimeProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $Date = null;

    /** @var string|null $Description */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Description = null;

    /** @var string[]|null $Options */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Options = null;

    /** @var string|null $From */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $From = null;

    /** @var string|null $To */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $To = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string            $Code = null,
        ?DateTimeInterface $Date = null,
        ?string            $Description = null,
        /** @param string[]|null $Options */
        ?array             $Options = null,
        ?string            $From = null,
        ?string            $To = null
    ) {
        parent::__construct();

        $this->setCode(Code: $Code);
        $this->setDate(date: $Date);
        $this->setDescription(Description: $Description);
        $this->setOptions(Options: $Options);
        $this->setFrom(From: $From);
        $this->setTo(To: $To);
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->Code;
    }

    /**
     * @param string|null $Code
     *
     * @return static
     */
    public function setCode(?string $Code): ReasonNoTimeframe
    {
        $this->Code = $Code;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->Description;
    }

    /**
     * @param string|null $Description
     *
     * @return static
     */
    public function setDescription(?string $Description): ReasonNoTimeframe
    {
        $this->Description = $Description;

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
     * @param array|null $Options
     *
     * @return ReasonNoTimeframe
     */
    public function setOptions(?array $Options): static
    {
        if (is_array(value: $Options)) {
            foreach ($Options as $option) {
                if (!is_string(value: $option)) {
                    throw new TypeError(message: 'Expected a string');
                }
            }
        }

        $this->Options = $Options;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFrom(): ?string
    {
        return $this->From;
    }

    /**
     * @param string|null $From
     *
     * @return static
     */
    public function setFrom(?string $From): static
    {
        $this->From = $From;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTo(): ?string
    {
        return $this->To;
    }

    /**
     * @param string|null $To
     *
     * @return static
     */
    public function setTo(?string $To): static
    {
        $this->To = $To;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDate(string|DateTimeInterface|null $date = null): static
    {
        if (is_string(value: $date)) {
            try {
                $date = new DateTimeImmutable(datetime: $date, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->Date = $date;

        return $this;
    }

    /**
     * @throws NotSupportedException
     * @throws DeserializationException
     * @throws EntityNotFoundException
     *
     * @since 1.2.0
     */
    public static function jsonDeserialize(stdClass $json): static
    {
        if (isset($json->ReasonNoTimeframe->Options)) {
            /** @var list<string> $deliveryOptions */
            $deliveryOptions = [];
            if (!is_array(value: $json->ReasonNoTimeframe->Options)) {
                $json->ReasonNoTimeframe->Options = [$json->ReasonNoTimeframe->Options];
            }

            foreach ($json->ReasonNoTimeframe->Options as $deliveryOption) {
                if (isset($deliveryOption->string)) {
                    if (!is_array(value: $deliveryOption->string)) {
                        $deliveryOption->string = [$deliveryOption->string];
                    }
                    foreach ($deliveryOption->string as $optionString) {
                        $deliveryOptions[] = $optionString;
                    }
                } elseif (is_array(value: $deliveryOption)) {
                    $deliveryOptions = array_merge($deliveryOptions, $deliveryOption);
                } elseif (is_string(value: $deliveryOption)) {
                    $deliveryOptions[] = $deliveryOption;
                }
            }

            $json->ReasonNoTimeframe->Options = $deliveryOptions;
        }

        return parent::jsonDeserialize(json: $json);
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

            if ('Options' === $propertyName) {
                if (isset($this->Options)) {
                    $options = [];
                    if (is_array(value: $this->Options)) {
                        foreach ($this->Options as $option) {
                            $options[] = ['{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string' => $option];
                        }
                    }
                    $xml["{{$namespace}}Options"] = $options;
                }
            } else {
                $xml["{{$namespace}}{$propertyName}"] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write(value: $xml);
    }
}
