<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;
use JetBrains\PhpStorm\Deprecated;

/**
 * Class GetLocationsInArea.
 *
 * This class is both the container and can be the actual GetLocationsInArea object itself!
 *
 * @method string|null        getCountrycode()
 * @method Location|null      getLocation()
 * @method Message|null       getMessage()
 * @method GetLocationsInArea setCountrycode(string|null $Countrycode = null)
 * @method GetLocationsInArea setLocation(Location|null $Location = null)
 * @method GetLocationsInArea setMessage(Message|null $Message = null)
 *
 * @since 1.0.0
 */
class GetLocationsInArea extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode' => [
            'Countrycode' => BarcodeService::DOMAIN_NAMESPACE,
            'Location'    => BarcodeService::DOMAIN_NAMESPACE,
            'Message'     => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Countrycode' => ConfirmingService::DOMAIN_NAMESPACE,
            'Location'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Message'     => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Countrycode' => LabellingService::DOMAIN_NAMESPACE,
            'Location'    => LabellingService::DOMAIN_NAMESPACE,
            'Message'     => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Countrycode' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Location'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Message'     => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Countrycode' => LocationService::DOMAIN_NAMESPACE,
            'Location'    => LocationService::DOMAIN_NAMESPACE,
            'Message'     => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Countrycode' => TimeframeService::DOMAIN_NAMESPACE,
            'Location'    => TimeframeService::DOMAIN_NAMESPACE,
            'Message'     => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $Countrycode;
    /** @var Location|null */
    protected $Location;
    /**
     * @var Message|null
     * @deprecated 1.4.1 SOAP support is going to be removed
     */
    #[Deprecated]
    protected $Message;
    // @codingStandardsIgnoreEnd

    /**
     * GetLocationsInArea constructor.
     *
     * @param string|null   $Countrycode
     * @param Location|null $Location
     * @param Message|null  $Message
     */
    public function __construct(
        $Countrycode = null,
        Location $Location = null,
        Message $Message = null
    ) {
        parent::__construct();

        $this->setCountrycode($Countrycode);
        $this->setLocation($Location);

        if ($Message instanceof Message) {
            PostNL::triggerDeprecation(
                'firstred/postnl-api-php',
                '1.4.1',
                'Please do not pass a `Message` object. SOAP support is going to be removed.'
            );
        }
        $this->setMessage($Message ?: new Message());
    }
}
