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
 * Class Group
 */
class Group extends AbstractEntity
{
    /**
     * Amount of shipments in the group.
     *
     * @var string|null $groupCount
     *
     * @since 1.0.0
     */
    protected $groupCount;

    /**
     * Sequence number.
     *
     * @var string|null $groupSequence
     *
     * @since 1.0.0
     */
    protected $groupSequence;

    /**
     * The type of group.
     *
     * Possible values:
     *
     * - `01`: Collection request
     * - `03`: Multiple parcels in one shipment (multi-colli)
     * - `04`: Single parcel in one shipment
     *
     * @var string|null $groupType
     *
     * @since 1.0.0
     */
    protected $groupType;

    /**
     * Main barcode for the shipment.
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
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getGroupCount(): ?string
    {
        return $this->groupCount;
    }

    /**
     * @param string|null $groupCount
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setGroupCount(?string $groupCount): Group
    {
        $this->groupCount = $groupCount;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getGroupSequence(): ?string
    {
        return $this->groupSequence;
    }

    /**
     * @param string|null $groupSequence
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setGroupSequence(?string $groupSequence): Group
    {
        $this->groupSequence = $groupSequence;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getGroupType(): ?string
    {
        return $this->groupType;
    }

    /**
     * @param string|null $groupType
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setGroupType(?string $groupType): Group
    {
        $this->groupType = $groupType;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getMainBarcode(): ?string
    {
        return $this->mainBarcode;
    }

    /**
     * @param string|null $mainBarcode
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setMainBarcode(?string $mainBarcode): Group
    {
        $this->mainBarcode = $mainBarcode;

        return $this;
    }
}
