<?php

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

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * @since 1.0.0
 */
class Group extends AbstractEntity
{
    /**
     * Amount of shipments in the group.
     *
     * @var string|null $GroupCount
     */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $GroupCount = null;

    /**
     * Sequence number.
     *
     * @var string|null $GroupSequence
     */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $GroupSequence = null;

    /**
     * The type of group.
     *
     * Possible values:
     *
     * - `01`: Collection request
     * - `03`: Multiple parcels in one shipment (multi-colli)
     * - `04`: Single parcel in one shipment
     *
     * @var string|null $GroupType
     */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $GroupType;

    /**
     * Main barcode for the shipment.
     *
     * @var string|null $MainBarcode
     */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $MainBarcode;

    /**
     * @param string|null $GroupCount
     * @param string|null $GroupSequence
     * @param string|null $GroupType
     * @param string|null $MainBarcode
     */
    public function __construct(
        ?string $GroupCount = null,
        ?string $GroupSequence = null,
        ?string $GroupType = null,
        ?string $MainBarcode = null,
    ) {
        parent::__construct();

        $this->setGroupCount(GroupCount: $GroupCount);
        $this->setGroupSequence(GroupSequence: $GroupSequence);
        $this->setGroupType(GroupType: $GroupType);
        $this->setMainBarcode(MainBarcode: $MainBarcode);
    }

    /**
     * @return string|null
     */
    public function getGroupCount(): ?string
    {
        return $this->GroupCount;
    }

    /**
     * @param string|null $GroupCount
     *
     * @return static
     */
    public function setGroupCount(?string $GroupCount): static
    {
        $this->GroupCount = $GroupCount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGroupSequence(): ?string
    {
        return $this->GroupSequence;
    }

    /**
     * @param string|null $GroupSequence
     *
     * @return static
     */
    public function setGroupSequence(?string $GroupSequence): static
    {
        $this->GroupSequence = $GroupSequence;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGroupType(): ?string
    {
        return $this->GroupType;
    }

    /**
     * @param string|null $GroupType
     *
     * @return static
     */
    public function setGroupType(?string $GroupType): static
    {
        $this->GroupType = $GroupType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMainBarcode(): ?string
    {
        return $this->MainBarcode;
    }

    /**
     * @param string|null $MainBarcode
     *
     * @return static
     */
    public function setMainBarcode(?string $MainBarcode): static
    {
        $this->MainBarcode = $MainBarcode;

        return $this;
    }
}
