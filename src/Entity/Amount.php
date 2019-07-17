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

/**
 * Class Amount
 */
class Amount extends AbstractEntity
{
    /** @var string|null $accountName */
    protected $accountName;
    /** @var string|null $amountType */
    protected $amountType;
    /** @var string|null $BIC */
    protected $BIC;
    /** @var string|null $currency */
    protected $currency;
    /** @var string|null $IBAN */
    protected $IBAN;
    /** @var string|null $reference */
    protected $reference;
    /** @var string|null $transactionNumber */
    protected $transactionNumber;
    /** @var string|null $value */
    protected $value;

    /**
     * @param string|null $accountName
     * @param string|null $amountType
     * @param string|null $bic
     * @param string|null $currency
     * @param string|null $iban
     * @param string|null $reference
     * @param string|null $transactionNumber
     * @param string|null $value
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
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAmountType(): ?string
    {
        return $this->amountType;
    }

    /**
     * Set amount type
     *
     * @param string|null $type
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setAmountType(?string $type = null): Amount
    {
        if (is_null($type)) {
            $this->amountType = null;
        } else {
            $this->amountType = str_pad($type, 2, '0', STR_PAD_LEFT);
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    /**
     * @param string|null $accountName
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAccountName(?string $accountName): Amount
    {
        $this->accountName = $accountName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBIC(): ?string
    {
        return $this->BIC;
    }

    /**
     * @param string|null $BIC
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setBIC(?string $BIC): Amount
    {
        $this->BIC = $BIC;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCurrency(?string $currency): Amount
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIBAN(): ?string
    {
        return $this->IBAN;
    }

    /**
     * @param string|null $IBAN
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setIBAN(?string $IBAN): Amount
    {
        $this->IBAN = $IBAN;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param string|null $reference
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setReference(?string $reference): Amount
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTransactionNumber(): ?string
    {
        return $this->transactionNumber;
    }

    /**
     * @param string|null $transactionNumber
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setTransactionNumber(?string $transactionNumber): Amount
    {
        $this->transactionNumber = $transactionNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setValue(?string $value): Amount
    {
        $this->value = $value;

        return $this;
    }
}
