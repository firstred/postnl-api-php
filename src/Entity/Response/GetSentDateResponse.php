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

namespace Firstred\PostNL\Entity\Response;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * @since 1.0.0
 */
class GetSentDateResponse extends AbstractEntity
{
    /** @var DateTimeInterface|null $SentDate */
    #[SerializableProperty(type: DateTimeInterface::class)]
    protected ?DateTimeInterface $SentDate = null;

    /** @var string[]|null $Options */
    #[SerializableProperty(type: 'string', isArray: true)]
    protected ?array $Options = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?DateTimeInterface $GetSentDate = null,
        /*  @param string[]|null $Options */
        array $Options = null,
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
     * @return DateTimeInterface|null
     */
    public function getSentDate(): ?DateTimeInterface
    {
        return $this->SentDate;
    }
}
