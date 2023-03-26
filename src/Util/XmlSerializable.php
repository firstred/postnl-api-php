<?php
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

namespace Firstred\PostNL\Util;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable as SabreXmlSerializable;

if (interface_exists(SabreXmlSerializable::class)) {
    class_alias(SabreXmlSerializable::class, XmlSerializable::class);
} else {
    /**
     * Objects implementing XmlSerializable can control how they are represented in
     * Xml.
     *
     * @copyright Copyright (C) 2009-2015 fruux GmbH (https://fruux.com/).
     * @author    Evert Pot (http://evertpot.com/)
     * @license   http://sabre.io/license/ Modified BSD License
     *
     * @since     1.2.0
     * @internal
     */
    interface XmlSerializable
    {
        /**
         * The xmlSerialize method is called during xml writing.
         *
         * Use the $writer argument to write its own xml serialization.
         *
         * An important note: do _not_ create a parent element. Any element
         * implementing XmlSerializable should only ever write what's considered
         * its 'inner xml'.
         *
         * The parent of the current element is responsible for writing a
         * containing element.
         *
         * This allows serializers to be re-used for different element names.
         *
         * If you are opening new elements, you must also close them again.
         *
         * @param Writer $writer
         *
         * @return void
         */
        function xmlSerialize(Writer $writer);
    }
}


