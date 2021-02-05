<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ServiceInterface;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class ReasonNoTimeframe
 */
class ReasonNoTimeframe extends SerializableObject
{
    /**
     * @var string|null
     */
    #[ResponseProp(requiredFor: [TimeframeServiceInterface::class])]
    protected string|null $Code = null;

    /**
     * @var string|null
     */
    #[ResponseProp(requiredFor: [TimeframeServiceInterface::class])]
    protected string|null $Date = null;

    /**
     * @var string|null
     */
    #[ResponseProp(requiredFor: [TimeframeServiceInterface::class])]
    protected string|null $Description = null;

    /**
     * @var mixed[]|null
     */
    #[ResponseProp(requiredFor: [TimeframeServiceInterface::class])]
    protected array|null $Options = null;

    /**
     * @var string|null
     */
    #[ResponseProp(requiredFor: [TimeframeServiceInterface::class])]
    protected string|null $From = null;

    /**
     * @var string|null
     */
    #[ResponseProp(requiredFor: [TimeframeServiceInterface::class])]
    protected string|null $To = null;

    /**
     * ReasonNoTimeframe constructor.
     *
     * @param string      $service
     * @param string      $propType
     * @param string|null $Code
     * @param string|null $Date
     * @param string|null $Description
     * @param array|null  $Options
     * @param string|null $From
     * @param string|null $To
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service,
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType,

        string|null $Code = null,
        string|null $Date = null,
        string|null $Description = null,
        array|null $Options = null,
        string|null $From = null,
        string|null $To = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setCode(Code: $Code);
        $this->setDate(Date: $Date);
        $this->setDescription(Description: $Description);
        $this->setOptions(Options: $Options);
        $this->setFrom(From: $From);
        $this->setTo(To: $To);
    }

    /**
     * @return string|null
     */
    public function getCode(): string|null
    {
        return $this->Code;
    }

    /**
     * @param string|null $Code
     *
     * @return static
     */
    public function setCode(string|null $Code = null): static
    {
        $this->Code = $Code;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDate(): string|null
    {
        return $this->Date;
    }

    /**
     * @param string|null $Date
     *
     * @return static
     */
    public function setDate(string|null $Date = null): static
    {
        $this->Date = $Date;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): string|null
    {
        return $this->Description;
    }

    /**
     * @param string|null $Description
     *
     * @return static
     */
    public function setDescription(string|null $Description = null): static
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getOptions(): array|null
    {
        return $this->Options;
    }

    /**
     * @param array|null $Options
     *
     * @return static
     */
    public function setOptions(array|null $Options = null): static
    {
        $this->Options = $Options;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFrom(): string|null
    {
        return $this->From;
    }

    /**
     * @param string|null $From
     *
     * @return static
     */
    public function setFrom(string|null $From = null): static
    {
        $this->From = $From;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTo(): string|null
    {
        return $this->To;
    }

    /**
     * @param string|null $To
     *
     * @return static
     */
    public function setTo(string|null $To = null): static
    {
        $this->To = $To;

        return $this;
    }
}
