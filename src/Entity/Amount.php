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
 * Class Amount
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string getAccountName()
 * @method string getAmountType()
 * @method string getBIC()
 * @method string getCurrency()
 * @method string getIBAN()
 * @method string getReference()
 * @method string getTransactionNumber()
 * @method string getValue()
 *
 * @method Amount setAccountName(string $accountName)
 * @method Amount setAmountType(string $amountType)
 * @method Amount setBIC(string $bic)
 * @method Amount setCurrency(string $currency)
 * @method Amount setIBAN(string $iban)
 * @method Amount setReference(string $reference)
 * @method Amount setTransactionNumber(string $transactionNr)
 * @method Amount setValue(string $value)
 */
class Amount
{
    /** @var string[] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'    => [
            'AccountName'       => BarcodeService::DOMAIN_NAMESPACE,
            'AmountType'        => BarcodeService::DOMAIN_NAMESPACE,
            'BIC'               => BarcodeService::DOMAIN_NAMESPACE,
            'Currency'          => BarcodeService::DOMAIN_NAMESPACE,
            'IBAN'              => BarcodeService::DOMAIN_NAMESPACE,
            'Reference'         => BarcodeService::DOMAIN_NAMESPACE,
            'TransactionNumber' => BarcodeService::DOMAIN_NAMESPACE,
            'Value'             => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'AccountName'       => ConfirmingService::DOMAIN_NAMESPACE,
            'AmountType'        => ConfirmingService::DOMAIN_NAMESPACE,
            'BIC'               => ConfirmingService::DOMAIN_NAMESPACE,
            'Currency'          => ConfirmingService::DOMAIN_NAMESPACE,
            'IBAN'              => ConfirmingService::DOMAIN_NAMESPACE,
            'Reference'         => ConfirmingService::DOMAIN_NAMESPACE,
            'TransactionNumber' => ConfirmingService::DOMAIN_NAMESPACE,
            'Value'             => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'  => [
            'AccountName'       => LabellingService::DOMAIN_NAMESPACE,
            'AmountType'        => LabellingService::DOMAIN_NAMESPACE,
            'BIC'               => LabellingService::DOMAIN_NAMESPACE,
            'Currency'          => LabellingService::DOMAIN_NAMESPACE,
            'IBAN'              => LabellingService::DOMAIN_NAMESPACE,
            'Reference'         => LabellingService::DOMAIN_NAMESPACE,
            'TransactionNumber' => LabellingService::DOMAIN_NAMESPACE,
            'Value'             => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus'  => [
            'AccountName'       => ShippingStatusService::DOMAIN_NAMESPACE,
            'AmountType'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'BIC'               => ShippingStatusService::DOMAIN_NAMESPACE,
            'Currency'          => ShippingStatusService::DOMAIN_NAMESPACE,
            'IBAN'              => ShippingStatusService::DOMAIN_NAMESPACE,
            'Reference'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'TransactionNumber' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Value'             => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'  => [
            'AccountName'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'AmountType'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'BIC'               => DeliveryDateService::DOMAIN_NAMESPACE,
            'Currency'          => DeliveryDateService::DOMAIN_NAMESPACE,
            'IBAN'              => DeliveryDateService::DOMAIN_NAMESPACE,
            'Reference'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'TransactionNumber' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Value'             => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'  => [
            'AccountName'       => LocationService::DOMAIN_NAMESPACE,
            'AmountType'        => LocationService::DOMAIN_NAMESPACE,
            'BIC'               => LocationService::DOMAIN_NAMESPACE,
            'Currency'          => LocationService::DOMAIN_NAMESPACE,
            'IBAN'              => LocationService::DOMAIN_NAMESPACE,
            'Reference'         => LocationService::DOMAIN_NAMESPACE,
            'TransactionNumber' => LocationService::DOMAIN_NAMESPACE,
            'Value'             => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'  => [
            'AccountName'       => TimeframeService::DOMAIN_NAMESPACE,
            'AmountType'        => TimeframeService::DOMAIN_NAMESPACE,
            'BIC'               => TimeframeService::DOMAIN_NAMESPACE,
            'Currency'          => TimeframeService::DOMAIN_NAMESPACE,
            'IBAN'              => TimeframeService::DOMAIN_NAMESPACE,
            'Reference'         => TimeframeService::DOMAIN_NAMESPACE,
            'TransactionNumber' => TimeframeService::DOMAIN_NAMESPACE,
            'Value'             => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string $AccountName */
    protected $AccountName;
    /** @var string $AmountType */
    protected $AmountType;
    /** @var string $BIC */
    protected $BIC;
    /** @var string $Currency */
    protected $Currency;
    /** @var string $IBAN */
    protected $IBAN;
    /** @var string $Reference */
    protected $Reference;
    /** @var string $TransactionNumber */
    protected $TransactionNumber;
    /** @var string $Value */
    protected $Value;
    // @codingStandardsIgnoreEnd

    /**
     * @param string $accountName
     * @param string $amountType
     * @param string $bic
     * @param string $currency
     * @param string $iban
     * @param string $reference
     * @param string $transactionNumber
     * @param string $value
     */
    public function __construct(
        $accountName,
        $amountType,
        $bic,
        $currency,
        $iban,
        $reference,
        $transactionNumber,
        $value
    ) {
        parent::__construct();

        $this->setAccountName($accountName);
        $this->setAmountType($amountType);
        $this->setBIC($bic);
        $this->setCurrency($currency);
        $this->setIBAN($iban);
        $this->setReference($reference);
        $this->setTransactionNumber($transactionNumber);
        $this->setValue($value);
    }
}
