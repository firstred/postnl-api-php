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

namespace Firstred\PostNL\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotSupportedException;
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
    #[SerializableProperty(type: 'string')]
    protected ?string $Code = null;

    /** @var DateTimeInterface|null $Date */
    #[SerializableProperty(type: DateTimeInterface::class)]
    protected ?DateTimeInterface $Date = null;

    /** @var string|null $Description */
    #[SerializableProperty(type: 'string')]
    protected ?string $Description = null;

    /** @var string[]|null $Options */
    #[SerializableProperty(type: 'string', isArray: true)]
    protected ?array $Options = null;

    /** @var string|null $From */
    #[SerializableProperty(type: 'string')]
    protected ?string $From = null;

    /** @var string|null $To */
    #[SerializableProperty(type: 'string')]
    protected ?string $To = null;

    /** @var Sustainability|null $Sustainability */
    #[SerializableProperty(type: Sustainability::class)]
    protected ?Sustainability $Sustainability = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        int|string|null $Code = null,
        ?DateTimeInterface $Date = null,
        ?string $Description = null,
        /* @param string[]|null $Options */
        ?array $Options = null,
        ?string $From = null,
        ?string $To = null,
        ?Sustainability $Sustainability = null,
    ) {
        parent::__construct();

        $this->setCode(Code: $Code);
        $this->setDate(date: $Date);
        $this->setDescription(Description: $Description);
        $this->setOptions(Options: $Options);
        $this->setFrom(From: $From);
        $this->setTo(To: $To);
        $this->setSustainability(Sustainability: $Sustainability);
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->Code;
    }

    /**
     * @param string|int|null $Code
     *
     * @return static
     */
    public function setCode(string|int|null $Code): ReasonNoTimeframe
    {
        if (is_int(value: $Code)) {
            $Code = (string) $Code;
        }

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
     * @return DateTimeInterface|null
     *
     */
    public function getDate(): ?DateTimeInterface
    {
        return $this->Date;
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
     * @return Sustainability|null
     *
     * @since 1.4.2
     */
    public function getSustainability(): ?Sustainability
    {
        return $this->Sustainability;
    }

    /**
     * @param Sustainability|null $Sustainability
     *
     * @return static
     *
     * @since 1.4.2
     */
    public function setSustainability(?Sustainability $Sustainability): static
    {
        $this->Sustainability = $Sustainability;

        return $this;
    }

    /**
     * @param stdClass $json
     *
     * @return ReasonNoTimeframe
     * @throws DeserializationException
     * @throws NotSupportedException
     * @throws InvalidConfigurationException
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
}
