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

namespace Firstred\PostNL\ResponseProcessor;

use ArgumentCountError;
use function class_implements;
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\Exception\ApiClientException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\ApiServerException;
use Firstred\PostNL\Exception\InvalidApiKeyException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotAvailableException;
use Firstred\PostNL\Exception\ParseError;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use Firstred\PostNL\Service\DeliveryDateServiceInterface;
use Firstred\PostNL\Service\LocationServiceInterface;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use function json_decode;
use Psr\Http\Message\ResponseInterface;
use TypeError;

/**
 * Class ResponseProcessorBase.
 */
abstract class ResponseProcessorBase implements ResponseProcessorInterface
{
    /**
     * @param ResponseInterface $response
     *
     * @throws ApiClientException
     * @throws ApiServerException
     * @throws InvalidApiKeyException
     * @throws NotAvailableException
     */
    protected function checkResponse(ResponseInterface $response): void
    {
        $statusCode = $response->getStatusCode();
        $faultString = static::getFaultString(responseBody: (string) $response->getBody());
        $faultCode = static::getFaultString(responseBody: (string) $response->getBody());

        if ($statusCode > 400 && $statusCode < 500) {
            if (403 === $statusCode) {
                if ('oauth.v2.InvalidApiKey' === $faultCode) {
                    throw new InvalidApiKeyException(message: $faultString, code: $faultCode);
                }
                throw new NotAvailableException(message: $faultString, code: $faultCode);
            }
            throw new ApiClientException(message: $faultString, code: $faultCode, response: $response);
        } elseif (400 === $statusCode) {
            if ($faultString) {
                throw new ApiClientException(message: $faultString, code: $faultCode, response: $response);
            }
            throw new ApiClientException(
                message: static::getErrorMessage(responseBody: (string) $response->getBody()),
                code: static::getErrorNumber(responseBody: (string) $response->getBody()),
            );
        } elseif ($statusCode >= 500 || $statusCode < 200) {
            throw new ApiServerException(message: $faultString, code: $faultCode, response: $response);
        }
    }

    /**
     * @param string             $className
     * @param ResponseInterface  $response
     * @psalm-param class-string $className
     *
     * @return SerializableObject
     *
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws NotAvailableException
     * @throws ParseError
     */
    protected function fullyProcessResponse(string $className, ResponseInterface $response): SerializableObject
    {
        $this->checkResponse(response: $response);

        return $this->deserialize(
            className: $className,
            response: $response,
        );
    }

    /**
     * @param string             $className
     * @param ResponseInterface  $response
     * @psalm-param class-string $className
     *
     * @return SerializableObject
     *
     * @throws InvalidArgumentException
     * @throws ParseError
     */
    protected function deserialize(string $className, ResponseInterface $response): SerializableObject
    {
        $json = @json_decode(json: (string) $response->getBody(), associative: true);

        $interfaces = class_implements(object_or_class: $this);
        $json['service'] = match (end(array: $interfaces)) {
            BarcodeServiceResponseProcessorInterface::class        => BarcodeServiceInterface::class,
//            ConfirmingServiceResponseProcessorInterface::class     => ConfirmingServiceInterface::class,
            DeliveryDateServiceResponseProcessorInterface::class   => DeliveryDateServiceInterface::class,
//            LabellingServiceResponseProcessorInterface::class      => LabellingServiceInterface::class,
            LocationServiceResponseProcessorInterface::class       => LocationServiceInterface::class,
//            ShippingServiceResponseProcessorInterface::class       => ShippingServiceInterface::class,
//            ShippingStatusServiceResponseProcessorInterface::class => ShippingStatusServiceInterface::class,
            TimeframeServiceResponseProcessorInterface::class      => TimeframeServiceInterface::class,
            default                                                => throw new ParseError(message: "Unable to find service for `$className` object"),
        };
        $json['propType'] = ResponseProp::class;

        try {
            /** @var SerializableObject $responseDto */
            $responseDto = new $className(...$json);
            if (!$responseDto->isValid()) {
                throw new ParseError(
                    message: "Unable to deserialize `$className` object",
                    response: $response,
                );
            }

            return $responseDto;
        } catch (TypeError | ArgumentCountError $e) {
            throw new ParseError(
                message: "Unable to deserialize `$className` object",
                previous: $e,
                response: $response,
            );
        }
    }

    /**
     * @param string $responseBody
     *
     * @return string
     */
    protected static function getFaultString(string $responseBody): string
    {
        return @json_decode(json: $responseBody, associative: true)['fault']['faultString'] ?? '';
    }

    /**
     * @param string $responseBody
     *
     * @return string
     */
    protected static function getFaultCode(string $responseBody): string
    {
        return @json_decode(json: $responseBody, associative: true)['fault']['detail']['errorCode'] ?? '';
    }

    /**
     * @param string $responseBody
     *
     * @return string
     */
    protected static function getErrorMessage(string $responseBody): string
    {
        $json = @json_decode(json: $responseBody, associative: true);

        return (string) ($json['ErrorMsg'] ?? $json[0]['ErrorMsg'] ?? '');
    }

    /**
     * @param string $responseBody
     *
     * @return int
     */
    protected static function getErrorNumber(string $responseBody): int
    {
        $json = @json_decode(json: $responseBody, associative: true);

        return (int) ($json['ErrorNumber'] ?? $json[0]['ErrorNumber'] ?? 0);
    }
}
