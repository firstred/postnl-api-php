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

namespace Firstred\PostNL\Entity\Response;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Attribute\SerializableDateTimeProperty;
use Firstred\PostNL\Attribute\SerializableStringArrayProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\ServiceNotSetException;
use Sabre\Xml\Writer;
use stdClass;
use TypeError;
use function is_array;

/**
 * @since 1.0.0
 */
class GetDeliveryDateResponse extends AbstractEntity
{
    /** @var DateTimeInterface|null $DeliveryDate */
    #[SerializableDateTimeProperty(namespace: SoapNamespace::Domain)]
    protected DateTimeInterface|null $DeliveryDate = null;

    /** @var string[]|null $Options */
    #[SerializableProperty(isArray: true, namespace: SoapNamespace::Domain)]
    protected ?array $Options = null;

    /**
     * @throws PostNLInvalidArgumentException
     */
    public function __construct(
        string|DateTimeInterface|null $DeliveryDate = null,
        /** @param string[]|null $Options */
        array                         $Options = null,
    ) {
        parent::__construct();

        $this->setDeliveryDate(DeliveryDate: $DeliveryDate);
        $this->setOptions(Options: $Options);
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
     *
     * @return GetDeliveryDateResponse
     */
    public function setOptions(?array $Options): GetDeliveryDateResponse
    {
        if (is_array(value: $Options)) {
            foreach ($Options as $option) {
                if (!is_string(value: $option)) {
                    throw new TypeError(message: 'Expected string');
                }
            }
        }

        $this->Options = $Options;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDeliveryDate(): DateTimeInterface|null
    {
        return $this->DeliveryDate;
    }

    /**
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDeliveryDate(DateTimeInterface|string|null $DeliveryDate = null): static
    {
        if (is_string(value: $DeliveryDate)) {
            try {
                $DeliveryDate = new DateTimeImmutable(datetime: $DeliveryDate, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new PostNLInvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->DeliveryDate = $DeliveryDate;

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

            if ('Shipments' === $propertyName) {
                $options = [];
                if (is_array(value: $this->Options)) {
                    foreach ($this->Options as $option) {
                        $options[] = ["{{$namespace}}string" => $option];
                    }
                }
                $xml["{{$namespace}}Options"] = $options;
            } else {
                $xml["{{$namespace}}{$propertyName}"] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write(value: $xml);
    }

    /**
     * @throws PostNLInvalidArgumentException
     * @throws DeserializationException
     */
    public static function jsonDeserialize(stdClass $json): static
    {
        if (!isset($json->GetDeliveryDateResponse)) {
            throw new DeserializationException();
        }

        $getDeliveryDateResponse = self::create();
        try {
            $getDeliveryDateResponse->DeliveryDate = new DateTimeImmutable(datetime: $json->GetDeliveryDateResponse->DeliveryDate, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
        } catch (Exception $e) {
            throw new PostNLInvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
        }
        if (isset($json->GetDeliveryDateResponse->Options)) {
            if (!is_array(value: $json->GetDeliveryDateResponse->Options)) {
                $json->GetDeliveryDateResponse->Options = [$json->GetDeliveryDateResponse->Options];
            }

            $options = [];
            foreach ($json->GetDeliveryDateResponse->Options as $key => $option) {
                if (is_string(value: $option)) {
                    $options[] = $option;
                } elseif ($option instanceof stdClass && isset($option->string)) {
                    $options[] = $option->string;
                }
            }

            $getDeliveryDateResponse->setOptions(Options: $options);
        }

        return $getDeliveryDateResponse;
    }
}
