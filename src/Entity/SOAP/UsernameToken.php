<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
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
 * @copyright 2017 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Entity\SOAP;

use Sabre\Xml\Writer;
use ThirtyBees\PostNL\Entity\AbstractEntity;

/**
 * Class UsernameToken
 *
 * @package ThirtyBees\PostNL\Entity\SOAP
 *
 * @method string getUsername()
 * @method string getPassword()
 *
 * @method UsernameToken setUsername(string $username)
 * @method UsernameToken setPassword(string $password)
 */
class UsernameToken extends AbstractEntity
{
    /** @var string[] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'    => [
            'Username' => Security::SECURITY_NAMESPACE,
            'Password' => Security::SECURITY_NAMESPACE,
        ],
        'Confirming' => [
            'Username' => Security::SECURITY_NAMESPACE,
            'Password' => Security::SECURITY_NAMESPACE,
        ],
        'Labelling'  => [
            'Username' => Security::SECURITY_NAMESPACE,
            'Password' => Security::SECURITY_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string $Username */
    public $Username;
    /** @var string $Password */
    public $Password;
    // @codingStandardsIgnoreEnd

    /**
     * UsernameToken constructor.
     *
     * @param string $username
     * @param string $password Plaintext password
     */
    public function __construct($username, $password)
    {
        parent::__construct();

        $this->setUsername($username);
        $this->setPassword($password);
    }

    /**
     * Return a serializable array for the XMLWriter
     *
     * @param Writer $writer
     *
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        $xml = [];
        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if (!is_null($this->{$propertyName})) {
                // Lack of username means new API and no hash needed
                if ($this->Username && $propertyName === 'Password') {
                    $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = sha1($this->{$propertyName});
                } else {
                    $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->{$propertyName};
                }
            }
        }

        $writer->write($xml);
    }
}
