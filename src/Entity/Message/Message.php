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

namespace Firstred\PostNL\Entity\Message;

use DateTime;
use Exception;
use Firstred\PostNL\Entity\AbstractEntity;

/**
 * Class Message
 */
class Message extends AbstractEntity
{
    /** @var string|null $messageID */
    protected $messageID;
    /** @var string|null $messageTimeStamp */
    protected $messageTimeStamp;

    /**
     * @param string|null $mid
     * @param string|null $timestamp
     *
     * @throws Exception
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct($mid = null, $timestamp = null)
    {
        parent::__construct();

        $this->setMessageID($mid ?: substr(str_replace('-', '', $this->getid()), 0, 12));
        $this->setMessageTimeStamp($timestamp ?: (new DateTime())->format('d-m-Y H:i:s'));
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getMessageID(): ?string
    {
        return $this->messageID;
    }

    /**
     * @param string|null $messageID
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setMessageID(?string $messageID): Message
    {
        $this->messageID = $messageID;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getMessageTimeStamp(): ?string
    {
        return $this->messageTimeStamp;
    }

    /**
     * @param string|null $messageTimeStamp
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setMessageTimeStamp(?string $messageTimeStamp): Message
    {
        $this->messageTimeStamp = $messageTimeStamp;

        return $this;
    }
}
