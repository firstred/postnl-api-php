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

use Firstred\PostNL\Entity\CreditWorthiness;
use Firstred\PostNL\Entity\Response\NationalBusinessCheckResponse;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifErrorException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\PostNL;
use Http\Client\Exception as HttpClientException;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CompanyCreditCheckService
 */
class CompanyCreditCheckService extends AbstractService
{
    // API Version
    const VERSION = '3';

    // Endpoints
    const COMPANY_SEARCH_LIVE_ENDPOINT = 'https://api.postnl.nl/company/creditcheck/v1/search';
    const CREDIT_FLAG_LIVE_ENDPOINT = 'https://api.postnl.nl/company/creditcheck/v1/creditflag';
    const CREDIT_ADVICE_LIVE_ENDPOINT = 'https://api.postnl.nl/company/creditcheck/v1/creditadvice';
    const CREDITWORTHINESS_LIVE_ENDPOINT = 'https://api.postnl.nl/company/creditcheck/v1/creditworthiness';
    const CREDITWORTHINESS_LARGE_LIVE_ENDPOINT = 'https://api.postnl.nl/company/creditcheck/v1/creditworthinesslarge';

    /** @var PostNL $postnl */
    protected $postnl;

    /**
     * Company search
     *
     *  Returns basic information about organizations, based on official numerical references
     *
     * @param string $kvkNumber
     * @param string $postalCode
     * @param string $houseNumber
     * @param string $city
     * @param string $searchKeyWords
     * @param string $telephoneNumber
     * @param string $keyNextSearch
     *
     * @return NationalBusinessCheckResponse
     *
     * @throws HttpClientException
     * @throws NotSupportedException
     *
     * @since 2.0.0
     */
    public function searchCompany(string $kvkNumber = '', string $postalCode = '', string $houseNumber = '', string $city = '', string $searchKeyWords = '', string $telephoneNumber = '', string $keyNextSearch = ''): NationalBusinessCheckResponse
    {
        /** @var ResponseInterface $response */
        $response = Client::getInstance()->doRequest(
            $this->buildSearchCompanyRequest(
                $kvkNumber,
                $postalCode,
                $houseNumber,
                $city,
                $searchKeyWords,
                $telephoneNumber,
                $keyNextSearch
            )
        );

        return $this->processNationalBusinessCheckResponse($response);
    }

    /**
     * Build the `validateAddress` HTTP request for the REST API
     *
     * @param string $kvkNumber
     * @param string $postalCode
     * @param string $houseNumber
     * @param string $city
     * @param string $searchKeyWords
     * @param string $telephoneNumber
     * @param string $keyNextSearch
     *
     * @return RequestInterface
     *
     * @throws NotSupportedException
     *
     * @since 2.0.0
     */
    public function buildSearchCompanyRequest(string $kvkNumber, string $postalCode, string $houseNumber, string $city, string $searchKeyWords, string $telephoneNumber, string $keyNextSearch): RequestInterface
    {
        if ($this->postnl->getSandbox()) {
            throw new NotSupportedException('The National Business Check API does not support sandbox mode');
        }
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        /** @var RequestInterface $request */
        $request = Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', static::COMPANY_SEARCH_LIVE_ENDPOINT)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withHeader('apikey', $this->postnl->getApiKey())
            ->withBody(
                $streamFactory->createStream(
                    json_encode(
                        [
                            'kvkNumber'       => $kvkNumber,
                            'postalCode'      => $postalCode,
                            'houseNumber'     => $houseNumber,
                            'city'            => $city,
                            'searchKeyWords'  => $searchKeyWords,
                            'telephoneNumber' => $telephoneNumber,
                            'keyNextSearch'   => $keyNextSearch,
                        ]
                    )
                )
            );

        return $request;
    }

    /**
     * Credit flag
     *
     *  Delivers a Credit Flag of the requested company.
     *
     * @param string $companyIdentification
     *
     * @return CreditWorthiness
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotSupportedException
     *
     * @since 2.0.0
     */
    public function retrieveCreditFlag(string $companyIdentification): CreditWorthiness
    {
        /** @var ResponseInterface $response */
        $response = Client::getInstance()->doRequest(
            $this->buildRetrieveCreditFlagRequest($companyIdentification)
        );

        return $this->processRetrieveCreditFlagResponse($response);
    }

    /**
     * Build the `validateAddress` HTTP request for the REST API
     *
     * @param string $companyIdentification
     *
     * @return RequestInterface
     *
     * @throws NotSupportedException
     *
     * @since 2.0.0
     */
    public function buildRetrieveCreditFlagRequest(string $companyIdentification): RequestInterface
    {
        if ($this->postnl->getSandbox()) {
            throw new NotSupportedException('The Company Credit Check API does not support sandbox mode');
        }
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        /** @var RequestInterface $request */
        $request = Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', static::CREDIT_FLAG_LIVE_ENDPOINT)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withHeader('apikey', $this->postnl->getApiKey())
            ->withBody($streamFactory->createStream(json_encode($companyIdentification)));

        return $request;
    }

    /**
     * Process credit flag response
     *
     * @param ResponseInterface $response
     *
     * @return CreditWorthiness
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function processRetrieveCreditFlagResponse(ResponseInterface $response): CreditWorthiness
    {
        static::validateResponse($response);
        $body = @json_decode((string) $response->getBody(), true);
        if (isset($body['mainMessage'])) {
            /** @var CreditWorthiness $object */
            $object = CreditWorthiness::jsonDeserialize(['CreditWorthiness' => $body]);

            return $object;
        }

        throw new CifErrorException('Unable to process credit flag response');
    }
}
