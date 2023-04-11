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

namespace Firstred\PostNL\Service\RequestBuilder;

use DateTimeInterface;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Request\CompleteStatus;
use Firstred\PostNL\Entity\Request\CurrentStatus;
use Firstred\PostNL\Entity\Request\CurrentStatusByReference;
use Firstred\PostNL\Entity\Request\GetSignature;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Psr\Http\Message\RequestInterface;

/**
 * @since 2.0.0
 *
 * @internal
 */
interface ShippingStatusServiceRequestBuilderInterface
{
    /**
     * Build the 'get current status' HTTP request.
     *
     * This function auto-detects and adjusts the following requests:
     * - CurrentStatus
     * - CurrentStatusByReference
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     * @since 2.0.0
     */
    public function buildCurrentStatusRequest(CurrentStatusByReference|CurrentStatus $currentStatus): RequestInterface;

    /**
     * Build the 'get complete status' HTTP request.
     *
     * This function auto-detects and adjusts the following requests:
     * - CompleteStatus
     * - CompleteStatusByReference
     * - CompleteStatusByPhase
     * - CompleteStatusByStatus
     *
     * @param CompleteStatus $completeStatus
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     *
     * @since 2.0.0
     */
    public function buildCompleteStatusRequest(CompleteStatus $completeStatus): RequestInterface;

    /**
     * Build the 'get signature' HTTP request.
     *
     * @param GetSignature $getSignature
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     *
     * @since 2.0.0
     */
    public function buildGetSignatureRequest(GetSignature $getSignature): RequestInterface;

    /**
     * Build the 'get updated shipments' HTTP request.
     *
     * @param Customer               $customer
     * @param DateTimeInterface|null $dateTimeFrom
     * @param DateTimeInterface|null $dateTimeTo
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     *
     * @since 2.0.0
     */
    public function buildGetUpdatedShipmentsRequest(
        Customer $customer,
        DateTimeInterface $dateTimeFrom = null,
        DateTimeInterface $dateTimeTo = null
    ): RequestInterface;
}
