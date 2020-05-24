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

use DI\ContainerBuilder;
use Firstred\PostNL\PostNL;
use Symfony\Component\Dotenv\Dotenv;

// Autoloader
require_once '../vendor/autoload.php';

// Load all environment variables
$dotenv = new Dotenv(true);
if (file_exists('./.env')) {
    $dotenv->load('./.env');
} else {
    $dotenv->load('../.env.example');
}

// Build the dependency injection container
$containerBuilder = new ContainerBuilder();
if (file_exists('./di.config.php')) {
    $containerBuilder->addDefinitions('./di.config.php');
} else {
    $containerBuilder->addDefinitions('../di.config.example.php');
}

$container = $containerBuilder->build();

// Get a wired and configured instance of the PostNL client via the DI container
$postnl = $container->get(PostNL::class);

$barcode = $postnl->generateBarcode('3S');

echo <<<STDOUT
\33[37m=========================================
The generated barcode is: \033[33m${barcode}\033[37m
=========================================

STDOUT;
