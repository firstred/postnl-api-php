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
 * Class Area.
 *
 * @method Coordinates|null getCoordinatesNorthWest()
 * @method Coordinates|null getCoordinatesSouthEast()
 * @method Area             setCoordinatesNorthWest(Coordinates|null $CoordinatesNorthWest = null)
 * @method Area             setCoordinatesSouthEast(Coordinates|null $CoordinatesSouthEast = null)
 *
 * @since 1.0.0
 */
class Area extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'CoordinatesNorthWest' => BarcodeService::DOMAIN_NAMESPACE,
            'CoordinatesSouthEast' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'CoordinatesNorthWest' => ConfirmingService::DOMAIN_NAMESPACE,
            'CoordinatesSouthEast' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'CoordinatesNorthWest' => LabellingService::DOMAIN_NAMESPACE,
            'CoordinatesSouthEast' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'CoordinatesNorthWest' => DeliveryDateService::DOMAIN_NAMESPACE,
            'CoordinatesSouthEast' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'CoordinatesNorthWest' => LocationService::DOMAIN_NAMESPACE,
            'CoordinatesSouthEast' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'CoordinatesNorthWest' => TimeframeService::DOMAIN_NAMESPACE,
            'CoordinatesSouthEast' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Coordinates|null */
    protected $CoordinatesNorthWest;
    /** @var Coordinates|null */
    protected $CoordinatesSouthEast;
    // @codingStandardsIgnoreEnd

    /**
     * @param Coordinates|null $CoordinatesNorthWest
     * @param Coordinates|null $CoordinatesSouthEast
     */
    public function __construct($CoordinatesNorthWest = null, $CoordinatesSouthEast = null)
    {
        parent::__construct();

        $this->setCoordinatesNorthWest($CoordinatesNorthWest);
        $this->setCoordinatesSouthEast($CoordinatesSouthEast);
    }
}
