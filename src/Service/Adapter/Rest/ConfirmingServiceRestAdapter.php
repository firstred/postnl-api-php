<?php
declare(strict_types=1);
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

namespace Firstred\PostNL\Service\Adapter\Rest;

use Firstred\PostNL\Entity\Request\Confirming;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\Adapter\ConfirmingServiceAdapterInterface;
use Firstred\PostNL\Util\Util;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @since 2.0.0
 */
class ConfirmingServiceRestAdapter extends AbstractRestAdapter implements ConfirmingServiceAdapterInterface
{
    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/${VERSION}/confirm';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/${VERSION}/confirm';

    /**
     * @since 2.0.0
     */
    public function buildConfirmRequest(Confirming $confirming): RequestInterface
    {
        return $this->getRequestFactory()->createRequest(
            method: 'POST',
            uri: Util::versionStringToURLString(
                version: $this->getVersion(),
                url: $this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT,
            ))
            ->withHeader('apikey', value: $this->getApiKey()->getString())
            ->withHeader('Accept', value: 'application/json')
            ->withHeader('Content-Type', value: 'application/json;charset=UTF-8')
            ->withBody(body: $this->getStreamFactory()->createStream(content: json_encode(value: $confirming)));
    }

    /**
     * Proces Confirm REST Response.
     *
     * @param ResponseInterface $response
     * @return ConfirmingResponseShipment
     * @throws CifDownException
     * @throws CifException
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws ResponseException
     * @throws InvalidConfigurationException
     * @since 2.0.0
     */
    public function processConfirmResponse(ResponseInterface $response): ConfirmingResponseShipment
    {
        $this->validateResponse(responseContent: (string) $response->getBody());
        $body = json_decode(json: $this->getResponseText(response: $response));

        if (isset($body->ResponseShipments)) {
            if (!is_array(value: $body->ResponseShipments)) {
                $body->ResponseShipments = [$body->ResponseShipments];
            }

            $objects = [];
            foreach ($body->ResponseShipments as $responseShipment) {
                $object = ConfirmingResponseShipment::jsonDeserialize(json: (object) ['ConfirmingResponseShipment' => $responseShipment]);
                $this->setService(object: $object);
                $objects[] = $object;
            }

            return $objects;
        }

        throw new ResponseException(message: 'Invalid response');
    }
}
