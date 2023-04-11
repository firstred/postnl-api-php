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

namespace Firstred\PostNL\Service\RequestBuilder\Rest;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Request\GenerateBarcode;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use Firstred\PostNL\Service\RequestBuilder\BarcodeServiceRequestBuilderInterface;
use Psr\Http\Message\RequestInterface;
use const PHP_QUERY_RFC3986;

/**
 * @since 2.0.0
 *
 * @internal
 */
class BarcodeServiceRestRequestBuilder extends AbstractRestRequestBuilder implements BarcodeServiceRequestBuilderInterface
{
    // Endpoints
    private const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v1_1/barcode';
    private const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v1_1/barcode';

    /**
     * Build the 'generate barcode' HTTP request.
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     *
     * @since 2.0.0
     */
    public function buildGenerateBarcodeRequest(GenerateBarcode $generateBarcode): RequestInterface
    {
        $this->setService(entity: $generateBarcode);

        return $this->getRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).'?'.http_build_query(data: [
                'CustomerCode'   => $generateBarcode->getCustomer()->getCustomerCode(),
                'CustomerNumber' => $generateBarcode->getCustomer()->getCustomerNumber(),
                'Type'           => $generateBarcode->getBarcode()->getType(),
                'Serie'          => $generateBarcode->getBarcode()->getSerie(),
                'Range'          => $generateBarcode->getBarcode()->getRange(),
            ], arg_separator: '&', encoding_type: PHP_QUERY_RFC3986)
        )
            ->withHeader('Accept', value: 'application/json')
            ->withHeader('apikey', value: $this->apiKey->getString());
    }

    /**
     * Set this service on the given entity.
     *
     * This lets the entity know for which service it should serialize.
     *
     * @param AbstractEntity $entity
     *
     * @return void
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     *
     * @since 2.0.0
     */
    public function setService(AbstractEntity $entity): void
    {
        $entity->setCurrentService(currentService: BarcodeServiceInterface::class);

        parent::setService(entity: $entity);
    }
}
