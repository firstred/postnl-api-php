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

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Attribute\SerializableEntityArrayProperty;
use Firstred\PostNL\Attribute\SerializableStringArrayProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Label;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * @since 1.0.0
 */
class MergedLabel extends AbstractEntity
{
    /** @var string[]|null $Barcodes */
    #[SerializableStringArrayProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Barcodes = null;

    /** @var Label[]|null $Labels */
    #[SerializableEntityArrayProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Labels = null;

    /**
     * @param array|null $Barcodes
     * @param array|null $Labels
     */
    public function __construct(
        /** @param string[]|null $Barcodes */
        ?array $Barcodes = null,
        /** @param Label[]|null $Labels */
        ?array $Labels = null,
    ) {
        parent::__construct();

        $this->setBarcodes(Barcodes: $Barcodes);
        $this->setLabels(Labels: $Labels);
    }

    /**
     * @return string[]|null
     */
    public function getBarcodes(): ?array
    {
        return $this->Barcodes;
    }

    /**
     * @param string[]|null $Barcodes
     *
     * @return static
     */
    public function setBarcodes(?array $Barcodes): static
    {
        $this->Barcodes = $Barcodes;

        return $this;
    }

    /**
     * @return Label[]|null
     */
    public function getLabels(): ?array
    {
        return $this->Labels;
    }

    /**
     * @param Label[]|null $Labels
     *
     * @return static
     */
    public function setLabels(?array $Labels): static
    {
        $this->Labels = $Labels;

        return $this;
    }
}
