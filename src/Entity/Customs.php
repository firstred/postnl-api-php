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

/**
 * @since 1.0.0
 */
class Customs extends AbstractEntity
{
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Certificate = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CertificateNr = null;

    /** @var Content[]|null */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Content = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Currency = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $HandleAsNonDeliverable = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Invoice = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]

    protected ?string $InvoiceNr = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $License = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $LicenseNr = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $ShipmentType = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $TrustedShipperID = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $TransactionCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $TransactionDescription = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $ImporterReferenceCode = null;

    public function __construct(
        ?string $Certificate = null,
        ?string $CertificateNr = null,
        ?array  $Content = null,
        ?string $Currency = null,
        ?string $HandleAsNonDeliverable = null,
        ?string $Invoice = null,
        ?string $InvoiceNr = null,
        ?string $License = null,
        ?string $LicenseNr = null,
        ?string $ShipmentType = null,
        ?string $TrustedShipperID = null,
        ?string $TransactionCode = null,
        ?string $TransactionDescription = null,
        ?string $ImporterReferenceCode = null
    ) {
        parent::__construct();

        $this->setCertificate(Certificate: $Certificate);
        $this->setCertificateNr(CertificateNr: $CertificateNr);
        $this->setContent(Content: $Content);
        $this->setCurrency(Currency: $Currency);
        $this->setHandleAsNonDeliverable(HandleAsNonDeliverable: $HandleAsNonDeliverable);
        $this->setInvoice(Invoice: $Invoice);
        $this->setInvoiceNr(InvoiceNr: $InvoiceNr);
        $this->setLicense(License: $License);
        $this->setLicenseNr(LicenseNr: $LicenseNr);
        $this->setShipmentType(ShipmentType: $ShipmentType);
        $this->setTrustedShipperID(TrustedShipperID: $TrustedShipperID);
        $this->setTransactionCode(TransactionCode: $TransactionCode);
        $this->setTransactionDescription(TransactionDescription: $TransactionDescription);
        $this->setImporterReferenceCode(ImporterReferenceCode: $ImporterReferenceCode);
    }

    public function getCertificate(): ?string
    {
        return $this->Certificate;
    }

    public function setCertificate(?string $Certificate): static
    {
        $this->Certificate = $Certificate;

        return $this;
    }

    public function getCertificateNr(): ?string
    {
        return $this->CertificateNr;
    }

    public function setCertificateNr(?string $CertificateNr): static
    {
        $this->CertificateNr = $CertificateNr;

        return $this;
    }

    /**
     * @return Content[]|null
     */
    public function getContent(): ?array
    {
        return $this->Content;
    }

    /**
     * @param Content[]|null $Content
     * @return $this
     */
    public function setContent(?array $Content): static
    {
        if (is_array(value: $Content)) {
            foreach ($Content as $content) {
                if (!$content instanceof Content) {
                    throw new \TypeError(message: 'Expected instance of `Content`');
                }
            }
        }

        $this->Content = $Content;

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

    public function getHandleAsNonDeliverable(): ?string
    {
        return $this->HandleAsNonDeliverable;
    }

    public function setHandleAsNonDeliverable(?string $HandleAsNonDeliverable): static
    {
        $this->HandleAsNonDeliverable = $HandleAsNonDeliverable;

        return $this;
    }

    public function getInvoice(): ?string
    {
        return $this->Invoice;
    }

    public function setInvoice(?string $Invoice): static
    {
        $this->Invoice = $Invoice;

        return $this;
    }

    public function getInvoiceNr(): ?string
    {
        return $this->InvoiceNr;
    }

    public function setInvoiceNr(?string $InvoiceNr): static
    {
        $this->InvoiceNr = $InvoiceNr;

        return $this;
    }

    public function getLicense(): ?string
    {
        return $this->License;
    }

    public function setLicense(?string $License): static
    {
        $this->License = $License;

        return $this;
    }

    public function getLicenseNr(): ?string
    {
        return $this->LicenseNr;
    }

    public function setLicenseNr(?string $LicenseNr): static
    {
        $this->LicenseNr = $LicenseNr;

        return $this;
    }

    public function getShipmentType(): ?string
    {
        return $this->ShipmentType;
    }

    public function setShipmentType(?string $ShipmentType): static
    {
        $this->ShipmentType = $ShipmentType;

        return $this;
    }

    public function getTrustedShipperID(): ?string
    {
        return $this->TrustedShipperID;
    }

    public function setTrustedShipperID(?string $TrustedShipperID): static
    {
        $this->TrustedShipperID = $TrustedShipperID;

        return $this;
    }

    public function getTransactionCode(): ?string
    {
        return $this->TransactionCode;
    }

    public function setTransactionCode(?string $TransactionCode): static
    {
        $this->TransactionCode = $TransactionCode;

        return $this;
    }

    public function getTransactionDescription(): ?string
    {
        return $this->TransactionDescription;
    }

    public function setTransactionDescription(?string $TransactionDescription): static
    {
        $this->TransactionDescription = $TransactionDescription;

        return $this;
    }

    public function getImporterReferenceCode(): ?string
    {
        return $this->ImporterReferenceCode;
    }

    public function setImporterReferenceCode(?string $ImporterReferenceCode): static
    {
        $this->ImporterReferenceCode = $ImporterReferenceCode;

        return $this;
    }
}
