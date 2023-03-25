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
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Sabre\Xml\Writer;

/**
 * @since 1.0.0
 */
class GetSentDateResponse extends AbstractEntity
{
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $SentDate = null;

    /** @var string[]|null */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Options = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?DateTimeInterface $GetSentDate = null,
        /**  @param string[]|null $Options */
        array              $Options = null,
    ) {
        parent::__construct();

        $this->setSentDate(SentDate: $GetSentDate);
        $this->setOptions(Options: $Options);
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setSentDate(string|DateTimeInterface|null $SentDate = null): static
    {
        if (is_string(value: $SentDate)) {
            try {
                $SentDate = new DateTimeImmutable(datetime: $SentDate, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->SentDate = $SentDate;

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
     * @param strinmg[]|null $Options
     * @return static
     */
    public function setOptions(?array $Options): static
    {
        $this->Options = $Options;

        return $this;
    }

    public function getSentDate(): ?DateTimeInterface
    {
        return $this->SentDate;
    }

    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        if (!$this->currentService || !in_array(needle: $this->currentService, haystack: array_keys(array: static::$defaultProperties))) {
            $writer->write(value: $xml);

            return;
        }

        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
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
            } elseif (isset($this->$propertyName)) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write(value: $xml);
    }
}
