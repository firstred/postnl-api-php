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

use JuliusHaertl\PHPDocToRst\ApiDocBuilder;
use JuliusHaertl\PHPDocToRst\Extension\TocExtension;

require_once __DIR__.'/vendor/autoload.php';

function rrmdir($dir)
{
    if (is_dir(filename: $dir)) {
        $objects = scandir(directory: $dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir(filename: $dir.DIRECTORY_SEPARATOR.$object) && !is_link(filename: $dir."/".$object))
                    rrmdir(dir: $dir.DIRECTORY_SEPARATOR.$object);
                else
                    unlink(filename: $dir.DIRECTORY_SEPARATOR.$object);
            }
        }
        rmdir(directory: $dir);
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

if (file_exists(filename: $referenceFolder)) {
    rrmdir(dir: $referenceFolder);
}

rename(from: "$referenceFolder-tmp/Firstred/PostNL", to: $referenceFolder);

$referenceIndexContents = file_get_contents(filename: "$referenceFolder/index.rst");
$referenceIndexContents = str_replace(search: "PostNL\n======", replace: "API Reference\n======", subject: $referenceIndexContents);
file_put_contents(filename: "$referenceFolder/index.rst", data: $referenceIndexContents);

// Cleanup
rrmdir(dir: "$referenceFolder-tmp");

