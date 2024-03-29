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

namespace Firstred\PostNL\Util;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Symfony\Component\Uid\Uuid as SymfonyUuid;

/**
 * Class UUID.
 *
 * @since 1.0.0
 */
class UUID
{
    /**
     * Generate a v4 UUID in RFC 4122 format.
     *
     * @return string
     */
    public static function generate(): string
    {
        if (class_exists(class: SymfonyUuid::class) && method_exists(object_or_class: SymfonyUuid::class, method: 'v4')) {
            return SymfonyUuid::v4()->toRfc4122();
        }

        if (class_exists(class: RamseyUuid::class) && method_exists(object_or_class: RamseyUuid::class, method: 'uuid4')) {
            return RamseyUuid::uuid4()->toString();
        }

        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(min: 0, max: 0xFFFF),
            mt_rand(min: 0, max: 0xFFFF),
            // 16 bits for "time_mid"
            mt_rand(min: 0, max: 0xFFFF),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(min: 0, max: 0x0FFF) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(min: 0, max: 0x3FFF) | 0x8000,
            // 48 bits for "node"
            mt_rand(min: 0, max: 0xFFFF),
            mt_rand(min: 0, max: 0xFFFF),
            mt_rand(min: 0, max: 0xFFFF)
        );
    }
}
