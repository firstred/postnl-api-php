<?php
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

namespace Firstred\PostNL\Service;

use DateTimeImmutable;
use Exception;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Request\GenerateLabel;
use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Entity\SOAP\Security;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use JetBrains\PhpStorm\Deprecated;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Sabre\Xml\LibXMLException;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use SimpleXMLElement;
use function http_build_query;
use function in_array;
use function json_encode;
use function str_replace;
use const PHP_QUERY_RFC3986;

/**
 * Class LabellingService.
 *
 * @method GenerateLabelResponse   generateLabel(GenerateLabel $generateLabel, bool $confirm)
 * @method RequestInterface        buildGenerateLabelRequest(GenerateLabel $generateLabel, bool $confirm)
 * @method GenerateLabelResponse   processGenerateLabelResponse(mixed $response)
 * @method GenerateLabelResponse[] generateLabels(GenerateLabel[] $generateLabel, bool $confirm)
 *
 * @since 1.0.0
 * @internal
 */
class LabellingService extends AbstractService implements LabellingServiceInterface
{
    // API Version
    /** @internal */
    const VERSION = '2.2';

    // Endpoints
    /** @internal */
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_2/label';
    /** @internal */
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_2/label';

    // SOAP API
    /** @internal */
    const SOAP_ACTION = 'http://postnl.nl/cif/services/LabellingWebService/ILabellingWebService/GenerateLabel';
    /** @internal */
    const SOAP_ACTION_NO_CONFIRM = 'http://postnl.nl/cif/services/LabellingWebService/ILabellingWebService/GenerateLabelWithoutConfirm';
    /** @internal */
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/LabellingWebService/';
    /** @internal */
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/LabellingWebService/';

    /**
     * Namespaces uses for the SOAP version of this service.
     *
     * @var array
     * @internal
     */
    public static $namespaces = [
        self::ENVELOPE_NAMESPACE     => 'soap',
        self::OLD_ENVELOPE_NAMESPACE => 'env',
        self::SERVICES_NAMESPACE     => 'services',
        self::DOMAIN_NAMESPACE       => 'domain',
        Security::SECURITY_NAMESPACE => 'wsse',
        self::XML_SCHEMA_NAMESPACE   => 'schema',
        self::COMMON_NAMESPACE       => 'common',
    ];

    /** @internal */
    private static $insuranceProductCodes =  [3534, 3544, 3087, 3094];

    /**
     * Generate a single barcode via REST.
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return GenerateLabelResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `generateLabel` instead
     * @internal
     */
    #[Deprecated]
    public function generateLabelREST(GenerateLabel $generateLabel, $confirm = true)
    {
        $response = $this->postnl->getHttpClient()->doRequest($this->buildGenerateLabelRequestREST($generateLabel, $confirm));
        static::validateRESTResponse($response);

        $object = $this->processGenerateLabelResponseREST($response);
        if ($object instanceof GenerateLabelResponse) {
            return $object;
        }

        throw new ResponseException('Invalid API response', null, null, $response);
    }

    /**
     * Generate multiple labels at once.
     *
     * @param array $generateLabels ['uuid' => [GenerateBarcode, confirm], ...]
     *
     * @return array
     *
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `generateLabels` instead
     * @internal
     */
    #[Deprecated]
    public function generateLabelsREST(array $generateLabels)
    {
        $httpClient = $this->postnl->getHttpClient();

        $responses = [];
        foreach ($generateLabels as $uuid => $generateLabel) {
            $httpClient->addOrUpdateRequest(
                $uuid,
                $this->buildGenerateLabelRequestREST($generateLabel[0], $generateLabel[1])
            );
        }
        $newResponses = $httpClient->doRequests();
        $labels = [];
        foreach ($responses + $newResponses as $uuid => $response) {
            $generateLabelResponse = $this->processGenerateLabelResponseREST($response);
            $labels[$uuid] = $generateLabelResponse;
        }

        return $labels;
    }

    /**
     * Generate a single label via SOAP.
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return GenerateLabelResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `generateLabels` instead
     * @internal
     */
    #[Deprecated]
    public function generateLabelSOAP(GenerateLabel $generateLabel, $confirm = true)
    {
        $response = $this->postnl->getHttpClient()->doRequest($this->buildGenerateLabelRequestSOAP($generateLabel, $confirm));

        return static::processGenerateLabelResponseSOAP($response);
    }

