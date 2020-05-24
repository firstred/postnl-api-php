<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Method;

use Firstred\PostNL\Entity\CustomerInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class AbstractMethod.
 */
abstract class AbstractMethod
{
    /** @var RequestFactoryInterface */
    protected $requestFactory;

    /** @var SerializerInterface */
    protected $serializer;

    /** @var CustomerInterface */
    protected $customer;

    /** @var string */
    protected $endpoint;

    /** @var string */
    protected $apiKey;

    public function __construct(RequestFactoryInterface $requestFactory, SerializerInterface $serializer)
    {
        $this->requestFactory = $requestFactory;
        $this->serializer = $serializer;
    }

    public function setRequestFactory(RequestFactoryInterface $requestFactory)
    {
        $this->requestFactory = $requestFactory;
    }

    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;
    }

    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }
}
