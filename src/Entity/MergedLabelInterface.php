<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

/**
 * Class MergedLabel.
 */
interface MergedLabelInterface extends EntityInterface
{
    /**
     * Get product code delivery.
     *
     * @return int|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   MergedLabel::$productCodeDelivery
     */
    public function getProductCodeDelivery(): ?int;

    /**
     * Set product code delivery.
     *
     * @pattern ^.{0,35}$
     *
     * @param int|null $productCodeDelivery
     *
     * @return static
     *
     * @example 003085
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     MergedLabel::$productCodeDelivery
     */
    public function setProductCodeDelivery(?int $productCodeDelivery): MergedLabelInterface;

    /**
     * Get barcodes.
     *
     * @return string[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   MergedLabel::$barcodes
     */
    public function getBarcodes(): ?array;

    /**
     * Set barcodes.
     *
     * @param string[]|null $barcodes
     *
     * @return static
     *
     * @example N/A
     *
     * @pattern N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     MergedLabel::$barcodes
     */
    public function setBarcodes(?array $barcodes): MergedLabelInterface;

    /**
     * Get warnings.
     *
     * @return WarningInterface[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Warning
     */
    public function getWarnings(): ?array;

    /**
     * Set warnings.
     *
     * @pattern N/A
     *
     * @param WarningInterface[]|null $warnings
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Warning
     */
    public function setWarnings(?array $warnings): MergedLabelInterface;

    /**
     * Get labels.
     *
     * @return LabelInterface[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Label
     */
    public function getLabels(): ?array;

    /**
     * Set labels.
     *
     * @pattern N/A
     *
     * @param LabelInterface[]|null $labels
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Label
     */
    public function setLabels(?array $labels): MergedLabelInterface;
}
