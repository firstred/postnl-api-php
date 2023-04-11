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

namespace Firstred\PostNL\Clock;

use Psr\Clock\ClockInterface;
use Symfony\Component\Clock\NativeClock;

/**
 * @since 2.0.0
 */
trait ClockAwareTrait
{
    private ClockInterface $clock;

    /**
     * Get the current clock.
     *
     * @return ClockInterface
     *
     * @since 2.0.0
     */
    public function getClock(): ClockInterface
    {
        if (!isset($this->clock) && class_exists(class: NativeClock::class)) {
            $this->clock = new NativeClock();
        }

        return $this->clock;
    }

    /**
     * Set the current clock.
     *
     * @param ClockInterface $clock
     *
     * @return void
     *
     * @since 2.0.0
     */
    public function setClock(ClockInterface $clock): void
    {
        $this->clock = $clock;
    }
}
