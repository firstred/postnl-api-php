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
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Amount;
use Firstred\PostNL\Entity\Barcode;
use Firstred\PostNL\Entity\Dimension;
use Firstred\PostNL\Entity\Expectation;
use Firstred\PostNL\Entity\Group;
use Firstred\PostNL\Entity\ProductOption;
use Firstred\PostNL\Entity\Status;
use Firstred\PostNL\Entity\Warning;

/**
 * Class CurrentStatusResponseShipment
 */
class CurrentStatusResponseShipment extends AbstractEntity
{
    /** @var Address[]|null $addresses */
    protected $addresses;
    /** @var Amount[]|null $amounts */
    protected $amounts;
    /** @var Barcode|null $barcode */
    protected $barcode;
    /** @var string|null $deliveryDate */
    protected $deliveryDate;
    /** @var Dimension|null Dimension */
    protected $dimension;
    /** @var Expectation|null $expectation */
    protected $expectation;
    /** @var Group[]|null $groups */
    protected $groups;
    /** @var string|null $productCode */
    protected $productCode;
    /** @var ProductOption[]|null $ProuctOptions */
    protected $productOptions;
    /** @var string|null $reference */
    protected $reference;
    /** @var Status|null $status */
    protected $status;
    /** @var Warning[]|null $warnings */
    protected $warnings;

    /**
     * CurrentStatusResponseShipment constructor.
     *
     * @param Address[]|null       $addresses
     * @param Amount[]|null        $amounts
     * @param Barcode|null         $barcode
     * @param string|null          $deliveryDate
     * @param Dimension|null       $dimension
     * @param Expectation|null     $expectation
     * @param Group[]|null         $groups
     * @param string|null          $productCode
     * @param ProductOption[]|null $productOptions
     * @param string|null          $reference
     * @param Status|null          $status
     * @param Warning[]|null       $warnings
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?array $addresses = null, ?array $amounts = null, ?Barcode $barcode = null, ?string $deliveryDate = null, ?Dimension $dimension = null, ?Expectation $expectation = null, ?array $groups = null, ?string $productCode = null, ?array $productOptions = null, ?string $reference = null, ?Status $status = null, ?array $warnings = null)
    {
        parent::__construct();

        $this->setAddresses($addresses);
        $this->setAmounts($amounts);
        $this->setBarcode($barcode);
        $this->setDeliveryDate($deliveryDate);
        $this->setDimension($dimension);
        $this->setExpectation($expectation);
        $this->setGroups($groups);
        $this->setProductCode($productCode);
        $this->setProductOptions($productOptions);
        $this->setReference($reference);
        $this->setStatus($status);
        $this->setWarnings($warnings);
    }

    /**
     * @return Address[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAddresses(): ?array
    {
        return $this->addresses;
    }

    /**
     * @param Address[]|null $addresses
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAddresses(?array $addresses): CurrentStatusResponseShipment
    {
        $this->addresses = $addresses;

        return $this;
    }

    /**
     * @return Amount[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAmounts(): ?array
    {
        return $this->amounts;
    }

    /**
     * @param Amount[]|null $amounts
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAmounts(?array $amounts): CurrentStatusResponseShipment
    {
        $this->amounts = $amounts;

        return $this;
    }

    /**
     * @return Barcode|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getBarcode(): ?Barcode
    {
        return $this->barcode;
    }

    /**
     * @param Barcode|null $barcode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setBarcode(?Barcode $barcode): CurrentStatusResponseShipment
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    /**
     * @param string|null $deliveryDate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDeliveryDate(?string $deliveryDate): CurrentStatusResponseShipment
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * @return Dimension|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDimension(): ?Dimension
    {
        return $this->dimension;
    }

    /**
     * @param Dimension|null $dimension
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDimension(?Dimension $dimension): CurrentStatusResponseShipment
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * @return Expectation|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getExpectation(): ?Expectation
    {
        return $this->expectation;
    }

    /**
     * @param Expectation|null $expectation
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setExpectation(?Expectation $expectation): CurrentStatusResponseShipment
    {
        $this->expectation = $expectation;

        return $this;
    }

    /**
     * @return Group[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getGroups(): ?array
    {
        return $this->groups;
    }

    /**
     * @param Group[]|null $groups
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setGroups(?array $groups): CurrentStatusResponseShipment
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getProductCode(): ?string
    {
        return $this->productCode;
    }

    /**
     * @param string|null $productCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setProductCode(?string $productCode): CurrentStatusResponseShipment
    {
        $this->productCode = $productCode;

        return $this;
    }

    /**
     * @return ProductOption[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getProductOptions(): ?array
    {
        return $this->productOptions;
    }

    /**
     * @param ProductOption[]|null $productOptions
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setProductOptions(?array $productOptions): CurrentStatusResponseShipment
    {
        $this->productOptions = $productOptions;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param string|null $reference
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setReference(?string $reference): CurrentStatusResponseShipment
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return Status|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getStatus(): ?Status
    {
        return $this->status;
    }

    /**
     * @param Status|null $status
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setStatus(?Status $status): CurrentStatusResponseShipment
    {
        $this->status = $status;

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
    public function setWarnings(?array $warnings): CurrentStatusResponseShipment
    {
        $this->warnings = $warnings;

        return $this;
    }
}
