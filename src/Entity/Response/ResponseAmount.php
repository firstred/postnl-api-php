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

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class ResponseAmount.
 *
 * @method string|null    getAccountName()
 * @method string|null    getResponseAmountType()
 * @method string|null    getBIC()
 * @method string|null    getCurrency()
 * @method string|null    getIBAN()
 * @method string|null    getReference()
 * @method string|null    getTransactionNumber()
 * @method string|null    getValue()
 * @method string|null    getVerzekerdBedrag()
 * @method ResponseAmount setAccountName(string|null $AccountName = null)
 * @method ResponseAmount setResponseAmountType(string|null $ResponseAmountType = null)
 * @method ResponseAmount setBIC(string|null $BIC = null)
 * @method ResponseAmount setCurrency(string|null $Currency = null)
 * @method ResponseAmount setIBAN(string|null $IBAN = null)
 * @method ResponseAmount setReference(string|null $Reference = null)
 * @method ResponseAmount setTransactionNumber(string|null $TransactionNumber = null)
 * @method ResponseAmount setValue(string|null $Value = null)
 * @method ResponseAmount setVerzekerdBedrag(string|null $Value = null)
 *
 * @since 1.0.0
 */
class ResponseAmount extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'AccountName'        => BarcodeService::DOMAIN_NAMESPACE,
            'ResponseAmountType' => BarcodeService::DOMAIN_NAMESPACE,
            'BIC'                => BarcodeService::DOMAIN_NAMESPACE,
            'Currency'           => BarcodeService::DOMAIN_NAMESPACE,
            'IBAN'               => BarcodeService::DOMAIN_NAMESPACE,
            'Reference'          => BarcodeService::DOMAIN_NAMESPACE,
            'TransactionNumber'  => BarcodeService::DOMAIN_NAMESPACE,
            'Value'              => BarcodeService::DOMAIN_NAMESPACE,
            'VerzekerdBedrag'    => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'AccountName'        => ConfirmingService::DOMAIN_NAMESPACE,
            'ResponseAmountType' => ConfirmingService::DOMAIN_NAMESPACE,
            'BIC'                => ConfirmingService::DOMAIN_NAMESPACE,
            'Currency'           => ConfirmingService::DOMAIN_NAMESPACE,
            'IBAN'               => ConfirmingService::DOMAIN_NAMESPACE,
            'Reference'          => ConfirmingService::DOMAIN_NAMESPACE,
            'TransactionNumber'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Value'              => ConfirmingService::DOMAIN_NAMESPACE,
            'VerzekerdBedrag'    => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'AccountName'        => LabellingService::DOMAIN_NAMESPACE,
            'ResponseAmountType' => LabellingService::DOMAIN_NAMESPACE,
            'BIC'                => LabellingService::DOMAIN_NAMESPACE,
            'Currency'           => LabellingService::DOMAIN_NAMESPACE,
            'IBAN'               => LabellingService::DOMAIN_NAMESPACE,
            'Reference'          => LabellingService::DOMAIN_NAMESPACE,
            'TransactionNumber'  => LabellingService::DOMAIN_NAMESPACE,
            'Value'              => LabellingService::DOMAIN_NAMESPACE,
            'VerzekerdBedrag'    => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'AccountName'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'ResponseAmountType' => DeliveryDateService::DOMAIN_NAMESPACE,
            'BIC'                => DeliveryDateService::DOMAIN_NAMESPACE,
            'Currency'           => DeliveryDateService::DOMAIN_NAMESPACE,
            'IBAN'               => DeliveryDateService::DOMAIN_NAMESPACE,
            'Reference'          => DeliveryDateService::DOMAIN_NAMESPACE,
            'TransactionNumber'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Value'              => DeliveryDateService::DOMAIN_NAMESPACE,
            'VerzekerdBedrag'    => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'AccountName'        => LocationService::DOMAIN_NAMESPACE,
            'ResponseAmountType' => LocationService::DOMAIN_NAMESPACE,
            'BIC'                => LocationService::DOMAIN_NAMESPACE,
            'Currency'           => LocationService::DOMAIN_NAMESPACE,
            'IBAN'               => LocationService::DOMAIN_NAMESPACE,
            'Reference'          => LocationService::DOMAIN_NAMESPACE,
            'TransactionNumber'  => LocationService::DOMAIN_NAMESPACE,
            'Value'              => LocationService::DOMAIN_NAMESPACE,
            'VerzekerdBedrag'    => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'AccountName'        => TimeframeService::DOMAIN_NAMESPACE,
            'ResponseAmountType' => TimeframeService::DOMAIN_NAMESPACE,
            'BIC'                => TimeframeService::DOMAIN_NAMESPACE,
            'Currency'           => TimeframeService::DOMAIN_NAMESPACE,
            'IBAN'               => TimeframeService::DOMAIN_NAMESPACE,
            'Reference'          => TimeframeService::DOMAIN_NAMESPACE,
            'TransactionNumber'  => TimeframeService::DOMAIN_NAMESPACE,
            'Value'              => TimeframeService::DOMAIN_NAMESPACE,
            'VerzekerdBedrag'    => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $AccountName;
    /** @var string|null */
    protected $ResponseAmountType;
    /** @var string|null */
    protected $BIC;
    /** @var string|null */
    protected $Currency;
    /** @var string|null */
    protected $IBAN;
    /** @var string|null */
    protected $Reference;
    /** @var string|null */
    protected $TransactionNumber;
    /** @var string|null */
    protected $Value;
    /** @var string|null */
    protected $VerzekerdBedrag;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null $AccountName
     * @param string|null $ResponseAmount
     * @param string|null $BIC
     * @param string|null $Currency
     * @param string|null $IBAN
     * @param string|null $Reference
     * @param string|null $TransactionNumber
     * @param string|null $Value
     * @param string|null $VerzekerdBedrag
     */
    public function __construct(
        $AccountName = null,
        $ResponseAmount = null,
        $BIC = null,
        $Currency = null,
        $IBAN = null,
        $Reference = null,
        $TransactionNumber = null,
        $Value = null,
        $VerzekerdBedrag = null
    ) {
        parent::__construct();

        $this->setAccountName($AccountName);
        $this->setResponseAmountType($ResponseAmount);
        $this->setBIC($BIC);
        $this->setCurrency($Currency);
        $this->setIBAN($IBAN);
        $this->setReference($Reference);
        $this->setTransactionNumber($TransactionNumber);
        $this->setValue($Value);
        $this->setVerzekerdBedrag($VerzekerdBedrag);
    }
}
