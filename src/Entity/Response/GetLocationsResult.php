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
use Sabre\Xml\Writer;

/**
 * Class GetLocationsResult.
 *
 * @method ResponseLocation[]|null getResponseLocation()
 * @method GetLocationsResult      setResponseLocation(ResponseLocation[]|null $ResponseLocation = null)
 *
 * @since 1.0.0
 */
class GetLocationsResult extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode' => [
            'ResponseLocation' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'ResponseLocation' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'ResponseLocation' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'ResponseLocation' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'ResponseLocation' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'ResponseLocation' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var ResponseLocation[]|null */
    protected $ResponseLocation;
    // @codingStandardsIgnoreEnd

    /**
     * GetLocationsResult constructor.
     *
     * @param ResponseLocation[]|null $ResponseLocation
     */
    public function __construct(array $ResponseLocation = null)
    {
        parent::__construct();

        $this->setResponseLocation($ResponseLocation);
    }

    /**
     * Return a serializable array for the XMLWriter.
     *
     * @param Writer $writer
     *
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        $xml = [];
        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
            $writer->write($xml);

            return;
        }

        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if ('ResponseLocation' === $propertyName) {
                $locations = [];
                foreach ($this->ResponseLocation as $location) {
                    $locations[] = $location;
                }
                $xml["{{$namespace}}ResponseLocation"] = $locations;
            } elseif (isset($this->$propertyName)) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}
