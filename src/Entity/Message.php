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

namespace Firstred\PostNL\Entity;

use DateTime;
use Exception;
use Firstred\PostNL\Exception\InvalidTypeException;
use ReflectionClass;
use ReflectionException;
use TypeError;

/**
 * Class Message
 */
class Message extends AbstractEntity
{
    /**
     * ID of the message
     *
     * @pattern ^.{1,21}$
     *
     * @example 1
     *
     * @var string|null $messageID
     *
     * @since 1.0.0
     */
    protected $messageID;

    /**
     * Date/time of sending the message. PHP Format: d-m-Y H:i:s
     *
     * @pattern d-m-Y H:i:s
     *
     * @example 01-01-2019 00:00:00
     *
     * @var string|null $messageTimeStamp
     *
     * @since 1.0.0
     */
    protected $messageTimeStamp;

    /**
     * Message constructor.
     *
     * @param string|null $mid
     * @param string|null $timestamp
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct($mid = null, $timestamp = null)
    {
        parent::__construct();

        $this->setMessageID($mid ?: substr(str_replace('-', '', $this->getid()), 0, 12));
        try {
            $this->setMessageTimeStamp($timestamp ?: (new DateTime())->format('d-m-Y H:i:s'));
        } catch (Exception $e) {
            $this->setMessageTimeStamp('01-01-2019 00:00:00');
        }
    }

    /**
     * Get message ID
     *
     * @return string|null
     *
     * @since 1.0.0
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
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setMessageID(?string $messageID): Message
    {
        static $minLength = 1;
        static $maxLength = 21;
        if (is_string($messageID) && (mb_strlen($messageID) < $minLength) || mb_strlen($messageID) > $maxLength) {
            throw new InvalidTypeException(sprintf('%s::%s - Invalid message ID given, must be between 1 to 21 characters long', (new ReflectionClass($this))->getShortName(), __METHOD__));
        }

        $this->messageID = $messageID;

        return $this;
    }

    /**
     * Get message time stamp
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getMessageTimeStamp(): ?string
    {
        return $this->messageTimeStamp;
    }

    /**
     * Set message time stamp
     *
     * @param string|null $messageTimeStamp
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setMessageTimeStamp(?string $messageTimeStamp): Message
    {
        if (is_string($messageTimeStamp)) {
            $dt = DateTime::createFromFormat('d-m-Y H:i:s', $messageTimeStamp);
            if (false === $dt || array_sum($dt::getLastErrors())) {
                throw new InvalidTypeException(sprintf('%s::%s - Invalid message time stamp given, date format must be `d-m-Y H:i:s`', (new ReflectionClass($this))->getShortName(), __METHOD__));
            }
        }

        $this->messageTimeStamp = $messageTimeStamp;

        return $this;
    }
}
