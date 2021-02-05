<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Service;

use Firstred\PostNL\DTO\Request\CalculateDeliveryDateRequestDTO;
use Firstred\PostNL\DTO\Request\CalculateShippingDateRequestDTO;
use Firstred\PostNL\DTO\Response\CalculateDeliveryDateResponseDTO;
use Firstred\PostNL\DTO\Response\CalculateShippingDateResponseDTO;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Exception\ApiClientException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\InvalidApiKeyException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotAvailableException;
use Firstred\PostNL\Exception\ParseError;
use Firstred\PostNL\Gateway\DeliveryDateServiceGatewayInterface;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use JetBrains\PhpStorm\Pure;

/**
 * Class DeliveryDateService.
 */
class DeliveryDateService extends ServiceBase implements DeliveryDateServiceInterface
{
    use ServiceLoggerTrait;

    #[Pure]
    /**
     * DeliveryDateService constructor.
     *
     * @param Customer                            $customer
     * @param string                              $apiKey
     * @param bool                                $sandbox
     * @param DeliveryDateServiceGatewayInterface $gateway
     */
    public function __construct(
        protected Customer $customer,
        protected string $apiKey,
        protected bool $sandbox,
        protected DeliveryDateServiceGatewayInterface $gateway,
    ) {
        parent::__construct(customer: $customer, apiKey: $apiKey, sandbox: $sandbox);
    }

    /**
     * @param CalculateDeliveryDateRequestDTO $calculateDeliveryDateRequestDTO
     *
     * @return CalculateDeliveryDateResponseDTO
     *
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function calculateDeliveryDate(
        CalculateDeliveryDateRequestDTO $calculateDeliveryDateRequestDTO,
    ): CalculateDeliveryDateResponseDTO {
        return $this->getGateway()->doCalculateDeliveryDateRequest(calculateDeliveryDateRequestDTO: $calculateDeliveryDateRequestDTO);
    }

    /**
     * @param CalculateShippingDateRequestDTO $getShippingDateRequestDTO
     *
     * @return CalculateShippingDateResponseDTO
     *
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function getShippingDate(
        CalculateShippingDateRequestDTO $getShippingDateRequestDTO,
    ): CalculateShippingDateResponseDTO {
        return $this->getGateway()->doCalculateShippingDateRequest(calculateShippingDateRequestDTO: $getShippingDateRequestDTO);
    }

    /**
     * @return DeliveryDateServiceGatewayInterface
     */
    public function getGateway(): DeliveryDateServiceGatewayInterface
    {
        return $this->gateway;
    }

    /**
     * @param DeliveryDateServiceGatewayInterface $gateway
     *
     * @return static
     */
    public function setGateway(DeliveryDateServiceGatewayInterface $gateway): static
    {
        $this->gateway = $gateway;

        return $this;
    }

    /**
     * @return HttpClientInterface
     */
    public function getHttpClient(): HttpClientInterface
    {
        return $this->getGateway()->getHttpClient();
    }

    /**
     * @param HttpClientInterface $httpClient
     *
     * @return static
     */
    public function setHttpClient(HttpClientInterface $httpClient): static
    {
        $this->getGateway()->setHttpClient(httpClient: $httpClient);

        return $this;
    }
}
