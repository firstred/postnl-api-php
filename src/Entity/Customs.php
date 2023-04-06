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
    /** @var string|null $Certificate */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Certificate = null;

    /** @var string|null $CertificateNr */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $CertificateNr = null;

    /** @var Content[]|null $Content */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: Content::class, isArray: true)]
    protected ?array $Content = null;

    /** @var string|null $Currency */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Currency = null;

    /** @var string|null $HandleAsNonDeliverable*/
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $HandleAsNonDeliverable = null;

    /** @var string|null $Invoice */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Invoice = null;

    /** @var string|null $InvoiceNr */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $InvoiceNr = null;

    /** @var string|null $License */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $License = null;

    /** @var string|null $LicenseNr */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $LicenseNr = null;

    /** @var string|null $ShipmentType */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $ShipmentType = null;

    /** @var string|null $TrustedShipperID */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $TrustedShipperID = null;

    /** @var string|null $TransactionCode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $TransactionCode = null;

    /** @var string|null $TransactionDescription */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $TransactionDescription = null;

    /** @var string|null $ImporterReferenceCode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
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
     * @return static
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
     * @return static
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
     * @return static
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
    public function getHandleAsNonDeliverable(): ?string
    {
        return $this->HandleAsNonDeliverable;
    }

    /**
     * @param string|null $HandleAsNonDeliverable
     *
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
     */
    public function setImporterReferenceCode(?string $ImporterReferenceCode): static
    {
        $this->ImporterReferenceCode = $ImporterReferenceCode;

        return $this;
    }
}
