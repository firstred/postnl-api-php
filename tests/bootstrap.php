<?php

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Psr\Log\LogLevel;
use wappr\Logger;

require_once __DIR__.'/../vendor/autoload.php';

error_reporting(E_ALL ^ E_DEPRECATED);

const _RESPONSES_DIR_ = __DIR__.'/Resources/responses';

$filesystemAdapter = new Local(__DIR__.'/');
$filesystem = new Filesystem($filesystemAdapter);

$adapter = new Local(__DIR__.'/logs/');
$logfs = new Filesystem($adapter);

global $logger;
$logger = new Logger($logfs, LogLevel::DEBUG);
$logger->setFilenameFormat('Y-m-d H:i');
