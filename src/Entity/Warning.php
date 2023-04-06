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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\NotSupportedException;
use stdClass;

/**
 * @since 1.0.0
 */
class Warning extends AbstractEntity
{
    /** @var string|null $Code */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Code = null;

    /** @var string|null $Description */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Description = null;

    /**
     * @param string|null $Code
     * @param string|null $Description
     */
    public function __construct(?string $Code = null, ?string $Description = null)
    {
        parent::__construct();

        $this->setCode(Code: $Code);
        $this->setDescription(Description: $Description);
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->Code;
    }

    /**
     * @param string|null $Code
     *
     * @return static
     */
    public function setCode(?string $Code): static
    {
        $this->Code = $Code;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->Description;
    }

    /**
     * @param string|null $Description
     *
     * @return static
     */
    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @param stdClass $json
     *
     * @return Warning
     * @throws NotSupportedException
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws \ReflectionException
     */
    public static function jsonDeserialize(stdClass $json): static
    {
        // Confirming Webservice has the code and description properties in lower case
        if (isset($json->Warning->code)) {
            $json->Warning->Code = $json->Warning->code;
            unset($json->Warning->code);
        }
        if (isset($json->Warning->description)) {
            $json->Warning->Description = $json->Warning->description;
            unset($json->Warning->description);
        }

        if (isset($json->Warning->Message)) {
            $json->Warning->Description = $json->Warning->Message;
            unset($json->Warning->Message);
        }

        return parent::jsonDeserialize(json: $json);
    }
}
