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
use Firstred\PostNL\Entity\Request\GenerateLabel;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\LabellingServiceInterface;
use Firstred\PostNL\Service\RequestBuilder\LabellingServiceRequestBuilderInterface;
use Firstred\PostNL\Util\Util;
use Psr\Http\Message\RequestInterface;
use ReflectionException;
use function http_build_query;
use function in_array;
use function json_encode;
use function str_replace;
use const PHP_QUERY_RFC3986;

/**
 * @since 2.0.0
 * @internal
 */
class LabellingServiceRestRequestBuilder extends AbstractRestRequestBuilder implements LabellingServiceRequestBuilderInterface
{
    // Endpoints
    private const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_2/label';
    private const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_2/label';

    /** @var int[] */
    private static array $insuranceProductCodes = [3534, 3544, 3087, 3094];

    /**
     * Build the GenerateLabel request for the REST API.
     *
     * @since 2.0.0
     */
    public function buildGenerateLabelRequest(GenerateLabel $generateLabel, bool $confirm = true): RequestInterface
    {
        $this->setService(entity: $generateLabel);

        $endpoint = $this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT;
        foreach ($generateLabel->getShipments() as $shipment) {
            if (in_array(needle: $shipment->getProductCodeDelivery(), haystack: static::$insuranceProductCodes)) {
                // Insurance behaves a bit strange w/ v2.2, falling back on v2.1
                $endpoint = str_replace(search: 'v2_2', replace: 'v2_1', subject: $endpoint);
            }
        }

        return $this->getRequestFactory()->createRequest(
            method: 'POST',
            uri: $endpoint.'?'.http_build_query(data: [
                'confirm' => ($confirm ? 'true' : 'false'),
            ], numeric_prefix: '', arg_separator: '&', encoding_type: PHP_QUERY_RFC3986))
            ->withHeader('apikey', value: $this->getApiKey()->getString())
            ->withHeader('Accept', value: 'application/json')
            ->withHeader('Content-Type', value: 'application/json;charset=UTF-8')
            ->withBody(body: $this->getStreamFactory()->createStream(content: json_encode(value: $generateLabel)));
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
        $entity->setCurrentService(currentService: LabellingServiceInterface::class);

        parent::setService(entity: $entity);
    }
}
