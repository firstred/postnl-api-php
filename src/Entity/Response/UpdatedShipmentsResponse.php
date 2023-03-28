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

namespace Firstred\PostNL\Entity\Response;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Attribute\SerializableDateTimeProperty;
use Firstred\PostNL\Attribute\SerializableEntityProperty;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Attribute\SerializableScalarProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Status;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * @since 1.2.0
 */
class UpdatedShipmentsResponse extends AbstractEntity
{
    /** @var string|null $Barcode */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Barcode = null;

    /** @var DateTimeInterface|null $CreationDate */
    #[SerializableDateTimeProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $CreationDate = null;

    /** @var string|null $CustomerNumber */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CustomerNumber = null;

    /** @var string|null $CustomerCode */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CustomerCode = null;

    /** @var Status|null $Status */
    #[SerializableEntityProperty(namespace: SoapNamespace::Domain)]
    protected ?Status $Status = null;


    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string                       $Barcode = null,
        string|DateTimeInterface|null $CreationDate = null,
        ?string                       $CustomerNumber = null,
        ?string                       $CustomerCode = null,
        ?string                       $Status = null
    ) {
        parent::__construct();

        $this->setBarcode(Barcode: $Barcode);
        $this->setCreationDate(CreationDate: $CreationDate);
        $this->setCustomerNumber(CustomerNumber: $CustomerNumber);
        $this->setCustomerCode(CustomerCode: $CustomerCode);
        $this->setStatus(Status: $Status);
    }

    /**
     * @return string|null
     */
    public function getBarcode(): ?string
    {
        return $this->Barcode;
    }

    /**
     * @param string|null $Barcode
     *
     * @return static
     */
    public function setBarcode(?string $Barcode): static
    {
        $this->Barcode = $Barcode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerNumber(): ?string
    {
        return $this->CustomerNumber;
    }

    /**
     * @param string|null $CustomerNumber
     *
     * @return static
     */
    public function setCustomerNumber(?string $CustomerNumber): static
    {
        $this->CustomerNumber = $CustomerNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerCode(): ?string
    {
        return $this->CustomerCode;
    }

    /**
     * @param string|null $CustomerCode
     *
     * @return static
     */
    public function setCustomerCode(?string $CustomerCode): static
    {
        $this->CustomerCode = $CustomerCode;

        return $this;
    }

    /**
     * @return Status|null
     */
    public function getStatus(): ?Status
    {
        return $this->Status;
    }

    /**
     * @param Status|null $Status
     *
     * @return static
     */
    public function setStatus(?Status $Status): static
    {
        $this->Status = $Status;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreationDate(): ?DateTimeInterface
    {
        return $this->CreationDate;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setCreationDate(string|DateTimeInterface|null $CreationDate = null): static
    {
        if (is_string(value: $CreationDate)) {
            try {
                $CreationDate = new DateTimeImmutable(datetime: $CreationDate, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->CreationDate = $CreationDate;

        return $this;
    }
}
