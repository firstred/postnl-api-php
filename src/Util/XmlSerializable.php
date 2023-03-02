<?php

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


