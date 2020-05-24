<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class Customs.
 */
interface CustomsInterface extends EntityInterface
{
    /**
     * Get certificate.
     *
     * @return bool|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customs::$certificate
     */
    public function getCertificate(): ?bool;

    /**
     * Set certificate.
     *
     * @pattern N/A
     *
     * @param bool|null $certificate
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customs::$certificate
     */
    public function setCertificate(?bool $certificate): CustomsInterface;

    /**
     * Get certificate number.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customs::$certificateNr
     */
    public function getCertificateNr(): ?string;

    /**
     * Set certificate number.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $certificateNr
     *
     * @return static
     *
     * @example NR112233
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customs::$certificateNr
     */
    public function setCertificateNr(?string $certificateNr): CustomsInterface;

    /**
     * Get content.
     *
     * @return ContentInterface[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customs::$content
     */
    public function getContent(): ?array;

    /**
     * Set content.
     *
     * @pattern N/A
     *
     * @param ContentInterface[]|null $content
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customs::$content
     */
    public function setContent(?array $content): CustomsInterface;

    /**
     * Get currency.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customs::$currency
     */
    public function getCurrency(): ?string;

    /**
     * Set currency.
     *
     * @pattern ^[A-Z]{3}$
     *
     * @param string|null $currency
     *
     * @return static
     *
     * @example EUR
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customs::$currency
     */
    public function setCurrency(?string $currency): CustomsInterface;

    /**
     * Get EAN.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customs::$EANa
     */
    public function getEAN(): ?string;

    /**
     * Set EAN.
     *
     * @pattern ^[0-9]{8}(?:[0-9]{5})?$
     *
     * @param string|null $EAN
     *
     * @return static
     *
     * @example 7501031311309
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customs::$EAN
     */
    public function setEAN(?string $EAN): CustomsInterface;

    /**
     * Get handle as non-deliverable.
     *
     * @return bool|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customs::$handleAsNonDeliverable
     */
    public function getHandleAsNonDeliverable(): ?bool;

    /**
     * Set handle as non-deliverable.
     *
     * @pattern N/A
     *
     * @param bool|null $handleAsNonDeliverable
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customs::$handleAsNonDeliverable
     */
    public function setHandleAsNonDeliverable(?bool $handleAsNonDeliverable): CustomsInterface;

    /**
     * Get invoice.
     *
     * @return bool|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customs::$invoice
     */
    public function getInvoice(): ?bool;

    /**
     * Set invoice.
     *
     * @pattern N/A
     *
     * @param bool|null $invoice
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customs::$invoice
     */
    public function setInvoice(?bool $invoice): CustomsInterface;

    /**
     * Get invoice number.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customs::$invoiceNr
     */
    public function getInvoiceNr(): ?string;

    /**
     * Set invoice number.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $invoiceNr
     *
     * @return static
     *
     * @example 22334455
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customs::$invoiceNr
     */
    public function setInvoiceNr(?string $invoiceNr): CustomsInterface;

    /**
     * Get license.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customs::$license
     */
    public function getLicense(): ?string;

    /**
     * Set license.
     *
     * @pattern N/A
     *
     * @param string|null $license
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customs::$license
     */
    public function setLicense(?string $license): CustomsInterface;

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customs::$licenseNr
     */
    public function getLicenseNr(): ?string;

    /**
     * Set license number.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $licenseNr
     *
     * @return static
     *
     * @example 11223344
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customs::$licenseNr
     */
    public function setLicenseNr(?string $licenseNr): CustomsInterface;

    /**
     * Get shipment type.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customs::$shipmentType
     */
    public function getShipmentType(): ?string;

    /**
     * Set shipment type.
     *
     * @pattern ^(?:Gift|Documents|Commercial Goods|Commercial Sample|Returned Goods)$
     *
     * @param string|null $shipmentType
     *
     * @return static
     *
     * @example Documents
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customs::$shipmentType
     */
    public function setShipmentType(?string $shipmentType): CustomsInterface;

    /**
     * Get Trusted Shipper ID.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customs::$trustedShipperID
     */
    public function getTrustedShipperID(): ?string;

    /**
     * Set Trusted Shipper ID.
     *
     * @pattern ^.{0,50}$
     *
     * @param string|null $trustedShipperID
     *
     * @return static
     *
     * @example 1234
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customs::$trustedShipperID
     */
    public function setTrustedShipperID(?string $trustedShipperID): CustomsInterface;

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customs::$importerReferenceCode
     */
    public function getImporterReferenceCode(): ?string;

    /**
     * Set importer reference code.
     *
     * @pattern ^.{0,50}$
     *
     * @param string|null $importerReferenceCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customs::$importerReferenceCode
     *
     * @example 567
     */
    public function setImporterReferenceCode(?string $importerReferenceCode): CustomsInterface;

    /**
     * Get transaction code.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customs::$transactionCode
     * @see   Customs::$transactionCode
     */
    public function getTransactionCode(): ?string;

    /**
     * Set transaction code.
     *
     * @pattern ^.{0,50}$
     *
     * @param string|null $transactionCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customs::$transactionCode
     *
     * @example 100
     */
    public function setTransactionCode(?string $transactionCode): CustomsInterface;

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Customs::$transactionDescription
     */
    public function getTransactionDescription(): ?string;

    /**
     * Set transaction description.
     *
     * @pattern ^.{0,50}$
     *
     * @param string|null $transactionDescription
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example Milk Powder
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Customs::$transactionDescription
     */
    public function setTransactionDescription(?string $transactionDescription): CustomsInterface;
}
