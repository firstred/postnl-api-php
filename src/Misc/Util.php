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

use function array_keys;
use function count;
use DateInterval;
use DateTime;
use Exception;
use Firstred\PostNL\Exception\InvalidArgumentException;
use function is_array;
use function range;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;

/**
 * Class Util.
 */
class Util
{
    const ERROR_MARGIN = 2;

    /**
     * 3S (or EU Pack Special) countries.
     */
    public static array $threeSCountries = ['AT', 'BE', 'BG', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'NL', 'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'EE'];

    /**
     * A6 positions
     * (index = amount of a6 left on the page).
     */
    public static array $a6positions = [
        4 => [-276, 2],
        3 => [-132, 2],
        2 => [-276, 110],
        1 => [-132, 110],
    ];

    /**
     * @param array       $arr    a map of param keys to values
     * @param string|null $prefix
     *
     * @return string a querystring, essentially
     *
     * @codeCoverageIgnore
     */
    public static function urlEncode(array $arr, string|null $prefix = null): string
    {
        if (!is_array(value: $arr)) {
            return (string) $arr;
        }

        $r = [];
        foreach ($arr as $k => $v) {
            if (is_null(value: $v)) {
                continue;
            }

            if ($prefix) {
                if (null !== $k && (!is_int(value: $k) || is_array(value: $v))) {
                    $k = $prefix.'['.$k.']';
                } else {
                    $k = $prefix.'[]';
                }
            }

            if (is_array(value: $v)) {
                $enc = static::urlEncode(arr: $v, prefix: $k);
                if ($enc) {
                    $r[] = $enc;
                }
            } else {
                $r[] = urlencode(string: $k).'='.urlencode(string: $v);
            }
        }

        return implode(separator: '&', array: $r);
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
            $fpdi->setSourceFile(file: StreamReader::createByString(content: $pdf));
            // import page 1
            $tplIdx1 = $fpdi->importPage(pageNumber: 1);
            $size = $fpdi->getTemplateSize(tpl: $tplIdx1);
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
        } catch (Exception) {
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
    public static function calculateDeliveryDate($deliveryDate, $mondayDelivery = false, $sundayDelivery = false)
    {
        $deliveryDate = new DateTime(datetime: $deliveryDate);

        $holidays = static::getHolidaysForYear(year: date(format: 'Y', timestamp: $deliveryDate->getTimestamp()));

        do {
            $deliveryDate->add(interval: new DateInterval(duration: 'P1D'));
        } while (in_array(needle: $deliveryDate->format(format: 'Y-m-d'), haystack: $holidays)
            || (!$sundayDelivery && 0 == $deliveryDate->format(format: 'w'))
            || (!$mondayDelivery && 1 == $deliveryDate->format(format: 'w'))
        );

        return $deliveryDate->format(format: 'Y-m-d H:i:s');
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
        if (array_sum(array: $days) < 1) {
            throw new InvalidArgumentException(message: 'There should be at least one shipping day');
        }

        $deliveryDate = new DateTime(datetime: $deliveryDate);

        $holidays = static::getHolidaysForYear(year: date(format: 'Y', timestamp: $deliveryDate->getTimestamp()));

        do {
            try {
                $deliveryDate->sub(interval: new DateInterval(duration: 'P1D'));
            } catch (Exception) {
                throw new InvalidArgumentException(message: 'Invalid date provided');
            }
        } while (in_array(needle: $deliveryDate->format(format: 'Y-m-d'), haystack: $holidays)
            || empty($days[$deliveryDate->format(format: 'w')])
        );

        return $deliveryDate->format(format: 'Y-m-d H:i:s');
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
        $shippingDate = date(format: 'Y-m-d 00:00:00', timestamp: strtotime(datetime: $shippingDate));

        // Find the nearest delivery date
        $nearestDeliveryDate = static::calculateDeliveryDate(deliveryDate: $shippingDate);

        // Calculate the interval
        $nearestDeliveryDate = new DateTime(datetime: $nearestDeliveryDate);
        $preferredDeliveryDate = new DateTime(datetime: date(format: 'Y-m-d 00:00:00', timestamp: strtotime(datetime: $preferredDeliveryDate)));

        $daysRemaining = (int) $nearestDeliveryDate->diff(targetObject: $preferredDeliveryDate)->format(format: '%R%a');

        // Subtract an additional day if we cannot ship today (Sunday or holiday)
        if (0 == date(format: 'w', timestamp: strtotime(datetime: $shippingDate)) ||
            in_array(
                needle: date(format: 'Y-m-d', timestamp: strtotime(datetime: $shippingDate)),
                haystack: static::getHolidaysForYear(year: date(format: 'Y', timestamp: strtotime(datetime: $shippingDate)))
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
     *
     * @throws \Exception
     */
    protected static function getHolidaysForYear($year)
    {
        // Avoid holidays
        // Fixed
        $nieuwjaar = new DateTime(datetime: $year.'-01-01');
        $eersteKerstDag = new DateTime(datetime: $year.'-12-25');
        $tweedeKerstDag = new DateTime(datetime: $year.'-12-25');
        $koningsdag = new DateTime(datetime: $year.'-04-27');
        // Dynamic
        $pasen = new DateTime();
        $pasen->setTimestamp(timestamp: easter_date(year: $year)); // thanks PHP!
        $paasMaandag = clone $pasen;
        try {
            $paasMaandag->add(interval: new DateInterVal(duration: 'P1D'));
        } catch (Exception) {
        }
        $hemelvaart = clone $pasen;
        try {
            $hemelvaart->add(interval: new DateInterVal(duration: 'P39D'));
        } catch (Exception) {
        }
        $pinksteren = clone $hemelvaart;
        try {
            $pinksteren->add(interval: new DateInterVal(duration: 'P10D'));
        } catch (Exception) {
        }
        $pinksterMaandag = clone $pinksteren;
        try {
            $pinksterMaandag->add(interval: new DateInterVal(duration: 'P1D'));
        } catch (Exception) {
        }

        return [
            $nieuwjaar->format(format: 'Y-m-d'),
            $pasen->format(format: 'Y-m-d'),
            $koningsdag->format(format: 'Y-m-d'),
            $paasMaandag->format(format: 'Y-m-d'),
            $hemelvaart->format(format: 'Y-m-d'),
            $pinksteren->format(format: 'Y-m-d'),
            $pinksterMaandag->format(format: 'Y-m-d'),
            $eersteKerstDag->format(format: 'Y-m-d'),
            $tweedeKerstDag->format(format: 'Y-m-d'),
        ];
    }

    /**
     * Determine if the array is associative.
     *
     * @param array $array
     *
     * @return bool
     */
    protected static function isAssociativeArray(array $array): bool
    {
        if ([] === $array || !is_array(value: $array)) {
            return false;
        }

        return array_keys(array: $array) !== range(start: 0, end: count(value: $array) - 1);
    }
}
