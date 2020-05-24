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

namespace Firstred\PostNL\Factory;

use Firstred\PostNL\Http\HttpClient;
use Firstred\PostNL\Http\HttpClientInterface;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\Plugin\RetryPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\HttpAsyncClientDiscovery;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttplugClient;

/**
 * Class HttpClientFactory.
 */
final class HttpClientFactory implements HttpClientFactoryInterface
{
    /** @var HttplugClient */
    private $symfonyHttplugClient = null;

    /** @var LoggerInterface */
    private $logger = null;

    /** @var int */
    private $maxRetries = 3;

    /** @var int */
    private $concurrency = 5;

    public function __construct(LoggerInterface $logger, HttplugClient $symfonyHttplugClient = null)
    {
        $this->logger = $logger;
        $this->symfonyHttplugClient = $symfonyHttplugClient;
    }

    public function setMaxRetries(int $maxRetries = 3): HttpClientFactoryInterface
    {
        $this->maxRetries = $maxRetries;

        return $this;
    }

    public function setConcurrency(int $concurrency = 5): HttpClientFactoryInterface
    {
        $this->concurrency = $concurrency;

        return $this;
    }

    public function create(): HttpClientInterface
    {
        $httpClient = new HttpClient();
        $plugins = [new RetryPlugin(['retries' => $this->maxRetries])];
        if ($this->logger) {
            $plugins[] = new LoggerPlugin($this->logger);
        }

        // Temporary extra check, due to auto-discovery failing atm
        if ($this->symfonyHttplugClient) {
            $pluginClient = new PluginClient($this->symfonyHttplugClient, $plugins);
        } else {
            $pluginClient = new PluginClient(HttpAsyncClientDiscovery::find(), $plugins);
        }
        $httpClient->setConcurrency($this->concurrency);
        $httpClient->setHttpAsyncClient($pluginClient);

        return $httpClient;
    }
}
