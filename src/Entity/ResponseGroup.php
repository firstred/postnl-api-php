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

/**
 * Class ResponseGroup.
 */
class ResponseGroup
{
    /**
     * Amount of shipments in the ResponseGroup.
     */
    protected string|null $GroupCount = null;
    /**
     * Sequence number.
     */
    protected string|null $GroupSequence = null;
    /**
     * The type of Group.
     *
     * Possible values:
     *
     * - `01`: Collection request
     * - `03`: Multiple parcels in one shipment (multi-colli)
     * - `04`: Single parcel in one shipment
     */
    protected string|null $GroupType = null;
    /**
     * Main barcode for the shipment.
     */
    protected string|null $MainBarcode = null;

    /**
     * ResponseGroup constructor.
     *
     * @param string|null $groupCount
     * @param string|null $groupSequence
     * @param string|null $groupType
     * @param string|null $mainBarcode
     */
    public function __construct(
        string|null $groupCount = null,
        string|null $groupSequence = null,
        string|null $groupType = null,
        string|null $mainBarcode = null
    ) {
        $this->setGroupCount(groupCount: $groupCount);
        $this->setGroupSequence(groupSequence: $groupSequence);
        $this->setGroupType(groupType: $groupType);
        $this->setMainBarcode(mainBarcode: $mainBarcode);
    }

    /**
     * @return string|null
     */
    public function getGroupCount(): string|null
    {
        return $this->GroupCount;
    }

    /**
     * @param string|null $groupCount
     *
     * @return $this
     */
    public function setGroupCount(string|null $groupCount = null): static
    {
        $this->GroupCount = $groupCount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGroupSequence(): string|null
    {
        return $this->GroupSequence;
    }

    /**
     * @param string|null $groupSequence
     *
     * @return $this
     */
    public function setGroupSequence(string|null $groupSequence = null): static
    {
        $this->GroupSequence = $groupSequence;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGroupType(): string|null
    {
        return $this->GroupType;
    }

    /**
     * @param string|null $groupType
     *
     * @return $this
     */
    public function setGroupType(string|null $groupType = null): static
    {
        $this->GroupType = $groupType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMainBarcode(): string|null
    {
        return $this->MainBarcode;
    }

    /**
     * @param string|null $mainBarcode
     *
     * @return $this
     */
    public function setMainBarcode(string|null $mainBarcode = null): static
    {
        $this->MainBarcode = $mainBarcode;

        return $this;
    }
}
