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

use Firstred\PostNL\Entity\Request\NationalGeoAddressCheckRequest;
use Firstred\PostNL\Entity\ValidatedAddress;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\PostNL;
use Http\Client\Exception as HttpClientException;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class NationalGeoAddressCheckService
 */
class NationalGeoAddressCheckService extends AbstractService
{
    // API Version
    const VERSION = '1';

    // Endpoints
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/address/national/v1/geocode';
    const LIVE_ENDPOINT = 'https://api.postnl.nl/address/national/v1/geocode';

    /** @var PostNL $postnl */
    protected $postnl;

    /**
     * Validate a national address
     *
     * @param NationalGeoAddressCheckRequest $validateAddress
     *
     * @return ValidatedAddress
     *
     * @throws CifDownException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function checkAddress(NationalGeoAddressCheckRequest $validateAddress): ValidatedAddress
    {
        /** @var ResponseInterface $response */
        $response = Client::getInstance()->doRequest($this->buildNationalGeoAddressCheckRequest($validateAddress));

        return $this->processNationalGeoAddressCheckResponse($response);
    }

    /**
     * Build the national geo address check HTTP request for the REST API
     *
     * @param NationalGeoAddressCheckRequest $validateAddress
     *
     * @return RequestInterface
     *
     * @since 2.0.0
     */
    public function buildNationalGeoAddressCheckRequest(NationalGeoAddressCheckRequest $validateAddress): RequestInterface
    {
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT
        )
            ->withHeader('Accept', 'application/json')
            ->withHeader('apikey', $this->postnl->getApiKey())
            ->withBody($streamFactory->createStream(json_encode($validateAddress)))
        ;
    }

    /**
     * Process national geo address check  REST response
     *
     * @param mixed $response
     *
     * @return ValidatedAddress
     *
     * @throws CifDownException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function processNationalGeoAddressCheckResponse(ResponseInterface $response): ValidatedAddress
    {
        $body = json_decode((string) $response->getBody(), true);
        if (is_array($body)) {
            if (isset($body[0]['Street'])) {
                return ValidatedAddress::jsonDeserialize(['ValidatedAddress' => $body[0]]);
            }
        }

        throw new CifDownException('Unable to process validate national address response', 0, null, null, $response);
    }
}
