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
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Customs.
 */
class Customs extends SerializableObject
{
    /**
     * @var string|null
     */
    protected string|null $Certificate = null;

    /**
     * @var string|null
     */
    protected string|null $CertificateNr = null;

    /**
     * @var array|null
     */
    protected array|null $Content = null;

    /**
     * @var string|null
     */
    protected string|null $Currency = null;

    /**
     * @var string|null
     */
    protected string|null $HandleAsNonDeliverable = null;

    /**
     * @var string|null
     */
    protected string|null $Invoice = null;

    /**
     * @var string|null
     */
    protected string|null $InvoiceNr = null;

    /**
     * @var string|null
     */
    protected string|null $License = null;

    /**
     * @var string|null
     */
    protected string|null $LicenseNr = null;

    /**
     * @var string|null
     */
    protected string|null $ShipmentType = null;

    /**
     * Customs constructor.
     *
     * @param string      $service
     * @param string      $propType
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
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType,

        string|null $Certificate = null,
        string|null $CertificateNr = null,
        array|null $Content = null,
        string|null $Currency = null,
        string|null $HandleAsNonDeliverable = null,
        string|null $Invoice = null,
        string|null $InvoiceNr = null,
        string|null $License = null,
        string|null $LicenseNr = null,
        string|null $ShipmentType = null,
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

    /**
     * @return string|null
     */
    public function getCertificate(): string|null
    {
        return $this->Certificate;
    }

    /**
     * @param string|null $Certificate
     *
     * @return static
     */
    public function setCertificate(string|null $Certificate = null): static
    {
        $this->Certificate = $Certificate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCertificateNr(): string|null
    {
        return $this->CertificateNr;
    }

    /**
     * @param string|null $CertificateNr
     *
     * @return static
     */
    public function setCertificateNr(string|null $CertificateNr = null): static
    {
        $this->CertificateNr = $CertificateNr;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getContent(): array|null
    {
        return $this->Content;
    }

    /**
     * @param array|null $Content
     *
     * @return static
     */
    public function setContent(array|null $Content = null): static
    {
        $this->Content = $Content;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): string|null
    {
        return $this->Currency;
    }

    /**
     * @param string|null $Currency
     *
     * @return static
     */
    public function setCurrency(string|null $Currency = null): static
    {
        $this->Currency = $Currency;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHandleAsNonDeliverable(): string|null
    {
        return $this->HandleAsNonDeliverable;
    }

    /**
     * @param string|null $HandleAsNonDeliverable
     *
     * @return static
     */
    public function setHandleAsNonDeliverable(string|null $HandleAsNonDeliverable = null): static
    {
        $this->HandleAsNonDeliverable = $HandleAsNonDeliverable;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInvoice(): string|null
    {
        return $this->Invoice;
    }

    /**
     * @param string|null $Invoice
     *
     * @return static
     */
    public function setInvoice(string|null $Invoice = null): static
    {
        $this->Invoice = $Invoice;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInvoiceNr(): string|null
    {
        return $this->InvoiceNr;
    }

    /**
     * @param string|null $InvoiceNr
     *
     * @return static
     */
    public function setInvoiceNr(string|null $InvoiceNr = null): static
    {
        $this->InvoiceNr = $InvoiceNr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLicense(): string|null
    {
        return $this->License;
    }

    /**
     * @param string|null $license
     *
     * @return static
     */
    public function setLicense(string|null $license = null): static
    {
        $this->License = $license;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLicenseNr(): string|null
    {
        return $this->LicenseNr;
    }

    /**
     * @param string|null $LicenseNr
     *
     * @return static
     */
    public function setLicenseNr(string|null $LicenseNr = null): static
    {
        $this->LicenseNr = $LicenseNr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShipmentType(): string|null
    {
        return $this->ShipmentType;
    }

    /**
     * @param string|null $ShipmentType
     *
     * @return static
     */
    public function setShipmentType(string|null $ShipmentType = null): static
    {
        $this->ShipmentType = $ShipmentType;

        return $this;
    }
}
