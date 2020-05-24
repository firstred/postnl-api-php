<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service;

use Firstred\PostNL\Entity\Request\PostalCodeCheckRequest;
use Firstred\PostNL\Entity\ValidatedAddress;
use Firstred\PostNL\Entity\ValidatedAddressInterface;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifErrorException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\PostNL;
use Http\Client\Exception as HttpClientException;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PostalCodeCheckService.
 */
class PostalCodeCheckService extends AbstractService
{
    // API Version
    const VERSION = '1';

    // Endpoints
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/checkout/v1/postalcodecheck';
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/checkout/v1/postalcodecheck';

    /** @var PostNL */
    protected $postnl;

    /**
     * Validate an international address.
     *
     * @param PostalCodeCheckRequest $checkPostalCode
     *
     * @return ValidatedAddressInterface
     *
     * @throws CifDownException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function checkPostalCode(PostalCodeCheckRequest $checkPostalCode): ValidatedAddressInterface
    {
        /** @var ResponseInterface $response */
        $response = Client::getInstance()->doRequest($this->buildPostalCodeCheckRequest($checkPostalCode));

        return $this->processPostalCodeCheckResponse($response);
    }

    /**
     * Build the `postalCodeCheck` HTTP request for the REST API.
     *
     * @param PostalCodeCheckRequest $postalCodeCheck
     *
     * @return RequestInterface
     *
     * @since 2.0.0
     */
    public function buildPostalCodeCheckRequest(PostalCodeCheckRequest $postalCodeCheck): RequestInterface
    {
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $endpoint = $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT;

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', $endpoint)
            ->withHeader('Accept', 'application/json')
            ->withHeader('apikey', $this->postnl->getApiKey())
            ->withBody($streamFactory->createStream(json_encode($postalCodeCheck)));
    }

    /**
     * Process postal code check REST response.
     *
     * @param mixed $response
     *
     * @return ValidatedAddressInterface
     *
     * @throws CifDownException
     * @throws InvalidArgumentException
     * @throws CifErrorException
     *
     * @since 2.0.0
     */
    public function processPostalCodeCheckResponse(ResponseInterface $response): ValidatedAddressInterface
    {
        static::validateResponse($response);
        $body = @json_decode((string) $response->getBody(), true);
        if (is_array($body)) {
            return ValidatedAddress::jsonDeserialize(['ValidatedAddress' => $body]);
        }

        throw new CifDownException('Unable to process postal code check response', 0, null, null, $response);
    }
}
