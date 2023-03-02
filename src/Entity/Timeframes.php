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
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class Timeframes.
 *
 * @method Timeframe[]|null          getTimeframess()
 * @method TimeframeTimeFrame[]|null getTimeframeTimeFrame()
 * @method Timeframes                setTimeframes(Timeframe[]|null $Timeframes = null)
 * @method Timeframes                setTimeframeTimeFrames(TimeframeTimeFrame[]|null $TimeframeTimeFrames = null)
 *
 * @since 1.0.0
 */
class Timeframes extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'Timeframes'          => BarcodeService::DOMAIN_NAMESPACE,
            'TimeframeTimeFrames' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Timeframes'          => ConfirmingService::DOMAIN_NAMESPACE,
            'TimeframeTimeFrames' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Timeframes'          => LabellingService::DOMAIN_NAMESPACE,
            'TimeframeTimeFrames' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Timeframes'          => DeliveryDateService::DOMAIN_NAMESPACE,
            'TimeframeTimeFrames' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Timeframes'          => LocationService::DOMAIN_NAMESPACE,
            'TimeframeTimeFrames' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Timeframes'          => TimeframeService::DOMAIN_NAMESPACE,
            'TimeframeTimeFrames' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Timeframe[]|null */
    protected $Timeframes;
    /** @var TimeframeTimeFrame[]|null */
    protected $TimeframeTimeFrames;
    // @codingStandardsIgnoreEnd

    /**
     * Timeframes constructor.
     *
     * @param array|null                $timeframes
     * @param TimeframeTimeFrame[]|null $timeframetimeframes
     */
    public function __construct(
        array $timeframes = null,
        array $timeframetimeframes = null
    ) {
        parent::__construct();

        $this->setTimeframes($timeframes);
        $this->setTimeframeTimeFrames($timeframetimeframes);
    }

    /**
     * Return a serializable array for `json_encode`.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $json = [];
        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
            return $json;
        }

        foreach (array_keys(static::$defaultProperties[$this->currentService]) as $propertyName) {
            if (isset($this->$propertyName)) {
                if ('Timeframes' === $propertyName) {
                    $timeframes = [];
                    foreach ($this->Timeframes as $timeframe) {
                        $timeframes[] = $timeframe;
                    }
                    $json[$propertyName] = ['TimeframeTimeFrame' => $timeframes];
                } elseif ('TimeframeTimeFrames' === $propertyName) {
                    $timeframes = [];
                    foreach ($this->TimeframeTimeFrames as $timeframe) {
                        $timeframes[] = $timeframe;
                    }
                    $json[$propertyName] = ['TimeframeTimeFrame' => $timeframes];
                } else {
                    $json[$propertyName] = $this->$propertyName;
                }
            }
        }

        return $json;
    }
}
