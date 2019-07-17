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
use Firstred\PostNL\Entity\Message\Message;

/**
 * Class GetSentDateRequest
 */
class GetSentDateRequest extends AbstractEntity
{
    /** @var GetSentDate|null $getSentDate */
    protected $getSentDate;
    /** @var Message|null $message */
    protected $message;

    /**
     * GetSentDate constructor.
     *
     * @param GetSentDate|null $date
     * @param Message|null     $message
     *
     * @throws Exception
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(GetSentDate $date = null, Message $message = null)
    {
        parent::__construct();

        $this->setGetSentDate($date);
        $this->setMessage($message ?: new Message());
    }

    /**
     * @return GetSentDate|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getGetSentDate(): ?GetSentDate
    {
        return $this->getSentDate;
    }

    /**
     * @param GetSentDate|null $getSentDate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setGetSentDate(?GetSentDate $getSentDate): GetSentDateRequest
    {
        $this->getSentDate = $getSentDate;

        return $this;
    }

    /**
     * @return Message|null
     *
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
     * @since 2.0.0 Strict typing
     */
    public function setMessage(?Message $message): GetSentDateRequest
    {
        $this->message = $message;

        return $this;
    }
}