    /**
     * Generate multiple labels at once via SOAP.
     *
     * @param array $generateLabels ['uuid' => [GenerateBarcode, confirm], ...]
     *
     * @return array
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `generateLabels` instead
     * @internal
     */
    #[Deprecated]
    public function generateLabelsSOAP(array $generateLabels)
    {
        $httpClient = $this->postnl->getHttpClient();

        $responses = [];
        foreach ($generateLabels as $uuid => $generateLabel) {
            $httpClient->addOrUpdateRequest(
                $uuid,
                $this->buildGenerateLabelRequestSOAP($generateLabel[0], $generateLabel[1])
            );
        }

        $newResponses = $httpClient->doRequests();
        $generateLabelResponses = [];
        foreach ($responses + $newResponses as $uuid => $response) {
            $generateLabelResponse = $this->processGenerateLabelResponseSOAP($response);
            $generateLabelResponses[$uuid] = $generateLabelResponse;
        }

        return $generateLabelResponses;
    }

    /**
     * Build the GenerateLabel request for the REST API.
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function buildGenerateLabelRequestREST(GenerateLabel $generateLabel, $confirm = true)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($generateLabel);
        $endpoint = $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT;
        foreach ($generateLabel->getShipments() as $shipment) {
            if (in_array($shipment->getProductCodeDelivery(), static::$insuranceProductCodes)) {
                // Insurance behaves a bit strange w/ v2.2, falling back on v2.1
                $endpoint = str_replace('v2_2', 'v2_1', $endpoint);
            }
        }

        return $this->postnl->getRequestFactory()->createRequest(
            'POST',
            $endpoint.'?'.http_build_query([
                'confirm' => ($confirm ? 'true' : 'false'),
            ], '', '&', PHP_QUERY_RFC3986))
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($this->postnl->getStreamFactory()->createStream(json_encode($generateLabel)));
    }

    /**
     * Process the GenerateLabel REST Response.
     *
     * @param ResponseInterface $response
     *
     * @return GenerateLabelResponse|null
     *
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @deprecatd 1.4.0
     * @internal
     */
    #[Deprecated]
    public function processGenerateLabelResponseREST($response)
    {
        $body = json_decode(static::getResponseText($response));
        if (isset($body->ResponseShipments)) {
            /** @var GenerateLabelResponse $object */
            $object = GenerateLabelResponse::jsonDeserialize((object) ['GenerateLabelResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Build the GenerateLabel request for the SOAP API.
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function buildGenerateLabelRequestSOAP(GenerateLabel $generateLabel, $confirm = true)
    {
        $soapAction = $confirm ? static::SOAP_ACTION : static::SOAP_ACTION_NO_CONFIRM;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $xmlService->classMap[DateTimeImmutable::class] = [__CLASS__, 'defaultDateFormat'];

        $security = new Security($this->postnl->getToken());

        $this->setService($security);
        $this->setService($generateLabel);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GenerateLabel' => $generateLabel,
                ],
            ]
        );

        $endpoint = $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT;

        foreach ($generateLabel->getShipments() as $shipment) {
            if (in_array($shipment->getProductCodeDelivery(), self::$insuranceProductCodes)) {
                // Insurance behaves a bit strange w/ v2.2, falling back on v2.1
                $endpoint = str_replace('v2_2', 'v2_1', $endpoint);
            }
        }

        return $this->postnl->getRequestFactory()->createRequest('POST', $endpoint)
            ->withHeader('SOAPAction', "\"$soapAction\"")
            ->withHeader('Accept', 'text/xml')
            ->withHeader('Content-Type', 'text/xml;charset=UTF-8')
            ->withBody($this->postnl->getStreamFactory()->createStream($request));
    }

    /**
     * @param ResponseInterface $response
     *
     * @return GenerateLabelResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function processGenerateLabelResponseSOAP(ResponseInterface $response)
    {
        try {
            $xml = new SimpleXMLElement(static::getResponseText($response));
        } catch (HttpClientException $e) {
            throw $e;
        } catch (ResponseException $e) {
            throw new ResponseException($e->getMessage(), 0, $e, $response);
        } catch (Exception $e) {
            throw new ResponseException('Could not parse response', 0, $e, $response);
        }

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        try {
            $array = array_values($reader->parse()['value'][0]['value']);
        } catch (LibXMLException $e) {
            throw new ResponseException('Could not parse reponse', 0, $e, $response);
        }
        $array = $array[0];

        /** @var GenerateLabelResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }
}
