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

namespace Firstred\PostNL\Service\RequestBuilder\Rest;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Request\SendShipment;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\RequestBuilder\ShippingServiceRequestBuilderInterface;
use Firstred\PostNL\Service\ShippingServiceInterface;
use Firstred\PostNL\Util\Util;
use Psr\Http\Message\RequestInterface;
use ReflectionException;
use function http_build_query;
use function json_encode;
use const PHP_QUERY_RFC3986;

/**
 * @since 2.0.0
 * @internal
 */
class ShippingServiceRestRequestBuilder extends AbstractRestRequestBuilder implements ShippingServiceRequestBuilderInterface
{
    // Endpoints
    private const LIVE_ENDPOINT = 'https://api.postnl.nl/${VERSION}/shipment';
    private const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/${VERSION}/shipment';

    /**
     * @param SendShipment $sendShipment
     * @param bool         $confirm
     *
     * @return RequestInterface
     *
     * @since 2.0.0
     */
    public function buildSendShipmentRequest(SendShipment $sendShipment, bool $confirm = true): RequestInterface
    {
        $this->setService(entity: $sendShipment);

        return $this->getRequestFactory()->createRequest(
            method: 'POST',
            uri: Util::versionStringToURLString(version: $this->getVersion(), url: $this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).'?'.http_build_query(data: [
                'confirm' => $confirm,
            ], numeric_prefix: '', arg_separator: '&', encoding_type: PHP_QUERY_RFC3986)
        )
            ->withHeader('apikey', value: $this->getApiKey()->getString())
            ->withHeader('Accept', value: 'application/json')
            ->withHeader('Content-Type', value: 'application/json;charset=UTF-8')
            ->withBody(body: $this->getStreamFactory()->createStream(content: json_encode(value: $sendShipment)));
    }

    /**
     * @param AbstractEntity $entity
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @since 2.0.0
     */
    protected function setService(AbstractEntity $entity): void
    {
        $entity->setCurrentService(currentService: ShippingServiceInterface::class);

        parent::setService(entity: $entity);
    }
}
