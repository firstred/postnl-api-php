<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2022 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2022 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Util;

use DateInterVal;
use DateTime;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Exception\InvalidArgumentException;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;

/**
 * Class Util.
 */
class Util
{
    const ERROR_MARGIN = 2;

    /**
     * @param array       $arr a map of param keys to values
     * @param string|null $prefix
     *
     * @return string a querystring, essentially
     *
     * @codeCoverageIgnore
     */
    public static function urlEncode($arr, $prefix = null)
    {
        if (!is_array($arr)) {
            return (string) $arr;
        }

        $r = [];
        foreach ($arr as $k => $v) {
            if (is_null($v)) {
                continue;
            }

            if ($prefix) {
                if (null !== $k && (!is_int($k) || is_array($v))) {
                    $k = $prefix.'['.$k.']';
                } else {
                    $k = $prefix.'[]';
                }
            }

            if (is_array($v)) {
                $enc = static::urlEncode($v, $k);
                if ($enc) {
                    $r[] = $enc;
                }
            } else {
                $r[] = urlencode($k).'='.urlencode($v);
            }
        }

        return implode('&', $r);
    }

    /**
     * @param string $pdf Raw PDF string
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

            $length = 'P' === $orientation ? $height : $width;
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
        } catch (Exception $e) {
            return false;
        }

        return [
            'orientation' => $orientation,
            'iso'         => $iso,
            'width'       => $width,
            'height'      => $height,
        ];
    }

    /**
     * Offline delivery date calculation.
     *
     * @param string $deliveryDate   Delivery date in any format accepted by DateTime
     * @param bool   $mondayDelivery Sunday sorting/Monday delivery enabled
     * @param bool   $sundayDelivery Sunday delivery enabled
     *
     * @return string (format: `Y-m-d H:i:s`)
     *
     * @throws Exception
     */
    public static function getDeliveryDate($deliveryDate, $mondayDelivery = false, $sundayDelivery = false)
    {
        $deliveryDate = new DateTime($deliveryDate, new DateTimeZone('Europe/Amsterdam'));

        $holidays = static::getHolidaysForYear(date('Y', $deliveryDate->getTimestamp()));

        do {
            $deliveryDate->add(new DateInterval('P1D'));
        } while (in_array($deliveryDate->format('Y-m-d'), $holidays)
        || (!$sundayDelivery && 0 == $deliveryDate->format('w'))
        || (!$mondayDelivery && 1 == $deliveryDate->format('w'))
        );

        return $deliveryDate->format('Y-m-d H:i:s');
    }

