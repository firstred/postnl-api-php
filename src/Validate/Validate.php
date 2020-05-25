<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Validate;

use Firstred\PostNL\Exception\InvalidArgumentException;
use League\ISO3166\ISO3166;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

/**
 * Class Validate.
 */
class Validate implements ValidateInterface
{
    /** @var array */
    private $postcodeFormats;

    /** @var array */
    private $barcodeTypes;

    /** @var string */
    private $barcodeFullFormat;

    /** @var string */
    private $barcodeRangeFormat;

    /** @var string */
    private $barcodeSerieFormat;

    /**
     * Validate constructor.
     *
     * @since 2.0.0
     */
    public function __construct(array $postcodeFormats, array $barcodeTypes, string $barcodeFullFormat, string $barcodeRangeFormat, string $barcodeSerieFormat)
    {
        $this->postcodeFormats = $postcodeFormats;
        $this->barcodeTypes = $barcodeTypes;
        $this->barcodeFullFormat = $barcodeFullFormat;
        $this->barcodeRangeFormat = $barcodeRangeFormat;
        $this->barcodeSerieFormat = $barcodeSerieFormat;
    }

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
    public function postcode($postcode, $countryCode = null)
    {
        if (is_string($postcode)) {
            $postcode = strtoupper(str_replace(' ', '', $postcode));
            if (!preg_match($this->postcodeFormats['_default'], $postcode)) {
                throw new InvalidArgumentException('Invalid zip / postal code given, it can be max 17 characters long');
            }
            if (!empty($countryCode)) {
                $countryFormat = $this->postcodeFormats[strtoupper($countryCode)] ?? '';
                if ($countryFormat && !preg_match($countryFormat, $postcode)) {
                    throw new InvalidArgumentException(sprintf('Invalid postal code given for %s. It should have the format `%s`.', strtoupper($countryCode), $countryFormat));
                }
            }
        }

        return $postcode;
    }

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
    public function distance($distance)
    {
        if (is_string($distance) || is_float($distance)) {
            $distance = (int) $distance;
        } elseif (!is_null($distance) && !is_int($distance)) {
            throw new InvalidArgumentException('Invalid distance given, must be int, float, string or null');
        }

        return $distance;
    }

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
    public function houseNumber($houseNumber)
    {
        if (is_int($houseNumber) || is_float($houseNumber)) {
            $houseNumber = number_format($houseNumber, 0);
        } elseif (is_string($houseNumber)) {
            if (!is_numeric($houseNumber)) {
                throw new InvalidArgumentException('Invalid house number given, must be numeric');
            }
        } elseif (!is_null($houseNumber)) {
            throw new InvalidArgumentException('Invalid house number given, must be int, float, string or null');
        }

        return $houseNumber;
    }

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
    public function coordinate($coordinate)
    {
        if (is_string($coordinate)) {
            $coordinate = (float) $coordinate;
        } elseif (!is_null($coordinate) && !is_int($coordinate) && !is_float($coordinate)) {
            throw new InvalidArgumentException('Invalid coordinate given, must be float, string or null');
        }

        return $coordinate;
    }

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
    public function addressType($addressType)
    {
        if (is_string($addressType) && (!is_numeric($addressType) || mb_strlen($addressType) > 2)) {
            throw new InvalidArgumentException('Invalid address type given, it has to be a numeric string (2 digits) or null');
        }

        if (is_null($addressType)) {
            $addressType = null;
        } else {
            $addressType = str_pad($addressType, 2, '0', STR_PAD_LEFT);
        }

        return $addressType;
    }

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
    public function area($area)
    {
        static $maxLength = 35;
        if (is_string($area) && mb_strlen($area) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid area given, must be max %d characters long', $maxLength));
        }

        return $area;
    }

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
    public function buildingName($buildingName)
    {
        static $maxLength = 35;
        if (is_string($buildingName) && mb_strlen($buildingName) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid building name given, must be max %d characters long', $maxLength));
        }

        return $buildingName;
    }

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
    public function city($city)
    {
        static $maxLength = 35;
        if (is_string($city) && mb_strlen($city) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid city name given, must be max %d characters long', $maxLength));
        }

        return $city;
    }

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
    public function companyName($companyName)
    {
        static $maxLength = 35;
        if (is_string($companyName) && mb_strlen($companyName) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid company name given, must be max %d characters long', $maxLength));
        }

        return $companyName;
    }

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
    public function isoAlpha2CountryCode($countryCode)
    {
        if (is_string($countryCode)) {
            $countryCode = strtoupper($countryCode);
            if (class_exists(ISO3166::class) && preg_match('/^[A-Z]{3}$/', $countryCode)) {
                $data = (new ISO3166())->alpha3($countryCode);
                if (isset($data['alpha2'])) {
                    $countryCode = $data['alpha2'];
                } else {
                    throw new InvalidArgumentException('Invalid country code given, must be a valid uppercase ISO 3166-1 alpha-2 code');
                }
            }
            if (!preg_match('/^[A-Z]{2}$/', $countryCode)) {
                throw new InvalidArgumentException('Invalid country code given, must be a valid uppercase ISO 3166-1 alpha-2 code');
            }
        }

        return $countryCode;
    }

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
    public function isoAlpha3CountryCode($countryCode)
    {
        if (is_string($countryCode)) {
            $countryCode = strtoupper($countryCode);
            if (class_exists(ISO3166::class) && preg_match('/^[A-Z]{2}$/', $countryCode)) {
                $data = (new ISO3166())->alpha2($countryCode);
                if (isset($data['alpha3'])) {
                    $countryCode = $data['alpha3'];
                } else {
                    throw new InvalidArgumentException('Invalid country code given, must be a valid uppercase ISO 3166-1 alpha-3 code');
                }
            }
            if (!preg_match('/^[A-Z]{3}$/', $countryCode)) {
                throw new InvalidArgumentException('Invalid country code given, must be a valid uppercase ISO 3166-1 alpha-3 code');
            }
        }

        return $countryCode;
    }

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
    public function isoAlpha2CountryCodeNlBe($countryCode)
    {
        if (is_string($countryCode)) {
            $countryCode = strtoupper($countryCode);
            if (!preg_match('/^(?:NL|BE)$/', $countryCode)) {
                throw new InvalidArgumentException('Invalid country code given, must be uppercase ISO-2 code');
            }
        }

        return $countryCode;
    }

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
    public function department($department)
    {
        static $maxLength = 35;
        if (is_string($department) && mb_strlen($department) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid department given, must be max %d characters long', $maxLength));
        }

        return $department;
    }

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
    public function doorcode($doorcode)
    {
        static $maxLength = 35;
        if (is_string($doorcode) && mb_strlen($doorcode) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid door code given, must be max %d characters long', $maxLength));
        }

        return $doorcode;
    }

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
    public function firstName($firstName)
    {
        static $maxLength = 35;
        if (is_string($firstName) && mb_strlen($firstName) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid first name given, must be max %d characters long', $maxLength));
        }

        return $firstName;
    }

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
    public function lastName($lastName)
    {
        static $maxLength = 35;
        if (is_string($lastName) && mb_strlen($lastName) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid first name given, must be max %d characters long', $maxLength));
        }

        return $lastName;
    }

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
    public function region($region)
    {
        static $maxLength = 35;
        if (is_string($region) && mb_strlen($region) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid region given, must be max %d characters long', $maxLength));
        }

        return $region;
    }

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
    public function remark($remark)
    {
        static $maxLength = 1000;
        if (is_string($remark) && mb_strlen($remark) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid remark given, must be max %d characters long', $maxLength));
        }

        return $remark;
    }

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
    public function street($street)
    {
        static $maxLength = 95;
        if (is_string($street) && mb_strlen($street) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid street given, must be max %d characters long', $maxLength));
        }

        return $street;
    }

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
    public function streetHouseNumberExtension($streetHouseNrExt)
    {
        static $maxLength = 95;
        if (is_string($streetHouseNrExt) && mb_strlen($streetHouseNrExt) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid street + house number + extension given, must be max %df characters long', $maxLength));
        }

        return $streetHouseNrExt;
    }

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
    public function iban($iban)
    {
        if (is_string($iban)) {
            $iban = preg_replace('/\s/', '', $iban);
            if (!preg_match('/^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$/', $iban)) {
                throw new InvalidArgumentException('Invalid IBAN given');
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
            for ($pos = 1; $pos < $numStrLength; ++$pos) {
                $checksum *= 10;
                $checksum += intval(substr($numStr, $pos, 1));
                $checksum %= 97;
            }

            if ((98 - $checksum) !== $checkInt) {
                throw new InvalidArgumentException('Invalid IBAN given');
            }
        }

        return $iban;
    }

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
    public function bic($bic)
    {
        static $minLength = 8;
        static $maxLength = 11;
        if (is_string($bic)) {
            $bic = preg_replace('/\s/', '', $bic);
            if (mb_strlen($bic) < $minLength || mb_strlen($bic) > $maxLength) {
                throw new InvalidArgumentException(sprintf('Invalid BIC given, must be %d to %d characters long', $minLength, $maxLength));
            }
            if (!preg_match('/^[a-z]{6}[0-9a-z]{2}([0-9a-z]{3})?\z/i', $bic)) {
                throw new InvalidArgumentException('%s::%s - Invalid BIC given');
            }
        }

        return $bic;
    }

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
    public function bankAccountName($accountName)
    {
        static $maxLength = 35;
        if (is_string($accountName) && mb_strlen($accountName) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid account name given, must be max %d characters long', $maxLength));
        }

        return $accountName;
    }

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
    public function currency($currency)
    {
        if (is_string($currency)) {
            $currency = strtoupper($currency);
            if (!preg_match('/^[A-Z]{3}$/', $currency)) {
                throw new InvalidArgumentException('Invalid currency code given, must be three uppercase characters');
            }
        }

        return $currency;
    }

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
    public function reference($reference)
    {
        static $maxLength = 35;
        if (is_string($reference) && mb_strlen($reference) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid reference given, must be max %d characters long', $maxLength));
        }

        return $reference;
    }

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
    public function transactionNumber($transactionNumber)
    {
        $maxLength = 35;
        if (is_string($transactionNumber) && mb_strlen($transactionNumber) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid transaction number given, must be max %d characters long', $maxLength));
        }

        return $transactionNumber;
    }

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
    public function amountValue($value)
    {
        if (is_float($value) || is_int($value)) {
            $value = number_format($value, 2, '.', '');
        }
        if (is_string($value) && !preg_match('/^\d{1,6}\.\d{2}$/', $value)) {
            throw new InvalidArgumentException('Invalid value given, must be a decimal with the format #####0.00');
        }
        if (!is_string($value) && !is_null($value)) {
            throw new InvalidArgumentException('Invalid value given, must be a string, float or null');
        }

        return $value;
    }

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
    public function amountType($amountType)
    {
        static $length = 2;
        if (is_null($amountType)) {
            $amountType = null;
        } elseif (is_int($amountType) || is_string($amountType)) {
            $amountType = str_pad($amountType, $length, '0', STR_PAD_LEFT);
        } else {
            throw new InvalidArgumentException('Invalid amount type given, must be a string, integer or null');
        }
        if (is_string($amountType) && mb_strlen($amountType) !== $length) {
            throw new InvalidArgumentException(sprintf('Invalid amount type given, must be %d characters long', $length));
        }

        return $amountType;
    }

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
    public function email($email)
    {
        static $maxLength = 50;
        if (is_string($email)) {
            if (mb_strlen($email) > $maxLength) {
                throw new InvalidArgumentException(sprintf('Invalid email given, must be max %d characters long', $maxLength));
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException('Invalid email given');
            }
        }

        return $email;
    }

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
    public function telephoneNumber($number, string $countryCode)
    {
        static $minLength = 10;
        static $maxLength = 17;
        if (is_string($number)) {
            if (mb_strlen($number) < $minLength || mb_strlen($number) > $maxLength) {
                throw new InvalidArgumentException(sprintf('Invalid telephone number given, must be between %d to %d characters', $minLength, $maxLength));
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
    public function contactType($contactType)
    {
        static $length = 2;
        if (is_int($contactType) || is_string($contactType) && 1 === mb_strlen($contactType)) {
            $contactType = str_pad($contactType, 2, '0', STR_PAD_LEFT);
        }
        if (is_string($contactType) && mb_strlen($contactType) !== $length) {
            throw new InvalidArgumentException(sprintf('Invalid contact type given, must be precisely %d characters long', $length));
        }

        return $contactType;
    }

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
    public function harmonizedSystemTariffNumber($number)
    {
        if (is_int($number) || is_float($number)) {
            $number = str_pad((int) $number, 6, '0', STR_PAD_LEFT);
        }
        if (is_string($number)) {
            $number = substr($number, 0, 6);
            if (!preg_match(\DI\get('postnl.format.hs_tariff'), $number)) {
                throw new InvalidArgumentException('Invalid HS tariff number, must be the first 6 digits');
            }
        }

        return $number;
    }

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
    public function numericString($number)
    {
        if (is_int($number)) {
            $number = (string) $number;
        } elseif (is_float($number)) {
            $number = number_format($number, 0, '', '');
        } elseif (!is_null($number) && !is_string($number)) {
            throw new InvalidArgumentException('Invalid quantity given, must be an int, float, string or null');
        }

        return $number;
    }

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
    public function integer($integer)
    {
        if (is_string($integer)) {
            $integer = (int) $integer;
        }
        if (is_float($integer)) {
            $integer = (int) round($integer, 0);
        } elseif (!is_null($integer) && !is_int($integer)) {
            throw new InvalidArgumentException('Invalid quantity given, must be an int, float, string or null');
        }

        return $integer;
    }

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
    public function float($float)
    {
        if (is_string($float)) {
            $float = number_format($float, 2, '', '');
        }
        if (is_int($float)) {
            $float = (float) $float;
        } elseif (!is_null($float) && !is_float($float)) {
            throw new InvalidArgumentException('Invalid float given, must be an int, float, string or null');
        }

        return $float;
    }

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
    public function ean($ean)
    {
        if (is_string($ean)) {
            $sumEvenIndexes = 0;
            $sumOddIndexes = 0;
            $eanAsArray = array_map('intval', str_split($ean));
            if (13 === strlen($ean)) {
                for ($i = 0; $i < count($eanAsArray) - 1; ++$i) {
                    if (0 === $i % 2) {
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
                    throw new InvalidArgumentException('Invalid EAN-13 code given');
                }
            } elseif (8 !== strlen($ean)) {
                throw new InvalidArgumentException('Invalid EAN given, only EAN-8 and EAN-13 are accepted');
            }
        }

        return $ean;
    }

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
    public function url($url)
    {
        if (is_string($url)) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                throw new InvalidArgumentException('Invalid url  given');
            }
        }

        return $url;
    }

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
    public function time($time)
    {
        if (is_string($time)) {
            $time = trim($time);
            if (preg_match('/^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9])$/', $time)) {
                $time .= ':00';
            }
            if (!preg_match('/^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$/', $time)) {
                throw new InvalidArgumentException('Invalid time given, format must be H:i:s');
            }
        }

        return $time;
    }

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
    public function timeRangeShort($timeRange)
    {
        if (is_string($timeRange)) {
            $timeRange = trim($timeRange);
            if (!preg_match('/^[0-2][0-9]:[0-5][0-9]-[0-2][0-9]:[0-5][0-9]$/', $timeRange)) {
                throw new InvalidArgumentException('Invalid short time range given, format must be H:i-H:i');
            }
        }

        return $timeRange;
    }

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
    public function date($date)
    {
        if (is_string($date)) {
            $date = trim($date);
            if (date('d-m-Y', strtotime($date)) !== $date) {
                throw new InvalidArgumentException('Invalid date given, format must be d-m-Y');
            }
        }

        return $date;
    }

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
    public function dateTime($dateTime)
    {
        if (is_string($dateTime)) {
            $dateTime = trim($dateTime);
            if (date('d-m-Y H:i:s', strtotime($dateTime)) !== $dateTime) {
                throw new InvalidArgumentException('Invalid datetime given, format must be d-m-Y H:i:s');
            }
        }

        return $dateTime;
    }

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
    public function dayOfTheWeek($day)
    {
        static $length = 2;
        if (is_int($day) || is_float($day)) {
            $day = str_pad(number_format($day, 0), 2, '0', STR_PAD_LEFT);
        }
        if (is_string($day) && mb_strlen($day) !== $length) {
            throw new InvalidArgumentException('Invalid day given, must be exactly 2 characters long');
        }

        return $day;
    }

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
    public function numericType($type)
    {
        static $length = 2;
        if (is_int($type) || is_float($type)) {
            $type = str_pad(number_format($type, 0), 2, '0', STR_PAD_LEFT);
        }
        if (is_string($type) && mb_strlen($type) !== $length) {
            throw new InvalidArgumentException('Invalid numeric type given, must be exactly 2 characters long');
        }

        return $type;
    }

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
    public function groupCount($groupCount)
    {
        if (is_int($groupCount) || is_float($groupCount)) {
            $groupCount = number_format($groupCount, 0);
        } elseif (is_string($groupCount)) {
            if (!is_numeric($groupCount)) {
                throw new InvalidArgumentException('Invalid group count given, must be numeric');
            }
        } elseif (!is_null($groupCount)) {
            throw new InvalidArgumentException('Invalid group count given, must be int, float, string or null');
        }

        return $groupCount;
    }

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
    public function productOption($productOption)
    {
        if (is_int($productOption) || is_float($productOption)) {
            $productOption = str_pad($productOption, 3, '0', STR_PAD_LEFT);
        }
        if (is_string($productOption)) {
            if (3 !== strlen($productOption)) {
                throw new InvalidArgumentException('Invalid product option given, must consist of 3 digits');
            }
        } elseif (!is_null($productOption)) {
            throw new InvalidArgumentException('Invalid product option given, must consist of 3 digits');
        }

        return $productOption;
    }

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
    public function productCode($productCode)
    {
        if (is_float($productCode) || is_int($productCode)) {
            $productCode = str_pad((int) $productCode, 4, '0', STR_PAD_LEFT);
        }
        if (is_string($productCode)) {
            if (4 !== strlen($productCode)) {
                throw new InvalidArgumentException('Invalid product code given, must be 4 digits or null');
            }
        } elseif (!is_null($productCode)) {
            throw new InvalidArgumentException('Invalid product code given, must be 4 digits or null');
        }

        return $productCode;
    }

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
    public function interval($interval)
    {
        if (is_int($interval)) {
            if (!in_array($interval, [30, 60])) {
                throw new InvalidArgumentException('Invalid interval given, must be 30 or 60');
            }
        }

        return $interval;
    }

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
    public function genericString($description, int $maxLength = 35)
    {
        if (is_string($description) && mb_strlen($description) > $maxLength) {
            throw new InvalidArgumentException(sprintf('Invalid string given, must be max %d characters long', $maxLength));
        }

        return $description;
    }

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
    public function barcode($barcode)
    {
        if (is_string($barcode)) {
            $barcode = trim($barcode);
            if (!preg_match($this->barcodeFullFormat, $barcode)) {
                throw new InvalidArgumentException('Invalid barcode given');
            }
        }

        return $barcode;
    }

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
    public function barcodeType($type)
    {
        if (is_string($type) && !in_array($type, $this->barcodeTypes)) {
            throw new InvalidArgumentException(sprintf('Invalid barcode type given, must be one of: %s', implode(', ', $this->barcodeTypes)));
        }

        return $type;
    }

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
    public function barcodeSerie($serie)
    {
        if (is_string($serie)) {
            $serie = trim($serie);
            if (!preg_match($this->barcodeSerieFormat, $serie)) {
                dump($this->barcodeSerieFormat);
                throw new InvalidArgumentException('Invalid serie given, must have the format ###000000-###000000');
            }
        }

        return $serie;
    }

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
    public function barcodeRange($range)
    {
        if (is_string($range)) {
            $range = trim($range);
            if (!preg_match($this->barcodeRangeFormat, $range)) {
                throw new InvalidArgumentException('Invalid barcode range given');
            }
        }

        return $range;
    }

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
    public function customerCode($code)
    {
        if (is_string($code)) {
            $code = trim($code);
            if (!preg_match('/^[A-Z]{4}$/', $code)) {
                throw new InvalidArgumentException('Invalid customer code given, must be 4 characters long');
            }
        }

        return $code;
    }

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
    public function customerNumber($customerNumber)
    {
        if (!is_numeric($customerNumber)) {
            throw new InvalidArgumentException('Invalid customer number given, must be a number');
        }

        return $customerNumber;
    }
}
