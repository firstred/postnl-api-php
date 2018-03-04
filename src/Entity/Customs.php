<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
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
 * @author    Michael Dekker <michael@thirtybees.com>
 * @copyright 2017-2018 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Entity;

use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class Customs
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string    getCertificate()
 * @method string    getCertificateNr()
 * @method Content[] getContent()
 * @method string    getCurrency()
 * @method string    getHandleAsNonDeliverable()
 * @method string    getInvoice()
 * @method string    getInvoiceNr()
 * @method string    getLicense()
 * @method string    getLicenseNr()
 * @method string    getShipmentType()
 *
 * @method Customs setCertificate(string $certificate)
 * @method Customs setCertificateNr(string $certificateNr)
 * @method Customs setContent(Content[] $content)
 * @method Customs setCurrency(string $currency)
 * @method Customs setHandleAsNonDeliverable(string $nonDeliverable)
 * @method Customs setInvoice(string $invoice)
 * @method Customs setInvoiceNr(string $invoiceNr)
 * @method Customs setLicense(string $license)
 * @method Customs setLicenseNr(string $licenseNr)
 * @method Customs setShipmentType(string $shipmentType)
 */
class Customs extends AbstractEntity
{
    /** @var string[] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'Certificate'            => BarcodeService::DOMAIN_NAMESPACE,
            'CertificateNr'          => BarcodeService::DOMAIN_NAMESPACE,
            'Content'                => BarcodeService::DOMAIN_NAMESPACE,
            'Currency'               => BarcodeService::DOMAIN_NAMESPACE,
            'HandleAsNonDeliverable' => BarcodeService::DOMAIN_NAMESPACE,
            'Invoice'                => BarcodeService::DOMAIN_NAMESPACE,
            'InvoiceNr'              => BarcodeService::DOMAIN_NAMESPACE,
            'License'                => BarcodeService::DOMAIN_NAMESPACE,
            'LicenseNr'              => BarcodeService::DOMAIN_NAMESPACE,
            'ShipmentType'           => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Certificate'            => ConfirmingService::DOMAIN_NAMESPACE,
            'CertificateNr'          => ConfirmingService::DOMAIN_NAMESPACE,
            'Content'                => ConfirmingService::DOMAIN_NAMESPACE,
            'Currency'               => ConfirmingService::DOMAIN_NAMESPACE,
            'HandleAsNonDeliverable' => ConfirmingService::DOMAIN_NAMESPACE,
            'Invoice'                => ConfirmingService::DOMAIN_NAMESPACE,
            'InvoiceNr'              => ConfirmingService::DOMAIN_NAMESPACE,
            'License'                => ConfirmingService::DOMAIN_NAMESPACE,
            'LicenseNr'              => ConfirmingService::DOMAIN_NAMESPACE,
            'ShipmentType'           => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Certificate'            => LabellingService::DOMAIN_NAMESPACE,
            'CertificateNr'          => LabellingService::DOMAIN_NAMESPACE,
            'Content'                => LabellingService::DOMAIN_NAMESPACE,
            'Currency'               => LabellingService::DOMAIN_NAMESPACE,
            'HandleAsNonDeliverable' => LabellingService::DOMAIN_NAMESPACE,
            'Invoice'                => LabellingService::DOMAIN_NAMESPACE,
            'InvoiceNr'              => LabellingService::DOMAIN_NAMESPACE,
            'License'                => LabellingService::DOMAIN_NAMESPACE,
            'LicenseNr'              => LabellingService::DOMAIN_NAMESPACE,
            'ShipmentType'           => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Certificate'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'CertificateNr'          => ShippingStatusService::DOMAIN_NAMESPACE,
            'Content'                => ShippingStatusService::DOMAIN_NAMESPACE,
            'Currency'               => ShippingStatusService::DOMAIN_NAMESPACE,
            'HandleAsNonDeliverable' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Invoice'                => ShippingStatusService::DOMAIN_NAMESPACE,
            'InvoiceNr'              => ShippingStatusService::DOMAIN_NAMESPACE,
            'License'                => ShippingStatusService::DOMAIN_NAMESPACE,
            'LicenseNr'              => ShippingStatusService::DOMAIN_NAMESPACE,
            'ShipmentType'           => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Certificate'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'CertificateNr'          => DeliveryDateService::DOMAIN_NAMESPACE,
            'Content'                => DeliveryDateService::DOMAIN_NAMESPACE,
            'Currency'               => DeliveryDateService::DOMAIN_NAMESPACE,
            'HandleAsNonDeliverable' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Invoice'                => DeliveryDateService::DOMAIN_NAMESPACE,
            'InvoiceNr'              => DeliveryDateService::DOMAIN_NAMESPACE,
            'License'                => DeliveryDateService::DOMAIN_NAMESPACE,
            'LicenseNr'              => DeliveryDateService::DOMAIN_NAMESPACE,
            'ShipmentType'           => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Certificate'            => LocationService::DOMAIN_NAMESPACE,
            'CertificateNr'          => LocationService::DOMAIN_NAMESPACE,
            'Content'                => LocationService::DOMAIN_NAMESPACE,
            'Currency'               => LocationService::DOMAIN_NAMESPACE,
            'HandleAsNonDeliverable' => LocationService::DOMAIN_NAMESPACE,
            'Invoice'                => LocationService::DOMAIN_NAMESPACE,
            'InvoiceNr'              => LocationService::DOMAIN_NAMESPACE,
            'License'                => LocationService::DOMAIN_NAMESPACE,
            'LicenseNr'              => LocationService::DOMAIN_NAMESPACE,
            'ShipmentType'           => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Certificate'            => TimeframeService::DOMAIN_NAMESPACE,
            'CertificateNr'          => TimeframeService::DOMAIN_NAMESPACE,
            'Content'                => TimeframeService::DOMAIN_NAMESPACE,
            'Currency'               => TimeframeService::DOMAIN_NAMESPACE,
            'HandleAsNonDeliverable' => TimeframeService::DOMAIN_NAMESPACE,
            'Invoice'                => TimeframeService::DOMAIN_NAMESPACE,
            'InvoiceNr'              => TimeframeService::DOMAIN_NAMESPACE,
            'License'                => TimeframeService::DOMAIN_NAMESPACE,
            'LicenseNr'              => TimeframeService::DOMAIN_NAMESPACE,
            'ShipmentType'           => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string $Certificate */
    protected $Certificate = null;
    /** @var string $CertificateNr */
    protected $CertificateNr = null;
    /** @var Content[] $Content */
    protected $Content = null;
    /** @var string $Currency */
    protected $Currency = null;
    /** @var string $HandleAsNonDeliverable */
    protected $HandleAsNonDeliverable = null;
    /** @var string $Invoice */
    protected $Invoice = null;
    /** @var string $InvoiceNr */
    protected $InvoiceNr = null;
    /** @var string $License */
    protected $License = null;
    /** @var string $LicenseNr */
    protected $LicenseNr = null;
    /** @var string $ShipmentType */
    protected $ShipmentType = null;
    // @codingStandardsIgnoreEnd

    /**
     * @param string    $certificate
     * @param string    $certificateNr
     * @param Content[] $content
     * @param string    $currency
     * @param string    $handleAsNonDeliverable
     * @param string    $invoice
     * @param string    $invoiceNr
     * @param string    $license
     * @param string    $licenseNr
     * @param string    $shipmentType
     */
    public function __construct(
        $certificate,
        $certificateNr,
        array $content,
        $currency,
        $handleAsNonDeliverable,
        $invoice,
        $invoiceNr,
        $license,
        $licenseNr,
        $shipmentType
    ) {
        parent::__construct();

        $this->setCertificate($certificate);
        $this->setCertificateNr($certificateNr);
        $this->setContent($content);
        $this->setCurrency($currency);
        $this->setHandleAsNonDeliverable($handleAsNonDeliverable);
        $this->setInvoice($invoice);
        $this->setInvoiceNr($invoiceNr);
        $this->setLicense($license);
        $this->setLicenseNr($licenseNr);
        $this->setShipmentType($shipmentType);
    }
}
