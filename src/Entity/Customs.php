<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * *Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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

use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;
use Sabre\Xml\Writer;

/**
 * Class Customs
 *
 * @method bool|null      getCertificate()
 * @method string|null    getCertificateNr()
 * @method Content[]|null getContent()
 * @method string|null    getCurrency()
 * @method string|null    getEAN()
 * @method bool|null      getHandleAsNonDeliverable()
 * @method bool|null      getInvoice()
 * @method string|null    getInvoiceNr()
 * @method bool|null      getLicense()
 * @method string|null    getLicenseNr()
 * @method string|null    getProductURL()
 * @method string|null    getShipmentType()
 * @method string|null    getTrustedShipperID()
 * @method string|null    getImporterReferenceCode()
 * @method string|null    getTransactionCode()
 * @method string|null    getTransactionDescription()
 *
 *
 * @method Customs setCertificate(bool|null $certificate = null)
 * @method Customs setCertificateNr(string|null $certificateNr = null)
 * @method Customs setContent(Content[]|null $content = null)
 * @method Customs setCurrency(string|null $currency = null)
 * @method Customs setEAN(string|null $ean = null)
 * @method Customs setHandleAsNonDeliverable(bool|null $nonDeliverable = null)
 * @method Customs setInvoice(bool|null $invoice = null)
 * @method Customs setInvoiceNr(string|null $invoiceNr = null)
 * @method Customs setLicense(bool|null $license = null)
 * @method Customs setLicenseNr(string|null $licenseNr = null)
 * @method Customs setProductUrl(string|null $url = null)
 * @method Customs setShipmentType(string|null $shipmentType = null)
 * @method Customs setTrustedShipperID(string|null $id = null)
 * @method Customs setImporterReferenceCode(string|null $code = null)
 * @method Customs setTransactionCode(string|null $code = null)
 * @method Customs setTransactionDescription(string|null $code = null)
 */
