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

namespace Firstred\PostNL\Entity\Soap;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;
use ParagonIE\HiddenString\HiddenString;
use Sabre\Xml\Writer;

/**
 * @since 1.0.0
 */
class UsernameToken extends AbstractEntity
{
    #[SerializableProperty(namespace: SoapNamespace::Security)]
    protected ?string $Username = null;
    #[SerializableProperty(namespace: SoapNamespace::Security)]
    protected ?HiddenString $Password = null;

    public function __construct(
        ?string                  $Username = null,
        HiddenString|string|null $Password = null /* Plaintext password */,
    ) {
        parent::__construct();

        $this->setUsername(Username: $Username);
        $this->setPassword(Password: $Password);
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(?string $Username): static
    {
        $this->Username = $Username;

        return $this;
    }

    public function getPassword(): ?HiddenString
    {
        return $this->Password;
    }

    public function setPassword(HiddenString|string|null $Password): static
    {
        if (is_string(value: $Password)) {
            $Password = new HiddenString(value: $Password);
        }

        $this->Password = $Password;

        return $this;
    }

    /**
     * Return a serializable array for the XMLWriter.
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        foreach (static::getSerializableProperties() as $propertyName => $namespaceReference) {
            if (!isset($this->namespaces[$namespaceReference->value])) {
                throw new InvalidArgumentException(message: "Namespace reference `$namespaceReference->value` not set");
            }
            $namespace = $this->namespaces[$namespaceReference->value];
            if (isset($this->$propertyName)) {
                // Lack of username means new API and no hash needed
                if ('Password' === $propertyName) {
                    $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = sha1(string: $this->$propertyName->getString());
                } else {
                    $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
                }
            }
        }

        $writer->write(value: $xml);
    }
}
