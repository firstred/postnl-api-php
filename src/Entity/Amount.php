<?php
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

namespace ThirtyBees\PostNL\Entity;

use InvalidArgumentException;
use Sabre\Xml\Writer;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class Amount.
 *
 * @method string|null getAccountName()
 * @method string|null getAmountType()
 * @method string|null getBIC()
 * @method string|null getCurrency()
 * @method string|null getIBAN()
 * @method string|null getReference()
 * @method string|null getTransactionNumber()
 * @method string|null getValue()
 * @method Amount      setAccountName(string|null $accountName = null)
 * @method Amount      setBIC(string|null $bic = null)
 * @method Amount      setCurrency(string|null $currency = null)
 * @method Amount      setIBAN(string|null $iban = null)
 * @method Amount      setReference(string|null $reference = null)
 * @method Amount      setTransactionNumber(string|null $transactionNr = null)
 * @method Amount      setValue(string|null $value = null)
 *
 * @since 1.0.0
 */
class Amount extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
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
        'Labelling' => [
            'AccountName'       => LabellingService::DOMAIN_NAMESPACE,
            'AmountType'        => LabellingService::DOMAIN_NAMESPACE,
            'BIC'               => LabellingService::DOMAIN_NAMESPACE,
            'Currency'          => LabellingService::DOMAIN_NAMESPACE,
            'IBAN'              => LabellingService::DOMAIN_NAMESPACE,
            'Reference'         => LabellingService::DOMAIN_NAMESPACE,
            'TransactionNumber' => LabellingService::DOMAIN_NAMESPACE,
            'Value'             => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'AccountName'       => ShippingStatusService::DOMAIN_NAMESPACE,
            'AmountType'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'BIC'               => ShippingStatusService::DOMAIN_NAMESPACE,
            'Currency'          => ShippingStatusService::DOMAIN_NAMESPACE,
            'IBAN'              => ShippingStatusService::DOMAIN_NAMESPACE,
            'Reference'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'TransactionNumber' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Value'             => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'AccountName'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'AmountType'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'BIC'               => DeliveryDateService::DOMAIN_NAMESPACE,
            'Currency'          => DeliveryDateService::DOMAIN_NAMESPACE,
            'IBAN'              => DeliveryDateService::DOMAIN_NAMESPACE,
            'Reference'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'TransactionNumber' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Value'             => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'AccountName'       => LocationService::DOMAIN_NAMESPACE,
            'AmountType'        => LocationService::DOMAIN_NAMESPACE,
            'BIC'               => LocationService::DOMAIN_NAMESPACE,
            'Currency'          => LocationService::DOMAIN_NAMESPACE,
            'IBAN'              => LocationService::DOMAIN_NAMESPACE,
            'Reference'         => LocationService::DOMAIN_NAMESPACE,
            'TransactionNumber' => LocationService::DOMAIN_NAMESPACE,
            'Value'             => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'AccountName'       => TimeframeService::DOMAIN_NAMESPACE,
            'AmountType'        => TimeframeService::DOMAIN_NAMESPACE,
            'BIC'               => TimeframeService::DOMAIN_NAMESPACE,
            'Currency'          => TimeframeService::DOMAIN_NAMESPACE,
            'IBAN'              => TimeframeService::DOMAIN_NAMESPACE,
            'Reference'         => TimeframeService::DOMAIN_NAMESPACE,
            'TransactionNumber' => TimeframeService::DOMAIN_NAMESPACE,
            'Value'             => TimeframeService::DOMAIN_NAMESPACE,
        ],
        'Shipping' => [
            'AccountName'       => ShippingService::DOMAIN_NAMESPACE,
            'AmountType'        => ShippingService::DOMAIN_NAMESPACE,
            'BIC'               => ShippingService::DOMAIN_NAMESPACE,
            'Currency'          => ShippingService::DOMAIN_NAMESPACE,
            'IBAN'              => ShippingService::DOMAIN_NAMESPACE,
            'Reference'         => ShippingService::DOMAIN_NAMESPACE,
            'TransactionNumber' => ShippingService::DOMAIN_NAMESPACE,
            'Value'             => ShippingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $AccountName;
    /** @var string|null */
    protected $AmountType;
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
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null $accountName
     * @param string|null $amountType
     * @param string|null $bic
     * @param string|null $currency
     * @param string|null $iban
     * @param string|null $reference
     * @param string|null $transactionNumber
     * @param string|null $value
     */
    public function __construct(
        $accountName = null,
        $amountType = null,
        $bic = null,
        $currency = null,
        $iban = null,
        $reference = null,
        $transactionNumber = null,
        $value = null
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

    /**
     * Set amount type.
     *
     * @param string|int|null $type
     *
     * @return $this
     */
    public function setAmountType($type = null)
    {
        if (is_null($type)) {
            $this->AmountType = null;
        } else {
            $this->AmountType = str_pad($type, 2, '0', STR_PAD_LEFT);
        }

        return $this;
    }

    /**
     * Return a serializable array for the XMLWriter.
     *
     * @param Writer $writer
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function xmlSerialize(Writer $writer)
    {
        $xml = [];
        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
            throw new InvalidArgumentException('Service not set before serialization');
        }

        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if (isset($this->{$propertyName})) {
                if ('Value' === $propertyName) {
                    $xml["{{$namespace}}Value"] = number_format($this->Value, 2, '.', '');
                } else {
                    $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->{$propertyName};
                }
            }
        }

        $writer->write($xml);
    }
}
