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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Exception\InvalidTypeException;
use ReflectionClass;
use ReflectionException;
use TypeError;

/**
 * Class Amount
 */
class Amount extends AbstractEntity
{
    /**
     * Name of bank account owner
     *
     * @pattern ^.{0,35}$
     *
     * @example C. de Ruiter
     *
     * @var string|null $accountName
     *
     * @since   1.0.0
     */
    protected $accountName;

    /**
     * Amount type. This is a code. Possible values are:
     * - 01 = Cash on delivery (COD)
     * - 02 = Insured value
     * - 04 mandatory for Commercial route China.
     * - 12 mandatory for Inco terms DDP Commercial route China.
     *
     * @pattern ^\d{2}$
     *
     * @var string|null $amountType
     *
     * @since   1.0.0
     */
    protected $amountType;

    /**
     * BIC number, optional for COD shipments (mandatory for bank account number other than originating in The Netherlands)
     *
     * @pattern ^.{8,11}$
     *
     * @example INGBNL2A
     *
     * @var string|null $BIC
     *
     * @since   1.0.0
     */
    protected $BIC;

    /**
     * Currency code according ISO 4217. E.g. EUR
     *
     * @pattern ^[A-Z]{3}$
     *
     * @example EUR
     *
     * @var string|null $currency
     *
     * @since 1.0.0
     */
    protected $currency;

    /**
     * IBAN bank account number, mandatory for COD shipments. Dutch IBAN numbers are 18 characters
     *
     * @pattern ^.{15,31}$
     *
     * @example NL00INGB1234567890
     *
     * @var string|null $IBAN
     *
     * @since 1.0.0
     */
    protected $IBAN;

    /**
     * Personal payment reference
     *
     * @pattern ^.{0,35}$
     *
     * @example 1234-5678
     *
     * @var string|null $reference
     *
     * @since 1.0.0
     */
    protected $reference;

    /**
     * Transaction number
     *
     * @pattern ^.{0,35}$
     *
     * @example 1234
     *
     * @var string|null $transactionNumber
     *
     * @since 1.0.0
     */
    protected $transactionNumber;

    /**
     * Money value in EUR (unless value Currency is specified for another currency). Value format (N6.2): ######0.00 (2 digits behind decimal dot)
     * Mandatory for COD, Insured products and Commercial route China.
     *
     * @pattern ^\d{1,6}\.\d{2}$
     *
     * @example 10.00
     *
     * @var string|null $value
     *
     * @since 1.0.0
     */
    protected $value;

    /**
     * Amount constructor.
     *
     * @param string|null $accountName
     * @param string|null $amountType
     * @param string|null $bic
     * @param string|null $currency
     * @param string|null $iban
     * @param string|null $reference
     * @param string|null $transactionNumber
     * @param string|null $value
     *
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $accountName = null, ?string $amountType = null, ?string $bic = null, ?string $currency = null, ?string $iban = null, ?string $reference = null, ?string $transactionNumber = null, ?string $value = null)
    {
        parent::__construct();

        $this->setAccountName($accountName);
        $this->setAmountType($amountType);
        $this->setBIC($bic);
        $this->setCurrency($currency);
        $this->setIBAN($iban);
        $this->setReference($reference);
        $this->setTransactionNumber($transactionNumber);
        $this->setValue($value);
    }

    /**
     * Get amount type
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$amountType
     */
    public function getAmountType(): ?string
    {
        return $this->amountType;
    }

    /**
     * Set amount type
     *
     * @param string|int|null $type
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$amountType
     */
    public function setAmountType($type = null): Amount
    {
        static $length = 2;
        if (is_null($type)) {
            $this->amountType = null;
        } elseif (is_int($type) || is_string($type)) {
            $this->amountType = str_pad($type, $length, '0', STR_PAD_LEFT);
        } else {
            throw new InvalidTypeException(sprintf('%s::%s - Invalid amount type given, must be a string, integer or null', (new ReflectionClass($this))->getShortName(), __METHOD__, $length));
        }
        if (is_string($type) && mb_strlen($type) !== $length) {
            throw new InvalidTypeException(sprintf('%s::%s - Invalid amount type given, must be %d characters long', (new ReflectionClass($this))->getShortName(), __METHOD__, $length));
        }

        return $this;
    }

