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
use Firstred\PostNL\Attribute\SerializableScalarProperty;
use Firstred\PostNL\Attribute\SerializableStringArrayProperty;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use stdClass;
use function array_merge;
use function is_array;
use function is_string;

/**
 * @since 1.0.0
 */
class TimeframeTimeFrame extends AbstractEntity
{
    /** @var string|null $Date */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Date = null;

    /** @var string|null $From */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $From = null;

    /** @var string|null $To */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $To = null;

    /** @var string[]|null $Options */
    #[SerializableStringArrayProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Options = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string $GetSentDate = null,
        ?string $From = null,
        ?string $To = null,
        /** @param string[]|null $Options */
        ?array  $Options = null,
    ) {
        parent::__construct();

        $this->setDate(Date: $GetSentDate);
        $this->setFrom(From: $From);
        $this->setTo(To: $To);
        $this->setOptions(Options: $Options);
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->Date;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDate(string|DateTimeInterface|null $Date = null): static
    {
        if (is_string(value: $Date)) {
            try {
                $Date = new DateTimeImmutable(datetime: $Date, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->Date = $Date;

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
    public function setTo(?string $To): TimeframeTimeFrame
    {
        $this->To = $To;

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
     *
     * @return static
     */
    public function setOptions(?array $Options): static
    {
        $this->Options = $Options;

        return $this;
    }

    /**
     * @param stdClass $json
     *
     * @return TimeframeTimeFrame
     * @throws NotSupportedException
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @since 1.2.0
     */
    public static function jsonDeserialize(stdClass $json): static
    {
        if (isset($json->TimeframeTimeFrame->Options)) {
            /** @var list<string> $deliveryOptions */
            $deliveryOptions = [];
            if (!is_array(value: $json->TimeframeTimeFrame->Options)) {
                $json->TimeframeTimeFrame->Options = [$json->TimeframeTimeFrame->Options];
            }

            foreach ($json->TimeframeTimeFrame->Options as $deliveryOption) {
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

            $json->TimeframeTimeFrame->Options = $deliveryOptions;
        }

        return parent::jsonDeserialize(json: $json);
    }
}
