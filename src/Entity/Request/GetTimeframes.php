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

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Cache\CacheableRequestEntityInterface;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Timeframe;
use http\Exception\InvalidArgumentException;

/**
 * @since 1.0.0
 */
class GetTimeframes extends AbstractEntity implements CacheableRequestEntityInterface
{
    /** @var Message|null $Message */
    #[SerializableProperty(type: Message::class)]
    protected ?Message $Message = null;

    /** @var Timeframe[]|null $Timeframe */
    #[SerializableProperty(type: Timeframe::class, isArray: true)]
    protected ?array $Timeframe = null;

    /**
     * @param Message|null $Message
     * @param array|null   $Timeframes
     */
    public function __construct(
        ?Message $Message = null,
        /* @param $Timeframes Timeframe[]|null */
        ?array $Timeframes = null,
    ) {
        parent::__construct();

        $this->setMessage(Message: $Message ?: new Message());
        $this->setTimeframe(timeframes: $Timeframes);
    }

    /**
     * @since 1.0.0
     * @since 1.2.0 Accept singular timeframe object
     */
    public function setTimeframe($timeframes): static
    {
        return $this->setTimeframes(timeframes: $timeframes);
    }

    /**
     * @param $timeframes TimeFrame|Timeframe[]|null
     *
     * @since 1.2.0
     */
    public function setTimeframes(TimeFrame|array|null $timeframes): static
    {
        if ($timeframes instanceof Timeframe) {
            $timeframes = [$timeframes];
        } elseif (is_array(value: $timeframes)) {
            foreach ($timeframes as $timeframe) {
                if (!$timeframe instanceof Timeframe) {
                    throw new InvalidArgumentException(message: 'Expected a Timeframe entity in the array');
                }
            }
        }

        $this->Timeframe = $timeframes;

        return $this;
    }

    /**
     * @return Timeframe[]|null
     *
     * @since 1.0.0
     */
    public function getTimeframe(): ?array
    {
        return $this->getTimeframes();
    }

    /**
     * @return Timeframe[]|null
     *
     * @since 1.2.0
     */
    public function getTimeframes(): ?array
    {
        return $this->Timeframe;
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
     * This method returns a unique cache key for every unique cacheable request as defined by PSR-6.
     *
     * @see https://www.php-fig.org/psr/psr-6/#definitions
     *
     * @return string
     */
    public function getCacheKey(): string
    {
        return hash(
            algo: 'xxh128',
            data: "GetTimeframes.{$this->getTimeframes()[0]->getHouseNr()}",
        );
    }
}
