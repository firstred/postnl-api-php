<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

/**
 * Class Customs
 */
class Customs extends AbstractEntity
{
    /** @var bool|null $certificate */
    protected $certificate;
    /** @var string|null $certificateNr */
    protected $certificateNr;
    /** @var Content[]|null $content */
    protected $content;
    /** @var string|null $currency */
    protected $currency;
    /** @var string|null EAN */
    protected $EAN;
    /** @var bool|null $handleAsNonDeliverable */
    protected $handleAsNonDeliverable;
    /** @var bool|null $invoice */
    protected $invoice;
    /** @var string|null $invoiceNr */
    protected $invoiceNr;
    /** @var string|null $license */
    protected $license;
    /** @var string|null $licenseNr */
    protected $licenseNr;
    /** @var string|null $shipmentType */
    protected $shipmentType;
    /** @var string|null $trustedShipperID */
    protected $trustedShipperID;
    /** @var string|null $importerReferenceCode */
    protected $importerReferenceCode;
    /** @var string|null $transactionCode */
    protected $transactionCode;
    /** @var string|null $transactionDescription */
    protected $transactionDescription;

    /**
     * @param bool|null      $certificate
     * @param string|null    $certificateNr
     * @param Content[]|null $content
     * @param string|null    $currency
     * @param string|null    $ean
     * @param bool|null      $handleAsNonDeliverable
     * @param bool|null      $invoice
     * @param string|null    $invoiceNr
     * @param bool|null      $license
     * @param string|null    $licenseNr
     * @param string|null    $shipmentType
     * @param string|null    $trustedShipperId
     * @param string|null    $importerReferenceCode
     * @param string|null    $transactionCode
     * @param string|null    $transactionDescription
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?bool $certificate = null, ?string $certificateNr = null, ?array $content = null, ?string $currency = null, ?string $ean = null, ?bool $handleAsNonDeliverable = null, ?bool $invoice = null, ?string $invoiceNr = null, ?bool $license = null, ?string $licenseNr = null, ?string $shipmentType = null, ?string $trustedShipperId = null, ?string $importerReferenceCode = null, ?string $transactionCode = null, ?string $transactionDescription = null)
    {
        parent::__construct();

        $this->setCertificate($certificate);
        $this->setCertificateNr($certificateNr);
        $this->setContent($content);
        $this->setCurrency($currency);
        $this->setEAN($ean);
        $this->setHandleAsNonDeliverable($handleAsNonDeliverable);
        $this->setInvoice($invoice);
        $this->setInvoiceNr($invoiceNr);
        $this->setLicense($license);
        $this->setLicenseNr($licenseNr);
        $this->setShipmentType($shipmentType);
        $this->setTrustedShipperID($trustedShipperId);
        $this->setImporterReferenceCode($importerReferenceCode);
        $this->setTransactionCode($transactionCode);
        $this->setTransactionDescription($transactionDescription);
    }

    /**
     * @return bool|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCertificate(): ?bool
    {
        return $this->certificate;
    }

    /**
     * @param bool|null $certificate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCertificate(?bool $certificate): Customs
    {
        $this->certificate = $certificate;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCertificateNr(): ?string
    {
        return $this->certificateNr;
    }

    /**
     * @param string|null $certificateNr
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCertificateNr(?string $certificateNr): Customs
    {
        $this->certificateNr = $certificateNr;

        return $this;
    }

    /**
     * @return Content[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getContent(): ?array
    {
        return $this->content;
    }

    /**
     * @param Content[]|null $content
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setContent(?array $content): Customs
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCurrency(?string $currency): Customs
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getEAN(): ?string
    {
        return $this->EAN;
    }

    /**
     * @param string|null $EAN
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setEAN(?string $EAN): Customs
    {
        $this->EAN = $EAN;

        return $this;
    }

    /**
     * @return bool|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getHandleAsNonDeliverable(): ?bool
    {
        return $this->handleAsNonDeliverable;
    }

    /**
     * @param bool|null $handleAsNonDeliverable
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setHandleAsNonDeliverable(?bool $handleAsNonDeliverable): Customs
    {
        $this->handleAsNonDeliverable = $handleAsNonDeliverable;

        return $this;
    }

    /**
     * @return bool|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getInvoice(): ?bool
    {
        return $this->invoice;
    }

    /**
     * @param bool|null $invoice
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setInvoice(?bool $invoice): Customs
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getInvoiceNr(): ?string
    {
        return $this->invoiceNr;
    }

    /**
     * @param string|null $invoiceNr
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setInvoiceNr(?string $invoiceNr): Customs
    {
        $this->invoiceNr = $invoiceNr;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getLicense(): ?string
    {
        return $this->license;
    }

    /**
     * @param string|null $license
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLicense(?string $license): Customs
    {
        $this->license = $license;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getLicenseNr(): ?string
    {
        return $this->licenseNr;
    }

    /**
     * @param string|null $licenseNr
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLicenseNr(?string $licenseNr): Customs
    {
        $this->licenseNr = $licenseNr;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getShipmentType(): ?string
    {
        return $this->shipmentType;
    }

    /**
     * @param string|null $shipmentType
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setShipmentType(?string $shipmentType): Customs
    {
        $this->shipmentType = $shipmentType;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getTrustedShipperID(): ?string
    {
        return $this->trustedShipperID;
    }

    /**
     * @param string|null $trustedShipperID
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setTrustedShipperID(?string $trustedShipperID): Customs
    {
        $this->trustedShipperID = $trustedShipperID;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getImporterReferenceCode(): ?string
    {
        return $this->importerReferenceCode;
    }

    /**
     * @param string|null $importerReferenceCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setImporterReferenceCode(?string $importerReferenceCode): Customs
    {
        $this->importerReferenceCode = $importerReferenceCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getTransactionCode(): ?string
    {
        return $this->transactionCode;
    }

    /**
     * @param string|null $transactionCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setTransactionCode(?string $transactionCode): Customs
    {
        $this->transactionCode = $transactionCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getTransactionDescription(): ?string
    {
        return $this->transactionDescription;
    }

    /**
     * @param string|null $transactionDescription
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setTransactionDescription(?string $transactionDescription): Customs
    {
        $this->transactionDescription = $transactionDescription;

        return $this;
    }
}
