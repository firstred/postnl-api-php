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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class Customs.
 *
 * @method string|null    getCertificate()
 * @method string|null    getCertificateNr()
 * @method Content[]|null getContent()
 * @method string|null    getCurrency()
 * @method string|null    getHandleAsNonDeliverable()
 * @method string|null    getInvoice()
 * @method string|null    getInvoiceNr()
 * @method string|null    getLicense()
 * @method string|null    getLicenseNr()
 * @method string|null    getShipmentType()
 * @method Customs        setCertificate(string|null $certificate = null)
 * @method Customs        setCertificateNr(string|null $certificateNr = null)
 * @method Customs        setContent(Content[]|null $content = null)
 * @method Customs        setCurrency(string|null $currency = null)
 * @method Customs        setHandleAsNonDeliverable(string|null $nonDeliverable = null)
 * @method Customs        setInvoice(string|null $invoice = null)
 * @method Customs        setInvoiceNr(string|null $invoiceNr = null)
 * @method Customs        setLicense(string|null $license = null)
 * @method Customs        setLicenseNr(string|null $licenseNr = null)
 * @method Customs        setShipmentType(string|null $shipmentType = null)
 *
 * @since 1.0.0
 */
class Customs extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
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
        'Confirming' => [
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
        'Labelling' => [
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
        'DeliveryDate' => [
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
        'Location' => [
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
        'Timeframe' => [
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
        'Shipping' => [
            'Certificate'            => ShippingService::DOMAIN_NAMESPACE,
            'CertificateNr'          => ShippingService::DOMAIN_NAMESPACE,
            'Content'                => ShippingService::DOMAIN_NAMESPACE,
            'Currency'               => ShippingService::DOMAIN_NAMESPACE,
            'HandleAsNonDeliverable' => ShippingService::DOMAIN_NAMESPACE,
            'Invoice'                => ShippingService::DOMAIN_NAMESPACE,
            'InvoiceNr'              => ShippingService::DOMAIN_NAMESPACE,
            'License'                => ShippingService::DOMAIN_NAMESPACE,
            'LicenseNr'              => ShippingService::DOMAIN_NAMESPACE,
            'ShipmentType'           => ShippingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $Certificate;
    /** @var string|null */
    protected $CertificateNr;
    /** @var Content[]|null */
    protected $Content;
    /** @var string|null */
    protected $Currency;
    /** @var string|null */
    protected $HandleAsNonDeliverable;
    /** @var string|null */
    protected $Invoice;
    /** @var string|null */
    protected $InvoiceNr;
    /** @var string|null */
    protected $License;
    /** @var string|null */
    protected $LicenseNr;
    /** @var string|null */
    protected $ShipmentType;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null    $certificate
     * @param string|null    $certificateNr
     * @param Content[]|null $content
     * @param string|null    $currency
     * @param string|null    $handleAsNonDeliverable
     * @param string|null    $invoice
     * @param string|null    $invoiceNr
     * @param string|null    $license
     * @param string|null    $licenseNr
     * @param string|null    $shipmentType
     */
    public function __construct(
        $certificate = null,
        $certificateNr = null,
        array $content = null,
        $currency = null,
        $handleAsNonDeliverable = null,
        $invoice = null,
        $invoiceNr = null,
        $license = null,
        $licenseNr = null,
        $shipmentType = null
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
