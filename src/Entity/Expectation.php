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
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Expectation.
 */
class Expectation extends SerializableObject
{
    /**
     * Expectation constructor.
     *
     * @param string      $service
     * @param string      $propType
     * @param string|null $ETAFrom
     * @param string|null $ETATo
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        protected string|null $ETAFrom = null,
        protected string|null $ETATo = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setETAFrom(ETAFrom: $ETAFrom);
        $this->setETATo(ETATo: $ETATo);
    }

    /**
     * @return string|null
     */
    public function getETAFrom(): string|null
    {
        return $this->ETAFrom;
    }

    /**
     * @param string|null $ETAFrom
     *
     * @return static
     */
    public function setETAFrom(string|null $ETAFrom = null): static
    {
        $this->ETAFrom = $ETAFrom;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getETATo(): string|null
    {
        return $this->ETATo;
    }

    /**
     * @param string|null $ETATo
     *
     * @return static
     */
    public function setETATo(string|null $ETATo = null): static
    {
        $this->ETATo = $ETATo;

        return $this;
    }
}
