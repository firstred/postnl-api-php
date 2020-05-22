<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service;

use Firstred\PostNL\Entity\Request\GenerateShipmentLabelRequest;
use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifErrorException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\Misc\Message;
use Http\Client\Exception as HttpClientException;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use TypeError;

/**
 * Class LabellingService
 */
class LabellingService extends AbstractService
{
    // API Version
    const VERSION = '2.2';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_2/label';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_2/label';

    /**
     * Generate a single barcode via REST
     *
     * @param GenerateShipmentLabelRequest $generateLabel
     * @param string                       $printerType
     * @param bool                         $confirm
     *
     * @return GenerateLabelResponse
     *
     * @throws HttpClientException
     * @throws CifDownException
     * @throws CifErrorException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function generateLabel(GenerateShipmentLabelRequest $generateLabel, string $printerType, bool $confirm = true)
    {
        $item = $this->retrieveCachedItem($generateLabel->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (TypeError $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = Client::getInstance()->doRequest(
                $this->buildGenerateLabelRequest($generateLabel, $printerType, $confirm)
            );
            static::validateResponse($response);
        }

        $object = $this->processGenerateLabelResponse($response);
        if ($item instanceof CacheItemInterface
            && $response instanceof ResponseInterface
            && $response->getStatusCode() === 200
        ) {
            $item->set(Message::str($response));
            $this->cacheItem($item);
        }

        return $object;
    }

    /**
     * Build the GenerateShipmentLabelRequest request for the REST API
     *
     * @param GenerateShipmentLabelRequest $generateLabel
     * @param string                       $printerType
     * @param bool                         $confirm
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function buildGenerateLabelRequest(GenerateShipmentLabelRequest $generateLabel, string $printerType, bool $confirm = true): RequestInterface
    {
        $body = json_decode(json_encode($generateLabel), true);
        $body['Message'] = [
            'MessageID'        => '1',
            'MessageTimeStamp' => date('d-m-Y 00:00:00'),
            'PrinterType'      => $printerType,
        ];
        $body['Customer'] = $this->postnl->getCustomer();

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).'?'.http_build_query(
                ['confirm' => $confirm ? 'true' : 'false']
            )
        )
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withHeader('apikey', $this->postnl->getApiKey())
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode($body)))
        ;
    }

    /**
     * Process the GenerateShipmentLabelRequest REST Response
     *
     * @param ResponseInterface $response
     *
     * @return GenerateLabelResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     */
    public function processGenerateLabelResponse(ResponseInterface $response): GenerateLabelResponse
    {
        static::validateResponse($response);

        return GenerateLabelResponse::jsonDeserialize(['GenerateLabelResponse' => @json_decode((string) $response->getBody(), true)]);
    }

    /**
     * Generate multiple labels at once
     *
     * @param array  $generateLabels ['uuid' => [GenerateBarcodeRequest, confirm], ...]
     * @param string $printerType    Printer type, e.g. GraphicFile|PDF
     *
     * @return array
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function generateLabels(array $generateLabels, string $printerType): array
    {
        $httpClient = Client::getInstance();

        $responses = [];
        foreach ($generateLabels as $uuid => $generateLabel) {
            $uuid = (string) $uuid;
            $item = $this->retrieveCachedItem($uuid);
            $response = null;
            if ($item instanceof CacheItemInterface) {
                $response = $item->get();
                try {
                    $response = Message::parseResponse($response);
                } catch (TypeError $e) {
                }
                if ($response instanceof ResponseInterface) {
                    $responses[$uuid] = $response;

                    continue;
                }
            }

            $httpClient->addOrUpdateRequest(
                (string) $uuid,
                $this->buildGenerateLabelRequest($generateLabel[0], $printerType, $generateLabel[1])
            );
        }
        $newResponses = $httpClient->doRequests();
        foreach ($newResponses as $uuid => $newResponse) {
            if ($newResponse instanceof ResponseInterface
                && $newResponse->getStatusCode() === 200
            ) {
                $item = $this->retrieveCachedItem($uuid);
                if ($item instanceof CacheItemInterface) {
                    $item->set(Message::str($newResponse));
                    $this->cache->saveDeferred($item);
                }
            }
        }
        if ($this->cache instanceof CacheItemPoolInterface) {
            $this->cache->commit();
        }

        $labels = [];
        foreach ($responses + $newResponses as $uuid => $response) {
            $generateLabelResponse = $this->processGenerateLabelResponse($response);
            $labels[$uuid] = $generateLabelResponse;
        }

        return $labels;
    }
}
