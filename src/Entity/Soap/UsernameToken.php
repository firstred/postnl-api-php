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

declare(strict_types=1);

namespace Firstred\PostNL\Entity\Soap;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\ServiceNotSetException;
use ParagonIE\HiddenString\HiddenString;
use Sabre\Xml\Writer;

/**
 * @since 1.0.0
 * @deprecated 2.0.0
 */
class UsernameToken extends AbstractEntity
{
    /** @var string|null $Username */
    #[SerializableProperty(namespace: SoapNamespace::Security, type: 'string')]
    protected ?string $Username = null;

    /** @var HiddenString|null $Password */
    #[SerializableProperty(namespace: SoapNamespace::Security, type: HiddenString::class)]
    protected ?HiddenString $Password = null;

    /**
     * @param string|null              $Username
     * @param HiddenString|string|null $Password
     */
    public function __construct(
        ?string $Username = null,
        HiddenString|string|null $Password = null /* Plaintext password */,
    ) {
        parent::__construct();

        $this->setUsername(Username: $Username);
        $this->setPassword(Password: $Password);
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->Username;
    }

    /**
     * @param string|null $Username
     *
     * @return static
     */
    public function setUsername(?string $Username): static
    {
        $this->Username = $Username;

        return $this;
    }

    /**
     * @return HiddenString|null
     */
    public function getPassword(): ?HiddenString
    {
        return $this->Password;
    }

    /**
     * @param HiddenString|string|null $Password
     *
     * @return static
     */
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
     * @param Writer $writer
     *
     * @throws InvalidArgumentException
     * @throws ServiceNotSetException
     *
     * @since 1.0.0
     */
    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        if (!isset($this->currentService)) {
            throw new ServiceNotSetException(message: 'Service not set before serialization');
        }

        foreach (static::getSerializableProperties() as $propertyName => $namespace) {
            if (!in_array(needle: $namespace, haystack: array_values(array: $this->namespaces))) {
                throw new InvalidArgumentException(message: "Namespace prefix `$namespace` not set");
            }
            if (isset($this->$propertyName)) {
                if ('Password' === $propertyName) {
                    $xml["{{$namespace}}{$propertyName}"] = $this->$propertyName->getString();
                } else {
                    $xml["{{$namespace}}{$propertyName}"] = $this->$propertyName;
                }
            }
        }

        $writer->write(value: $xml);
    }
}
