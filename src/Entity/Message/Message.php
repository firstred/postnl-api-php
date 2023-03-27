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

namespace Firstred\PostNL\Entity\Message;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * @since 1.0.0
 * @deprecated 2.0.0
 */
class Message extends AbstractEntity
{
    /** @var string|null $MessageID */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $MessageID = null;

    /** @var DateTimeInterface|null $MessageTimeStamp */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $MessageTimeStamp = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(?string $MessageID = null, string|DateTimeInterface|null $MessageTimeStamp = null)
    {
        parent::__construct();

        $this->setMessageID(MessageID: $MessageID ?: substr(string: str_replace(search: '-', replace: '', subject: $this->getid()), offset: 0, length: 12));
        try {
            $this->setMessageTimeStamp(MessageTimeStamp: $MessageTimeStamp ?: new DateTimeImmutable(datetime: 'NOW', timezone: new DateTimeZone(timezone: 'Europe/Amsterdam')));
        } catch (Exception $e) {
            throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
        }
    }

    /**
     * @return string|null
     */
    public function getMessageID(): ?string
    {
        return $this->MessageID;
    }

    /**
     * @param string|null $MessageID
     *
     * @return $this
     */
    public function setMessageID(?string $MessageID): static
    {
        $this->MessageID = $MessageID;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getMessageTimeStamp(): ?DateTimeInterface
    {
        return $this->MessageTimeStamp;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setMessageTimeStamp(string|DateTimeInterface|null $MessageTimeStamp = null): static
    {
        if (is_string(value: $MessageTimeStamp)) {
            try {
                $MessageTimeStamp = new DateTimeImmutable(
                    datetime: $MessageTimeStamp,
                    timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'),
                );
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->MessageTimeStamp = $MessageTimeStamp;

        return $this;
    }
}
