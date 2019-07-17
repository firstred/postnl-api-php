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
use Firstred\PostNL\Entity\Label;
use Firstred\PostNL\Entity\Warning;

/**
 * Class ResponseShipment
 */
class ResponseShipment extends AbstractEntity
{
    /** @var string|null $barcode */
    protected $barcode;
    /** @var string|null $downPartnerBarcode */
    protected $downPartnerBarcode;
    /** @var string|null $downPartnerID */
    protected $downPartnerID;
    /** @var string|null $downPartnerLocation */
    protected $downPartnerLocation;
    /** @var Label[]|null $labels */
    protected $labels;
    /** @var string|null $productCodeDelivery */
    protected $productCodeDelivery;
    /** @var Warning[]|null $warnings */
    protected $warnings;

    /**
     * @param string|null  $barcode
     * @param string|null  $productCodeDelivery
     * @param Label[]|null $labels
     * @param string|null  $downPartnerBarcode
     * @param string|null  $downPartnerId
     * @param string|null  $downPartnerLocation
     * @param array|null   $warnings
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $barcode = null, ?string $productCodeDelivery = null, ?array $labels = null, ?string $downPartnerBarcode = null, ?string $downPartnerId = null, ?string $downPartnerLocation = null, ?array $warnings = null)
    {
        parent::__construct();

        $this->setBarcode($barcode);
        $this->setProductCodeDelivery($productCodeDelivery);
        $this->setDownPartnerBarcode($downPartnerBarcode);
        $this->setDownPartnerId($downPartnerId);
        $this->setDownPartnerLocation($downPartnerLocation);
        $this->setLabels($labels);
        $this->setWarnings($warnings);
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * @param string|null $barcode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setBarcode(?string $barcode): ResponseShipment
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDownPartnerBarcode(): ?string
    {
        return $this->downPartnerBarcode;
    }

    /**
     * @param string|null $downPartnerBarcode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDownPartnerBarcode(?string $downPartnerBarcode): ResponseShipment
    {
        $this->downPartnerBarcode = $downPartnerBarcode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDownPartnerID(): ?string
    {
        return $this->downPartnerID;
    }

    /**
     * @param string|null $downPartnerID
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDownPartnerID(?string $downPartnerID): ResponseShipment
    {
        $this->downPartnerID = $downPartnerID;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDownPartnerLocation(): ?string
    {
        return $this->downPartnerLocation;
    }

    /**
     * @param string|null $downPartnerLocation
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDownPartnerLocation(?string $downPartnerLocation): ResponseShipment
    {
        $this->downPartnerLocation = $downPartnerLocation;

        return $this;
    }

    /**
     * @return Label[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getLabels(): ?array
    {
        return $this->labels;
    }

    /**
     * @param Label[]|null $labels
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLabels(?array $labels): ResponseShipment
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getProductCodeDelivery(): ?string
    {
        return $this->productCodeDelivery;
    }

    /**
     * @param string|null $productCodeDelivery
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setProductCodeDelivery(?string $productCodeDelivery): ResponseShipment
    {
        $this->productCodeDelivery = $productCodeDelivery;

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
    public function setWarnings(?array $warnings): ResponseShipment
    {
        $this->warnings = $warnings;

        return $this;
    }
}
