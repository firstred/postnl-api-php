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

use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\ResponseException;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestInterface;

class ConfirmingService implements ConfirmingServiceInterface
{
    // API Version
    const VERSION = '2.0';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2/confirm';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2/confirm';

    /**
     * Generate a single barcode via REST.
     *
     * @param ConfirmingResponseDto $confirming
     *
     * @return ConfirmingResponseShipment
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     */
    public function confirmShipment(ConfirmingResponseDto $confirming)
    {
        $response = $this->postnl->getHttpClient()->doRequest(request: $this->buildConfirmRequestREST(confirming: $confirming));
        $object = $this->processConfirmResponseREST(response: $response);

        if ($object instanceof ConfirmingResponseShipment) {
            return $object;
        }

        if (200 === $response->getStatusCode()) {
            throw new ResponseException(message: 'Invalid API Response', code: null, previous: null, response: $response);
        }

        throw new ApiException('Unable to confirm');
    }

    /**
     * Confirm multiple shipments.
     *
     * @param ConfirmingResponseDto[] $confirms ['uuid' => Confirming, ...]
     *
     * @return ConfirmingResponseShipment[]
     */
    public function confirmShipments(array $confirms)
    {
        $httpClient = $this->postnl->getHttpClient();

        foreach ($confirms as $confirm) {
            $httpClient->addOrUpdateRequest(
                id: $confirm->getId(),
                request: $this->buildConfirmRequestREST(confirming: $confirm)
            );
        }

        $confirmingResponses = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            try {
                $confirming = $this->processConfirmResponseREST(response: $response);
                if (!$confirming instanceof ConfirmingResponseShipment) {
                    throw new ResponseException(message: 'Invalid API Response', code: null, previous: null, response: $response);
                }
            } catch (\Exception $e) {
                $confirming = $e;
            }

            $confirmingResponses[$uuid] = $confirming;
        }

        return $confirmingResponses;
    }

    /**
     * @param ConfirmingResponseDto $confirming
     *
     * @return RequestInterface
     */
    public function buildConfirmRequest(ConfirmingResponseDto $confirming)
    {
        $apiKey = $this->postnl->getRestApiKey();

        $this->setService(object: $confirming);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            method: 'POST',
            uri: ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)
        )
            ->withHeader(name: 'apikey', value: $apiKey)
            ->withHeader(name: 'Accept', value: 'application/json')
            ->withHeader(name: 'Content-Type', value: 'application/json;charset=UTF-8')
            ->withBody(body: Psr17FactoryDiscovery::findStreamFactory()->createStream(content: json_encode(value: $confirming)))
        ;
    }

    /**
     * Proces Confirm REST Response.
     *
     * @param mixed $response
     *
     * @return ConfirmingResponseShipment|null
     *
     * @throws ApiException
     * @throws ResponseException
     * @throws CifDownException
     * @throws CifException
     */
    public function processConfirmResponse($response)
    {
        static::validateRESTResponse(response: $response);
        $body = @json_decode(json: static::getResponseText(response: $response), associative: true);
        if (isset($body['ConfirmingResponseShipments'])) {
            /** @var ConfirmingResponseShipment $object */
            $object = JsonSerializableObject::jsonDeserialize(json: ['ConfirmingResponseShipment' => $body['ConfirmingResponseShipments']['ConfirmingResponseShipment']]);
            $this->setService(object: $object);

            return $object;
        }

        return null;
    }

    public function getCustomer(): Customer
    {
        // TODO: Implement getCustomer() method.
    }

    public function setCustomer(Customer $customer): static
    {
        // TODO: Implement setCustomer() method.
    }

    public function getApiKey(): string
    {
        // TODO: Implement getApiKey() method.
    }

    public function setApiKey(string $apiKey): static
    {
        // TODO: Implement setApiKey() method.
    }

    public function isSandbox(): bool
    {
        // TODO: Implement isSandbox() method.
    }

    public function setSandbox(bool $sandbox): static
    {
        // TODO: Implement setSandbox() method.
    }
}
