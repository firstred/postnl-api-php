<?php
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

namespace Firstred\PostNL\Service\ResponseProcessor;

use DateTimeImmutable;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\ResponseException;
use GuzzleHttp\Psr7\Response;
use ParagonIE\HiddenString\HiddenString;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Sabre\Xml\Writer;

/**
 * @since 2.0.0
 * @internal
 */
abstract class AbstractResponseProcessor
{
    /**
     * @param HiddenString            $apiKey
     * @param bool                    $sandbox
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface  $streamFactory
     * @param string                  $version
     */
    public function __construct(
        private HiddenString            $apiKey,
        private bool                    $sandbox,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface  $streamFactory,
        private string                  $version,
    ) {
    }

    /**
     * Get the response.
     *
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 2.0.0
     */
    public static function getResponseText(array|ResponseInterface|HttpClientException $response): string
    {
        // Guzzle returned promises
        if (is_array(value: $response)) {
            if (isset($response['reason'])) {
                $response = $response['reason'];
            } elseif (isset($response['value'])) {
                $response = $response['value'];
            }
        }

        if ($response instanceof ResponseInterface) {
            return (string) $response->getBody();
        } elseif (is_a(object_or_class: $response, class: HttpClientException::class)) {
            $exception = $response;
            if (method_exists(object_or_class: $response, method: 'getResponse')) {
                $response = $response->getResponse();
            }
            if (!$response || $response instanceof $exception) {
                throw $exception;
            }

            /* @var Response $response */
            return (string) $response->getBody();
        } else {
            throw new ResponseException(message: 'Unknown response type');
        }
    }

    /**
     * Write default date format in XML
     *
     * @since 2.0.0
     */
    public static function defaultDateFormat(Writer $writer, DateTimeImmutable $value): void
    {
        $writer->write(value: $value->format(format: 'd-m-Y H:i:s'));
    }

    /**
     * @since 2.0.0
     */
    public function getApiKey(): HiddenString
    {
        return $this->apiKey;
    }

    /**
     * @since 2.0.0
     */
    public function setApiKey(HiddenString $apiKey): AbstractResponseProcessor
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @since 2.0.0
     */
    public function isSandbox(): bool
    {
        return $this->sandbox;
    }

    /**
     * @since 2.0.0
     */
    public function setSandbox(bool $sandbox): AbstractResponseProcessor
    {
        $this->sandbox = $sandbox;

        return $this;
    }

    /**
     * @since 2.0.0
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @since 2.0.0
     */
    public function setVersion(string $version): static
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @since 2.0.0
     */
    public function getRequestFactory(): RequestFactoryInterface
    {
        return $this->requestFactory;
    }

    /**
     * @since 2.0.0
     */
    public function setRequestFactory(RequestFactoryInterface $requestFactory): AbstractResponseProcessor
    {
        $this->requestFactory = $requestFactory;

        return $this;
    }

    /**
     * @since 2.0.0
     */
    public function getStreamFactory(): StreamFactoryInterface
    {
        return $this->streamFactory;
    }

    /**
     * @since 2.0.0
     */
    public function setStreamFactory(StreamFactoryInterface $streamFactory): AbstractResponseProcessor
    {
        $this->streamFactory = $streamFactory;

        return $this;
    }
}