    /**
     * Offline shipping date calculation.
     *
     * @param string $deliveryDate
     * @param array  $days
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public static function getShippingDate(
        $deliveryDate,
        $days = [0 => false, 1 => true, 2 => true, 3 => true, 4 => true, 5 => true, 6 => true]
    ) {
        if (array_sum($days) < 1) {
            throw new InvalidArgumentException('There should be at least one shipping day');
        }

        $deliveryDate = new DateTime($deliveryDate, new DateTimeZone('Europe/Amsterdam'));

        $holidays = static::getHolidaysForYear(date('Y', $deliveryDate->getTimestamp()));

        do {
            try {
                $deliveryDate->sub(new DateInterval('P1D'));
            } catch (Exception $e) {
                throw new InvalidArgumentException('Invalid date provided');
            }
        } while (in_array($deliveryDate->format('Y-m-d'), $holidays)
        || empty($days[$deliveryDate->format('w')])
        );

        return $deliveryDate->format('Y-m-d H:i:s');
    }

    /**
     * Calculates amount of days remaining
     * i.e. preferred delivery date the day tomorrow => today = 0
     * i.e. preferred delivery date the day after tomorrow => today + tomorrow = 1
     * i.e. preferred delivery date the day after tomorrow, but one holiday => today + holiday = 0.
     *
     * 0 means: should ship today
     * < 0 means: should've shipped in the past
     * anything higher means: you've got some more time
     *
     * @param string $shippingDate          Shipping date (format: `Y-m-d H:i:s`)
     * @param string $preferredDeliveryDate Customer preference
     *
     * @return int
     *
     * @throws Exception
     */
    public static function getShippingDaysRemaining($shippingDate, $preferredDeliveryDate)
    {
        // Remove the hours/minutes/seconds
        $shippingDate = date('Y-m-d 00:00:00', strtotime($shippingDate));

        // Find the nearest delivery date
        $nearestDeliveryDate = static::getDeliveryDate($shippingDate);

        // Calculate the interval
        $nearestDeliveryDate = new DateTime($nearestDeliveryDate, new DateTimeZone('Europe/Amsterdam'));
        $preferredDeliveryDate = new DateTime(
            date('Y-m-d 00:00:00', strtotime($preferredDeliveryDate)),
            new DateTimeZone('Europe/Amsterdam')
        );

        $daysRemaining = (int) $nearestDeliveryDate->diff($preferredDeliveryDate)->format('%R%a');

        // Subtract an additional day if we cannot ship today (Sunday or holiday)
        if (0 == date('w', strtotime($shippingDate)) ||
            in_array(
                date('Y-m-d', strtotime($shippingDate)),
                static::getHolidaysForYear(date('Y', strtotime($shippingDate)))
            )
        ) {
            --$daysRemaining;
        }

        return $daysRemaining;
    }

    /**
     * Get an array with all Dutch holidays for the given year.
     *
     * @param string $year
     *
     * @return array
     *
     * Credits to @tvlooy (https://gist.github.com/tvlooy/1894247)
     */
    protected static function getHolidaysForYear($year)
    {
        // Avoid holidays
        // Fixed
        $nieuwjaar = new DateTime($year.'-01-01', new DateTimeZone('Europe/Amsterdam'));
        $eersteKerstDag = new DateTime($year.'-12-25', new DateTimeZone('Europe/Amsterdam'));
        $tweedeKerstDag = new DateTime($year.'-12-25', new DateTimeZone('Europe/Amsterdam'));
        $koningsdag = new DateTime($year.'-04-27', new DateTimeZone('Europe/Amsterdam'));
        // Dynamic
        $pasen = new DateTime('NOW', new DateTimeZone('Europe/Amsterdam'));
        $pasen->setTimestamp(easter_date($year)); // thanks PHP!
        $paasMaandag = clone $pasen;
        $paasMaandag->add(new DateInterVal('P1D'));
        $hemelvaart = clone $pasen;
        $hemelvaart->add(new DateInterVal('P39D'));
        $pinksteren = clone $hemelvaart;
        $pinksteren->add(new DateInterVal('P10D'));
        $pinksterMaandag = clone $pinksteren;
        $pinksterMaandag->add(new DateInterVal('P1D'));

        $holidays = [
            $nieuwjaar->format('Y-m-d'),
            $pasen->format('Y-m-d'),
            $koningsdag->format('Y-m-d'),
            $paasMaandag->format('Y-m-d'),
            $hemelvaart->format('Y-m-d'),
            $pinksteren->format('Y-m-d'),
            $pinksterMaandag->format('Y-m-d'),
            $eersteKerstDag->format('Y-m-d'),
            $tweedeKerstDag->format('Y-m-d'),
        ];

        return $holidays;
    }

    public static function compareGuzzleVersion($a, $b)
    {
        $a = str_replace('.', '', $a);
        $b = str_replace('.', '', $b);

        $len = max(array(strlen($a), strlen($b)));

        $a = (int) str_pad($a, $len, '0', STR_PAD_RIGHT);
        $b = (int) str_pad($b, $len, '0', STR_PAD_RIGHT);

        if ($a === $b) {
            return  0;
        } elseif ($a > $b) {
            return 1;
        }
        return -1;
    }
}
