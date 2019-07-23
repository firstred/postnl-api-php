<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Request;

use Exception;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Message;
use Firstred\PostNL\Entity\Timeframe;
use TypeError;

/**
 * Class GetTimeframes
 */
class GetTimeframes extends AbstractEntity
{
    /**
     * @var Message|null $message
     *
     * @since 1.0.0
     */
    protected $message;

    /**
     * @var Timeframe[]|null $timeframe
     *
     * @since 1.0.0
     */
    protected $timeframe;

    /**
     * GetTimeframes constructor.
     *
     * @param Message|null     $message
     * @param Timeframe[]|null $timeframes
     *
     * @throws Exception
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typingq
     */
    public function __construct(Message $message = null, array $timeframes = null)
    {
        parent::__construct();

        $this->setMessage($message ?: new Message());
        $this->setTimeframe($timeframes);
    }

    /**
     * @return Message|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getMessage(): ?Message
    {
        return $this->message;
    }

    /**
     * @param Message|null $message
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setMessage(?Message $message): GetTimeframes
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return Timeframe[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getTimeframe(): ?array
    {
        return $this->timeframe;
    }

    /**
     * @param Timeframe[]|null $timeframe
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setTimeframe(?array $timeframe): GetTimeframes
    {
        $this->timeframe = $timeframe;

        return $this;
    }
}
