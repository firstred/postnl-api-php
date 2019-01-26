<?php
declare(strict_types=1);
require __DIR__.'/../vendor/autoload.php';

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Psr\Log\LogLevel;
use wappr\Logger;

$filesystemAdapter = new Local(__DIR__.'/');
$filesystem = new Filesystem($filesystemAdapter);

$adapter = new Local(__DIR__.'/logs/');
$logfs = new Filesystem($adapter);
$logger = new Logger($logfs, LogLevel::DEBUG);
$logger->setFilenameFormat('Y-m-d H:i');
$GLOBALS['logger'] = $logger;
