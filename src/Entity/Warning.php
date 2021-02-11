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
use Firstred\PostNL\Service\CheckoutServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Warning.
 */
class Warning extends SerializableObject
{
    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [CheckoutServiceInterface::class])]
    protected string|null $DeliveryDate = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [CheckoutServiceInterface::class])]
    protected string|null $Code = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [CheckoutServiceInterface::class])]
    protected string|null $Description = null;

    /**
     * @var array|null
     */
    #[ResponseProp(optionalFor: [CheckoutServiceInterface::class])]
    protected array|null $Options = null;

    /**
     * Warning constructor.
     *
     * @param string      $service
     * @param string      $propType
     * @param string|null $DeliveryDate
     * @param string|null $Code
     * @param string|null $Description
     * @param array|null  $Options
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType,

        string|null $DeliveryDate = null,
        string|null $Code = null,
        string|null $Description = null,
        array|null $Options = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setDeliveryDate(DeliveryDate: $DeliveryDate);
        $this->setCode(Code: $Code);
        $this->setDescription(Description: $Description);
        $this->setOptions(Options: $Options);
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
     * @return string|null
     */
    public function getDeliveryDate(): string|null
    {
        return $this->DeliveryDate;
    }

    /**
     * @param string|null $DeliveryDate
     *
     * @return static
     */
    public function setDeliveryDate(string|null $DeliveryDate = null): static
    {
        $this->DeliveryDate = $DeliveryDate;

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getOptions(): array|null
    {
        return $this->Options;
    }

    /**
     * @param string[]|null $Options
     *
     * @return static
     */
    public function setOptions(array|null $Options = null): static
    {
        $this->Options = $Options;

        return $this;
    }
}
