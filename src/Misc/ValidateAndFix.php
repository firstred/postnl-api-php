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

namespace Firstred\PostNL\Misc;

use Firstred\PostNL\Exception\InvalidArgumentException;
use League\ISO3166\ISO3166;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use ReflectionClass;
use ReflectionException;

/**
 * Class ValidateAndFix
 */
class ValidateAndFix
{
    /**
     * Validate and fix postcode
     *
     * @param mixed       $postcode
     * @param null|string $countryCode
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function postcode($postcode, $countryCode = null)
    {
        if (is_string($postcode)) {
            $postcode = strtoupper(str_replace(' ', '', $postcode));
            if (!preg_match('/^.{0,17}$/', $postcode)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid zip / postal code given, it can be max 17 characters long', $class, $method));
            }
            if (!empty($countryCode)) {
                if ('NL' === $countryCode) {
                    if (mb_strlen($postcode) !== 6) {
                        list($class, $method) = static::getCaller();
                        throw new InvalidArgumentException(sprintf('%s::%s - Invalid postal code given for NL. It has to consist of 4 numeric characters, followed by 2 letters.', $class, $method));
                    }
                } elseif (in_array($countryCode, ['BE', 'LU'])) {
                    if (!is_numeric($postcode) || mb_strlen($postcode) !== 4) {
                        list($class, $method) = static::getCaller();
                        throw new InvalidArgumentException(sprintf('%s::%s - Invalid postal code given for BE/LU. It has to consist of 4 numeric characters.', $class, $method));
                    }
                }
            }
        }

        return $postcode;
    }

    /**
     * Validate and fix distance
     *
     * @param mixed $distance
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function distance($distance)
    {
        if (is_string($distance) || is_float($distance)) {
            $distance = (int) $distance;
        } elseif (!is_null($distance) && !is_int($distance)) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid distance given, must be int, float, string or null', $class, $method));
        }

        return $distance;
    }

    /**
     * Validate and fix house number
     *
     * @param mixed $houseNumber
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function houseNumber($houseNumber)
    {
        if (is_int($houseNumber) || is_float($houseNumber)) {
            $houseNumber = number_format($houseNumber, 0);
        } elseif (is_string($houseNumber)) {
            if (!is_numeric($houseNumber)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid house number given, must be numeric', $class, $method));
            }
        } elseif (!is_null($houseNumber)) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid house number given, must be int, float, string or null', $class, $method));
        }

        return $houseNumber;
    }

    /**
     * Validate and fix longitude or latitude
     *
     * @param mixed $coordinate
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function coordinate($coordinate)
    {
        if (is_string($coordinate)) {
            $coordinate = (float) $coordinate;
        } elseif (!is_null($coordinate) && !is_int($coordinate) && !is_float($coordinate)) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid coordinate given, must be float, string or null', $class, $method));
        }

        return $coordinate;
    }

    /**
     * Validate and fix address type
     *
     * @param mixed $addressType
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function addressType($addressType)
    {
        if (is_string($addressType) && (!is_numeric($addressType) || mb_strlen($addressType) > 2)) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid address type given, it has to be a numeric string (2 digits) or null', $class, $method));
        }

        if (is_null($addressType)) {
            $addressType = null;
        } else {
            $addressType = str_pad($addressType, 2, '0', STR_PAD_LEFT);
        }

        return $addressType;
    }

    /**
     * Validate and fix area
     *
     * @param mixed $area
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function area($area)
    {
        static $maxLength = 35;
        if (is_string($area) && mb_strlen($area) > $maxLength) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid area given, must be max %d characters long', $class, $method, $maxLength));
        }

        return $area;
    }

    /**
     * Validate and fix building name
     *
     * @param mixed $buildingName
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function buildingName($buildingName)
    {
        static $maxLength = 35;
        if (is_string($buildingName) && mb_strlen($buildingName) > $maxLength) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid building name given, must be max %d characters long', $class, $method, $maxLength));
        }

        return $buildingName;
    }

    /**
     * Validate and fix city name
     *
     * @param mixed $city
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function city($city)
    {
        static $maxLength = 35;
        if (is_string($city) && mb_strlen($city) > $maxLength) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid city given, must be max %d characters long', $class, $method, $maxLength));
        }

        return $city;
    }

    /**
     * Validate and fix company name
     *
     * @param mixed $companyName
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function companyName($companyName)
    {
        static $maxLength = 35;
        if (is_string($companyName) && mb_strlen($companyName) > $maxLength) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid company name given, must be max %d characters long', $class, $method, $maxLength));
        }

        return $companyName;
    }

    /**
     * Validate and fix 2 letter ISO country code
     *
     * @param mixed $countryCode
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function isoAlpha2CountryCode($countryCode)
    {
        if (is_string($countryCode)) {
            $countryCode = strtoupper($countryCode);
            if (class_exists(ISO3166::class) && preg_match('/^[A-Z]{3}$/', $countryCode)) {
                $data = (new ISO3166())->alpha3($countryCode);
                if (isset($data['alpha2'])) {
                    $countryCode = $data['alpha2'];
                } else {
                    list($class, $method) = static::getCaller();
                    throw new InvalidArgumentException(sprintf('%s::%s - Invalid country code given, must be a valid uppercase ISO 3166-1 alpha-2 code', $class, $method));
                }
            }
            if (!preg_match('/^[A-Z]{2}$/', $countryCode)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid country code given, must be a valid uppercase ISO 3166-1 alpha-2 code', $class, $method));
            }
        }

        return $countryCode;
    }

    /**
     * Validate and fix 3 letter ISO country code
     *
     * @param mixed $countryCode
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function isoAlpha3CountryCode($countryCode)
    {
        if (is_string($countryCode)) {
            $countryCode = strtoupper($countryCode);
            if (class_exists(ISO3166::class) && preg_match('/^[A-Z]{2}$/', $countryCode)) {
                $data = (new ISO3166())->alpha2($countryCode);
                if (isset($data['alpha3'])) {
                    $countryCode = $data['alpha3'];
                } else {
                    list($class, $method) = static::getCaller();
                    throw new InvalidArgumentException(sprintf('%s::%s - Invalid country code given, must be a valid uppercase ISO 3166-1 alpha-3 code', $class, $method));
                }
            }
            if (!preg_match('/^[A-Z]{3}$/', $countryCode)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid country code given, must be a valid uppercase ISO 3166-1 alpha-3 code', $class, $method));
            }
        }

        return $countryCode;
    }

    /**
     * Validate and fix NL BE country codes
     *
     * @param mixed $countryCode
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function isoAlpha2CountryCodeNlBe($countryCode)
    {
        if (is_string($countryCode)) {
            $countryCode = strtoupper($countryCode);
            if (!preg_match('/^(?:NL|BE)$/', $countryCode)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid country code given, must be uppercase ISO-2 code', $class, $method));
            }
        }

        return $countryCode;
    }

    /**
     * Validate and fix department name
     *
     * @param mixed $department
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function department($department)
    {
        static $maxLength = 35;
        if (is_string($department) && mb_strlen($department) > $maxLength) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid department given, must be max %d characters long', $class, $method, $maxLength));
        }

        return $department;
    }

    /**
     * Validate and fix doorcode
     *
     * @param mixed $doorcode
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function doorcode($doorcode)
    {
        static $maxLength = 35;
        if (is_string($doorcode) && mb_strlen($doorcode) > $maxLength) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid door code given, must be max %d characters long', $class, $method, $maxLength));
        }

        return $doorcode;
    }

    /**
     * Validate and fix first name
     *
     * @param mixed $firstName
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function firstName($firstName)
    {
        static $maxLength = 35;
        if (is_string($firstName) && mb_strlen($firstName) > $maxLength) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid first name given, must be max %d characters long', $class, $method, $maxLength));
        }

        return $firstName;
    }

    /**
     * Validate and fix last name
     *
     * @param mixed $lastName
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function lastName($lastName)
    {
        static $maxLength = 35;
        if (is_string($lastName) && mb_strlen($lastName) > $maxLength) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid first name given, must be max %d characters long', $class, $method, $maxLength));
        }

        return $lastName;
    }

    /**
     * Validate and fix region
     *
     * @param mixed $region
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function region($region)
    {
        static $maxLength = 35;
        if (is_string($region) && mb_strlen($region) > $maxLength) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid region given, must be max %d characters long', $class, $method, $maxLength));
        }

        return $region;
    }

    /**
     * Validate and fix remark
     *
     * @param mixed $remark
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function remark($remark)
    {
        static $maxLength = 1000;
        if (is_string($remark) && mb_strlen($remark) > $maxLength) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid remark given, must be max %d characters long', $class, $method, $maxLength));
        }

        return $remark;
    }

    /**
     * Validate and fix street name
     *
     * @param mixed $street
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function street($street)
    {
        static $maxLength = 95;
        if (is_string($street) && mb_strlen($street) > $maxLength) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid street given, must be max %d characters long', $class, $method, $maxLength));
        }

        return $street;
    }

    /**
     * Validate and fix street + house number + extension combination
     *
     * @param mixed $streetHouseNrExt
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function streetHouseNumberExtension($streetHouseNrExt)
    {
        static $maxLength = 95;
        if (is_string($streetHouseNrExt) && mb_strlen($streetHouseNrExt) > $maxLength) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid street + house number + extension given, must be max %df characters long', $class, $method, $maxLength));
        }

        return $streetHouseNrExt;
    }

    /**
     * Validate and fix IBAN
     *
     * @param mixed $iban
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function iban($iban)
    {
        if (is_string($iban)) {
            $iban = preg_replace('/\s/', '', $iban);
            if (!preg_match('/^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$/', $iban)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid IBAN given', $class, $method));
            }

            $country = substr($iban, 0, 2);
            $checkInt = intval(substr($iban, 2, 2));
            $account = substr($iban, 4);
            $search = range('A', 'Z');
            $replace = [];
            foreach (range(10, 35) as $tmp) {
                $replace[] = strval($tmp);
            }
            $numStr = str_replace($search, $replace, $account.$country.'00');
            $checksum = intval(substr($numStr, 0, 1));
            $numStrLength = strlen($numStr);
            for ($pos = 1; $pos < $numStrLength; $pos++) {
                $checksum *= 10;
                $checksum += intval(substr($numStr, $pos, 1));
                $checksum %= 97;
            }

            if ((98 - $checksum) !== $checkInt) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid IBAN given', $class, $method));
            }
        }

        return $iban;
    }

    /**
     * Validate and fix BIC
     *
     * @param mixed $bic
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function bic($bic)
    {
        static $minLength = 8;
        static $maxLength = 11;
        if (is_string($bic)) {
            $bic = preg_replace('/\s/', '', $bic);
            if (mb_strlen($bic) < $minLength || mb_strlen($bic) > $maxLength) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid BIC given, must be %d to %d characters long', $class, $method, $minLength, $maxLength));
            }
            if (!preg_match('/^[a-z]{6}[0-9a-z]{2}([0-9a-z]{3})?\z/i', $bic)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid BIC given', $class, $method));
            }
        }

        return $bic;
    }

    /**
     * Validate and fix bank account name
     *
     * @param mixed $accountName
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function bankAccountName($accountName)
    {
        static $maxLength = 35;
        if (is_string($accountName) && mb_strlen($accountName) > $maxLength) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid account name given, must be max %d characters long', $class, $method, $maxLength));
        }

        return $accountName;
    }

    /**
     * Validate and fix currency iso code
     *
     * @param mixed $currency
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function currency($currency)
    {
        if (is_string($currency)) {
            $currency = strtoupper($currency);
            if (!preg_match('/^[A-Z]{3}$/', $currency)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid currency code given, must be three uppercase characters', $class, $method));
            }
        }

        return $currency;
    }

    /**
     * Validate and fix reference
     *
     * @param string $reference
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function reference($reference)
    {
        static $maxLength = 35;
        if (is_string($reference) && mb_strlen($reference) > $maxLength) {
            list ($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid reference given, must be max %d characters long', $class, $method, $maxLength));
        }

        return $reference;
    }

    /**
     * Validate and fix transaction number
     *
     * @param mixed $transactionNumber
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function transactionNumber($transactionNumber)
    {
        $maxLength = 35;
        if (is_string($transactionNumber) && mb_strlen($transactionNumber) > $maxLength) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid transaction number given, must be max %d characters long', $class, $method, $maxLength));
        }

        return $transactionNumber;
    }

    /**
     * Validate and fix amount value
     *
     * @param mixed $value
     *
     * @return string
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function amountValue($value)
    {
        if (is_float($value) || is_int($value)) {
            $value = number_format($value, 2, '.', '');
        }
        if (is_string($value) && !preg_match('/^\d{1,6}\.\d{2}$/', $value)) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid value given, must be a decimal with the format #####0.00', $class, $method));
        }
        if (!is_string($value) && !is_null($value)) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid value given, must be a string, float or null', $class, $method));
        }

        return $value;
    }

    /**
     * Validate and fix amount type
     *
     * @param mixed $amountType
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function amountType($amountType)
    {
        static $length = 2;
        if (is_null($amountType)) {
            $amountType = null;
        } elseif (is_int($amountType) || is_string($amountType)) {
            $amountType = str_pad($amountType, $length, '0', STR_PAD_LEFT);
        } else {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid amount type given, must be a string, integer or null', $class, $method));
        }
        if (is_string($amountType) && mb_strlen($amountType) !== $length) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid amount type given, must be %d characters long', $class, $method, $length));
        }

        return $amountType;
    }

    /**
     * Validate and fix barcode type
     *
     * @param mixed $type
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function barcodeType($type)
    {
        if (is_string($type) && !in_array($type, ['2S', '3S', 'CC', 'CP', 'CD', 'CF', 'LA', 'CX'])) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid barcode type given, must be one of: 2S, 3S, CC, CP, CD, CF, LA, CX', $class, $method));
        }

        return $type;
    }

    /**
     * Validate and fix barcode serie
     *
     * @param mixed $serie
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function barcodeSerie($serie)
    {
        if (is_string($serie)) {
            $serie = trim($serie);
            if (!preg_match('/^\d{0,3}\d{6}-\d{0,3}\d{6}$/', $serie)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid serie given, must have the format ###000000-###000000', $class, $method));
            }
        }

        return $serie;
    }

    /**
     * Validate and fix barcode range
     *
     * @param mixed $range
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function barcodeRange($range)
    {
        if (is_string($range)) {
            $range = trim($range);
            if (!preg_match('/^[A-Z0-9]{1,4}$/', $range)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid barcode range given', $class, $method));
            }
        }

        return $range;
    }

    /**
     * Validate and fix email address
     *
     * @param mixed $email
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function email($email)
    {
        static $maxLength = 50;
        if (is_string($email)) {
            if (mb_strlen($email) > $maxLength) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid email given, must be max %d characters long', $class, $method, $maxLength));
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid email given', $class, $method));
            }
        }

        return $email;
    }

    /**
     * Validate and fix telephone number
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
    public static function telephoneNumber($number, string $countryCode)
    {
        static $minLength = 10;
        static $maxLength = 17;
        if (is_string($number)) {
            if (mb_strlen($number) < $minLength || mb_strlen($number) > $maxLength) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(

                    sprintf('%s::%s - Invalid SMS number given, must be between %d to %d characters', $class, $method, $minLength, $maxLength)
                );
            }
            if (class_exists(PhoneNumberUtil::class)) {
                $util = PhoneNumberUtil::getInstance();
                $phoneNumber = $util->parse($number, mb_strtoupper($countryCode));
                $number = $util->format($phoneNumber, PhoneNumberFormat::E164);
            }
        }

        return $number;
    }

    /**
     * Validate and fix contact type
     *
     * @param mixed $contactType
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function contactType($contactType)
    {
        static $length = 2;
        if (is_int($contactType) || is_string($contactType) && mb_strlen($contactType) === 1) {
            $contactType = str_pad($contactType, 2, '0', STR_PAD_LEFT);
        }
        if (is_string($contactType) && mb_strlen($contactType) !== $length) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid contact type given, must be precisely %d characters long', $class, $method, $length));
        }

        return $contactType;
    }

    /**
     * Validate and fix harmonized system tariff number
     *
     * @param mixed $number
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function harmonizedSystemTariffNumber($number)
    {
        if (is_int($number) || is_float($number)) {
            $number = str_pad((int) $number, 6, '0', STR_PAD_LEFT);
        }
        if (is_string($number)) {
            $number = substr($number, 0, 6);
            if (!preg_match('/^\d{6}$/', $number)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid HS tariff number, must be the first 6 digits', $class, $method));
            }
        }

        return $number;
    }

    /**
     * Validate and fix numeric string
     *
     * @param mixed $number
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function numericString($number)
    {
        if (is_int($number)) {
            $number = (string) $number;
        } elseif (is_float($number)) {
            $number = number_format($number, 0, '', '');
        } elseif (!is_null($number) && !is_string($number)) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid quantity given, must be an int, float, string or null', $class, $method));
        }

        return $number;
    }

    /**
     * Validate and fix integer value
     *
     * @param mixed $integer
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function integer($integer)
    {
        if (is_string($integer)) {
            $integer = (int) $integer;
        }
        if (is_float($integer)) {
            $integer = (int) round($integer, 0);
        } elseif (!is_null($integer) && !is_int($integer)) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid quantity given, must be an int, float, string or null', $class, $method));
        }

        return $integer;
    }

    /**
     * Validate and fix float value
     *
     * @param mixed $float
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function float($float)
    {
        if (is_string($float)) {
            $float = number_format($float, 2, '', '');
        } if (is_int($float)) {
            $float = (float) $float;
        } elseif (!is_null($float) && !is_float($float)) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid float given, must be an int, float, string or null', $class, $method));
        }

        return $float;
    }

    /**
     * Validate and fix description
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
    public static function genericString($description, int $maxLength = 35)
    {
        if (is_string($description) && mb_strlen($description) > $maxLength) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid string given, must be max %d characters long', $class, $method, $maxLength));
        }

        return $description;
    }

    /**
     * Validate and fix EAN-8 or EAN-13
     *
     * @param mixed $ean
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function ean($ean)
    {
        if (is_string($ean)) {
            $sumEvenIndexes = 0;
            $sumOddIndexes = 0;
            $eanAsArray = array_map('intval', str_split($ean));
            if (strlen($ean) === 13) {
                for ($i = 0; $i < count($eanAsArray) - 1; $i++) {
                    if ($i % 2 === 0) {
                        $sumOddIndexes += $eanAsArray[$i];
                    } else {
                        $sumEvenIndexes += $eanAsArray[$i];
                    }
                }
                $rest = ($sumOddIndexes + (3 * $sumEvenIndexes)) % 10;
                if (0 !== $rest) {
                    $rest = 10 - $rest;
                }

                if ($rest !== $eanAsArray[12]) {
                    list($class, $method) = static::getCaller();
                    throw new InvalidArgumentException(sprintf('%s::%s - Invalid EAN-13 code given', $class, $method));
                }
            } elseif (strlen($ean) !== 8) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid EAN given, only EAN-8 and EAN-13 are accepted', $class, $method));
            }
        }

        return $ean;
    }

    /**
     * Validate url
     *
     * @param mixed $url
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function url($url)
    {
        if (is_string($url)) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid url  given', $class, $method));
            }
        }

        return $url;
    }

    /**
     * Validate and fix customer code
     *
     * @param mixed $code
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function customerCode($code)
    {
        if (is_string($code)) {
            $code = trim($code);
            if (!preg_match('/^[A-Z]{4}$/', $code)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid customer code given, must be 4 characters', $class, $method));
            }
        }

        return $code;
    }

    /**
     * Validate and fix customer number
     *
     * @param mixed $customerNumber
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function customerNumber($customerNumber)
    {
        static $length = 8;
        if (is_string($customerNumber) && mb_strlen($customerNumber) !== $length) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid customer number given, must be 8 characters long', $class, $method));
        }

        return $customerNumber;
    }

    /**
     * Validate and fix time
     *
     * @param mixed $time
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function time($time)
    {
        if (is_string($time)) {
            $time = trim($time);
            if (preg_match('/^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9])$/', $time)) {
                $time .= ':00';
            }
            if (!preg_match('/^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$/', $time)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid time given, format must be H:i:s', $class, $method));
            }
        }

        return $time;
    }

    /**
     * Validate and fix time
     *
     * @param mixed $timeRange
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function timeRangeShort($timeRange)
    {
        if (is_string($timeRange)) {
            $timeRange = trim($timeRange);
            if (!preg_match('/^[0-2][0-9]:[0-5][0-9]-[0-2][0-9]:[0-5][0-9]$/', $timeRange)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid short time range given, format must be H:i-H:i', $class, $method));
            }
        }

        return $timeRange;
    }

    /**
     * Validate and fix date
     *
     * @param mixed $date
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function date($date)
    {
        if (is_string($date)) {
            $date = trim($date);
            if (date('d-m-Y', strtotime($date)) !== $date) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid date given, format must be d-m-Y', $class, $method));
            }
        }

        return $date;
    }

    /**
     * Validate and fix datetime
     *
     * @param mixed $dateTime
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function dateTime($dateTime)
    {
        if (is_string($dateTime)) {
            $dateTime = trim($dateTime);
            if (date('d-m-Y H:i:s', strtotime($dateTime)) !== $dateTime) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid datetime given, format must be d-m-Y H:i:s', $class, $method));
            }
        }

        return $dateTime;
    }

    /**
     * Validate day of the week
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
    public static function dayOfTheWeek($day)
    {
        static $length = 2;
        if (is_int($day) || is_float($day)) {
            $day = str_pad(number_format($day, 0), 2, '0', STR_PAD_LEFT);
        }
        if (is_string($day) && mb_strlen($day) !== $length) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid day given, must be exactly 2 characters long', $class, $method));
        }

        return $day;
    }

    /**
     * Validate group type
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
    public static function numericType($type)
    {
        static $length = 2;
        if (is_int($type) || is_float($type)) {
            $type = str_pad(number_format($type, 0), 2, '0', STR_PAD_LEFT);
        }
        if (is_string($type) && mb_strlen($type) !== $length) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid numeric type given, must be exactly 2 characters long', $class, $method));
        }

        return $type;
    }

    /**
     * Validate and fix group count
     *
     * @param mixed $groupCount
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function groupCount($groupCount)
    {
        if (is_int($groupCount) || is_float($groupCount)) {
            $groupCount = number_format($groupCount, 0);
        } elseif (is_string($groupCount)) {
            if (!is_numeric($groupCount)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid group count given, must be numeric', $class, $method));
            }
        } elseif (!is_null($groupCount)) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid group count given, must be int, float, string or null', $class, $method));
        }

        return $groupCount;
    }

    /**
     * Validate and fix barcode
     *
     * @param mixed $barcode
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function barcode($barcode)
    {
        if (is_string($barcode)) {
            $barcode = trim($barcode);
            if (!preg_match('/^[A-Z0-9]{11,15}$/', $barcode)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid barcode given', $class, $method));
            }
        }

        return $barcode;
    }

    /**
     * Validate and fix product option
     *
     * @param mixed $productOption
     *
     * @return string
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function productOption($productOption)
    {
        if (is_int($productOption) || is_float($productOption)) {
            $productOption = str_pad($productOption, 3, '0', STR_PAD_LEFT);
        }
        if (is_string($productOption)) {
            if (3 !== strlen($productOption)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid product option given, must consist of 3 digits', $class, $method));
            }
        } elseif (!is_null($productOption)) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid product option given, must consist of 3 digits', $class, $method));
        }

        return $productOption;
    }

    /**
     * Validate and fix product code
     *
     * @param mixed $productCode
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function productCode($productCode)
    {
        if (is_float($productCode) || is_int($productCode)) {
            $productCode = str_pad((int) $productCode, 4, '0', STR_PAD_LEFT);
        }
        if (is_string($productCode)) {
            if (4 !== strlen($productCode)) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid product code given, must be 4 digits or null', $class, $method));
            }
        } elseif (!is_null($productCode)) {
            list($class, $method) = static::getCaller();
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid product code given, must be 4 digits or null', $class, $method));
        }

        return $productCode;
    }

    /**
     * Validate and fix interval
     *
     * @param mixed $interval
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function interval($interval)
    {
        if (is_int($interval)) {
            if (!in_array($interval, [30, 60])) {
                list($class, $method) = static::getCaller();
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid interval given, must be 30 or 60', $class, $method));
            }
        }

        return $interval;
    }

    /**
     * Get calling class info
     *
     * @return array
     *
     * @since 2.0.0
     */
    private static function getCaller()
    {
        $trace = debug_backtrace()[2];

        try {
            $class = (new ReflectionClass($trace['class']))->getShortName();
        } catch (ReflectionException $e) {
            $class = $trace['class'];
        }

        return [$class, $trace['function']];
    }
}