class Customs extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'Certificate'            => BarcodeService::DOMAIN_NAMESPACE,
            'CertificateNr'          => BarcodeService::DOMAIN_NAMESPACE,
            'Content'                => BarcodeService::DOMAIN_NAMESPACE,
            'Currency'               => BarcodeService::DOMAIN_NAMESPACE,
            'EAN'                    => BarcodeService::DOMAIN_NAMESPACE,
            'HandleAsNonDeliverable' => BarcodeService::DOMAIN_NAMESPACE,
            'Invoice'                => BarcodeService::DOMAIN_NAMESPACE,
            'InvoiceNr'              => BarcodeService::DOMAIN_NAMESPACE,
            'License'                => BarcodeService::DOMAIN_NAMESPACE,
            'LicenseNr'              => BarcodeService::DOMAIN_NAMESPACE,
            'ProductURL'             => BarcodeService::DOMAIN_NAMESPACE,
            'ShipmentType'           => BarcodeService::DOMAIN_NAMESPACE,
            'TrustedShipperID'       => BarcodeService::DOMAIN_NAMESPACE,
            'ImporterReferenceCode'  => BarcodeService::DOMAIN_NAMESPACE,
            'TransactionCode'        => BarcodeService::DOMAIN_NAMESPACE,
            'TransactionDescription' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Certificate'            => ConfirmingService::DOMAIN_NAMESPACE,
            'CertificateNr'          => ConfirmingService::DOMAIN_NAMESPACE,
            'Content'                => ConfirmingService::DOMAIN_NAMESPACE,
            'Currency'               => ConfirmingService::DOMAIN_NAMESPACE,
            'EAN'                    => ConfirmingService::DOMAIN_NAMESPACE,
            'HandleAsNonDeliverable' => ConfirmingService::DOMAIN_NAMESPACE,
            'Invoice'                => ConfirmingService::DOMAIN_NAMESPACE,
            'InvoiceNr'              => ConfirmingService::DOMAIN_NAMESPACE,
            'License'                => ConfirmingService::DOMAIN_NAMESPACE,
            'LicenseNr'              => ConfirmingService::DOMAIN_NAMESPACE,
            'ProductURL'             => ConfirmingService::DOMAIN_NAMESPACE,
            'ShipmentType'           => ConfirmingService::DOMAIN_NAMESPACE,
            'TrustedShipperID'       => ConfirmingService::DOMAIN_NAMESPACE,
            'ImporterReferenceCode'  => ConfirmingService::DOMAIN_NAMESPACE,
            'TransactionCode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'TransactionDescription' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Certificate'            => LabellingService::DOMAIN_NAMESPACE,
            'CertificateNr'          => LabellingService::DOMAIN_NAMESPACE,
            'Content'                => LabellingService::DOMAIN_NAMESPACE,
            'Currency'               => LabellingService::DOMAIN_NAMESPACE,
            'EAN'                    => LabellingService::DOMAIN_NAMESPACE,
            'HandleAsNonDeliverable' => LabellingService::DOMAIN_NAMESPACE,
            'Invoice'                => LabellingService::DOMAIN_NAMESPACE,
            'InvoiceNr'              => LabellingService::DOMAIN_NAMESPACE,
            'License'                => LabellingService::DOMAIN_NAMESPACE,
            'LicenseNr'              => LabellingService::DOMAIN_NAMESPACE,
            'ProductURL'             => LabellingService::DOMAIN_NAMESPACE,
            'ShipmentType'           => LabellingService::DOMAIN_NAMESPACE,
            'TrustedShipperID'       => LabellingService::DOMAIN_NAMESPACE,
            'ImporterReferenceCode'  => LabellingService::DOMAIN_NAMESPACE,
            'TransactionCode'        => LabellingService::DOMAIN_NAMESPACE,
            'TransactionDescription' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Certificate'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'CertificateNr'          => ShippingStatusService::DOMAIN_NAMESPACE,
            'Content'                => ShippingStatusService::DOMAIN_NAMESPACE,
            'Currency'               => ShippingStatusService::DOMAIN_NAMESPACE,
            'EAN'                    => ShippingStatusService::DOMAIN_NAMESPACE,
            'HandleAsNonDeliverable' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Invoice'                => ShippingStatusService::DOMAIN_NAMESPACE,
            'InvoiceNr'              => ShippingStatusService::DOMAIN_NAMESPACE,
            'License'                => ShippingStatusService::DOMAIN_NAMESPACE,
            'LicenseNr'              => ShippingStatusService::DOMAIN_NAMESPACE,
            'ProductURL'             => ShippingStatusService::DOMAIN_NAMESPACE,
            'ShipmentType'           => ShippingStatusService::DOMAIN_NAMESPACE,
            'TrustedShipperID'       => ShippingStatusService::DOMAIN_NAMESPACE,
            'ImporterReferenceCode'  => ShippingStatusService::DOMAIN_NAMESPACE,
            'TransactionCode'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'TransactionDescription' => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Certificate'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'CertificateNr'          => DeliveryDateService::DOMAIN_NAMESPACE,
            'Content'                => DeliveryDateService::DOMAIN_NAMESPACE,
            'Currency'               => DeliveryDateService::DOMAIN_NAMESPACE,
            'EAN'                    => DeliveryDateService::DOMAIN_NAMESPACE,
            'HandleAsNonDeliverable' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Invoice'                => DeliveryDateService::DOMAIN_NAMESPACE,
            'InvoiceNr'              => DeliveryDateService::DOMAIN_NAMESPACE,
            'License'                => DeliveryDateService::DOMAIN_NAMESPACE,
            'LicenseNr'              => DeliveryDateService::DOMAIN_NAMESPACE,
            'ProductURL'             => DeliveryDateService::DOMAIN_NAMESPACE,
            'ShipmentType'           => DeliveryDateService::DOMAIN_NAMESPACE,
            'TrustedShipperID'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'ImporterReferenceCode'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'TransactionCode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'TransactionDescription' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Certificate'            => LocationService::DOMAIN_NAMESPACE,
            'CertificateNr'          => LocationService::DOMAIN_NAMESPACE,
            'Content'                => LocationService::DOMAIN_NAMESPACE,
            'Currency'               => LocationService::DOMAIN_NAMESPACE,
            'EAN'                    => LocationService::DOMAIN_NAMESPACE,
            'HandleAsNonDeliverable' => LocationService::DOMAIN_NAMESPACE,
            'Invoice'                => LocationService::DOMAIN_NAMESPACE,
            'InvoiceNr'              => LocationService::DOMAIN_NAMESPACE,
            'License'                => LocationService::DOMAIN_NAMESPACE,
            'LicenseNr'              => LocationService::DOMAIN_NAMESPACE,
            'ProductURL'             => LocationService::DOMAIN_NAMESPACE,
            'ShipmentType'           => LocationService::DOMAIN_NAMESPACE,
            'TrustedShipperID'       => LocationService::DOMAIN_NAMESPACE,
            'ImporterReferenceCode'  => LocationService::DOMAIN_NAMESPACE,
            'TransactionCode'        => LocationService::DOMAIN_NAMESPACE,
            'TransactionDescription' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Certificate'            => TimeframeService::DOMAIN_NAMESPACE,
            'CertificateNr'          => TimeframeService::DOMAIN_NAMESPACE,
            'Content'                => TimeframeService::DOMAIN_NAMESPACE,
            'Currency'               => TimeframeService::DOMAIN_NAMESPACE,
            'EAN'                    => TimeframeService::DOMAIN_NAMESPACE,
            'HandleAsNonDeliverable' => TimeframeService::DOMAIN_NAMESPACE,
            'Invoice'                => TimeframeService::DOMAIN_NAMESPACE,
            'InvoiceNr'              => TimeframeService::DOMAIN_NAMESPACE,
            'License'                => TimeframeService::DOMAIN_NAMESPACE,
            'LicenseNr'              => TimeframeService::DOMAIN_NAMESPACE,
            'ProductURL'             => TimeframeService::DOMAIN_NAMESPACE,
            'ShipmentType'           => TimeframeService::DOMAIN_NAMESPACE,
            'TrustedShipperID'       => TimeframeService::DOMAIN_NAMESPACE,
            'ImporterReferenceCode'  => TimeframeService::DOMAIN_NAMESPACE,
            'TransactionCode'        => TimeframeService::DOMAIN_NAMESPACE,
            'TransactionDescription' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var bool|null $Certificate */
    protected $Certificate;
    /** @var string|null $CertificateNr */
    protected $CertificateNr;
    /** @var Content[]|null $Content */
    protected $Content;
    /** @var string|null $Currency */
    protected $Currency;
    /** @var string|null EAN */
    protected $EAN;
    /** @var bool|null $HandleAsNonDeliverable */
    protected $HandleAsNonDeliverable;
    /** @var bool|null $Invoice */
    protected $Invoice;
    /** @var string|null $InvoiceNr */
    protected $InvoiceNr;
    /** @var string|null $License */
    protected $License;
    /** @var string|null $LicenseNr */
    protected $LicenseNr;
    /** @var string|null $ShipmentType */
    protected $ShipmentType;
    // @codingStandardsIgnoreEnd

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
     * Return a serializable array for the XMLWriter
     *
     * @param Writer $writer
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
            $writer->write($xml);

            return;
        }

        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if ('Certificate' === $propertyName) {
                // @codingStandardsIgnoreLine
                if (isset($this->Certificate)) {
                    // @codingStandardsIgnoreLine
                    $xml["{{$namespace}}Certificate"] = $this->Certificate ? 'true' : 'false';
                }
            } elseif ('HandleAsNonDeliverable' === $propertyName) {
                // @codingStandardsIgnoreLine
                if (isset($this->HandleAsNonDeliverable)) {
                    // @codingStandardsIgnoreLine
                    $xml["{{$namespace}}HandleAsNonDeliverable"] = $this->HandleAsNonDeliverable ? 'true' : 'false';
                }
            } elseif ('Invoice' === $propertyName) {
                // @codingStandardsIgnoreLine
                if (isset($this->Invoice)) {
                    // @codingStandardsIgnoreLine
                    $xml["{{$namespace}}Invoice"] = $this->Invoice ? 'true' : 'false';
                }
            } elseif ('License' === $propertyName) {
                // @codingStandardsIgnoreLine
                if (isset($this->License)) {
                    // @codingStandardsIgnoreLine
                    $xml["{{$namespace}}License"] = $this->License ? 'true' : 'false';
                }
            } elseif (isset($this->{$propertyName})) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->{$propertyName};
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}
