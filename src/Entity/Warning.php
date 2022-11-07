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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingService;
use Firstred\PostNL\Service\TimeframeService;
use stdClass;

/**
 * Class Warning.
 *
 * @method string|null getCode()
 * @method string|null getDescription()
 * @method Warning     setCode(string|null $Code = null)
 * @method Warning     setDescription(string|null $Description = null)
 *
 * @since 1.0.0
 */
class Warning extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'Code'        => BarcodeService::DOMAIN_NAMESPACE,
            'Description' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Code'        => ConfirmingService::DOMAIN_NAMESPACE,
            'Description' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Code'        => LabellingService::DOMAIN_NAMESPACE,
            'Description' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Code'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'Description' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Code'        => LocationService::DOMAIN_NAMESPACE,
            'Description' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Code'        => TimeframeService::DOMAIN_NAMESPACE,
            'Description' => TimeframeService::DOMAIN_NAMESPACE,
        ],
        'Shipping' => [
            'Code'        => ShippingService::DOMAIN_NAMESPACE,
            'Description' => ShippingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $Code;
    /** @var string|null */
    protected $Description;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null $Code
     * @param string|null $Description
     */
    public function __construct($Code = null, $Description = null)
    {
        parent::__construct();

        $this->setCode($Code);
        $this->setDescription($Description);
    }

    /**
     * Deserialize JSON.
     *
     * @param stdClass $json JSON object `{"EntityName": object}`
     *
     * @return static
     *
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     */
    public static function jsonDeserialize(stdClass $json)
    {
        // Confirming Webservice has the code and description properties in lower case
        if (isset($json->Warning->code)) {
            $json->Warning->Code = $json->Warning->code;
            unset($json->Warning->code);
        }
        if (isset($json->Warning->description)) {
            $json->Warning->Description = $json->Warning->description;
            unset($json->Warning->description);
        }

        if (isset($json->Warning->Message)) {
            $json->Warning->Description = $json->Warning->Message;
            unset($json->Warning->Message);
        }

        return parent::jsonDeserialize($json);
    }
}
