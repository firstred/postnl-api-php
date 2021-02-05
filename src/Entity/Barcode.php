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
use Firstred\PostNL\Service\BarcodeServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Barcode.
 */
class Barcode extends SerializableObject
{
    /**
     * @var null|string
     */
    #[ResponseProp(requiredFor: [BarcodeServiceInterface::class])]
    protected string|null $Type = null;
    /**
     * @var null|string
     */
    #[ResponseProp(requiredFor: [BarcodeServiceInterface::class])]
    protected string|null $Range = null;
    /**
     * @var string|null
     */
    #[ResponseProp(requiredFor: [BarcodeServiceInterface::class])]
    protected string|null $Serie = '000000000-999999999';

    /**
     * Barcode constructor.
     *
     * @param string      $service
     * @param string      $propType
     * @param string|null $Type
     * @param string|null $Range
     * @param string|null $Serie
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service,
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType,

        string|null $Type = null,
        string|null $Range = null,
        string|null $Serie = '000000000-999999999',
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setType(Type: $Type);
        $this->setRange(Range: $Range);
        $this->setSerie(Serie: $Serie);
    }

    /**
     * @return string|null
     */
    public function getType(): string|null
    {
        return $this->Type;
    }

    /**
     * @param string|null $Type
     *
     * @return static
     */
    public function setType(string|null $Type = null): static
    {
        $this->Type = $Type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRange(): string|null
    {
        return $this->Range;
    }

    /**
     * @param string|null $Range
     *
     * @return static
     */
    public function setRange(string|null $Range = null): static
    {
        $this->Range = $Range;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSerie(): string|null
    {
        return $this->Serie;
    }

    /**
     * @param string|null $Serie
     *
     * @return static
     */
    public function setSerie(string|null $Serie = null): static
    {
        $this->Serie = $Serie;

        return $this;
    }
}
