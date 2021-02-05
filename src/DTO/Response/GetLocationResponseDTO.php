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

declare(strict_types=1);

namespace Firstred\PostNL\DTO\Response;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\OpeningHours;
use Firstred\PostNL\Entity\ResponseLocation;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class GetLocationResponseDTO.
 */
class GetLocationResponseDTO extends ResponseLocation
{
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',
        string $cacheKey = '',

        int|string|null $LocationCode = null,
        string|null $Name = null,
        int|string|null $Distance = null,
        float|string|null $Latitude = null,
        float|string|null $Longitude = null,
        Address|array|null $Address = null,
        array|null $DeliveryOptions = null,
        OpeningHours|array|null $OpeningHours = null,
        string|null $PartnerName = null,
        string|null $PhoneNumber = null,
        string|null $RetailNetworkID = null,
        string|null $Saleschannel = null,
        string|null $TerminalType = null,
        array|null $Warnings = null,

        // Lookup location response
        array|null $GetLocationsResult = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setLocationCode(LocationCode: $LocationCode);
        $this->setName(Name: $Name);
        $this->setDistance(Distance: $Distance);
        $this->setLatitude(Latitude: $Latitude);
        $this->setLongitude(Longitude: $Longitude);
        $this->setAddress(Address: $Address);
        $this->setDeliveryOptions(DeliveryOptions: $DeliveryOptions);
        $this->setOpeningHours(OpeningHours: $OpeningHours);
        $this->setPartnerName(PartnerName: $PartnerName);
        $this->setPhoneNumber(PhoneNumber: $PhoneNumber);
        $this->setRetailNetworkID(RetailNetworkID: $RetailNetworkID);
        $this->setSaleschannel(Saleschannel: $Saleschannel);
        $this->setTerminalType(TerminalType: $TerminalType);

        $this->setWarnings(Warnings: $Warnings);
        $this->setGetLocationsResult(GetLocationsResult: $GetLocationsResult);
    }

    protected function setGetLocationsResult(array|null $GetLocationsResult): static
    {
        if (is_array(value: $GetLocationsResult)
            && isset($GetLocationsResult['ResponseLocation'])
            && is_array(value: $GetLocationsResult['ResponseLocation'])
        ) {
            foreach ($GetLocationsResult['ResponseLocation'] as $prop => $value) {
                $this->{"set$prop"}($value);
            }
        }

        return $this;
    }
}
