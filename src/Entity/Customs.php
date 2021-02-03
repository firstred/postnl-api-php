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

class Customs extends SerializableObject
{
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        protected string|null $Certificate = null,
        protected string|null $CertificateNr = null,
        protected array|null $Content = null,
        protected string|null $Currency = null,
        protected string|null $HandleAsNonDeliverable = null,
        protected string|null $Invoice = null,
        protected string|null $InvoiceNr = null,
        protected string|null $License = null,
        protected string|null $LicenseNr = null,
        protected string|null $ShipmentType = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setCertificate(Certificate: $Certificate);
        $this->setCertificateNr(CertificateNr: $CertificateNr);
        $this->setContent(Content: $Content);
        $this->setCurrency(Currency: $Currency);
        $this->setHandleAsNonDeliverable(HandleAsNonDeliverable: $HandleAsNonDeliverable);
        $this->setInvoice(Invoice: $Invoice);
        $this->setInvoiceNr(InvoiceNr: $InvoiceNr);
        $this->setLicense(license: $License);
        $this->setLicenseNr(LicenseNr: $LicenseNr);
        $this->setShipmentType(ShipmentType: $ShipmentType);
    }

    public function getCertificate(): string|null
    {
        return $this->Certificate;
    }

    public function setCertificate(string|null $Certificate = null): static
    {
        $this->Certificate = $Certificate;

        return $this;
    }

    public function getCertificateNr(): string|null
    {
        return $this->CertificateNr;
    }

    public function setCertificateNr(string|null $CertificateNr = null): static
    {
        $this->CertificateNr = $CertificateNr;

        return $this;
    }

    public function getContent(): array|null
    {
        return $this->Content;
    }

    public function setContent(array|null $Content = null): static
    {
        $this->Content = $Content;

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

    public function getHandleAsNonDeliverable(): string|null
    {
        return $this->HandleAsNonDeliverable;
    }

    public function setHandleAsNonDeliverable(string|null $HandleAsNonDeliverable = null): static
    {
        $this->HandleAsNonDeliverable = $HandleAsNonDeliverable;

        return $this;
    }

    public function getInvoice(): string|null
    {
        return $this->Invoice;
    }

    public function setInvoice(string|null $Invoice = null): static
    {
        $this->Invoice = $Invoice;

        return $this;
    }

    public function getInvoiceNr(): string|null
    {
        return $this->InvoiceNr;
    }

    public function setInvoiceNr(string|null $InvoiceNr = null): static
    {
        $this->InvoiceNr = $InvoiceNr;

        return $this;
    }

    public function getLicense(): string|null
    {
        return $this->License;
    }

    public function setLicense(string|null $license = null): static
    {
        $this->License = $license;

        return $this;
    }

    public function getLicenseNr(): string|null
    {
        return $this->LicenseNr;
    }

    public function setLicenseNr(string|null $LicenseNr = null): static
    {
        $this->LicenseNr = $LicenseNr;

        return $this;
    }

    public function getShipmentType(): string|null
    {
        return $this->ShipmentType;
    }

    public function setShipmentType(string|null $ShipmentType = null): static
    {
        $this->ShipmentType = $ShipmentType;

        return $this;
    }
}
