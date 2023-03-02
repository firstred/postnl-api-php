<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2022 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2022 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;
use stdClass;
use function is_array;

/**
 * Class GetNearestLocationsResponse.
 *
 * @method GetLocationsResult|null     getGetLocationsResult()
 * @method GetNearestLocationsResponse setGetLocationsResult(GetLocationsResult|null $GetLocationsResult = null)
 *
 * @since 1.0.0
 */
class GetNearestLocationsResponse extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
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
    /** @var GetLocationsResult|null */
    protected $GetLocationsResult;
    // @codingStandardsIgnoreEnd

    /**
     * GetNearestLocationsResponse constructor.
     *
     * @param GetLocationsResult|null $GetLocationsResult
     */
    public function __construct(GetLocationsResult $GetLocationsResult = null)
    {
        parent::__construct();

        $this->setGetLocationsResult($GetLocationsResult);
    }

    /**
     * @param stdClass $json
     *
     * @return mixed|stdClass|null
     *
     * @throws PostNLInvalidArgumentException
     * @throws NotSupportedException
     *
     * @since 1.2.0
     */
    public static function jsonDeserialize(stdClass $json)
    {
        if (isset($json->GetNearestLocationsResponse->GetLocationsResult)
            && !is_array($json->GetNearestLocationsResponse->GetLocationsResult->ResponseLocation)
        ) {
            $json->GetNearestLocationsResponse->GetLocationsResult->ResponseLocation = [$json->GetNearestLocationsResponse->GetLocationsResult->ResponseLocation];
        }

        return parent::jsonDeserialize($json);
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
                if ('GetLocationsResult' === $propertyName) {
                    $locations = [];
                    foreach ($this->GetLocationsResult as $location) {
                        $locations[] = $location;
                    }
                    $json[$propertyName] = ['ResponseLocation' => $locations];
                } else {
                    $json[$propertyName] = $this->$propertyName;
                }
            }
        }

        return $json;
    }
}
