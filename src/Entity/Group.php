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
 * Class Group.
 */
class Group extends SerializableObject
{
    public const GROUP_TYPES = ['01' , '03', '04'];

    /**
     * Amount of shipments in the group.
     *
     * @var string|null
     */
    protected string|null $GroupCount = null;

    /**
     * Sequence number.
     *
     * @var string|null
     */
    protected string|null $GroupSequence = null;

    /**
     * The type of group.
     *
     * Possible values:
     *
     * - `01`: Collection request
     * - `03`: Multiple parcels in one shipment (multi-colli)
     * - `04`: Single parcel in one shipment
     *
     * @var string|null
     */
    #[ExpectedValues(values: self::GROUP_TYPES)]
    protected string|null $GroupType = null;

    /**
     * Main barcode for the shipment.
     *
     * @var string|null
     */
    protected string|null $MainBarcode = null;

    /**
     * Group constructor.
     *
     * @param string      $service
     * @param string      $propType
     * @param string|null $GroupCount
     * @param string|null $GroupSequence
     * @param string|null $GroupType
     * @param string|null $MainBarcode
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType,

        string|null $GroupCount = null,
        string|null $GroupSequence = null,
        #[ExpectedValues(values: self::GROUP_TYPES)]
        string|null $GroupType = null,
        string|null $MainBarcode = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setGroupCount(GroupCount: $GroupCount);
        $this->setGroupSequence(GroupSequence: $GroupSequence);
        $this->setGroupType(GroupType: $GroupType);
        $this->setMainBarcode(MainBarcode: $MainBarcode);
    }

    /**
     * @return string|null
     */
    public function getGroupCount(): string|null
    {
        return $this->GroupCount;
    }

    /**
     * @param string|null $GroupCount
     *
     * @return static
     */
    public function setGroupCount(string|null $GroupCount = null): static
    {
        $this->GroupCount = $GroupCount;

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
     * @param string|null $GroupSequence
     *
     * @return static
     */
    public function setGroupSequence(string|null $GroupSequence = null): static
    {
        $this->GroupSequence = $GroupSequence;

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
     * @param string|null $GroupType
     *
     * @return static
     */
    public function setGroupType(string|null $GroupType = null): static
    {
        $this->GroupType = $GroupType;

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
     * @param string|null $MainBarcode
     *
     * @return static
     */
    public function setMainBarcode(string|null $MainBarcode = null): static
    {
        $this->MainBarcode = $MainBarcode;

        return $this;
    }
}
