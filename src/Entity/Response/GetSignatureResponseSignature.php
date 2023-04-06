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
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * @since 1.0.0
 */
class GetSignatureResponseSignature extends AbstractEntity
{
    /** @var string|null $Barcode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Barcode = null;

    /** @var DateTimeInterface|null $SignatureDate */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: DateTimeInterface::class)]
    protected ?DateTimeInterface $SignatureDate = null;

    /** @var string|null $SignatureImage */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $SignatureImage = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string $Barcode = null,
        ?string $SignatureDate = null,
        ?string $SignatureImage = null,
    ) {
        parent::__construct();

        $this->setBarcode(Barcode: $Barcode);
        $this->setSignatureDate(SignatureDate: $SignatureDate);
        $this->setSignatureImage(SignatureImage: $SignatureImage);
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
    public function getSignatureImage(): ?string
    {
        return $this->SignatureImage;
    }

    /**
     * @param string|null $SignatureImage
     *
     * @return static
     */
    public function setSignatureImage(?string $SignatureImage): static
    {
        $this->SignatureImage = $SignatureImage;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getSignatureDate(): ?DateTimeInterface
    {
        return $this->SignatureDate;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setSignatureDate(string|DateTimeInterface|null $SignatureDate = null): static
    {
        if (is_string(value: $SignatureDate)) {
            try {
                $SignatureDate = new DateTimeImmutable(datetime: $SignatureDate, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->SignatureDate = $SignatureDate;

        return $this;
    }
}
