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
 * Class MergedLabel
 */
class MergedLabel extends SerializableObject
{
    protected array|null $Barcodes = null;
    protected array|null $Labels = null;

    /**
     * MergedLabel constructor.
     *
     * @param string     $service
     * @param string     $propType
     * @param array|null $barcodes
     * @param array|null $labels
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType,

        array|null $barcodes = null, array|null $labels = null
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setBarcodes(barcodes: $barcodes);
        $this->setLabels(labels: $labels);
    }

    /**
     * @return array|null
     */
    public function getBarcodes(): array|null
    {
        return $this->Barcodes;
    }

    /**
     * @param array|null $barcodes
     *
     * @return static
     */
    public function setBarcodes(array|null $barcodes = null): static
    {
        $this->Barcodes = $barcodes;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getLabels(): array|null
    {
        return $this->Labels;
    }

    /**
     * @param array|null $labels
     *
     * @return static
     */
    public function setLabels(array|null $labels = null): static
    {
        $this->Labels = $labels;

        return $this;
    }
}
