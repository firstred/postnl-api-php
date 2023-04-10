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
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Message\Message;

/**
 * @since 1.0.0
 */
class GetSentDateRequest extends AbstractEntity
{
    /** @var GetSentDate|null $GetSentDate */
    #[SerializableProperty(type: GetSentDate::class)]
    protected ?GetSentDate $GetSentDate = null;

    /** @var Message|null $Message */
    #[SerializableProperty(type: Message::class)]
    protected ?Message $Message = null;

    /**
     * @param GetSentDate|null $GetSentDate
     * @param Message|null     $Message
     */
    public function __construct(
        ?GetSentDate $GetSentDate = null,
        ?Message $Message = null
    ) {
        parent::__construct();

        $this->setGetSentDate(GetSentDate: $GetSentDate);
        $this->setMessage(Message: $Message ?: new Message());
    }

    /**
     * @return GetSentDate|null
     */
    public function getGetSentDate(): ?GetSentDate
    {
        return $this->GetSentDate;
    }

    /**
     * @param GetSentDate|null $GetSentDate
     *
     * @return static
     */
    public function setGetSentDate(?GetSentDate $GetSentDate): static
    {
        $this->GetSentDate = $GetSentDate;

        return $this;
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
}
