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

use Firstred\PostNL\Misc\ValidateAndFix;
use ReflectionException;
use TypeError;

/**
 * Class Group
 */
class Group extends AbstractEntity
{
    /**
     * Total number of colli in the shipment (in case of multicolli shipments)
     * Mandatory for multicollo shipments
     *
     * @pattern ^[1-4]$
     *
     * @example 2
     *
     * @var string|null $groupCount
     *
     * @since 1.0.0
     */
    protected $groupCount;

    /**
     * Sequence number of the collo within the complete shipment (e.g. collo 2 of 4)
     * Mandatory for multicollo shipments
     *
     * @pattern ^[1-4]$
     *
     * @example 2
     *
     * @var string|null $groupSequence
     *
     * @since 1.0.0
     */
    protected $groupSequence;

    /**
     * The type of group.
     *
     * Group sort that determines the type of group that is indicated. This is a code.
     *
     * Possible values:
     *
     * - `01`: Collection request
     * - `03`: Multiple parcels in one shipment (multicolli)
     * - `04`: Single parcel in one shipment
     *
     * @pattern ^\d{2}$
     *
     * @example 03
     *
     * @var string|null $groupType
     *
     * @since 1.0.0
     */
    protected $groupType;

    /**
     * Main barcode for the shipment (in case of multicolli shipments)
     * Mandatory for multicolli shipments
     *
     * @pattern ^{A-Z0-9}{11,15}$
     *
     * @example 3SABCD6659149
     *
     * @var string|null $mainBarcode
     *
     * @since 1.0.0
     */
    protected $mainBarcode;

    /**
     * Group Constructor.
     *
     * @param string|null $groupCount
     * @param string|null $groupSequence
     * @param string|null $groupType
     * @param string|null $mainBarcode
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct($groupCount = null, $groupSequence = null, $groupType = null, $mainBarcode = null)
    {
        parent::__construct();

        $this->setGroupCount($groupCount);
        $this->setGroupSequence($groupSequence);
        $this->setGroupType($groupType);
        $this->setMainBarcode($mainBarcode);
    }

    /**
     * Get group count
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Group::$groupCount
     */
    public function getGroupCount(): ?string
    {
        return $this->groupCount;
    }

    /**
     * Set group count
     *
     * @pattern ^[1-4]$
     *
     * @param string|float|int|null $groupCount
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example 2
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Group::$groupCount
     */
    public function setGroupCount($groupCount): Group
    {
        $this->groupCount = ValidateAndFix::groupCount($groupCount);

        return $this;
    }

    /**
     * Get group sequence
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Group::$groupSequence
     */
    public function getGroupSequence(): ?string
    {
        return $this->groupSequence;
    }

    /**
     * Set group sequence
     *
     * @pattern ^[1-4]$
     *
     * @param string|null $groupSequence
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example 2
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Group::$groupSequence
     */
    public function setGroupSequence(?string $groupSequence): Group
    {
        $this->groupSequence = ValidateAndFix::groupCount($groupSequence);

        return $this;
    }

    /**
     * Get group type
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Group::$groupType
     */
    public function getGroupType(): ?string
    {
        return $this->groupType;
    }

    /**
     * Set group type
     *
     * @pattern ^\d{2}$
     *
     * @param string|float|int|null $groupType
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example 03
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Group::$groupType
     */
    public function setGroupType($groupType): Group
    {
        $this->groupType = ValidateAndFix::numericType($groupType);

        return $this;
    }

    /**
     * Get main barcode
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Group::$mainBarcode
     */
    public function getMainBarcode(): ?string
    {
        return $this->mainBarcode;
    }

    /**
     * Set main barcode
     *
     * @pattern ^{A-Z0-9}{11,15}$
     *
     * @param string|null $mainBarcode
     *
     * @return static
     *
     * @throws ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @example 3SABCD6659149
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Group::$mainBarcode
     */
    public function setMainBarcode(?string $mainBarcode): Group
    {
        $this->mainBarcode = ValidateAndFix::barcode($mainBarcode);

        return $this;
    }
}
