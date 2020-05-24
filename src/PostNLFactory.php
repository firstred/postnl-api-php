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

namespace Firstred\PostNL;

use function class_exists;
use DI\ContainerBuilder as DIContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use const DIRECTORY_SEPARATOR;
use Firstred\PostNL\Exception\InvalidArgumentException;
use function rtrim;
use function str_replace;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder as SymfonyContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class PostNLFactoryInterface.
 */
class PostNLFactory
{
    /**
     * Get the config folder (without trailing directory separator).
     *
     * @return string
     *
     * @since 2.0.0
     */
    public static function getConfigFolder(): string
    {
        return __DIR__.'/../config';
    }

    /**
     * Create a new PostNL client instance with Symfony's Dependency Injection Component.
     *
     * @param string $tempFolder Production mode
     * @param bool   $production
     *
     * @return PostNL|mixed
     *
     * @throws InvalidArgumentException
     * @throws DependencyException
     * @throws NotFoundException
     *
     * @since 2.0.0
     */
    public static function create(bool $production = true, string $tempFolder = ''): PostNL
    {
        if (class_exists(SymfonyContainerBuilder::class)) {
            $file = ($tempFolder ? rtrim($tempFolder, DIRECTORY_SEPARATOR) : __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tmp').DIRECTORY_SEPARATOR.'PostNLCachedContainer'.str_replace('.', '_', PostNL::VERSION).'.php';
            $containerClass = 'Firstred\\PostNL\\Misc\\CachedContainer';
            $containerConfigCache = new ConfigCache($file, !$production);

            if (!$containerConfigCache->isFresh()) {
                $containerBuilder = new SymfonyContainerBuilder();
                $loader = new XmlFileLoader($containerBuilder, new FileLocator(static::getConfigFolder()));
                $loader->load('services.xml');
                $containerBuilder->compile();

                $dumper = new PhpDumper($containerBuilder);
                $containerConfigCache->write(
                    $dumper->dump([
                        'namespace' => 'Firstred\\PostNL\\Misc',
                        'class'     => 'CachedContainer',
                    ]),
                    $containerBuilder->getResources()
                );
            }

            /** @noinspection PhpIncludeInspection */
            require_once $file;

            $container = new $containerClass();
        } elseif (class_exists(DIContainerBuilder::class)) {
            // Build the dependency injection container
            $containerBuilder = new DIContainerBuilder();
            $containerBuilder->addDefinitions(static::getConfigFolder().'/php-di.config.php');
            if ($production) {
                $containerBuilder->enableCompilation(__DIR__.'/../tmp');
                $containerBuilder->writeProxiesToFile(true, __DIR__.'/../tmp/proxies');
            }
            $container = $containerBuilder->build();
        } else {
            throw new InvalidArgumentException('No supported PSR-11 container builders found');
        }

        // Get a wired and configured instance of the PostNL client via the DI container
        return $container->get(PostNL::class);
    }
}
