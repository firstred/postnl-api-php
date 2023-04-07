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

namespace Firstred\PostNL\Service\ResponseProcessor\Rest;

use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\ResponseProcessor\ConfirmingServiceResponseProcessorInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @since 2.0.0
 *
 * @internal
 */
class ConfirmingServiceRestResponseProcessor extends AbstractRestResponseProcessor implements ConfirmingServiceResponseProcessorInterface
{
    /**
     * Proces Confirm REST Response.
     *
     * @param ResponseInterface $response
     *
     * @return ConfirmingResponseShipment[]
     *
     * @throws CifDownException
     * @throws CifException
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws ResponseException
     * @throws InvalidConfigurationException
     * @throws \ReflectionException
     *
     * @since 2.0.0
     */
    public function processConfirmResponse(ResponseInterface $response): array
    {
        $this->validateResponse(response: $response);
        $body = json_decode(json: static::getResponseText(response: $response));

        if (!is_array(value: $body->ResponseShipments)) {
            $body->ResponseShipments = [$body->ResponseShipments];
        }

        $objects = [];
        foreach ($body->ResponseShipments as $responseShipment) {
            $object = ConfirmingResponseShipment::jsonDeserialize(json: (object) ['ConfirmingResponseShipment' => $responseShipment]);
            $objects[] = $object;
        }

        if (!empty($objects)) {
            return $objects;
        }

        throw new ResponseException(message: 'Invalid response', response: $response);
    }
}
