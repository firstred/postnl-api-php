<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Label;
use Firstred\PostNL\Entity\Warning;

/**
 * Class MergedLabel
 */
class MergedLabel extends AbstractEntity
{
    /** @var int $productCodeDelivery */
    protected $productCodeDelivery;
    /** @var string[]|null $barcodes */
    protected $barcodes;
    /** @var Warning[]|null */
    protected $warnings;
    /** @var Label[]|null $labels */
    protected $labels;

    /**
     * @param int|null       $productCodeDelivery
     * @param string[]|null  $barcodes
     * @param Warning[]|null $warnings
     * @param Label[]|null   $labels
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?int $productCodeDelivery = null, array $barcodes = null, array $warnings = null, array $labels = null)
    {
        parent::__construct();

        $this->setProductCodeDelivery($productCodeDelivery);
        $this->setBarcodes($barcodes);
        $this->setWarnings($warnings);
        $this->setLabels($labels);
    }

    /**
     * @return int|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getProductCodeDelivery(): ?int
    {
        return $this->productCodeDelivery;
    }

    /**
     * @param int|null $productCodeDelivery
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setProductCodeDelivery(?int $productCodeDelivery): MergedLabel
    {
        $this->productCodeDelivery = $productCodeDelivery;

        return $this;
    }

    /**
     * @return string[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getBarcodes(): ?array
    {
        return $this->barcodes;
    }

    /**
     * @param string[]|null $barcodes
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setBarcodes(?array $barcodes): MergedLabel
    {
        $this->barcodes = $barcodes;

        return $this;
    }

    /**
     * @return Warning[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getWarnings(): ?array
    {
        return $this->warnings;
    }

    /**
     * @param Warning[]|null $warnings
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setWarnings(?array $warnings): MergedLabel
    {
        $this->warnings = $warnings;

        return $this;
    }

    /**
     * @return Label[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getLabels(): ?array
    {
        return $this->labels;
    }

    /**
     * @param Label[]|null $labels
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLabels(?array $labels): MergedLabel
    {
        $this->labels = $labels;

        return $this;
    }
}
