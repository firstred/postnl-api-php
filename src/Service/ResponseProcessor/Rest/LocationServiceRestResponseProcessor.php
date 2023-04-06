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

declare(strict_types=1);

namespace Firstred\PostNL\Service\ResponseProcessor\Rest;

use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\OpeningHours;
use Firstred\PostNL\Entity\Response\GetLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Entity\Response\ResponseLocation;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\ResponseProcessor\LocationServiceResponseProcessorInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @since 2.0.0
 * @internal
 */
class LocationServiceRestResponseProcessor extends AbstractRestResponseProcessor implements LocationServiceResponseProcessorInterface
{
    /**
     * Process GetNearestLocations Response REST.
     *
     * @param ResponseInterface $response
     *
     * @return GetNearestLocationsResponse
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws ResponseException
     * @throws CifDownException
     * @throws CifException
     * @throws InvalidConfigurationException
     * @since 2.0.0
     */
    public function processGetNearestLocationsResponse(ResponseInterface $response): GetNearestLocationsResponse
    {
        $this->validateResponse(response: $response);
        $body = json_decode(json: static::getResponseText(response: $response));

        return GetNearestLocationsResponse::jsonDeserialize(json: (object) ['GetNearestLocationsResponse' => $body]);
    }

    /**
     * Process GetLocationsInArea Response REST.
     *
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse
     * @throws CifDownException
     * @throws CifException
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws InvalidConfigurationException
     * @throws NotSupportedException
     * @throws ResponseException
     * @since 2.0.0
     */
    public function processGetLocationsInAreaResponse(ResponseInterface $response): GetLocationsInAreaResponse
    {
        $this->validateResponse(response: $response);
        $body = json_decode(json: static::getResponseText(response: $response));

        /** @var GetLocationsInAreaResponse $object */
        $object = GetLocationsInAreaResponse::jsonDeserialize(
            json: (object) ['GetLocationsInAreaResponse' => $body]
        );

        return $object;
    }

    /**
     * Process GetLocation Response REST.
     *
     * @param ResponseInterface $response
     *
     * @return GetLocationsInAreaResponse
     * @throws CifDownException
     * @throws CifException
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws InvalidConfigurationException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @since 2.0.0
     */
    public function processGetLocationResponse(ResponseInterface $response): GetLocationsInAreaResponse
    {
        $this->validateResponse(response: $response);
        $body = json_decode(json: static::getResponseText(response: $response));

        if (!is_array(value: $body->GetLocationsResult->ResponseLocation)) {
            $body->GetLocationsResult->ResponseLocation = [$body->GetLocationsResult->ResponseLocation];
        }

        $newLocations = [];
        foreach ($body->GetLocationsResult->ResponseLocation as $location) {
            if (isset($location->Address)) {
                $location->Address = Address::jsonDeserialize(json: (object) ['Address' => $location->Address]);
            }

            if (isset($location->DeliveryOptions->string)) {
                $location->DeliveryOptions = $location->DeliveryOptions->string;
            }

            if (isset($location->OpeningHours)) {
                foreach ($location->OpeningHours as $day => $hour) {
                    if (isset($hour->string)) {
                        $location->OpeningHours->$day = $hour->string;
                    }
                }

                $location->OpeningHours = OpeningHours::jsonDeserialize(
                    json: (object) ['OpeningHours' => $location->OpeningHours]
                );
            }

            $newLocations[] = ResponseLocation::jsonDeserialize(
                json: (object) ['ResponseLocation' => $location]
            );
        }
        $body->GetLocationsResult->ResponseLocation = $newLocations;

        /** @var GetLocationsInAreaResponse $object */
        $object = GetLocationsInAreaResponse::jsonDeserialize(json: (object) ['GetLocationsInAreaResponse' => $body]);

        return $object;
    }
}
