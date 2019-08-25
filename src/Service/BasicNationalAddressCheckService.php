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

use Firstred\PostNL\Entity\Request\BasicNationalAddressCheckRequest;
use Firstred\PostNL\Entity\Response\BasicNationalAddressCheckResponse;
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
 * Class BasicNationalAddressCheckService
 */
class BasicNationalAddressCheckService extends AbstractService
{
    // API Version
    const VERSION = '1';

    // Endpoints
    const POSTAL_CODE_SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/address/national/basic/v1/postalcode';
    const POSTAL_CODE_LIVE_ENDPOINT = 'https://api.postnl.nl/address/national/basic/v1/postalcode';
    const CITY_STREET_SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/address/national/basic/v1/citystreetname';
    const CITY_STREET_LIVE_ENDPOINT = 'https://api.postnl.nl/address/national/basic/v1/citystreetname';

    /** @var PostNL $postnl */
    protected $postnl;

    /**
     * Validate a national address
     *
     * @param BasicNationalAddressCheckRequest $addressCheck
     *
     * @return BasicNationalAddressCheckResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function checkAddress(BasicNationalAddressCheckRequest $addressCheck): BasicNationalAddressCheckResponse
    {
        /** @var ResponseInterface $response */
        $response = Client::getInstance()->doRequest($this->buildBasicNationalAddressCheckRequest($addressCheck));

        return $this->processBasicNationalAddressCheckResponse($response);
    }

    /**
     * Build the `validateAddress` HTTP request for the REST API
     *
     * @param BasicNationalAddressCheckRequest $validateAddress
     *
     * @return RequestInterface
     *
     * @since 2.0.0
     */
    public function buildBasicNationalAddressCheckRequest(BasicNationalAddressCheckRequest $validateAddress): RequestInterface
    {
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $query = [
            'postalcode' => $validateAddress->getPostalCode(),
        ];
        $endpoint = $this->postnl->getSandbox() ? static::CITY_STREET_SANDBOX_ENDPOINT : static::CITY_STREET_LIVE_ENDPOINT;
        if ($validateAddress->getHouseNumber()) {
            $query['housenumber'] = $validateAddress->getHouseNumber();
            $endpoint = $this->postnl->getSandbox() ? static::POSTAL_CODE_SANDBOX_ENDPOINT : static::POSTAL_CODE_LIVE_ENDPOINT;
        }

        /** @var RequestInterface $request */
        $request = Psr17FactoryDiscovery::findRequestFactory()->createRequest('GET', $endpoint.'?'.http_build_query($query))
            ->withHeader('Accept', 'application/json')
            ->withHeader('apikey', $this->postnl->getApiKey())
            ->withBody($streamFactory->createStream())
        ;

        return $request;
    }

    /**
     * Process validate national address REST response
     *
     * @param mixed $response
     *
     * @return BasicNationalAddressCheckResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function processBasicNationalAddressCheckResponse(ResponseInterface $response): BasicNationalAddressCheckResponse
    {
        static::validateResponse($response);
        $body = @json_decode((string) $response->getBody(), true);
        if (isset($body['streetName'])) {
            return BasicNationalAddressCheckResponse::jsonDeserialize(['BasicNationalAddressCheckResponse' => $body]);
        }

        throw new CifDownException('Unable to process basic national address check response', 0, null, null, $response);
    }
}
