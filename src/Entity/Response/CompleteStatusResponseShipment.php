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
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Dimension;
use Firstred\PostNL\Entity\Expectation;
use Firstred\PostNL\Entity\Group;
use Firstred\PostNL\Entity\ProductOption;
use Firstred\PostNL\Entity\Status;
use Firstred\PostNL\Entity\Warning;
use TypeError;

/**
 * Class CompleteStatusResponseShipment
 */
class CompleteStatusResponseShipment extends AbstractEntity
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
     * @var Barcode|null $barcode
     *
     * @since 1.0.0
     */
    protected $barcode;

    /**
     * @var Customer|null $customer
     *
     * @since 1.0.0
     */
    protected $customer;

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
     * @var CompleteStatusResponseEvent[]|null $events
     *
     * @since 1.0.0
     */
    protected $events;

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
     * @var CompleteStatusResponseOldStatus[]|null $oldStatuses
     *
     * @since 1.0.0
     */
    protected $oldStatuses;

    /**
     * @var string|null $productCode
     *
     * @since 1.0.0
     */
    protected $productCode;

    /**
     * @var ProductOption[]|null $productOptions
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
     * CompleteStatusResponseShipment constructor.
     *
     * @param Address[]|null                    $addresses
     * @param Amount[]|null                     $amounts
     * @param Barcode|null                      $barcode
     * @param Customer|null                     $customer
     * @param string|null                       $deliveryDate
     * @param Dimension|null                    $dimension
     * @param array|null                        $events
     * @param Expectation|null                  $expectation
     * @param Group[]|null                      $groups
     * @param CompleteStatusResponseOldStatus[] $oldStatuses
     * @param string|null                       $productCode
     * @param ProductOption[]|null              $productOptions
     * @param string|null                       $reference
     * @param Status|null                       $status
     * @param Warning[]|null                    $warnings
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(array $addresses = null, array $amounts = null, ?Barcode $barcode = null, ?Customer $customer = null, ?string $deliveryDate = null, ?Dimension $dimension = null, array $events = null, ?Expectation $expectation = null, array $groups = null, array $oldStatuses = null, ?string $productCode = null, array $productOptions = null, ?string $reference = null, ?Status $status = null, array $warnings = null)
    {
        parent::__construct();

        $this->setAddresses($addresses);
        $this->setAmounts($amounts);
        $this->setBarcode($barcode);
        $this->setCustomer($customer);
        $this->setDeliveryDate($deliveryDate);
        $this->setDimension($dimension);
        $this->setEvents($events);
        $this->setExpectation($expectation);
        $this->setGroups($groups);
        $this->setOldStatuses($oldStatuses);
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
    public function setAddresses(?array $addresses): CompleteStatusResponseShipment
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
    public function setAmounts(?array $amounts): CompleteStatusResponseShipment
    {
        $this->amounts = $amounts;

        return $this;
    }

    /**
     * Get barcode
     *
     * @return Barcode|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getBarcode(): ?Barcode
    {
        return $this->barcode;
    }

    /**
     * Set barcode
     *
     * @param Barcode|null $barcode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setBarcode(?Barcode $barcode): CompleteStatusResponseShipment
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get customer
     *
     * @return Customer|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * Set customer
     *
     * @param Customer|null $customer
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setCustomer(?Customer $customer): CompleteStatusResponseShipment
    {
        $this->customer = $customer;

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
    public function setDeliveryDate(?string $deliveryDate): CompleteStatusResponseShipment
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
    public function setDimension(?Dimension $dimension): CompleteStatusResponseShipment
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * Get events
     *
     * @return CompleteStatusResponseEvent[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getEvents(): ?array
    {
        return $this->events;
    }

    /**
     * Set events
     *
     * @param CompleteStatusResponseEvent[]|null $events
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setEvents(?array $events): CompleteStatusResponseShipment
    {
        $this->events = $events;

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
    public function setExpectation(?Expectation $expectation): CompleteStatusResponseShipment
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
     * @param Group[]|null $groups
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setGroups(?array $groups): CompleteStatusResponseShipment
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * Get old statuses
     *
     * @return CompleteStatusResponseOldStatus[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getOldStatuses(): ?array
    {
        return $this->oldStatuses;
    }

    /**
     * Set old statuses
     *
     * @param CompleteStatusResponseOldStatus[]|null $oldStatuses
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setOldStatuses(?array $oldStatuses): CompleteStatusResponseShipment
    {
        $this->oldStatuses = $oldStatuses;

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
    public function setProductCode(?string $productCode): CompleteStatusResponseShipment
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
    public function setProductOptions(?array $productOptions): CompleteStatusResponseShipment
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
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setReference(?string $reference): CompleteStatusResponseShipment
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
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setStatus(?Status $status): CompleteStatusResponseShipment
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
     * @param Warning[]|null $warnings
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setWarnings(?array $warnings): CompleteStatusResponseShipment
    {
        $this->warnings = $warnings;

        return $this;
    }
}
