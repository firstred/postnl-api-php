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
     */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $GroupCount = null;

    /**
     * Sequence number.
     */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $GroupSequence = null;

    /**
     * The type of group.
     *
     * Possible values:
     *
     * - `01`: Collection request
     * - `03`: Multiple parcels in one shipment (multi-colli)
     * - `04`: Single parcel in one shipment
     */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $GroupType;

    /**
     * Main barcode for the shipment.
     */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $MainBarcode;

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

    public function getGroupCount(): ?string
    {
        return $this->GroupCount;
    }

    public function setGroupCount(?string $GroupCount): static
    {
        $this->GroupCount = $GroupCount;

        return $this;
    }

    public function getGroupSequence(): ?string
    {
        return $this->GroupSequence;
    }

    public function setGroupSequence(?string $GroupSequence): static
    {
        $this->GroupSequence = $GroupSequence;

        return $this;
    }

    public function getGroupType(): ?string
    {
        return $this->GroupType;
    }

    public function setGroupType(?string $GroupType): static
    {
        $this->GroupType = $GroupType;

        return $this;
    }

    public function getMainBarcode(): ?string
    {
        return $this->MainBarcode;
    }

    public function setMainBarcode(?string $MainBarcode): static
    {
        $this->MainBarcode = $MainBarcode;

        return $this;
    }
}
