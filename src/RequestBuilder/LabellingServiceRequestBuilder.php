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

namespace Firstred\PostNL\RequestBuilder;

use Firstred\PostNL\DTO\Request\GenerateLabelsRequestDTO;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use function str_replace;

/**
 * Class LabellingServiceRequestBuilder.
 */
class LabellingServiceRequestBuilder extends RequestBuilderBase implements LabellingServiceRequestBuilderInterface
{
    const DEFAULT_VERSION = '2.1';

    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/{{version}}/label';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/{{version}}/label';

    /**
     * @param GenerateLabelsRequestDTO $generateLabelRequestDTO
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     */
    public function buildGenerateLabelRequest(GenerateLabelsRequestDTO $generateLabelRequestDTO): RequestInterface
    {
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'POST',
            str_replace(
                search: '{{version}}',
                replace: 'v'.str_replace(search: '.', replace: '_', subject: $this->getVersion()),
                subject: $this->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT,
            ),
        )
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode(value: $generateLabelRequestDTO->jsonSerialize())))
            ->withHeader('apikey', $this->getApiKey())
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ;
    }
}
