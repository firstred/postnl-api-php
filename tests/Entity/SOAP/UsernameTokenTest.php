<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker
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
 * @copyright 2017-2019 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Tests\Entity\SOAP;
use Sabre\Xml\Service as XmlService;
use Firstred\PostNL\Entity\SOAP\UsernameToken;

/**
 * Class UsernameTokenTest
 *
 * @package Firstred\PostNL\Tests\Entity\SOAP
 *
 * @testdox The UsernameToken class
 */
class UsernameTokenTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @testdox should automatically hash the password for the legacy API
     */
    public function testLegacyPassword()
    {
        $token = new UsernameToken('test', 'test');
        $token->setCurrentService('Barcode');
        $xmlService = new XmlService();
        $write = $xmlService->write(
            '{test}UserNameToken',
            [
                '{test}token' => $token,
            ]
        );

        $this->assertEquals('<?xml version="1.0"?>
<x1:UserNameToken xmlns:x1="test">
 <x1:token xmlns:x1="test">
  <x2:Username xmlns:x2="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">test</x2:Username>
  <x2:Password xmlns:x2="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">a94a8fe5ccb19ba61c4c0873d391e987982fbbd3</x2:Password>
 </x1:token>
</x1:UserNameToken>
', $write);
    }
}
