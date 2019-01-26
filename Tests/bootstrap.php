<?php
declare(strict_types=1);
require __DIR__.'/../vendor/autoload.php';

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Psr\Log\LogLevel;
use wappr\Logger;

$dotenv = Dotenv::create(__DIR__.'/../');
try {
    $dotenv->load();
} catch (InvalidPathException $e) {
    // Do absolutely nothing with this error :D
}
$dotenv->required([
    'POSTNL_API_KEY',
    'POSTNL_COLLECTION_LOCATION',
    'POSTNL_CONTACT_PERSION',
    'POSTNL_CUSTOMER_CODE',
    'POSTNL_CUSTOMER_NUMBER',
]);

$filesystemAdapter = new Local(__DIR__.'/');
$filesystem = new Filesystem($filesystemAdapter);

$adapter = new Local(__DIR__.'/logs/');
$logfs = new Filesystem($adapter);
$logger = new Logger($logfs, LogLevel::DEBUG);
$logger->setFilenameFormat('Y-m-d H:i');
$GLOBALS['logger'] = $logger;
