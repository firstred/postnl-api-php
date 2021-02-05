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
 * Class ResponseShipment
 */
class ResponseShipment extends SerializableObject
{
    /**
     * @var null|string
     */
    protected string|null $Barcode = null;
    /**
     * @var null|string
     */
    protected string|null $DownPartnerBarcode = null;
    /**
     * @var null|string
     */
    protected string|null $DownPartnerID = null;
    /**
     * @var null|string
     */
    protected string|null $DownPartnerLocation = null;
    /**
     * @var null|mixed[]
     */
    protected array|null $Labels = null;
    /**
     * @var null|string
     */
    protected string|null $ProductCodeDelivery = null;
    /**
     * @var null|mixed[]
     */
    protected array|null $Warnings = null;

    /**
     * ResponseShipment constructor.
     *
     * @param string      $service
     * @param string      $propType
     * @param string|null $barcode
     * @param string|null $productCodeDelivery
     * @param array|null  $labels
     * @param string|null $downPartnerBarcode
     * @param string|null $downPartnerId
     * @param string|null $downPartnerLocation
     * @param array|null  $warnings
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType,

        string|null $barcode = null,
        string|null $productCodeDelivery = null,
        array|null $labels = null,
        string|null $downPartnerBarcode = null,
        string|null $downPartnerId = null,
        string|null $downPartnerLocation = null,
        array|null $warnings = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setBarcode(barcode: $barcode);
        $this->setProductCodeDelivery(productCodeDelivery: $productCodeDelivery);
        $this->setDownPartnerBarcode(downPartnerBarcode: $downPartnerBarcode);
        $this->setDownPartnerId(downPartnerID: $downPartnerId);
        $this->setDownPartnerLocation(downPartnerLocation: $downPartnerLocation);
        $this->setLabels(labels: $labels);
        $this->setWarnings(warnings: $warnings);
    }

    /**
     * @return string|null
     */
    public function getBarcode(): string|null
    {
        return $this->Barcode;
    }

    /**
     * @param string|null $barcode
     *
     * @return static
     */
    public function setBarcode(string|null $barcode = null): static
    {
        $this->Barcode = $barcode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDownPartnerBarcode(): string|null
    {
        return $this->DownPartnerBarcode;
    }

    /**
     * @param string|null $downPartnerBarcode
     *
     * @return static
     */
    public function setDownPartnerBarcode(string|null $downPartnerBarcode = null): static
    {
        $this->DownPartnerBarcode = $downPartnerBarcode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDownPartnerID(): string|null
    {
        return $this->DownPartnerID;
    }

    /**
     * @param string|null $downPartnerID
     *
     * @return static
     */
    public function setDownPartnerID(string|null $downPartnerID = null): static
    {
        $this->DownPartnerID = $downPartnerID;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDownPartnerLocation(): string|null
    {
        return $this->DownPartnerLocation;
    }

    /**
     * @param string|null $downPartnerLocation
     *
     * @return static
     */
    public function setDownPartnerLocation(string|null $downPartnerLocation = null): static
    {
        $this->DownPartnerLocation = $downPartnerLocation;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getLabels(): array|null
    {
        return $this->Labels;
    }

    /**
     * @param array|null $labels
     *
     * @return static
     */
    public function setLabels(array|null $labels = null): static
    {
        $this->Labels = $labels;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductCodeDelivery(): string|null
    {
        return $this->ProductCodeDelivery;
    }

    /**
     * @param string|null $productCodeDelivery
     *
     * @return static
     */
    public function setProductCodeDelivery(string|null $productCodeDelivery = null): static
    {
        $this->ProductCodeDelivery = $productCodeDelivery;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getWarnings(): array|null
    {
        return $this->Warnings;
    }

    /**
     * @param array|null $warnings
     *
     * @return static
     */
    public function setWarnings(array|null $warnings = null): static
    {
        $this->Warnings = $warnings;

        return $this;
    }
}
