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

namespace Firstred\PostNL\Entity;

use TypeError;

/**
 * Class MergedLabel
 */
class MergedLabel extends AbstractEntity
{
    /**
     * Product code delivery
     *
     * @pattern ^.{0,35}$
     *
     * @example 003085
     *
     * @var int $productCodeDelivery
     *
     * @since 1.0.0
     */
    protected $productCodeDelivery;

    /**
     * Barcodes
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string[]|null $barcodes
     *
     * @since 1.0.0
     */
    protected $barcodes;

    /**
     * Warnings
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var Warning[]|null
     *
     * @since 1.0.0
     */
    protected $warnings;

    /**
     * Labels
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var Label[]|null $labels
     *
     * @since 1.0.0
     */
    protected $labels;

    /**
     * MergedLabel constructor.
     *
     * @param int|null       $productCodeDelivery
     * @param string[]|null  $barcodes
     * @param Warning[]|null $warnings
     * @param Label[]|null   $labels
     *
     * @throws TypeError
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
     * Get product code delivery
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   MergedLabel::$productCodeDelivery
     */
    public function getProductCodeDelivery(): ?int
    {
        return $this->productCodeDelivery;
    }

    /**
     * Set product code delivery
     *
     * @pattern ^.{0,35}$
     *
     * @param int|null $productCodeDelivery
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example 003085
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     MergedLabel::$productCodeDelivery
     */
    public function setProductCodeDelivery(?int $productCodeDelivery): MergedLabel
    {
        $this->productCodeDelivery = $productCodeDelivery;

        return $this;
    }

    /**
     * Get barcodes
     *
     * @return string[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   MergedLabel::$barcodes
     */
    public function getBarcodes(): ?array
    {
        return $this->barcodes;
    }

    /**
     * Set barcodes
     *
     * @param string[]|null $barcodes
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example N/A
     *
     * @pattern N/A
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     MergedLabel::$barcodes
     */
    public function setBarcodes(?array $barcodes): MergedLabel
    {
        $this->barcodes = $barcodes;

        return $this;
    }

    /**
     * Get warnings
     *
     * @return Warning[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Warning
     */
    public function getWarnings(): ?array
    {
        return $this->warnings;
    }

    /**
     * Set warnings
     *
     * @pattern N/A
     *
     * @param Warning[]|null $warnings
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example N/A
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     Warning
     */
    public function setWarnings(?array $warnings): MergedLabel
    {
        $this->warnings = $warnings;

        return $this;
    }

    /**
     * Get labels
     *
     * @return Label[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Label
     */
    public function getLabels(): ?array
    {
        return $this->labels;
    }

    /**
     * Set labels
     *
     * @pattern N/A
     *
     * @param Label[]|null $labels
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example N/A
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     Label
     */
    public function setLabels(?array $labels): MergedLabel
    {
        $this->labels = $labels;

        return $this;
    }
}
