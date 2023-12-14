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

namespace Firstred\PostNL\Exception;

/**
 * Class CifException.
 *
 * Thrown when the CIF API has a fatal error.
 *
 * @since 1.0.0
 */
class CifException extends ApiException
{
    /** @var array */
    protected array $messages;

    /**
     * CifException constructor.
     *
     * @param string|string[] $message  In case of multiple errors, the format looks like:
     *                                  [
     *                                  'description' => string <The description>,
     *                                  'message'     => string <The error message>,
     *                                  'code'        => int <The error code>
     *                                  ]
     *                                  The code param will be discarded if `$message` is an array
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = '', int $code = 0, \Throwable $previous = null)
    {
        if (is_array(value: $message)) {
            $this->messages = $message;

            $message = $this->messages[0]['message'];
            if (!empty($this->messages[0]['description'])) {
                $message .= ' (' . $this->messages[0]['description'] . ')';
            }
            $code = $this->messages[0]['code'];
        } else {
            $this->messages = [
                [
                    'message'     => $message,
                    'description' => $message,
                    'code'        => $code,
                ],
            ];
        }

        parent::__construct(message: $message, code: $code, previous: $previous);
    }

    /**
     * Get error messages and codes.
     *
     * @return array|string|string[]
     */
    public function getMessagesDescriptionsAndCodes(): array|string
    {
        return $this->messages;
    }
}
