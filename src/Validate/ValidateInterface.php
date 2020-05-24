<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
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
 * @copyright 2017-2019 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Validate;

use Firstred\PostNL\Exception\InvalidArgumentException;
use libphonenumber\NumberParseException;

/**
 * Interface ValidateInterface.
 */
interface ValidateInterface
{
    /**
     * Validate and fix postcode.
     *
     * @param mixed       $postcode
     * @param string|null $countryCode
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function postcode($postcode, $countryCode = null);

    /**
     * Validate and fix distance.
     *
     * @param mixed $distance
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function distance($distance);

    /**
     * Validate and fix house number.
     *
     * @param mixed $houseNumber
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function houseNumber($houseNumber);

    /**
     * Validate and fix longitude or latitude.
     *
     * @param mixed $coordinate
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function coordinate($coordinate);

    /**
     * Validate and fix address type.
     *
     * @param mixed $addressType
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function addressType($addressType);

    /**
     * Validate and fix area.
     *
     * @param mixed $area
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function area($area);

    /**
     * Validate and fix building name.
     *
     * @param mixed $buildingName
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function buildingName($buildingName);

    /**
     * Validate and fix city name.
     *
     * @param mixed $city
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function city($city);

    /**
     * Validate and fix company name.
     *
     * @param mixed $companyName
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function companyName($companyName);

    /**
     * Validate and fix 2 letter ISO country code.
     *
     * @param mixed $countryCode
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function isoAlpha2CountryCode($countryCode);

    /**
     * Validate and fix 3 letter ISO country code.
     *
     * @param mixed $countryCode
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function isoAlpha3CountryCode($countryCode);

    /**
     * Validate and fix NL BE country codes.
     *
     * @param mixed $countryCode
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function isoAlpha2CountryCodeNlBe($countryCode);

    /**
     * Validate and fix department name.
     *
     * @param mixed $department
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function department($department);

    /**
     * Validate and fix doorcode.
     *
     * @param mixed $doorcode
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function doorcode($doorcode);

    /**
     * Validate and fix first name.
     *
     * @param mixed $firstName
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function firstName($firstName);

    /**
     * Validate and fix last name.
     *
     * @param mixed $lastName
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function lastName($lastName);

    /**
     * Validate and fix region.
     *
     * @param mixed $region
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function region($region);

    /**
     * Validate and fix remark.
     *
     * @param mixed $remark
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function remark($remark);

    /**
     * Validate and fix street name.
     *
     * @param mixed $street
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function street($street);

    /**
     * Validate and fix street + house number + extension combination.
     *
     * @param mixed $streetHouseNrExt
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function streetHouseNumberExtension($streetHouseNrExt);

    /**
     * Validate and fix IBAN.
     *
     * @param mixed $iban
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function iban($iban);

    /**
     * Validate and fix BIC.
     *
     * @param mixed $bic
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function bic($bic);

    /**
     * Validate and fix bank account name.
     *
     * @param mixed $accountName
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function bankAccountName($accountName);

    /**
     * Validate and fix currency iso code.
     *
     * @param mixed $currency
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function currency($currency);

    /**
     * Validate and fix reference.
     *
     * @param string $reference
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function reference($reference);

    /**
     * Validate and fix transaction number.
     *
     * @param mixed $transactionNumber
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function transactionNumber($transactionNumber);

    /**
     * Validate and fix amount value.
     *
     * @param mixed $value
     *
     * @return string
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function amountValue($value);

    /**
     * Validate and fix amount type.
     *
     * @param mixed $amountType
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function amountType($amountType);

    /**
     * Validate and fix email address.
     *
     * @param mixed $email
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function email($email);

    /**
     * Validate and fix telephone number.
     *
     * @param mixed  $number
     * @param string $countryCode
     *
     * @return mixed
     *
     * @throws NumberParseException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function telephoneNumber($number, string $countryCode);

    /**
     * Validate and fix contact type.
     *
     * @param mixed $contactType
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function contactType($contactType);

    /**
     * Validate and fix harmonized system tariff number.
     *
     * @param mixed $number
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function harmonizedSystemTariffNumber($number);

    /**
     * Validate and fix numeric string.
     *
     * @param mixed $number
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function numericString($number);

    /**
     * Validate and fix integer value.
     *
     * @param mixed $integer
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function integer($integer);

    /**
     * Validate and fix float value.
     *
     * @param mixed $float
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function float($float);

    /**
     * Validate and fix EAN-8 or EAN-13.
     *
     * @param mixed $ean
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function ean($ean);

    /**
     * Validate url.
     *
     * @param mixed $url
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function url($url);

    /**
     * Validate and fix time.
     *
     * @param mixed $time
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function time($time);

    /**
     * Validate and fix time.
     *
     * @param mixed $timeRange
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function timeRangeShort($timeRange);

    /**
     * Validate and fix date.
     *
     * @param mixed $date
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function date($date);

    /**
     * Validate and fix datetime.
     *
     * @param mixed $dateTime
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function dateTime($dateTime);

    /**
     * Validate day of the week.
     *
     * @pattern ^\d{2}$
     *
     * @param mixed $day
     *
     * @return string
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     */
    public function dayOfTheWeek($day);

    /**
     * Validate group type.
     *
     * @pattern ^\d{2}$
     *
     * @param mixed $type
     *
     * @return string
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     */
    public function numericType($type);

    /**
     * Validate and fix group count.
     *
     * @param mixed $groupCount
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function groupCount($groupCount);

    /**
     * Validate and fix product option.
     *
     * @param mixed $productOption
     *
     * @return string
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function productOption($productOption);

    /**
     * Validate and fix product code.
     *
     * @param mixed $productCode
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function productCode($productCode);

    /**
     * Validate and fix interval.
     *
     * @param mixed $interval
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function interval($interval);

    /**
     * Validate and fix description.
     *
     * @param mixed $description
     * @param int   $maxLength
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function genericString($description, int $maxLength = 35);

    /**
     * Validate and fix full barcode.
     *
     * @param mixed $barcode
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function barcode($barcode);

    /**
     * Validate and fix barcode type.
     *
     * @param mixed $type
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function barcodeType($type);

    /**
     * Validate and fix barcode serie.
     *
     * @param mixed $serie
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function barcodeSerie($serie);

    /**
     * Validate and fix barcode range.
     *
     * @param mixed $range
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function barcodeRange($range);

    /**
     * Validate and fix customer code.
     *
     * @param mixed $code
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function customerCode($code);

    /**
     * Validate and fix customer number.
     *
     * @param mixed $customerNumber
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function customerNumber($customerNumber);
}
