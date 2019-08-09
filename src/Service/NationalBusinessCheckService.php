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
 * Class NationalBusinessCheckService
 */
class NationalBusinessCheckService extends AbstractService
{
    // API Version
    const VERSION = '3';

    // Endpoints
    const COMPANY_SEARCH_LIVE_ENDPOINT = 'https://api.postnl.nl/company/search/v3/companysearch';
    const COMPANY_NAME_AND_ADDRESS_LIVE_ENDPOINT = 'https://api.postnl.nl/company/search/v3/companynameandaddress';
    const COMPANY_ADDRESS_LIVE_ENDPOINT = 'https://api.postnl.nl/company/search/v3/companyaddress';
    const COMPANY_PHONE_LIVE_ENDPOINT = 'https://api.postnl.nl/company/search/v3/companyphone';
    const COMPANY_DETAILS_LIVE_ENDPOINT = 'https://api.postnl.nl/company/detail/v3/companydetails';
    const COMPANY_DETAILS_EXTRA_LIVE_ENDPOINT = 'https://api.postnl.nl/company/detail/v3/companydetailsextra';
    const COMPANY_AUTHORIZED_SIGNATORY_LIVE_ENDPOINT = 'https://api.postnl.nl/company/v1/authorizedsignatory';
    const COMPANY_EXTRACT_LIVE_ENDPOINT = 'https://api.postnl.nl/company/v1/cocextract';

    const METHOD_COMPANY_SEARCH = 1;
    const METHOD_COMPANY_NAME_AND_ADDRESS = 2;
    const METHOD_COMPANY_ADDRESS = 3;
    const METHOD_COMPANY_PHONE = 4;
    const METHOD_COMPANY_DETAILS = 5;
    const METHOD_COMPANY_DETAILS_EXTRA = 6;
    const METHOD_COMPANY_AUTHORIZED_SIGNATORY = 7;
    const METHOD_COMPANY_EXTRACT = 8;

    /** @var PostNL $postnl */
    protected $postnl;

    /**
     * Company search
     *
     *  Returns basic information about organizations, based on official numerical references
     *
     * @param string $kvkNumber
     * @param string $branchNumber
     * @param string $rsin
     * @param bool   $includeActive
     * @param bool   $mainBranch
     * @param bool   $branch
     * @param int    $maxResultsPerPage
     * @param int    $requestedPage
     *
     * @return NationalBusinessCheckResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotSupportedException
     *
     * @since 2.0.0
     */
    public function searchCompany(string $kvkNumber = '', string $branchNumber = '', string $rsin = '', bool $includeActive = false, bool $mainBranch = true, bool $branch = true, int $maxResultsPerPage = 50, int $requestedPage = 1): NationalBusinessCheckResponse
    {
        /** @var ResponseInterface $response */
        $response = Client::getInstance()->doRequest(
            $this->buildSearchCompanyRequest(
                $kvkNumber,
                $branchNumber,
                $rsin,
                $includeActive,
                $mainBranch,
                $branch,
                $maxResultsPerPage,
                $requestedPage
            )
        );

        return $this->processNationalBusinessCheckResponse($response);
    }

