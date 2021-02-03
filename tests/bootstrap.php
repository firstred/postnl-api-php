<?php

declare(strict_types=1);

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Psr\Log\LogLevel;
use wappr\Logger;

require __DIR__.'/../vendor/autoload.php';

if (!getenv(name: 'TRAVIS_PULL_REQUEST')) {
//    $dotenv->required(
//        [
//            'POSTNL_API_KEY',
//            'POSTNL_COLLECTION_LOCATION',
//            'POSTNL_CONTACT_PERSON',
//            'POSTNL_CUSTOMER_CODE',
//            'POSTNL_CUSTOMER_NUMBER',
//        ]
//    );
}

$filesystemAdapter = new Local(root: __DIR__.'/');
$filesystem = new Filesystem(adapter: $filesystemAdapter);

$adapter = new Local(root: __DIR__.'/logs/');
$logfs = new Filesystem(adapter: $adapter);
$logger = new Logger(filesystem: $logfs, threshold: LogLevel::DEBUG);
$logger->setFilenameFormat(filenameFormat: 'Y-m-d H:i');
$GLOBALS['logger'] = $logger;
