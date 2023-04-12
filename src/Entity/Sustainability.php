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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\SerializableProperty;

/**
 * Class Sustainability.
 *
 * @since 1.4.2
 */
class Sustainability extends AbstractEntity
{
    /** @var string|null */
    #[SerializableProperty(type: 'string')]
    protected ?string $Code;

    /** @var string|null */
    #[SerializableProperty(type: 'string')]
    protected ?string $Description;

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
     *
     * @since 1.4.2
     */
    public function getCode(): ?string
    {
        return $this->Code;
    }

    /**
     * @param string|null $Code
     *
     * @return static
     *
     * @since 1.4.2
     */
    public function setCode(?string $Code): static
    {
        $this->Code = $Code;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.4.2
     */
    public function getDescription(): ?string
    {
        return $this->Description;
    }

    /**
     * @param string|null $Description
     *
     * @return static
     *
     * @since 1.4.2
     */
    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }
}
