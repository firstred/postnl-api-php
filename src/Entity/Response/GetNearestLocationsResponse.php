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

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class GetNearestLocationsResponse
 *
 * @method GetLocationsResult|null getGetLocationsResult()
 *
 * @method GetNearestLocationsResponse setGetLocationsResult(GetLocationsResult|null $result = null)
 */
class GetNearestLocationsResponse extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API
     *
     * @var array $defaultProperties
     */
    public static $defaultProperties = [
        'Barcode'        => [
            'GetLocationsResult' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'GetLocationsResult' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'GetLocationsResult' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'GetLocationsResult' => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'GetLocationsResult' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'GetLocationsResult' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'GetLocationsResult' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var GetLocationsResult|null $GetLocationsResult */
    protected $GetLocationsResult;
    // @codingStandardsIgnoreEnd

    /**
     * GetNearestLocationsResponse constructor.
     *
     * @param GetLocationsResult|null $result
     */
    public function __construct(GetLocationsResult $result = null)
    {
        parent::__construct();

        $this->setGetLocationsResult($result);
    }

    /**
     * Return a serializable array for `json_encode`
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [];
        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
            return $json;
        }

        foreach (array_keys(static::$defaultProperties[$this->currentService]) as $propertyName) {
            if (isset($this->{$propertyName})) {
                if ('GetLocationsResult' === $propertyName) {
                    $locations = [];
                    // @codingStandardsIgnoreLine
                    foreach ($this->GetLocationsResult as $location) {
                        $locations[] = $location;
                    }
                    $json[$propertyName] = ['ResponseLocation' => $locations];
                } else {
                    $json[$propertyName] = $this->{$propertyName};
                }
            }
        }

        return $json;
    }
}
