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

use Firstred\PostNL\PostNL;
use Firstred\PostNL\PostNLFactory;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
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

/** @var PostNL $postnl */
$postnl = PostNLFactory::create(false);

$console = new Application();

$console
    ->setDefaultCommand('generate:barcode')
    ->register('generate:barcode')
    ->setDefinition([
        new InputArgument('type', InputArgument::OPTIONAL, 'Barcode type (3S, CX, etc.)', '3S'),
    ])
    ->setDescription('Generate a barcode.')
    ->setHelp('
The <info>generate:barcode</info> command will generate a barcode.
 
<comment>Samples:</comment>
  To run with default options:
    <info>php 01_barcode_service.php generate:barcode</info>
  To generate a different type of barcode
    <info>php console.php generate:barcode CX</info>
')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($postnl) {
        $type = $input->getArgument('type');
        $barcode = $postnl->generateBarcode($type);
        $output->writeln("The generated $type barcode is: <info>$barcode</info>");
    });

$console
    ->register('generate:barcodes')
    ->setDefinition([
        new InputOption('country', 'c', InputOption::VALUE_OPTIONAL, 'Country code (NL, DE, US, etc.)', 'NL'),
        new InputOption('amount', 'a', InputOption::VALUE_OPTIONAL, 'Amount of barcodes', '1'),
    ])
    ->setDescription('Generate multiple barcodes.')
    ->setHelp('
The <info>generate:barcodes</info> command will generate multiple barcodes.

<comment>Samples:</comment>
  To run with default options:
    <info>php 01_barcode_service.php generate:barcodes</info>
  To generate barcodes for a specific country
    <info>php console.php generate:barcodes --country=NL</info>
  To generate multiple barcodes for a specific country
    <info>php console.php generate:barcodes --country=NL --amount=3</info>
  To generate multiple barcodes for multiple countries (with amounts 3 & 5 resp.)
    <info>php console.php generate:barcodes --country=NL,DE --amount=3,5</info>
')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($postnl) {
//        $countries = explode(',', (string) $input->getOption('country'));
//        $amount = explode(',', (string) $input->getOption('amount'));
//        $postcodes = $postnl->generateBarcodesByCountryCodes(array_combine($countries, $amount));
        $country = (string) $input->getOption('country');
        $barcode = $postnl->generateBarcodeByCountryCode($country);
        $output->writeln("The generated barcode for $country is <info>$barcode</info>");
    });

$console->run();
