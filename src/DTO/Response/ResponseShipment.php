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

class ResponseShipment
{
    protected string|null $Barcode = null;
    protected string|null $DownPartnerBarcode = null;
    protected string|null $DownPartnerID = null;
    protected string|null $DownPartnerLocation = null;
    protected array|null $Labels = null;
    protected string|null $ProductCodeDelivery = null;
    protected array|null $Warnings = null;

    public function __construct(
        string|null $barcode = null,
        string|null $productCodeDelivery = null,
        array|null $labels = null,
        string|null $downPartnerBarcode = null,
        string|null $downPartnerId = null,
        string|null $downPartnerLocation = null,
        array|null $warnings = null,
    ) {
        $this->setBarcode(barcode: $barcode);
        $this->setProductCodeDelivery(productCodeDelivery: $productCodeDelivery);
        $this->setDownPartnerBarcode(downPartnerBarcode: $downPartnerBarcode);
        $this->setDownPartnerId(downPartnerID: $downPartnerId);
        $this->setDownPartnerLocation(downPartnerLocation: $downPartnerLocation);
        $this->setLabels(labels: $labels);
        $this->setWarnings(warnings: $warnings);
    }

    public function getBarcode(): string|null
    {
        return $this->Barcode;
    }

    public function setBarcode(string|null $barcode = null): static
    {
        $this->Barcode = $barcode;

        return $this;
    }

    public function getDownPartnerBarcode(): string|null
    {
        return $this->DownPartnerBarcode;
    }

    public function setDownPartnerBarcode(string|null $downPartnerBarcode = null): static
    {
        $this->DownPartnerBarcode = $downPartnerBarcode;

        return $this;
    }

    public function getDownPartnerID(): string|null
    {
        return $this->DownPartnerID;
    }

    public function setDownPartnerID(string|null $downPartnerID = null): static
    {
        $this->DownPartnerID = $downPartnerID;

        return $this;
    }

    public function getDownPartnerLocation(): string|null
    {
        return $this->DownPartnerLocation;
    }

    public function setDownPartnerLocation(string|null $downPartnerLocation = null): static
    {
        $this->DownPartnerLocation = $downPartnerLocation;

        return $this;
    }

    public function getLabels(): array|null
    {
        return $this->Labels;
    }

    public function setLabels(array|null $labels = null): static
    {
        $this->Labels = $labels;

        return $this;
    }

    public function getProductCodeDelivery(): string|null
    {
        return $this->ProductCodeDelivery;
    }

    public function setProductCodeDelivery(string|null $productCodeDelivery = null): static
    {
        $this->ProductCodeDelivery = $productCodeDelivery;

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
