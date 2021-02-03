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

namespace Firstred\PostNL\DTO\Response;

class ResponseAmount
{
    protected string|null $AccountName = null;
    protected string|null $ResponseAmountType = null;
    protected string|null $BIC = null;
    protected string|null $Currency = null;
    protected string|null $IBAN = null;
    protected string|null $Reference = null;
    protected string|null $TransactionNumber = null;
    protected string|null $Value = null;

    public function __construct(
        string|null $accountName = null,
        string|null $responseAmount = null,
        string|null $bic = null,
        string|null $currency = null,
        string|null $iban = null,
        string|null $reference = null,
        string|null $transactionNumber = null,
        string|null $value = null,
    ) {
        $this->setAccountName(accountName: $accountName);
        $this->setResponseAmountType(responseAmountType: $responseAmount);
        $this->setBIC(bic: $bic);
        $this->setCurrency(currency: $currency);
        $this->setIBAN(iban: $iban);
        $this->setReference(reference: $reference);
        $this->setTransactionNumber(transactionNumber: $transactionNumber);
        $this->setValue(value: $value);
    }

    public function getAccountName(): string|null
    {
        return $this->AccountName;
    }

    public function setAccountName(string|null $accountName = null): static
    {
        $this->AccountName = $accountName;

        return $this;
    }

    public function getResponseAmountType(): string|null
    {
        return $this->ResponseAmountType;
    }

    public function setResponseAmountType(string|null $responseAmountType = null): static
    {
        $this->ResponseAmountType = $responseAmountType;

        return $this;
    }

    public function getBIC(): string|null
    {
        return $this->BIC;
    }

    public function setBIC(string|null $bic = null): static
    {
        $this->BIC = $bic;

        return $this;
    }

    public function getCurrency(): string|null
    {
        return $this->Currency;
    }

    public function setCurrency(string|null $currency = null): static
    {
        $this->Currency = $currency;

        return $this;
    }

    public function getIBAN(): string|null
    {
        return $this->IBAN;
    }

    public function setIBAN(string|null $iban = null): static
    {
        $this->IBAN = $iban;

        return $this;
    }

    public function getReference(): string|null
    {
        return $this->Reference;
    }

    public function setReference(string|null $reference = null): static
    {
        $this->Reference = $reference;

        return $this;
    }

    public function getTransactionNumber(): string|null
    {
        return $this->TransactionNumber;
    }

    public function setTransactionNumber(string|null $transactionNumber = null): static
    {
        $this->TransactionNumber = $transactionNumber;

        return $this;
    }

    public function getValue(): string|null
    {
        return $this->Value;
    }

    public function setValue(string|null $value = null): static
    {
        $this->Value = $value;

        return $this;
    }
}
