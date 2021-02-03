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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

class Amount extends SerializableObject
{
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        protected string|null $AccountName = null,
        protected string|null $AmountType = null,
        protected string|null $BIC = null,
        protected string|null $Currency = null,
        protected string|null $IBAN = null,
        protected string|null $Reference = null,
        protected string|null $TransactionNumber = null,
        protected string|null $Value = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setAccountName(AccountName: $AccountName);
        $this->setAmountType(AmountType: $AmountType);
        $this->setBIC(BIC: $BIC);
        $this->setCurrency(Currency: $Currency);
        $this->setIBAN(IBAN: $IBAN);
        $this->setReference(Reference: $Reference);
        $this->setTransactionNumber(TransactionNumber: $TransactionNumber);
        $this->setValue(Value: $Value);
    }

    public function getAmountType(): string|null
    {
        return $this->AmountType;
    }

    public function setAmountType(string|int|null $AmountType = null): static
    {
        if (is_null(value: $AmountType)) {
            $this->AmountType = null;
        } else {
            $this->AmountType = str_pad(string: $AmountType, length: 2, pad_string: '0', pad_type: STR_PAD_LEFT);
        }

        return $this;
    }

    public function getAccountName(): string|null
    {
        return $this->AccountName;
    }

    public function setAccountName(string|null $AccountName = null): static
    {
        $this->AccountName = $AccountName;

        return $this;
    }

    public function getBIC(): string|null
    {
        return $this->BIC;
    }

    public function setBIC(string|null $BIC = null): static
    {
        $this->BIC = $BIC;

        return $this;
    }

    public function getCurrency(): string|null
    {
        return $this->Currency;
    }

    public function setCurrency(string|null $Currency = null): static
    {
        $this->Currency = $Currency;

        return $this;
    }

    public function getIBAN(): string|null
    {
        return $this->IBAN;
    }

    public function setIBAN(string|null $IBAN = null): static
    {
        $this->IBAN = $IBAN;

        return $this;
    }

    public function getReference(): string|null
    {
        return $this->Reference;
    }

    public function setReference(string|null $Reference = null): static
    {
        $this->Reference = $Reference;

        return $this;
    }

    public function getTransactionNumber(): string|null
    {
        return $this->TransactionNumber;
    }

    public function setTransactionNumber(string|null $TransactionNumber = null): static
    {
        $this->TransactionNumber = $TransactionNumber;

        return $this;
    }

    public function getValue(): string|null
    {
        return $this->Value;
    }

    public function setValue(string|null $Value = null): static
    {
        $this->Value = $Value;

        return $this;
    }
}
