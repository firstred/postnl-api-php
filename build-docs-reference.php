<?php

use JuliusHaertl\PHPDocToRst\ApiDocBuilder;
use JuliusHaertl\PHPDocToRst\Extension\TocExtension;

require_once __DIR__.'/vendor/autoload.php';

function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir.DIRECTORY_SEPARATOR.$object) && !is_link($dir."/".$object))
                    rrmdir($dir.DIRECTORY_SEPARATOR.$object);
                else
                    unlink($dir.DIRECTORY_SEPARATOR.$object);
            }
        }
        rmdir($dir);
    }
}

$referenceFolder = __DIR__.'/docs/reference';

$src = [__DIR__.'/src'];

// destination path for the documentation
$dst = "$referenceFolder-tmp";

$apiDocBuilder = new ApiDocBuilder($src, $dst);

// DEBUG FEATURES : optional
// optional : activate verbosity
$apiDocBuilder->setVerboseOutput(true);
// optional : activate debug
$apiDocBuilder->setDebugOutput(true);

// EXTENSIONS : optional

///**
//* Do not render classes marked with phpDoc internal tag
//* Do only render public methods/properties.
//*/
//$apiDocBuilder->addExtension(PublicOnlyExtension::class);
//
///**
//* Do not render classes marked with phpDoc internal tag
//* Do only render public methods/properties.
//*/
//$apiDocBuilder->addExtension(NoPrivateExtension::class);

/**
 * This extension will render a list of methods  for easy access
 * at the beginning of classes, interfaces and traits.
 */
$apiDocBuilder->addExtension(TocExtension::class);

// Build documentation
$apiDocBuilder->build();

if (file_exists($referenceFolder)) {
    rrmdir($referenceFolder);
}

rename("$referenceFolder-tmp/Firstred/PostNL", $referenceFolder);

$referenceIndexContents = file_get_contents("$referenceFolder/index.rst");
$referenceIndexContents = str_replace("PostNL\n======", "API Reference\n======", $referenceIndexContents);
file_put_contents("$referenceFolder/index.rst", $referenceIndexContents);

// Cleanup
rrmdir("$referenceFolder-tmp");

