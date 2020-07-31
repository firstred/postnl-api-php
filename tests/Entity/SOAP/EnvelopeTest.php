<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2018 Thirty Development, LLC
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
 * @author    Michael Dekker <michael@thirtybees.com>
 * @copyright 2017-2018 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Tests\Entity\SOAP;

use ThirtyBees\PostNL\Entity\SOAP\Body;
use ThirtyBees\PostNL\Entity\SOAP\Envelope;
use ThirtyBees\PostNL\Entity\SOAP\Header;

/**
 * Class EnvelopeTest.
 *
 * @testdox The Envelope class
 */
class EnvelopeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @testdox can return the header
     */
    public function testHeader()
    {
        $envelope = Envelope::create()
            ->setHeader(Header::create())
        ;

        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Entity\\SOAP\\Header', $envelope->getHeader());
    }

    /**
     * @testdox can return the body
     */
    public function testBody()
    {
        $envelope = Envelope::create()
            ->setBody(Body::create())
        ;

        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Entity\\SOAP\\Body', $envelope->getBody());
    }
}
