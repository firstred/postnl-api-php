<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Misc;

use setasign\Fpdi\Fpdi;

/**
 * Class RFPdi.
 *
 * @credits to haakym on Stack Overflow: https://stackoverflow.com/a/40526456
 *
 * @codeCoverageIgnore
 */
class RFPdi extends Fpdi
{
    public int $angle = 0;

    /**
     * @param int $angle
     */
    public function rotate(int $angle, mixed $x = -1, mixed $y = -1): void
    {
        if (-1 == $x) {
            $x = $this->x;
        }

        if (-1 == $y) {
            $y = $this->y;
        }

        if (0 != $this->angle) {
            $this->_out(s: 'Q');
        }

        $this->angle = $angle;

        if (0 != $angle) {
            $angle *= M_PI / 180;
            $c = cos(num: $angle);
            $s = sin(num: $angle);
            $cx = $x              *$this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(
                s: sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy)
            );
        }
    }

    public function rotateClockWise(): void
    {
        $this->rotate(angle: 270);
    }

    public function rotateCounterClockWise(): void
    {
        $this->rotate(angle: 90);
    }

    public function _endpage(): void
    {
        if (0 != $this->angle) {
            $this->angle = 0;
            $this->_out(s: 'Q');
        }
        parent::_endpage();
    }
}
