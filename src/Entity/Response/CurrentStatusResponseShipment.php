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
use Firstred\PostNL\Entity\GenerateBarcode;
use Firstred\PostNL\Entity\Dimension;
use Firstred\PostNL\Entity\Expectation;
use Firstred\PostNL\Entity\Group;
use Firstred\PostNL\Entity\ProductOption;
use Firstred\PostNL\Entity\Status;
use Firstred\PostNL\Entity\Warning;
use TypeError;

/**
 * Class CurrentStatusResponseShipment
 */
class CurrentStatusResponseShipment extends AbstractEntity
{
    /**
     * @var Address[]|null $addresses
     *
     * @since 1.0.0
     */
    protected $addresses;

    /**
     * @var Amount[]|null $amounts
     *
     * @since 1.0.0
     */
    protected $amounts;

    /**
     * @var GenerateBarcode|null $barcode
     *
     * @since 1.0.0
     */
    protected $barcode;

    /**
     * @var string|null $deliveryDate
     *
     * @since 1.0.0
     */
    protected $deliveryDate;

    /**
     * @var Dimension|null Dimension
     *
     * @since 1.0.0
     */
    protected $dimension;

    /**
     * @var Expectation|null $expectation
     *
     * @since 1.0.0
     */
    protected $expectation;

    /**
     * @var Group[]|null $groups
     *
     * @since 1.0.0
     */
    protected $groups;

    /**
     * @var string|null $productCode
     *
     * @since 1.0.0
     */
    protected $productCode;

    /**
     * @var ProductOption[]|null $ProuctOptions
     *
     * @since 1.0.0
     */
    protected $productOptions;

    /**
     * @var string|null $reference
     *
     * @since 1.0.0
     */
    protected $reference;

    /**
     * @var Status|null $status
     *
     * @since 1.0.0
     */
    protected $status;

    /**
     * @var Warning[]|null $warnings
     *
     * @since 1.0.0
     */
    protected $warnings;

    /**
     * CurrentStatusResponseShipment constructor.
     *
     * @param Address[]|null       $addresses
     * @param Amount[]|null        $amounts
     * @param GenerateBarcode|null $barcode
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
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?array $addresses = null, ?array $amounts = null, ?GenerateBarcode $barcode = null, ?string $deliveryDate = null, ?Dimension $dimension = null, ?Expectation $expectation = null, ?array $groups = null, ?string $productCode = null, ?array $productOptions = null, ?string $reference = null, ?Status $status = null, ?array $warnings = null)
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
     * Get addresses
     *
     * @return Address[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getAddresses(): ?array
    {
        return $this->addresses;
    }

    /**
     * Set addresses
     *
     * @param Address[]|null $addresses
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setAddresses(?array $addresses): CurrentStatusResponseShipment
    {
        $this->addresses = $addresses;

        return $this;
    }

    /**
     * Get amounts
     *
     * @return Amount[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getAmounts(): ?array
    {
        return $this->amounts;
    }

    /**
     * Set amounts
     *
     * @param Amount[]|null $amounts
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setAmounts(?array $amounts): CurrentStatusResponseShipment
    {
        $this->amounts = $amounts;

        return $this;
    }

    /**
     * Get barcode
     *
     * @return GenerateBarcode|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getBarcode(): ?GenerateBarcode
    {
        return $this->barcode;
    }

    /**
     * Set barcode
     *
     * @param GenerateBarcode|null $barcode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setBarcode(?GenerateBarcode $barcode): CurrentStatusResponseShipment
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get delivery date
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    /**
     * Set delivery date
     *
     * @param string|null $deliveryDate
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setDeliveryDate(?string $deliveryDate): CurrentStatusResponseShipment
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * Get dimension
     *
     * @return Dimension|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getDimension(): ?Dimension
    {
        return $this->dimension;
    }

    /**
     * Set dimension
     *
     * @param Dimension|null $dimension
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setDimension(?Dimension $dimension): CurrentStatusResponseShipment
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * Get expectation
     *
     * @return Expectation|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getExpectation(): ?Expectation
    {
        return $this->expectation;
    }

    /**
     * Set expectation
     *
     * @param Expectation|null $expectation
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setExpectation(?Expectation $expectation): CurrentStatusResponseShipment
    {
        $this->expectation = $expectation;

        return $this;
    }

    /**
     * Get groups
     *
     * @return Group[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getGroups(): ?array
    {
        return $this->groups;
    }

    /**
     * Set groups
     *
     * @param Group[]|null $groups
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setGroups(?array $groups): CurrentStatusResponseShipment
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * Get product code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getProductCode(): ?string
    {
        return $this->productCode;
    }

    /**
     * Set product code
     *
     * @param string|null $productCode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setProductCode(?string $productCode): CurrentStatusResponseShipment
    {
        $this->productCode = $productCode;

        return $this;
    }

    /**
     * Get product options
     *
     * @return ProductOption[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getProductOptions(): ?array
    {
        return $this->productOptions;
    }

    /**
     * Set product options
     *
     * @param ProductOption[]|null $productOptions
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setProductOptions(?array $productOptions): CurrentStatusResponseShipment
    {
        $this->productOptions = $productOptions;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * Set reference
     *
     * @param string|null $reference
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setReference(?string $reference): CurrentStatusResponseShipment
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get status
     *
     * @return Status|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getStatus(): ?Status
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param Status|null $status
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setStatus(?Status $status): CurrentStatusResponseShipment
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get warnings
     *
     * @return Warning[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getWarnings(): ?array
    {
        return $this->warnings;
    }

    /**
     * Set warnings
     *
     * @param Warning[]|null $warnings
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setWarnings(?array $warnings): CurrentStatusResponseShipment
    {
        $this->warnings = $warnings;

        return $this;
    }
}
