<?php
declare(strict_types=1);
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Enum\SoapNamespace;
use InvalidArgumentException;
use Sabre\Xml\Writer;

/**
 * @since 1.0.0
 */
class Amount extends AbstractEntity
{
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $AccountName = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $AmountType = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $BIC = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Currency = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $IBAN = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Reference = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $TransactionNumber = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Value = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $VerzekerdBedrag = null;

    public function __construct(
        ?string $AccountName = null,
        ?string $AmountType = null,
        ?string $BIC = null,
        ?string $Currency = null,
        ?string $IBAN = null,
        ?string $Reference = null,
        ?string $TransactionNumber = null,
        ?string $Value = null,
        ?string $VerzekerdBedrag = null
    ) {
        parent::__construct();

        $this->setAccountName(AccountName: $AccountName);
        $this->setAmountType(AmountType: $AmountType);
        $this->setBIC(BIC: $BIC);
        $this->setCurrency(Currency: $Currency);
        $this->setIBAN(IBAN: $IBAN);
        $this->setReference(Reference: $Reference);
        $this->setTransactionNumber(TransactionNumber: $TransactionNumber);
        $this->setValue(Value: $Value);
        $this->setVerzekerdBedrag(VerzekerdBedrag: $VerzekerdBedrag);
    }

    public function getAccountName(): ?string
    {
        return $this->AccountName;
    }

    public function setAccountName(?string $AccountName): static
    {
        $this->AccountName = $AccountName;

        return $this;
    }

    public function getBIC(): ?string
    {
        return $this->BIC;
    }

    public function setBIC(?string $BIC): static
    {
        $this->BIC = $BIC;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->Currency;
    }

    public function setCurrency(?string $Currency): static
    {
        $this->Currency = $Currency;

        return $this;
    }

    public function getIBAN(): ?string
    {
        return $this->IBAN;
    }

    public function setIBAN(?string $IBAN): static
    {
        $this->IBAN = $IBAN;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->Reference;
    }

    public function setReference(?string $Reference): static
    {
        $this->Reference = $Reference;

        return $this;
    }

    public function getTransactionNumber(): ?string
    {
        return $this->TransactionNumber;
    }

    public function setTransactionNumber(?string $TransactionNumber): static
    {
        $this->TransactionNumber = $TransactionNumber;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->Value;
    }

    public function setValue(?string $Value): static
    {
        $this->Value = $Value;

        return $this;
    }

    public function getVerzekerdBedrag(): ?string
    {
        return $this->VerzekerdBedrag;
    }

    public function setVerzekerdBedrag(?string $VerzekerdBedrag): static
    {
        $this->VerzekerdBedrag = $VerzekerdBedrag;

        return $this;
    }

    public function getAmountType(): ?string
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

    /**
     * @throws InvalidArgumentException
     */
    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        if (!$this->currentService || !in_array(needle: $this->currentService, haystack: array_keys(array: static::$defaultProperties))) {
            throw new InvalidArgumentException(message: 'Service not set before serialization');
        }

        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if (isset($this->$propertyName)) {
                if ('Value' === $propertyName) {
                    $xml["{{$namespace}}Value"] = number_format(num: (float) $this->Value, decimals: 2, decimal_separator: '.', thousands_separator: '');
                } else {
                    $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
                }
            }
        }

        $writer->write(value: $xml);
    }
}
