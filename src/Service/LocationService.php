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

namespace Firstred\PostNL\Service;

use Firstred\PostNL\DTO\Request\GetLocationsInAreaRequestDTO;
use Firstred\PostNL\DTO\Request\GetNearestLocationsGeocodeRequestDTO;
use Firstred\PostNL\DTO\Request\GetNearestLocationsRequestDTO;
use Firstred\PostNL\DTO\Request\LookupLocationRequestDTO;
use Firstred\PostNL\DTO\Response\GetLocationResponseDTO;
use Firstred\PostNL\DTO\Response\GetLocationsResponseDTO;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Gateway\LocationServiceGatewayInterface;
use JetBrains\PhpStorm\Pure;

class LocationService extends ServiceBase implements LocationServiceInterface
{
    use ServiceLoggerTrait;

    #[Pure]
    public function __construct(
        protected Customer $customer,
        protected string $apiKey,
        protected bool $sandbox,
        protected LocationServiceGatewayInterface $gateway,
    ) {
        parent::__construct(customer: $customer, apiKey: $apiKey, sandbox: $sandbox);
    }

    public function lookupLocation(LookupLocationRequestDTO $lookupLocationRequestDTO): GetLocationResponseDTO
    {
        return $this->getGateway()->doLookupLocationRequest(lookupLocationRequestDTO: $lookupLocationRequestDTO);
    }

    public function getNearestLocations(GetNearestLocationsRequestDTO $getNearestLocationsRequestDTO): GetLocationsResponseDTO
    {
        return $this->getGateway()->doGetNearestLocationsRequest(getNearestLocationsRequestDTO: $getNearestLocationsRequestDTO);
    }


    public function getNearestLocationsGeocode(
        GetNearestLocationsGeocodeRequestDTO $getNearestLocationsGeocodeRequestDTO,
    ): GetLocationsResponseDTO {
        return $this->getGateway()->doGetNearestLocationsGeocodeRequest(
            getNearestLocationsGeocodeRequestDTO: $getNearestLocationsGeocodeRequestDTO,
        );
    }

    public function getLocationsInArea(GetLocationsInAreaRequestDTO $getLocationsInAreaRequestDTO): GetLocationsResponseDTO
    {
        return $this->getGateway()->doGetLocationsInAreaRequest(
            getLocationsInAreaRequestDTO: $getLocationsInAreaRequestDTO,
        );
    }

    public function setGateway(LocationServiceGatewayInterface $gateway): static
    {
        $this->gateway = $gateway;

        return $this;
    }

    public function getGateway(): LocationServiceGatewayInterface
    {
        return $this->gateway;
    }
}
