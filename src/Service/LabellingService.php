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
use Firstred\PostNL\Entity\Request\GenerateLabel;
use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\Util\Message;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\RequestFactory;
use InvalidArgumentException;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return GenerateLabelResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     */
    public function generateLabel(GenerateLabel $generateLabel, $confirm = true)
    {
        $item = $this->retrieveCachedItem($generateLabel->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = Client::getInstance()->doRequest(
                $this->buildGenerateLabelRequest($generateLabel, $confirm)
            );
            static::validateResponse($response);
        }

        $object = $this->processGenerateLabelResponse($response);
        if ($object instanceof GenerateLabelResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && $response->getStatusCode() === 200
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        if ($response->getStatusCode() === 200) {
            throw new ResponseException('Invalid API response', 0, null, $response);
        }

        throw new ApiException('Unable to generate label');
    }

    /**
     * Build the GenerateLabel request for the REST API
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function buildGenerateLabelRequest(GenerateLabel $generateLabel, bool $confirm = true): RequestInterface
    {
        /** @var RequestFactory $factory */
        $factory = Psr17FactoryDiscovery::findRequestFactory();

        return $factory->createRequest(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).'?'.http_build_query(
                ['confirm' => $confirm]
            ),
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
                'apikey'       => $this->postnl->getApiKey(),
            ],
            json_encode($generateLabel, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES)
        );
    }

    /**
     * Process the GenerateLabel REST Response
     *
     * @param ResponseInterface $response
     *
     * @return GenerateLabelResponse|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function processGenerateLabelResponse($response): ?GenerateLabelResponse
    {
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['ResponseShipments'])) {
            /** @var GenerateLabelResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GenerateLabelResponse' => $body]);

            return $object;
        }

        return null;
    }

    /**
     * Generate multiple labels at once
     *
     * @param array $generateLabels ['uuid' => [GenerateBarcode, confirm], ...]
     *
     * @return array
     */
    public function generateLabels(array $generateLabels): array
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
                } catch (InvalidArgumentException $e) {
                }
                if ($response instanceof ResponseInterface) {
                    $responses[$uuid] = $response;

                    continue;
                }
            }

            $httpClient->addOrUpdateRequest(
                (string) $uuid,
                $this->buildGenerateLabelRequest($generateLabel[0], $generateLabel[1])
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
            try {
                $generateLabelResponse = $this->processGenerateLabelResponse($response);
            } catch (Exception $e) {
                $generateLabelResponse = $e;
            }

            $labels[$uuid] = $generateLabelResponse;
        }

        return $labels;
    }
}
