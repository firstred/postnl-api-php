<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * *Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\SOAP;

use Firstred\PostNL\Entity\AbstractEntity;
use Sabre\Xml\Writer;

/**
 * Class UsernameToken
 *
 * @method string|null getPassword()
 *
 * @method UsernameToken setPassword(string|null $password = null)
 */
class UsernameToken extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'Username' => Security::SECURITY_NAMESPACE,
            'Password' => Security::SECURITY_NAMESPACE,
        ],
        'Confirming'     => [
            'Username' => Security::SECURITY_NAMESPACE,
            'Password' => Security::SECURITY_NAMESPACE,
        ],
        'Labelling'      => [
            'Username' => Security::SECURITY_NAMESPACE,
            'Password' => Security::SECURITY_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Username' => Security::SECURITY_NAMESPACE,
            'Password' => Security::SECURITY_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Username' => Security::SECURITY_NAMESPACE,
            'Password' => Security::SECURITY_NAMESPACE,
        ],
        'Timeframe'      => [
            'Username' => Security::SECURITY_NAMESPACE,
            'Password' => Security::SECURITY_NAMESPACE,
        ],
        'Location'       => [
            'Username' => Security::SECURITY_NAMESPACE,
            'Password' => Security::SECURITY_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null $Username */
    protected $Username;
    /** @var string|null $Password */
    protected $Password;
    // @codingStandardsIgnoreEnd

    /**
     * UsernameToken constructor.
     *
     * @param string $password Plaintext password
     */
    public function __construct(string $password)
    {
        parent::__construct();

        $this->setPassword($password);
    }

    /**
     * Return a serializable array for the XMLWriter
     *
     * @param Writer $writer
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if (isset($this->{$propertyName})) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->{$propertyName};
            }
        }

        $writer->write($xml);
    }
}