    /**
     * Get account name
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$accountName
     */
    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    /**
     * Set account name
     *
     * @param string|null $accountName
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$accountName
     */
    public function setAccountName(?string $accountName): Amount
    {
        static $maxLength = 35;
        if (is_string($accountName) && mb_strlen($accountName) > $maxLength) {
            throw new InvalidTypeException(sprintf('%s::%s - Invalid account name given, must be max %d characters long', (new ReflectionClass($this))->getShortName(), __METHOD__, $maxLength));
        }

        $this->accountName = $accountName;

        return $this;
    }

    /**
     * Get BIC
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$BIC
     */
    public function getBIC(): ?string
    {
        return $this->BIC;
    }

    /**
     * Set BIC
     *
     * @param string|null $bic
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$BIC
     */
    public function setBIC(?string $bic): Amount
    {
        static $minLength = 8;
        static $maxLength = 11;
        if (is_string($bic) && (mb_strlen($bic) < $minLength || mb_strlen($bic) > $maxLength)) {
            throw new InvalidTypeException(sprintf('%s::%s - Invalid BIC given, must be %d to %d characters long', (new ReflectionClass($this))->getShortName(), __METHOD__, $minLength, $maxLength));
        }

        $this->BIC = $bic;

        return $this;
    }

    /**
     * Get currency code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$currency
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Set currency code
     *
     * @param string|null $currency
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$currency
     */
    public function setCurrency(?string $currency): Amount
    {
        if (is_string($currency) && !preg_match('/^[A-Z]{3}$/', $currency)) {
            throw new InvalidTypeException(sprintf('%s::%s - Invalid currency code given, must be three uppercase characters', (new ReflectionClass($this))->getShortName(), __METHOD__));
        }

        $this->currency = $currency;

        return $this;
    }

    /**
     * Get IBAN
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$IBAN
     */
    public function getIBAN(): ?string
    {
        return $this->IBAN;
    }

    /**
     * Set IBAN
     *
     * @param string|null $iban
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$IBAN
     */
    public function setIBAN(?string $iban): Amount
    {
        static $minLength = 15;
        static $maxLength = 31;
        if (is_string($iban) && (mb_strlen($iban) < $minLength || mb_strlen($iban) > $maxLength)) {
            throw new InvalidTypeException(sprintf('%s::%s - Invalid IBAN given, must be %d to %d characters long', (new ReflectionClass($this))->getShortName(), __METHOD__, $minLength, $maxLength));
        }

        $this->IBAN = $iban;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$reference
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * Set reference
     *
     * @param string|null $reference
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$reference
     */
    public function setReference(?string $reference): Amount
    {
        static $maxLength = 35;
        if (is_string($reference) && mb_strlen($reference) > $maxLength) {
            throw new InvalidTypeException(sprintf('%s::%s - Invalid reference given, must be max %d characters long', (new ReflectionClass($this))->getShortName(), __METHOD__, $maxLength));
        }

        $this->reference = $reference;

        return $this;
    }

    /**
     * Get transaction number
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$transactionNumber
     */
    public function getTransactionNumber(): ?string
    {
        return $this->transactionNumber;
    }

    /**
     * Set transaction number
     *
     * @param string|null $transactionNumber
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$transactionNumber
     */
    public function setTransactionNumber(?string $transactionNumber): Amount
    {
        $maxLength = 35;
        if (is_string($transactionNumber) && mb_strlen($transactionNumber) > $maxLength) {
            throw new InvalidTypeException(sprintf('%s::%s - Invalid transaction number given, must be max %d characters long', (new ReflectionClass($this))->getShortName(), __METHOD__, $maxLength));
        }

        $this->transactionNumber = $transactionNumber;

        return $this;
    }

    /**
     * Get value
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$value
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Set value
     *
     * @param string|float|int|null $value
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Amount::$value
     */
    public function setValue($value): Amount
    {
        if (is_float($value) || is_int($value)) {
            $value = number_format($value, 2, '.', '');
        }
        if (is_string($value) && !preg_match('/^\d{1,6}\.\d{2}$/', $value)) {
            throw new InvalidTypeException(sprintf('%s::%s - Invalid value given, must be a decimal with the format #####0.00', (new ReflectionClass($this))->getShortName(), __METHOD__));
        }
        if (!is_string($value) && !is_null($value)) {
            throw new InvalidTypeException(sprintf('%s::%s - Invalid value given, must be a string, float or null', (new ReflectionClass($this))->getShortName(), __METHOD__));
        }

        $this->value = $value;

        return $this;
    }
}
