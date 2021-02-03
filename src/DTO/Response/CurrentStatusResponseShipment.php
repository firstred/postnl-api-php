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

use Firstred\PostNL\Entity\Barcode;
use Firstred\PostNL\Entity\Dimension;
use Firstred\PostNL\Entity\Expectation;
use Firstred\PostNL\Entity\Status;

class CurrentStatusResponseShipment
{
    protected array|null $Addresses = null;
    protected array|null $Amounts = null;
    protected ?Barcode $Barcode = null;
    protected string|null $DeliveryDate = null;
    protected ?Dimension $Dimension = null;
    protected ?Expectation $Expectation = null;
    protected array|null $Groups = null;
    protected string|null $ProductCode = null;
    protected array|null $ProductOptions = null;
    protected string|null $Reference = null;
    protected ?Status $Status = null;
    protected array|null $Warnings = null;

    public function __construct(
        array|null $addresses = null,
        array|null $amounts = null,
        ?Barcode $barcode = null,
        string|null $deliveryDate = null,
        ?Dimension $dimension = null,
        ?Expectation $expectation = null,
        array|null $groups = null,
        string|null $productCode = null,
        array|null $productOptions = null,
        string|null $reference = null,
        ?Status $status = null,
        array|null $warnings = null,
    ) {
        $this->setAddresses(addresses: $addresses);
        $this->setAmounts(amounts: $amounts);
        $this->setBarcode(barcode: $barcode);
        $this->setDeliveryDate(deliveryDate: $deliveryDate);
        $this->setDimension(dimension: $dimension);
        $this->setExpectation(expectation: $expectation);
        $this->setGroups(groups: $groups);
        $this->setProductCode(productCode: $productCode);
        $this->setProductOptions(productOptions: $productOptions);
        $this->setReference(reference: $reference);
        $this->setStatus(status: $status);
        $this->setWarnings(warnings: $warnings);
    }

    public function getAddresses(): array|null
    {
        return $this->Addresses;
    }

    public function setAddresses(array|null $addresses = null): static
    {
        $this->Addresses = $addresses;

        return $this;
    }

    public function getAmounts(): array|null
    {
        return $this->Amounts;
    }

    public function setAmounts(array|null $amounts = null): static
    {
        $this->Amounts = $amounts;

        return $this;
    }

    public function getBarcode(): ?Barcode
    {
        return $this->Barcode;
    }

    public function setBarcode(?Barcode $barcode = null): static
    {
        $this->Barcode = $barcode;

        return $this;
    }

    public function calculateDeliveryDate(): string|null
    {
        return $this->DeliveryDate;
    }

    public function setDeliveryDate(string|null $deliveryDate = null): static
    {
        $this->DeliveryDate = $deliveryDate;

        return $this;
    }

    public function getDimension(): ?Dimension
    {
        return $this->Dimension;
    }

    public function setDimension(?Dimension $dimension = null): static
    {
        $this->Dimension = $dimension;

        return $this;
    }

    public function getExpectation(): ?Expectation
    {
        return $this->Expectation;
    }

    public function setExpectation(?Expectation $expectation = null): static
    {
        $this->Expectation = $expectation;

        return $this;
    }

    public function getGroups(): array|null
    {
        return $this->Groups;
    }

    public function setGroups(array|null $groups = null): static
    {
        $this->Groups = $groups;

        return $this;
    }

    public function getProductCode(): string|null
    {
        return $this->ProductCode;
    }

    public function setProductCode(string|null $productCode = null): static
    {
        $this->ProductCode = $productCode;

        return $this;
    }

    public function getProductOptions(): array|null
    {
        return $this->ProductOptions;
    }

    public function setProductOptions(array|null $productOptions = null): static
    {
        $this->ProductOptions = $productOptions;

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

    public function getStatus(): ?Status
    {
        return $this->Status;
    }

    public function setStatus(?Status $status = null): static
    {
        $this->Status = $status;

        return $this;
    }

    public function getWarnings(): array|null
    {
        return $this->Warnings;
    }

    public function setWarnings(array|null $warnings = null): static
    {
        $this->Warnings = $warnings;

        return $this;
    }
}
