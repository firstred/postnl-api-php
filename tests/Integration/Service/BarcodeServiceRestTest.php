<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Tests\Integration\Service;

use Firstred\PostNL\Exception\ApiClientException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\InvalidApiKeyException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidBarcodeException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotAvailableException;
use Firstred\PostNL\Exception\ParseError;
use Firstred\PostNL\Service\BarcodeServiceInterface;

/**
 * Class BarcodeServiceTest.
 *
 * @testdox The BarcodeService (REST)
 */
class BarcodeServiceRestTest extends ServiceTestBase
{
    protected BarcodeServiceInterface $service;

    /**
     * @testdox Returns a valid single barcode
     *
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws InvalidBarcodeException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function testSingleBarcodeRest()
    {
        if (isset($_ENV['CI'])) {
            $this->markTestSkipped();
        }

        $this->assertStringStartsWith(prefix: '3S', string: (string) $this->postnl->generateBarcode());
    }

    /**
     * @testdox Returns a valid single barcode for a country
     *
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws InvalidBarcodeException
     * @throws InvalidConfigurationException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function testSingleBarCodeByCountryRest()
    {
        if (isset($_ENV['CI'])) {
            $this->markTestSkipped();
        }

        $this->assertStringStartsWith(prefix: '3S', string: (string) $this->postnl->generateBarcodeByCountryCode(iso: 'NL'));
    }

    /**
     * @testdox Returns several barcodes
     *
     * @throws InvalidBarcodeException
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function testMultipleNLBarcodesRest()
    {
        if (isset($_ENV['CI'])) {
            $this->markTestSkipped();
        }

        $barcodes = $this->postnl->generateBarcodesByCountryCodes(isos: ['NL' => 2]);

        $this->assertStringStartsWith(prefix: '3S', string: (string) $barcodes['NL'][1]);
    }
}