    /**
     * Build the `validateAddress` HTTP request for the REST API
     *
     * @param string $kvkNumber
     * @param string $branchNumber
     * @param string $rsin
     * @param bool   $includeInactive
     * @param bool   $mainBranch
     * @param bool   $branch
     * @param int    $maxResultsPerPage
     * @param int    $requestedPage
     *
     * @return RequestInterface
     *
     * @throws NotSupportedException
     *
     * @since 2.0.0
     */
    public function buildSearchCompanyRequest(string $kvkNumber, string $branchNumber, string $rsin, bool $includeInactive, bool $mainBranch, bool $branch, int $maxResultsPerPage, int $requestedPage): RequestInterface
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
                            'kvknumber'         => $kvkNumber,
                            'branchnumber'      => $branchNumber,
                            'rsin'              => $rsin,
                            'includeinactive'   => $includeInactive ? '1' : '0',
                            'mainbranch'        => $mainBranch ? '1' : '0',
                            'branch'            => $branch ? '1' : '0',
                            'maxresultsperpage' => (string) $maxResultsPerPage,
                            'requestedpage'     => (string) $requestedPage,
                        ]
                    )
                )
            );

        return $request;
    }

    /**
     * Company search by name and address
     *
     *  Returns basic information about organizations, based on a name and optional address components
     *
     * @param string $companyName
     * @param string $branchStreetName
     * @param string $branchHouseNumber
     * @param string $branchHouseNumberAddition
     * @param string $branchPostalCode
     * @param string $branchCity
     * @param bool   $includeBranchAddress
     * @param bool   $includeMailingAddress
     * @param bool   $includeActive
     * @param bool   $mainBranch
     * @param bool   $branch
     * @param int    $maxResultsPerPage
     * @param int    $requestedPage
     *
     * @return NationalBusinessCheckResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotSupportedException
     *
     * @since 2.0.0
     */
    public function searchCompanyByNameAndAddress(string $companyName = '', string $branchStreetName = '', string $branchHouseNumber = '', string $branchHouseNumberAddition = '', string $branchPostalCode = '', string $branchCity = '', bool $includeBranchAddress = true, bool $includeMailingAddress = true, bool $includeActive = false, bool $mainBranch = true, bool $branch = true, int $maxResultsPerPage = 50, int $requestedPage = 1): NationalBusinessCheckResponse
    {
        /** @var ResponseInterface $response */
        $response = Client::getInstance()->doRequest(
            $this->buildSearchCompanyByNameAndAddressRequest(
                $companyName,
                $branchStreetName,
                $branchHouseNumber,
                $branchHouseNumberAddition,
                $branchPostalCode,
                $branchCity,
                $includeBranchAddress,
                $includeMailingAddress,
                $includeActive,
                $mainBranch,
                $branch,
                $maxResultsPerPage,
                $requestedPage
            )
        );

        return $this->processNationalBusinessCheckResponse($response);
    }

    /**
     * Build the `validateAddress` HTTP request for the REST API
     *
     * @param string $companyName
     * @param string $branchStreetName
     * @param string $branchHouseNumber
     * @param string $branchHouseNumberAddition
     * @param string $branchPostalCode
     * @param string $branchCity
     * @param bool   $includeBranchAddress
     * @param bool   $includeMailingAddress
     * @param bool   $includeInactive
     * @param bool   $mainBranch
     * @param bool   $branch
     * @param int    $maxResultsPerPage
     * @param int    $requestedPage
     *
     * @return RequestInterface
     *
     * @throws NotSupportedException
     *
     * @since 2.0.0
     */
    public function buildSearchCompanyByNameAndAddressRequest(string $companyName, string $branchStreetName, string $branchHouseNumber, string $branchHouseNumberAddition, string $branchPostalCode, string $branchCity, bool $includeBranchAddress, bool $includeMailingAddress, bool $includeInactive, bool $mainBranch, bool $branch, int $maxResultsPerPage, int $requestedPage): RequestInterface
    {
        if ($this->postnl->getSandbox()) {
            throw new NotSupportedException('The National Business Check API does not support sandbox mode');
        }
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        /** @var RequestInterface $request */
        $request = Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', static::COMPANY_NAME_AND_ADDRESS_LIVE_ENDPOINT)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withHeader('apikey', $this->postnl->getApiKey())
            ->withBody(
                $streamFactory->createStream(
                    json_encode(
                        [
                            'companyname'               => $companyName,
                            'branchstreetname'          => $branchStreetName,
                            'branchhousenumber'         => $branchHouseNumber,
                            'branchhousenumberaddition' => $branchHouseNumberAddition,
                            'branchpostalcode'          => $branchPostalCode,
                            'branchcity'                => $branchCity,
                            'includebranchaddress'      => $includeBranchAddress ? '1' : '0',
                            'includemailingaddress'     => $includeMailingAddress ? '1' : '0',
                            'includeinactive'           => $includeInactive ? '1' : '0',
                            'mainbranch'                => $mainBranch ? '1' : '0',
                            'branch'                    => $branch ? '1' : '0',
                            'maxresultsperpage'         => (string) $maxResultsPerPage,
                            'requestedpage'             => (string) $requestedPage,
                        ]
                    )
                )
            );

        return $request;
    }

    /**
     * Company search by address
     *
     *  Returns basic information about organizations, based on address components
     *
     * @param string $branchStreetName
     * @param string $branchHouseNumber
     * @param string $branchHouseNumberAddition
     * @param string $branchPostalCode
     * @param string $branchCity
     * @param bool   $includeBranchAddress
     * @param bool   $includeMailingAddress
     * @param bool   $includeInactive
     * @param bool   $mainBranch
     * @param bool   $branch
     * @param int    $maxResultsPerPage
     * @param int    $requestedPage
     *
     * @return NationalBusinessCheckResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotSupportedException
     *
     * @since 2.0.0
     */
    public function searchCompanyByAddress(string $branchStreetName = '', string $branchHouseNumber = '', string $branchHouseNumberAddition = '', string $branchPostalCode = '', string $branchCity = '', bool $includeBranchAddress = true, bool $includeMailingAddress = true, bool $includeInactive = false, bool $mainBranch = true, bool $branch = true, int $maxResultsPerPage = 50, int $requestedPage = 1): NationalBusinessCheckResponse
    {
        /** @var ResponseInterface $response */
        $response = Client::getInstance()->doRequest(
            $this->buildSearchCompanyByNameAndAddressRequest(
                $branchStreetName,
                $branchHouseNumber,
                $branchHouseNumberAddition,
                $branchPostalCode,
                $branchCity,
                $includeBranchAddress,
                $includeMailingAddress,
                $includeInactive,
                $mainBranch,
                $branch,
                $maxResultsPerPage,
                $requestedPage
            )
        );

        return $this->processNationalBusinessCheckResponse($response);
    }

    /**
     * Build the `validateAddress` HTTP request for the REST API
     *
     * @param string $branchStreetName
     * @param string $branchHouseNumber
     * @param string $branchHouseNumberAddition
     * @param string $branchPostalCode
     * @param string $branchCity
     * @param bool   $includeBranchAddress
     * @param bool   $includeMailingAddress
     * @param bool   $includeInactive
     * @param bool   $mainBranch
     * @param bool   $branch
     * @param int    $maxResultsPerPage
     * @param int    $requestedPage
     *
     * @return RequestInterface
     *
     * @throws NotSupportedException
     *
     * @since 2.0.0
     */
    public function buildSearchCompanyByAddressRequest(string $branchStreetName, string $branchHouseNumber, string $branchHouseNumberAddition, string $branchPostalCode, string $branchCity, bool $includeBranchAddress, bool $includeMailingAddress, bool $includeInactive, bool $mainBranch, bool $branch, int $maxResultsPerPage, int $requestedPage): RequestInterface
    {
        if ($this->postnl->getSandbox()) {
            throw new NotSupportedException('The National Business Check API does not support sandbox mode');
        }
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        /** @var RequestInterface $request */
        $request = Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', static::COMPANY_ADDRESS_LIVE_ENDPOINT)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withHeader('apikey', $this->postnl->getApiKey())
            ->withBody(
                $streamFactory->createStream(
                    json_encode(
                        [
                            'branchstreetname'          => $branchStreetName,
                            'branchhousenumber'         => $branchHouseNumber,
                            'branchhousenumberaddition' => $branchHouseNumberAddition,
                            'branchpostalcode'          => $branchPostalCode,
                            'branchcity'                => $branchCity,
                            'includebranchaddress'      => $includeBranchAddress ? '1' : '0',
                            'includemailingaddress'     => $includeMailingAddress ? '1' : '0',
                            'includeinactive'           => $includeInactive ? '1' : '0',
                            'mainbranch'                => $mainBranch ? '1' : '0',
                            'branch'                    => $branch ? '1' : '0',
                            'maxresultsperpage'         => (string) $maxResultsPerPage,
                            'requestedpage'             => (string) $requestedPage,
                        ]
                    )
                )
            );

        return $request;
    }

    /**
     * Company search by phone number
     *
     *  Returns basic information about organizations, based on a general telephone number
     *
     * @param string $branchStreetName
     * @param string $branchHouseNumber
     * @param string $branchHouseNumberAddition
     * @param string $branchPostalCode
     * @param string $branchCity
     * @param bool   $includeBranchAddress
     * @param bool   $includeMailingAddress
     * @param bool   $includeInactive
     * @param bool   $mainBranch
     * @param bool   $branch
     * @param int    $maxResultsPerPage
     * @param int    $requestedPage
     *
     * @return NationalBusinessCheckResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotSupportedException
     *
     * @since 2.0.0
     */
    public function searchCompanyByPhone(string $branchStreetName = '', string $branchHouseNumber = '', string $branchHouseNumberAddition = '', string $branchPostalCode = '', string $branchCity = '', bool $includeBranchAddress = true, bool $includeMailingAddress = true, bool $includeInactive = false, bool $mainBranch = true, bool $branch = true, int $maxResultsPerPage = 50, int $requestedPage = 1): NationalBusinessCheckResponse
    {
        /** @var ResponseInterface $response */
        $response = Client::getInstance()->doRequest(
            $this->buildSearchCompanyByNameAndAddressRequest(
                $branchStreetName,
                $branchHouseNumber,
                $branchHouseNumberAddition,
                $branchPostalCode,
                $branchCity,
                $includeBranchAddress,
                $includeMailingAddress,
                $includeInactive,
                $mainBranch,
                $branch,
                $maxResultsPerPage,
                $requestedPage
            )
        );

        return $this->processNationalBusinessCheckResponse($response);
    }

    /**
     * Build the `validateAddress` HTTP request for the REST API
     *
     * @param string $phoneNumber
     * @param bool   $includeInactive
     * @param bool   $mainBranch
     * @param bool   $branch
     * @param int    $maxResultsPerPage
     * @param int    $requestedPage
     *
     * @return RequestInterface
     *
     * @throws NotSupportedException
     *
     * @since 2.0.0
     */
    public function buildSearchCompanyByPhoneRequest(string $phoneNumber, bool $includeInactive, bool $mainBranch, bool $branch, int $maxResultsPerPage, int $requestedPage): RequestInterface
    {
        if ($this->postnl->getSandbox()) {
            throw new NotSupportedException('The National Business Check API does not support sandbox mode');
        }
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        /** @var RequestInterface $request */
        $request = Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', static::COMPANY_ADDRESS_LIVE_ENDPOINT)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withHeader('apikey', $this->postnl->getApiKey())
            ->withBody(
                $streamFactory->createStream(
                    json_encode(
                        [
                            'phonenumber'       => $phoneNumber,
                            'includeinactive'   => $includeInactive ? '1' : '0',
                            'mainbranch'        => $mainBranch ? '1' : '0',
                            'branch'            => $branch ? '1' : '0',
                            'maxresultsperpage' => (string) $maxResultsPerPage,
                            'requestedpage'     => (string) $requestedPage,
                        ]
                    )
                )
            );

        return $request;
    }

    /**
     * Company search by phone number
     *
     *  Returns basic information about organizations, based on a general telephone number
     *
     * @param string $kvkNumber
     * @param string $branchNumber
     * @param string $postnlKey
     * @param int    $type
     *
     * @return NationalBusinessCheckResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotSupportedException
     *
     * @since 2.0.0
     */
    public function getCompanyDetails(string $kvkNumber = '', string $branchNumber = '', string $postnlKey = '', int $type = self::METHOD_COMPANY_DETAILS): NationalBusinessCheckResponse
    {
        /** @var ResponseInterface $response */
        $response = Client::getInstance()->doRequest(
            $this->buildGetCompanyDetailsRequest(
                $kvkNumber,
                $branchNumber,
                $postnlKey,
                $type
            )
        );

        return $this->processNationalBusinessCheckResponse($response);
    }

    /**
     * Build the `validateAddress` HTTP request for the REST API
     *
     * @param string $kvkNumber
     * @param string $branchNumber
     * @param string $postnlKey
     * @param int    $type
     *
     * @return RequestInterface
     *
     * @throws NotSupportedException
     *
     * @since 2.0.0
     */
    public function buildGetCompanyDetailsRequest(string $kvkNumber, string $branchNumber, string $postnlKey, int $type): RequestInterface
    {
        if ($this->postnl->getSandbox()) {
            throw new NotSupportedException('The National Business Check API does not support sandbox mode');
        }
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        switch ($type) {
            case static::METHOD_COMPANY_DETAILS:
                $endpoint = static::COMPANY_DETAILS_LIVE_ENDPOINT;
                break;
            case static::METHOD_COMPANY_DETAILS_EXTRA:
                $endpoint = static::COMPANY_DETAILS_EXTRA_LIVE_ENDPOINT;
                break;
            case static::METHOD_COMPANY_AUTHORIZED_SIGNATORY:
                $endpoint = static::COMPANY_AUTHORIZED_SIGNATORY_LIVE_ENDPOINT;
                break;
            case static::METHOD_COMPANY_EXTRACT:
                $endpoint = static::COMPANY_EXTRACT_LIVE_ENDPOINT;
                break;
            default:
                throw new NotSupportedException('Method not supported');
        }

        /** @var RequestInterface $request */
        $request = Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', $endpoint)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withHeader('apikey', $this->postnl->getApiKey())
            ->withBody(
                $streamFactory->createStream(
                    json_encode(
                        [
                            'kvknumber'    => $kvkNumber,
                            'branchnumber' => $branchNumber,
                            'postnlkey'    => $postnlKey,
                        ]
                    )
                )
            );

        return $request;
    }

    /**
     * Process validate national address REST response
     *
     * @param mixed $response
     *
     * @return NationalBusinessCheckResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function processNationalBusinessCheckResponse(ResponseInterface $response): NationalBusinessCheckResponse
    {
        static::validateResponse($response);
        $body = json_decode((string) $response->getBody(), true);
        $object = NationalBusinessCheckResponse::jsonDeserialize(['NationalBusinessCheckResponse' => $body]);
        if ($object instanceof NationalBusinessCheckResponse) {
            return $object;
        }

        throw new CifDownException('Unable to process basic national address check response', 0, null, null, $response);
    }
}
