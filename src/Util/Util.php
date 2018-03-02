<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
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
 * @author    Michael Dekker <michael@thirtybees.com>
 * @copyright 2017 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Util;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;

/**
 * Class Util
 *
 * @package ThirtyBees\PostNL\Util
 */
class Util
{
    const ERROR_MARGIN = 2;

    /**
     * @param array       $arr    A map of param keys to values.
     * @param string|null $prefix
     *
     * @return string A querystring, essentially.
     */
    public static function urlEncode($arr, $prefix = null)
    {
        if (!is_array($arr)) {
            return $arr;
        }

        $r = [];
        foreach ($arr as $k => $v) {
            if (is_null($v)) {
                continue;
            }

            if ($prefix) {
                if ($k !== null && (!is_int($k) || is_array($v))) {
                    $k = $prefix."[".$k."]";
                } else {
                    $k = $prefix."[]";
                }
            }

            if (is_array($v)) {
                $enc = static::urlEncode($v, $k);
                if ($enc) {
                    $r[] = $enc;
                }
            } else {
                $r[] = urlencode($k)."=".urlencode($v);
            }
        }

        return implode("&", $r);
    }

    /**
     * @param string $pdf     Raw PDF string
     *
     * @return array|false|string Returns an array with the dimensions or ISO size and orientation
     *                            The orientation is in FPDF format, so L for Landscape and P for Portrait
     *                            Sizes are in mm
     */
    public static function getPdfSizeAndOrientation($pdf)
    {
        try {
            $fpdi = new Fpdi('P', 'mm');
            $fpdi->setSourceFile(StreamReader::createByString($pdf));
            // import page 1
            $tplIdx1 = $fpdi->importPage(1);
            $size = $fpdi->getTemplateSize($tplIdx1);
            $width = $size['width'];
            $height = $size['height'];
            $orientation = $size['orientation'];

            $length = $orientation === 'P' ? $height : $width;
            if ($length >= (148 - static::ERROR_MARGIN) && $length <= (148 + static::ERROR_MARGIN)) {
                $iso = 'A6';
            } elseif ($length >= (210 - static::ERROR_MARGIN) && $length <= (210 + static::ERROR_MARGIN)) {
                $iso = 'A5';
            } elseif ($length >= (420 - static::ERROR_MARGIN) && $length <= (420 + static::ERROR_MARGIN)) {
                $iso = 'A3';
            } elseif ($length >= (594 - static::ERROR_MARGIN) && $length <= (594 + static::ERROR_MARGIN)) {
                $iso = 'A2';
            } elseif ($length >= (841 - static::ERROR_MARGIN) && $length <= (841 + static::ERROR_MARGIN)) {
                $iso = 'A1';
            } else {
                $iso = 'A4';
            }
        } catch (\Exception $e) {
            return false;
        }

        return [
            'orientation' => $orientation,
            'iso'         => $iso,
            'width'       => $width,
            'height'      => $height,
        ];
    }
}
