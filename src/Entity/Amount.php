<?php

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

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\ServiceNotSetException;
use InvalidArgumentException;
use Sabre\Xml\Writer;

/**
 * @since 1.0.0
 */
class Amount extends AbstractEntity
{
    /** @var string|null $AccountName */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $AccountName = null;

    /** @var string|null $AmountType */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $AmountType = null;

    /** @var string|null $BIC */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $BIC = null;

    /** @var string|null $Currency */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Currency = null;

    /** @var string|null $IBAN */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $IBAN = null;

    /** @var string|null $Reference */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Reference = null;

    /** @var string|null $TransactionNumber */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $TransactionNumber = null;

    /** @var string|null $Value */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Value = null;

    /** @var string|null $VerzekerdBedrag */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $VerzekerdBedrag = null;

    /**
     * @param string|null $AccountName
     * @param string|null $AmountType
     * @param string|null $BIC
     * @param string|null $Currency
     * @param string|null $IBAN
     * @param string|null $Reference
     * @param string|null $TransactionNumber
     * @param string|null $Value
     * @param string|null $VerzekerdBedrag
     */
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

    /**
     * @return string|null
     */
    public function getAccountName(): ?string
    {
        return $this->AccountName;
    }

    /**
     * @param string|null $AccountName
     *
     * @return static
     */
    public function setAccountName(?string $AccountName): static
    {
        $this->AccountName = $AccountName;

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
     */
    public function setBIC(?string $BIC): static
    {
        $this->BIC = $BIC;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->Currency;
    }

    /**
     * @param string|null $Currency
     *
     * @return static
     */
    public function setCurrency(?string $Currency): static
    {
        $this->Currency = $Currency;

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
     */
    public function setIBAN(?string $IBAN): static
    {
        $this->IBAN = $IBAN;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->Reference;
    }

    /**
     * @param string|null $Reference
     *
     * @return static
     */
    public function setReference(?string $Reference): static
    {
        $this->Reference = $Reference;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTransactionNumber(): ?string
    {
        return $this->TransactionNumber;
    }

    /**
     * @param string|null $TransactionNumber
     *
     * @return static
     */
    public function setTransactionNumber(?string $TransactionNumber): static
    {
        $this->TransactionNumber = $TransactionNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->Value;
    }

    /**
     * @param string|null $Value
     *
     * @return static
     */
    public function setValue(?string $Value): static
    {
        $this->Value = $Value;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVerzekerdBedrag(): ?string
    {
        return $this->VerzekerdBedrag;
    }

    /**
     * @param string|null $VerzekerdBedrag
     *
     * @return static
     */
    public function setVerzekerdBedrag(?string $VerzekerdBedrag): static
    {
        $this->VerzekerdBedrag = $VerzekerdBedrag;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAmountType(): ?string
    {
        return $this->AmountType;
    }

    /**
     * @param string|int|null $AmountType
     *
     * @return static
     */
    public function setAmountType(string|int|null $AmountType = null): static
    {
        if (is_null(value: $AmountType)) {
            $this->AmountType = null;
        } else {
            $this->AmountType = str_pad(string: (string) $AmountType, length: 2, pad_string: '0', pad_type: STR_PAD_LEFT);
        }

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     * @throws ServiceNotSetException
     */
    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        if (!isset($this->currentService)) {
            throw new ServiceNotSetException(message: 'Service not set before serialization');
        }

        foreach ($this->getSerializableProperties() as $propertyName => $namespace) {
            if (!isset($this->$propertyName)) {
                continue;
            }

            if ('Value' === $propertyName) {
                $xml["{{$namespace}}Value"] = number_format(num: (float) $this->Value, decimals: 2, decimal_separator: '.', thousands_separator: '');
            } else {
                $xml["{{$namespace}}{$propertyName}"] = $this->$propertyName;
            }
        }

        $writer->write(value: $xml);
    }
}
