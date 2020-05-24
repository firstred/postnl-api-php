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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class Amount.
 */
interface AmountInterface extends EntityInterface
{
    /**
     * Get amount type.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Amount::$amountType
     */
    public function getAmountType(): ?string;

    /**
     * Set amount type.
     *
     * @pattern ^\d{2}$
     *
     * @param string|int|null $type
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 01
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Amount::$amountType
     */
    public function setAmountType($type = null): AmountInterface;

    /**
     * Get account name.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Amount::$accountName
     */
    public function getAccountName(): ?string;

    /**
     * Set account name.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $accountName
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example C. de Ruiter
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Amount::$accountName
     */
    public function setAccountName(?string $accountName): AmountInterface;

    /**
     * Get BIC.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Amount::$BIC
     */
    public function getBIC(): ?string;

    /**
     * Set BIC.
     *
     * @pattern ^.{8,11}$
     *
     * @param string|null $bic
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example INGBNL2A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Amount::$BIC
     */
    public function setBIC(?string $bic): AmountInterface;

    /**
     * Get currency code.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Amount::$currency
     */
    public function getCurrency(): ?string;

    /**
     * Set currency code.
     *
     * @pattern ^[A-Z]{3}$
     *
     * @param string|null $currency
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example EUR
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Amount::$currency
     */
    public function setCurrency(?string $currency): AmountInterface;

    /**
     * Get IBAN.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Amount::$IBAN
     */
    public function getIBAN(): ?string;

    /**
     * Set IBAN.
     *
     * @pattern ^.{15,31}$
     *
     * @param string|null $iban
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example NL00INGB1234567890
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Amount::$IBAN
     */
    public function setIBAN(?string $iban): AmountInterface;

    /**
     * Get reference.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Amount::$reference
     */
    public function getReference(): ?string;

    /**
     * Set reference.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $reference
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 1234-5678
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Amount::$reference
     */
    public function setReference(?string $reference): AmountInterface;

    /**
     * Get transaction number.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Amount::$transactionNumber
     */
    public function getTransactionNumber(): ?string;

    /**
     * Set transaction number.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $transactionNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 1234
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Amount::$transactionNumber
     */
    public function setTransactionNumber(?string $transactionNumber): AmountInterface;

    /**
     * Get value.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Amount::$value
     */
    public function getValue(): ?string;

    /**
     * Set value.
     *
     * @param string|float|int|null $value
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @pattern ^\d{1,6}\.\d{2}$
     *
     * @example 10.00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Amount::$value
     */
    public function setValue($value): AmountInterface;
}
