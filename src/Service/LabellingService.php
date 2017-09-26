<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
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
 * @author    Michael Dekker <michael@thirtybees.com>
 * @copyright 2017 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Service;

use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\GenerateLabelResponse;
use ThirtyBees\PostNL\Entity\Request\GenerateLabel;
use ThirtyBees\PostNL\Entity\SOAP\Security;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\PostNL;

/**
 * Class LabellingService
 *
 * @package ThirtyBees\PostNL\Service
 *
 * @method GenerateLabelResponse   generateLabel(GenerateLabel $generateLabel, bool $confirm)
 * @method GenerateLabelResponse[] generateLabels(GenerateLabel[] $generateLabel, bool $confirm)
 */
class LabellingService extends AbstractService
{
    // API Version
    const VERSION = '2.1';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_1/label';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_1/label';
    const LEGACY_SANDBOX_ENDPOINT = 'https://testservice.postnl.com/CIF_SB/LabellingWebService/2_1/LabellingWebService.svc';
    const LEGACY_LIVE_ENDPOINT = 'https://service.postnl.com/CIF/LabellingWebService/2_1/LabellingWebService.svc';

    // SOAP API
    const SOAP_ACTION = 'http://postnl.nl/cif/services/LabellingWebService/ILabellingWebService/GenerateLabel';
    const SOAP_ACTION_NO_CONFIRM = 'http://postnl.nl/cif/services/LabellingWebService/ILabellingWebService/GenerateLabelWithoutConfirm';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/LabellingWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/LabellingWebService/';

    /**
     * Namespaces uses for the SOAP version of this service
     *
     * @var array $namespaces
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

    /**
     * Generate a single barcode via REST
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return GenerateLabelResponse
     *
     * @throws ApiException
     */
    public function generateLabelREST(GenerateLabel $generateLabel, $confirm = false)
    {
        $client = $this->postnl->getHttpClient();
        $result = call_user_func_array([$client, 'request'], array_slice($this->buildGenerateLabelRESTRequest($generateLabel, $confirm), 1));

        $label = json_decode($result[0], true);
        static::validateRESTResponse($label);
        if (isset($label['ResponseShipments'])) {
            return AbstractEntity::jsonDeserialize(['GenerateLabelResponse' => $label]);
        }

        throw new ApiException('Unable to generate label');
    }

    /**
     * Generate multiple labels at once
     *
     * @param array $generateLabels ['uuid' => [GenerateBarcode, confirm], ...]
     *
     * @return array
     */
    public function generateLabelsREST(array $generateLabels)
    {
        $httpClient = $this->postnl->getHttpClient();

        foreach ($generateLabels as $generateLabel) {
            call_user_func_array(
                [$httpClient, 'addRequest'],
                $this->buildGenerateLabelRESTRequest($generateLabel[0], $generateLabel[1])
            );
        }

        $labels = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            $label = json_decode($response['body'], true);
            try {
                static::validateRESTResponse($label);
                if (isset($label['ResponseShipments'])) {
                    $barcode = AbstractEntity::jsonDeserialize(['GenerateLabelResponse' => $label]);
                } else {
                    throw new ApiException('Unable to generate label');
                }
            } catch (\Exception $e) {
                $barcode = $e;
            }

            $labels[$uuid] = $barcode;
        }

        return $labels;
    }

    /**
     * Generate a single label via SOAP
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return GenerateLabelResponse
     */
    public function generateLabelSOAP(GenerateLabel $generateLabel, $confirm = false)
    {
        $result =  call_user_func_array(
            [$this->postnl->getHttpClient(), 'request'],
            array_slice($this->buildGenerateLabelSOAPRequest($generateLabel, $confirm), 1)
        );

        $xml = simplexml_load_string($result[0]);

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml($result[0]);
        $array = array_values($reader->parse()['value'][0]['value']);
        $array = $array[0];

        return AbstractEntity::xmlDeserialize($array);
    }

    /**
     * Generate multiple labels at once
     *
     * @param array $generateLabels ['uuid' => [GenerateBarcode, confirm], ...]
     *
     * @return array
     */
    public function generateLabelsSOAP(array $generateLabels)
    {
        $httpClient = $this->postnl->getHttpClient();

        foreach ($generateLabels as $generateLabel) {
            call_user_func_array(
                [$httpClient, 'addRequest'],
                $this->buildGenerateLabelSOAPRequest($generateLabel[0], $generateLabel[1])
            );
        }

        $generateLabelResponses = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            $xml = simplexml_load_string($response['body']);
            if (!$xml instanceof \SimpleXMLElement) {
                $generateLabelResponse = new ApiException('Invalid API response');
            } else {
                try {
                    static::registerNamespaces($xml);
                    static::validateSOAPResponse($xml);

                    $reader = new Reader();
                    $reader->xml($response['body']);
                    $array = array_values($reader->parse()['value'][0]['value']);
                    $array = $array[0];

                    $generateLabelResponse = AbstractEntity::xmlDeserialize($array);
                } catch (\Exception $e) {
                    $generateLabelResponse = $e;
                }
            }

            $generateLabelResponses[$uuid] = $generateLabelResponse;
        }

        return $generateLabelResponses;
    }

    /**
     * Build the GenerateLabel request for the REST API
     *
     * @param GenerateLabel $generateLabel
     * @param               $confirm
     *
     * @return array
     */
    protected function buildGenerateLabelRESTRequest(GenerateLabel $generateLabel, $confirm)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($generateLabel);

        return [
            $generateLabel->getId(),
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT,
            [
                "apikey: $apiKey",
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            [
                'confirm' => $confirm,
            ],
            json_encode($generateLabel, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES),
        ];
    }

    /**
     * Build the GenerateLabel request for the SOAP API
     *
     * @param GenerateLabel $generateLabel
     * @param               $confirm
     *
     * @return array
     */
    protected function buildGenerateLabelSOAPRequest(GenerateLabel $generateLabel, $confirm)
    {
        $soapAction = $confirm ? static::SOAP_ACTION : static::SOAP_ACTION_NO_CONFIRM;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
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

        $endpoint = $this->postnl->getSandbox()
            ? ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_SANDBOX_ENDPOINT : static::SANDBOX_ENDPOINT)
            : ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_LIVE_ENDPOINT : static::LIVE_ENDPOINT);

        return [
            $generateLabel->getId(),
            'POST',
            $endpoint,
            [
                "SOAPAction: \"$soapAction\"",
                'Content-Type: text/xml',
                'Accept: text/xml',
            ],
            [],
            $request,
        ];
    }
}
