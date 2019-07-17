<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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

namespace Firstred\PostNL\Service;

use Exception;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Request\Confirming;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Http\Client;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;

/**
 * Class ConfirmingService
 */
class ConfirmingService extends AbstractService
{
    // API Version
    const VERSION = '2.0';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v1_10/confirm';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v1_10/confirm';

    /**
     * Generate a single barcode via REST
     *
     * @param Confirming $confirming
     *
     * @return ConfirmingResponseShipment
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function confirmShipment(Confirming $confirming): ConfirmingResponseShipment
    {
        $response = Client::getInstance()->doRequest($this->buildConfirmRequest($confirming));
        $object = $this->processConfirmResponse($response);

        if ($object instanceof ConfirmingResponseShipment) {
            return $object;
        }

        if ($response->getStatusCode() === 200) {
            throw new ResponseException('Invalid API Response', 0, null, $response);
        }

        throw new ApiException('Unable to confirm');
    }

    /**
     * @param Confirming $confirming
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     */
    public function buildConfirmRequest(Confirming $confirming): RequestInterface
    {
        /** @var RequestFactory $factory */
        $factory = Psr17FactoryDiscovery::findRequestFactory();

        return $factory->createRequest(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT,
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
                'apikey'       => $this->postnl->getApiKey(),
            ],
            json_encode($confirming)
        );
    }

    /**
     * Process Confirm REST Response
     *
     * @param mixed $response
     *
     * @return null|ConfirmingResponseShipment
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function processConfirmResponse($response): ?ConfirmingResponseShipment
    {
        static::validateResponse($response);
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['ConfirmingResponseShipments'])) {
            /** @var ConfirmingResponseShipment $object */
            $object = AbstractEntity::jsonDeserialize($body['ConfirmingResponseShipments']);

            return $object;
        }

        return null;
    }

    /**
     * Confirm multiple shipments
     *
     * @param Confirming[] $confirms ['uuid' => Confirming, ...]
     *
     * @return ConfirmingResponseShipment[]
     *
     * @since 1.0.0
     */
    public function confirmShipments(array $confirms): array
    {
        $httpClient = Client::getInstance();

        foreach ($confirms as $confirm) {
            $httpClient->addOrUpdateRequest(
                (string) $confirm->getId(),
                $this->buildConfirmRequest($confirm)
            );
        }

        $confirmingResponses = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            try {
                $confirming = $this->processConfirmResponse($response);
                if (!$confirming instanceof ConfirmingResponseShipment) {
                    throw new ResponseException('Invalid API Response', 0, null, $response);
                }
            } catch (Exception $e) {
                $confirming = $e;
            }

            $confirmingResponses[$uuid] = $confirming;
        }

        return $confirmingResponses;
    }
}
