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
use Firstred\PostNL\Service\ConfirmingServiceInterface;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LabellingServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Label.
 */
class Label extends SerializableObject
{
    public const FORMAT_A4 = 1;
    public const FORMAT_A6 = 2;

    /**
     * Base 64 encoded content.
     *
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LabellingServiceInterface::class, ConfirmingServiceInterface::class])]
    protected string|null $Content = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LabellingServiceInterface::class, ConfirmingServiceInterface::class])]
    protected string|null $Contenttype = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LabellingServiceInterface::class, ConfirmingServiceInterface::class])]
    protected string|null $Labeltype = null;

    /**
     * Label constructor.
     *
     * @param string      $service
     * @param string      $propType
     * @param string|null $Content
     * @param string|null $Contenttype
     * @param string|null $Labeltype
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType,

        string|null $Content = null,
        string|null $Contenttype = null,
        string|null $Labeltype = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setContent(Content: $Content);
        $this->setContenttype(Contenttype: $Contenttype);
        $this->setLabeltype(Labeltype: $Labeltype);
    }

    /**
     * @return string|null
     */
    public function getContent(): string|null
    {
        return $this->Content;
    }

    /**
     * @param string|null $Content
     *
     * @return static
     */
    public function setContent(string|null $Content = null): static
    {
        $this->Content = $Content;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContenttype(): string|null
    {
        return $this->Contenttype;
    }

    /**
     * @param string|null $Contenttype
     *
     * @return static
     */
    public function setContenttype(string|null $Contenttype = null): static
    {
        $this->Contenttype = $Contenttype;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabeltype(): string|null
    {
        return $this->Labeltype;
    }

    /**
     * @param string|null $Labeltype
     *
     * @return static
     */
    public function setLabeltype(string|null $Labeltype = null): static
    {
        $this->Labeltype = $Labeltype;

        return $this;
    }
}
