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

namespace Firstred\PostNL\Service;

use Firstred\PostNL\Entity\Request\GenerateShipping;
use Firstred\PostNL\Entity\Response\GenerateShippingResponse;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\ResponseException;
use Psr\Cache\InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;

/**
 * Class ShippingService.
 *
 * @method GenerateShippingResponse generateShipping(GenerateShipping $generateShipping, bool $confirm)
 * @method RequestInterface         buildGenerateShippingRequest(GenerateShipping $generateShipping, bool $confirm)
 * @method GenerateShippingResponse processGenerateShippingResponse(mixed $response)
 *
 * @since 1.2.0
 */
interface ShippingServiceInterface extends ServiceInterface
{
    /**
     * Generate a single Shipping vai REST.
     *
     * @param GenerateShipping $generateShipping
     * @param bool             $confirm
     *
     * @return GenerateShippingResponse|null
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ReflectionException
     * @throws ResponseException
     * @throws InvalidArgumentException
     * @throws HttpClientException
     *
     * @since 1.2.0
     */
    public function generateShippingREST(GenerateShipping $generateShipping, $confirm = true);

    /**
     * @param GenerateShipping $generateShipping
     * @param bool             $confirm
     *
     * @return RequestInterface
     *
     * @throws ReflectionException
     *
     * @since 1.2.0
     */
    public function buildGenerateShippingRequestREST(GenerateShipping $generateShipping, $confirm = true);

    /**
     * Process the GenerateShipping REST Response.
     *
     * @param ResponseInterface $response
     *
     * @return GenerateShippingResponse|null
     *
     * @throws ReflectionException
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 1.2.0
     */
    public function processGenerateShippingResponseREST($response);
}
