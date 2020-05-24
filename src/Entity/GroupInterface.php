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

use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class Group.
 */
interface GroupInterface extends EntityInterface
{
    /**
     * Get group count.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Group::$groupCount
     */
    public function getGroupCount(): ?string;

    /**
     * Set group count.
     *
     * @pattern ^[1-4]$
     *
     * @param string|float|int|null $groupCount
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 2
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Group::$groupCount
     */
    public function setGroupCount($groupCount): GroupInterface;

    /**
     * Get group sequence.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Group::$groupSequence
     */
    public function getGroupSequence(): ?string;

    /**
     * Set group sequence.
     *
     * @pattern ^[1-4]$
     *
     * @param string|null $groupSequence
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 2
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Group::$groupSequence
     */
    public function setGroupSequence(?string $groupSequence): GroupInterface;

    /**
     * Get group type.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Group::$groupType
     */
    public function getGroupType(): ?string;

    /**
     * Set group type.
     *
     * @pattern ^\d{2}$
     *
     * @param string|float|int|null $groupType
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 03
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Group::$groupType
     */
    public function setGroupType($groupType): GroupInterface;

    /**
     * Get main barcode.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Group::$mainBarcode
     */
    public function getMainBarcode(): ?string;

    /**
     * Set main barcode.
     *
     * @pattern ^{A-Z0-9}{11,15}$
     *
     * @param string|null $mainBarcode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 3SABCD6659149
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Group::$mainBarcode
     */
    public function setMainBarcode(?string $mainBarcode): GroupInterface;
}
