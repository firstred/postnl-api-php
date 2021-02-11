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

use Firstred\PostNL\DTO\Request\GetDeliveryInformationRequestDTO;
use Firstred\PostNL\DTO\Response\GetDeliveryInformationResponseDTO;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Gateway\CheckoutServiceGatewayInterface;
use JetBrains\PhpStorm\Pure;

/**
 * Class CheckoutService.
 *
 * @see https://developer.postnl.nl/browse-apis/checkout/checkout-api/
 */
class CheckoutService extends ServiceBase implements CheckoutServiceInterface
{
    use ServiceLoggerTrait;
    use ServiceHttpClientTrait;

    #[Pure]
    /**
     * CheckoutService constructor.
     *
     * @param Customer                        $customer
     * @param string                          $apiKey
     * @param bool                            $sandbox
     * @param CheckoutServiceGatewayInterface $gateway
     */
    public function __construct(
        protected Customer $customer,
        protected string $apiKey,
        protected bool $sandbox,
        protected CheckoutServiceGatewayInterface $gateway,
    ) {
        parent::__construct(customer: $customer, apiKey: $apiKey, sandbox: $sandbox);
    }

    public function getDeliveryInformation(GetDeliveryInformationRequestDTO $getDeliveryInformationRequestDTO): GetDeliveryInformationResponseDTO
    {
        return $this->getGateway()->doGetDeliveryInformationRequest(
            getDeliveryInformationRequestDTO: $getDeliveryInformationRequestDTO,
        );
    }

    /**
     * @return CheckoutServiceGatewayInterface
     */
    public function getGateway(): CheckoutServiceGatewayInterface
    {
        return $this->gateway;
    }

    /**
     * @param CheckoutServiceGatewayInterface $gateway
     *
     * @return static
     */
    public function setGateway(CheckoutServiceGatewayInterface $gateway): static
    {
        $this->gateway = $gateway;

        return $this;
    }
}
