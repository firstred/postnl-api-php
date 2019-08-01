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

use Firstred\PostNL\Misc\ValidateAndFix;
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
     * @example 01
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
     * @pattern ^\d{2}$
     *
     * @param string|int|null $type
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example 01
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Amount::$amountType
     */
    public function setAmountType($type = null): Amount
    {
        $this->amountType = ValidateAndFix::amountType($type);

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
     * @pattern ^.{0,35}$
     *
     * @param string|null $accountName
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example C. de Ruiter
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Amount::$accountName
     */
    public function setAccountName(?string $accountName): Amount
    {
        $this->accountName = ValidateAndFix::bankAccountName($accountName);

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
     * @pattern ^.{8,11}$
     *
     * @param string|null $bic
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example INGBNL2A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Amount::$BIC
     */
    public function setBIC(?string $bic): Amount
    {
        $this->BIC = ValidateAndFix::bic($bic);

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
     * @pattern ^[A-Z]{3}$
     *
     * @param string|null $currency
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example EUR
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Amount::$currency
     */
    public function setCurrency(?string $currency): Amount
    {
        $this->currency = ValidateAndFix::currency($currency);

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
     * @pattern ^.{15,31}$
     *
     * @param string|null $iban
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example NL00INGB1234567890
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Amount::$IBAN
     */
    public function setIBAN(?string $iban): Amount
    {
        $this->IBAN = ValidateAndFix::iban($iban);

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
     * @pattern ^.{0,35}$
     *
     * @param string|null $reference
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example 1234-5678
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Amount::$reference
     */
    public function setReference(?string $reference): Amount
    {
        $this->reference = ValidateAndFix::reference($reference);

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
     * @pattern ^.{0,35}$
     *
     * @param string|null $transactionNumber
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example 1234
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Amount::$transactionNumber
     */
    public function setTransactionNumber(?string $transactionNumber): Amount
    {
        $this->transactionNumber = ValidateAndFix::transactionNumber($transactionNumber);

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
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @pattern ^\d{1,6}\.\d{2}$
     *
     * @example 10.00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Amount::$value
     */
    public function setValue($value): Amount
    {
        $this->value = ValidateAndFix::amountValue($value);

        return $this;
    }
}
