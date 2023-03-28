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

namespace Firstred\PostNL\Service\ResponseProcessor\Soap;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Response\GetLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ResponseProcessor\LocationServiceResponseProcessorInterface;
use ParagonIE\HiddenString\HiddenString;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Sabre\Xml\LibXMLException;
use Sabre\Xml\Reader;
use SimpleXMLElement;

/**
 * @deprecated 2.0.0
 * @internal
 */
class LocationServiceSoapResponseProcessor extends AbstractSoapResponseProcessor implements LocationServiceResponseProcessorInterface
{
    /**
     * @param HiddenString            $apiKey
     * @param bool                    $sandbox
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface  $streamFactory
     */
    public function __construct(
        HiddenString            $apiKey,
        bool                    $sandbox,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface  $streamFactory,
    ) {
        parent::__construct(
            apiKey: $apiKey,
            sandbox: $sandbox,
            requestFactory: $requestFactory,
            streamFactory: $streamFactory,
        );

        $this->namespaces = array_merge($this->namespaces, [
            SoapNamespace::Services->value => LocationService::SERVICES_NAMESPACE,
            SoapNamespace::Domain->value   => LocationService::DOMAIN_NAMESPACE,
        ]);
    }

    /**
     * Process GetNearestLocations Response SOAP.
     *
     * @param mixed $response
     *
     * @return GetNearestLocationsResponse
     * @throws CifDownException
     * @throws CifException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws LibXMLException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @deprecated 2.0.0
     */
    public function processGetNearestLocationsResponse(mixed $response): GetNearestLocationsResponse
    {
        $responseContent = static::getResponseText(response: $response);
        $this->validateResponse(response: $responseContent);
        /** @noinspection PhpUnhandledExceptionInspection */
        $xml = new SimpleXMLElement(data: $responseContent);
        $this->registerNamespaces(element: $xml);

        $reader = new Reader();
        $reader->xml(source: static::getResponseText(response: $response));
        $array = array_values(array: $reader->parse()['value'][0]['value']);
        foreach ($array[0]['value'][0]['value'] as &$responseLocation) {
            foreach ($responseLocation['value'] as &$item) {
                if (false !== strpos(haystack: $item['name'], needle: 'DeliveryOptions')) {
                    $newDeliveryOptions = [];
                    foreach ($item['value'] as $option) {
                        $newDeliveryOptions[] = $option['value'];
                    }

                    $item['value'] = $newDeliveryOptions;
                } elseif (false !== strpos(haystack: $item['name'], needle: 'OpeningHours')) {
                    foreach ($item['value'] as &$openingHour) {
                        $openingHour['value'] = $openingHour['value'][0]['value'];
                    }
                }
            }
        }
        $array = $array[0];

        /** @var GetNearestLocationsResponse $object */
        $object = AbstractEntity::xmlDeserialize(xml: $array);
        $this->setService(object: $object);

        return $object;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return GetLocationsInAreaResponse
     * @throws CifDownException
     * @throws CifException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws LibXMLException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @deprecated 2.0.0
     */
    public function processGetLocationsInAreaResponse(ResponseInterface $response): GetLocationsInAreaResponse
    {
        $this->validateResponse(response: $response);
        $responseContent = static::getResponseText(response: $response);
        /** @noinspection PhpUnhandledExceptionInspection */
        $xml = new SimpleXMLElement(data: $responseContent);
        $this->registerNamespaces(element: $xml);

        $reader = new Reader();
        $reader->xml(source: static::getResponseText(response: $response));
        $array = array_values(array: $reader->parse()['value'][0]['value']);
        foreach ($array[0]['value'][0]['value'] as &$responseLocation) {
            foreach ($responseLocation['value'] as &$item) {
                if (str_contains(haystack: $item['name'], needle: 'DeliveryOptions')) {
                    $newDeliveryOptions = [];
                    foreach ($item['value'] as $option) {
                        $newDeliveryOptions[] = $option['value'];
                    }

                    $item['value'] = $newDeliveryOptions;
                } elseif (str_contains(haystack: $item['name'], needle: 'OpeningHours')) {
                    foreach ($item['value'] as &$openingHour) {
                        $openingHour['value'] = $openingHour['value'][0]['value'];
                    }
                }
            }
        }
        $array = $array[0];

        /** @var GetLocationsInAreaResponse $object */
        $object = AbstractEntity::xmlDeserialize(xml: $array);
        $this->setService(object: $object);

        return $object;
    }

    /**
     * Process GetLocation Response SOAP.
     *
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws LibXMLException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @throws EntityNotFoundException
     * @deprecated 2.0.0
     */
    public function processGetLocationResponse(ResponseInterface $response): GetLocationsInAreaResponse
    {
        $this->validateResponse(response: $response);
        $responseContent = static::getResponseText(response: $response);
        /** @noinspection PhpUnhandledExceptionInspection */
        $xml = new SimpleXMLElement(data: $responseContent);
        $this->registerNamespaces(element: $xml);

        $reader = new Reader();
        $reader->xml(source: static::getResponseText(response: $response));
        $array = array_values(array: $reader->parse()['value'][0]['value']);
        $array = $array[0];

        /** @var GetLocationsInAreaResponse $object */
        $object = AbstractEntity::xmlDeserialize(xml: $array);
        $this->setService(object: $object);

        return $object;
    }
}
