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

/**
 * Class CoordinatesNorthWest
 *
 * @method string|null getLatitude()
 * @method string|null getLongitude()
 *
 * @method CoordinatesNorthWest setLatitude(string|null $lat = null)
 * @method CoordinatesNorthWest setLongitude(string|null $long = null)
 */
class CoordinatesNorthWest extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'Latitude'  => BarcodeService::DOMAIN_NAMESPACE,
            'Longitude' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Latitude'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Longitude' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Latitude'  => LabellingService::DOMAIN_NAMESPACE,
            'Longitude' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Latitude'  => ShippingStatusService::DOMAIN_NAMESPACE,
            'Longitude' => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Latitude'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Longitude' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Latitude'  => LocationService::DOMAIN_NAMESPACE,
            'Longitude' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Latitude'  => TimeframeService::DOMAIN_NAMESPACE,
            'Longitude' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null $Latitude */
    protected $Latitude;
    /** @var string|null $Longitude */
    protected $Longitude;
    // @codingStandardsIgnoreEnd

    /**
     * @param string $lat
     * @param string $long
     */
    public function __construct($lat = null, $long = null)
    {
        parent::__construct();

        $this->setLatitude($lat);
        $this->setLongitude($long);
    }
}
