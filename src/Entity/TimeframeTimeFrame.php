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

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;
use stdClass;
use function array_merge;
use function is_array;
use function is_string;

/**
 * Class TimeframeTimeFrame.
 *
 * @method DateTimeInterface|null getDate()
 * @method string|null            getFrom()
 * @method string|null            getTo()
 * @method string[]|null          getOptions()
 * @method TimeframeTimeFrame     setFrom(string|null $From = null)
 * @method TimeframeTimeFrame     setTo(string|null $To = null)
 * @method TimeframeTimeFrame     setOptions(string[]|null $Options = null)
 *
 * @since 1.0.0
 */
class TimeframeTimeFrame extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode'        => [
            'Date'    => BarcodeService::DOMAIN_NAMESPACE,
            'From'    => BarcodeService::DOMAIN_NAMESPACE,
            'Options' => BarcodeService::DOMAIN_NAMESPACE,
            'To'      => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Date'    => ConfirmingService::DOMAIN_NAMESPACE,
            'From'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Options' => ConfirmingService::DOMAIN_NAMESPACE,
            'To'      => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Date'    => LabellingService::DOMAIN_NAMESPACE,
            'From'    => LabellingService::DOMAIN_NAMESPACE,
            'Options' => LabellingService::DOMAIN_NAMESPACE,
            'To'      => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Date'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'From'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Options' => DeliveryDateService::DOMAIN_NAMESPACE,
            'To'      => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Date'    => LocationService::DOMAIN_NAMESPACE,
            'From'    => LocationService::DOMAIN_NAMESPACE,
            'Options' => LocationService::DOMAIN_NAMESPACE,
            'To'      => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Date'    => TimeframeService::DOMAIN_NAMESPACE,
            'From'    => TimeframeService::DOMAIN_NAMESPACE,
            'Options' => TimeframeService::DOMAIN_NAMESPACE,
            'To'      => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $Date;
    /** @var string|null */
    protected $From;
    /** @var string[]|null */
    protected $Options;
    /** @var string|null */
    protected $To;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|DateTimeInterface|null $GetSentDate
     * @param string|null                   $From
     * @param string|null                   $To
     * @param string[]|null                 $Options
     *
     * @throws InvalidArgumentException
     */
    public function __construct($GetSentDate = null, $From = null, $To = null, array $Options = null)
    {
        parent::__construct();

        $this->setDate($GetSentDate);
        $this->setFrom($From);
        $this->setTo($To);
        $this->setOptions($Options);
    }

    /**
     * @param string|DateTimeInterface|null $Date
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDate($Date = null)
    {
        if (is_string($Date)) {
            try {
                $Date = new DateTimeImmutable($Date, new DateTimeZone('Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->Date = $Date;

        return $this;
    }

    /**
     * @param stdClass $json
     *
     * @return mixed|stdClass|null
     *
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\NotSupportedException
     *
     * @since 1.2.0
     */
    public static function jsonDeserialize(stdClass $json)
    {
        if (isset($json->TimeframeTimeFrame->Options)) {
            /** @psalm-var list<string> $deliveryOptions */
            $deliveryOptions = [];
            if (!is_array($json->TimeframeTimeFrame->Options)){
                $json->TimeframeTimeFrame->Options = [$json->TimeframeTimeFrame->Options];
            }

            foreach ($json->TimeframeTimeFrame->Options as $deliveryOption) {
                if (isset($deliveryOption->string)) {
                    if (!is_array($deliveryOption->string)) {
                        $deliveryOption->string = [$deliveryOption->string];
                    }
                    foreach ($deliveryOption->string as $optionString) {
                        $deliveryOptions[] = $optionString;
                    }
                } elseif (is_array($deliveryOption)) {
                    $deliveryOptions = array_merge($deliveryOptions, $deliveryOption);
                } elseif (is_string($deliveryOption)) {
                    $deliveryOptions[] = $deliveryOption;
                }
            }

            $json->TimeframeTimeFrame->Options = $deliveryOptions;
        }

        return parent::jsonDeserialize($json);
    }
}
