<?php

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Psr\Log\LogLevel;
use wappr\Logger;

$autoloader = require __DIR__.'/../vendor/autoload.php';
$autoloader->add('ThirtyBees\\PostNL\\Tests\\', __DIR__);

$filesystemAdapter = new Local(__DIR__.'/');
$filesystem = new Filesystem($filesystemAdapter);

$adapter = new Local(__DIR__.'/logs/');
$logfs = new Filesystem($adapter);
$logger = new Logger($logfs, LogLevel::DEBUG);
$logger->setFilenameFormat('Y-m-d H:i');
$GLOBALS['logger'] = $logger;
