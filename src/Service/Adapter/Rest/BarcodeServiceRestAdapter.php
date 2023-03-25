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

namespace Firstred\PostNL\Service\Adapter\Rest;

use Firstred\PostNL\Entity\Request\GenerateBarcode;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\Adapter\BarcodeServiceAdapterInterface;
use Firstred\PostNL\Util\Util;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use const PHP_QUERY_RFC3986;

/**
 * @since 2.0.0
 */
class BarcodeServiceRestAdapter extends AbstractRestAdapter implements BarcodeServiceAdapterInterface
{
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/${VERSION}/barcode';
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/${VERSION}/barcode';

    /**
     * Build the `generateBarcode` HTTP request for the REST API.
     *
     * @since 2.0.0
     */
    public function buildGenerateBarcodeRequest(GenerateBarcode $generateBarcode): RequestInterface
    {
        return $this->getRequestFactory()->createRequest(
            method: 'GET',
            uri: Util::versionStringToURLString(
                version: $this->getVersion(),
                url: $this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT,
            ).'?'.http_build_query(data: [
                'CustomerCode'   => $generateBarcode->getCustomer()->getCustomerCode(),
                'CustomerNumber' => $generateBarcode->getCustomer()->getCustomerNumber(),
                'Type'           => $generateBarcode->getBarcode()->getType(),
                'Serie'          => $generateBarcode->getBarcode()->getSerie(),
                'Range'          => $generateBarcode->getBarcode()->getRange(),
            ], arg_separator: '&', encoding_type: PHP_QUERY_RFC3986)
        )
            ->withHeader('Accept', value: 'application/json')
            ->withHeader('apikey', value: $this->getApiKey()->getString());
    }

    /**
     * Process GenerateBarcode REST response.
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws InvalidConfigurationException
     *
     * @since 2.0.0
     */
    public function processGenerateBarcodeResponse(ResponseInterface $response): string
    {
        $responseContent = $this->getResponseText(response: $response);
        $this->validateResponse(responseContent: $responseContent);

        $json = json_decode(json: $responseContent);

        if (!isset($json->Barcode)) {
            throw new ResponseException(message: 'Invalid API Response', response: $response);
        }

        return $json->Barcode;
    }
}
