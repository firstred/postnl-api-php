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

use Firstred\PostNL\Attribute\SerializableEntityArrayProperty;
use Firstred\PostNL\Attribute\SerializableScalarProperty;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * @since 1.0.0
 */
class Customs extends AbstractEntity
{
    /** @var string|null $Certificate */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Certificate = null;

    /** @var string|null $CertificateNr */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CertificateNr = null;

    /** @var Content[]|null $Content */
    #[SerializableEntityArrayProperty(namespace: SoapNamespace::Domain, entityFqcn: Content::class)]
    protected ?array $Content = null;

    /** @var string|null $Currency */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Currency = null;

    /** @var string|null $HandleAsNonDeliverable*/
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $HandleAsNonDeliverable = null;

    /** @var string|null $Invoice */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Invoice = null;

    /** @var string|null $InvoiceNr */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $InvoiceNr = null;

    /** @var string|null $License */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $License = null;

    /** @var string|null $LicenseNr */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $LicenseNr = null;

    /** @var string|null $ShipmentType */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $ShipmentType = null;

    /** @var string|null $TrustedShipperID */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $TrustedShipperID = null;

    /** @var string|null $TransactionCode */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $TransactionCode = null;

    /** @var string|null $TransactionDescription */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $TransactionDescription = null;

    /** @var string|null $ImporterReferenceCode */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $ImporterReferenceCode = null;

    /**
     * @param string|null $Certificate
     * @param string|null $CertificateNr
     * @param array|null  $Content
     * @param string|null $Currency
     * @param string|null $HandleAsNonDeliverable
     * @param string|null $Invoice
     * @param string|null $InvoiceNr
     * @param string|null $License
     * @param string|null $LicenseNr
     * @param string|null $ShipmentType
     * @param string|null $TrustedShipperID
     * @param string|null $TransactionCode
     * @param string|null $TransactionDescription
     * @param string|null $ImporterReferenceCode
     */
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

    /**
     * @return string|null
     */
    public function getCertificate(): ?string
    {
        return $this->Certificate;
    }

    /**
     * @param string|null $Certificate
     *
     * @return $this
     */
    public function setCertificate(?string $Certificate): static
    {
        $this->Certificate = $Certificate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCertificateNr(): ?string
    {
        return $this->CertificateNr;
    }

    /**
     * @param string|null $CertificateNr
     *
     * @return $this
     */
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
     *
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
     * @return $this
     */
    public function setCurrency(?string $Currency): static
    {
        $this->Currency = $Currency;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHandleAsNonDeliverable(): ?string
    {
        return $this->HandleAsNonDeliverable;
    }

    /**
     * @param string|null $HandleAsNonDeliverable
     *
     * @return $this
     */
    public function setHandleAsNonDeliverable(?string $HandleAsNonDeliverable): static
    {
        $this->HandleAsNonDeliverable = $HandleAsNonDeliverable;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInvoice(): ?string
    {
        return $this->Invoice;
    }

    /**
     * @param string|null $Invoice
     *
     * @return $this
     */
    public function setInvoice(?string $Invoice): static
    {
        $this->Invoice = $Invoice;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInvoiceNr(): ?string
    {
        return $this->InvoiceNr;
    }

    /**
     * @param string|null $InvoiceNr
     *
     * @return $this
     */
    public function setInvoiceNr(?string $InvoiceNr): static
    {
        $this->InvoiceNr = $InvoiceNr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLicense(): ?string
    {
        return $this->License;
    }

    /**
     * @param string|null $License
     *
     * @return $this
     */
    public function setLicense(?string $License): static
    {
        $this->License = $License;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLicenseNr(): ?string
    {
        return $this->LicenseNr;
    }

    /**
     * @param string|null $LicenseNr
     *
     * @return $this
     */
    public function setLicenseNr(?string $LicenseNr): static
    {
        $this->LicenseNr = $LicenseNr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShipmentType(): ?string
    {
        return $this->ShipmentType;
    }

    /**
     * @param string|null $ShipmentType
     *
     * @return $this
     */
    public function setShipmentType(?string $ShipmentType): static
    {
        $this->ShipmentType = $ShipmentType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTrustedShipperID(): ?string
    {
        return $this->TrustedShipperID;
    }

    /**
     * @param string|null $TrustedShipperID
     *
     * @return $this
     */
    public function setTrustedShipperID(?string $TrustedShipperID): static
    {
        $this->TrustedShipperID = $TrustedShipperID;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTransactionCode(): ?string
    {
        return $this->TransactionCode;
    }

    /**
     * @param string|null $TransactionCode
     *
     * @return $this
     */
    public function setTransactionCode(?string $TransactionCode): static
    {
        $this->TransactionCode = $TransactionCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTransactionDescription(): ?string
    {
        return $this->TransactionDescription;
    }

    /**
     * @param string|null $TransactionDescription
     *
     * @return $this
     */
    public function setTransactionDescription(?string $TransactionDescription): static
    {
        $this->TransactionDescription = $TransactionDescription;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImporterReferenceCode(): ?string
    {
        return $this->ImporterReferenceCode;
    }

    /**
     * @param string|null $ImporterReferenceCode
     *
     * @return $this
     */
    public function setImporterReferenceCode(?string $ImporterReferenceCode): static
    {
        $this->ImporterReferenceCode = $ImporterReferenceCode;

        return $this;
    }
}
