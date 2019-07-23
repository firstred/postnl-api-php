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

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;
use TypeError;

/**
 * Class GetSentDate
 */
class GetSentDate extends AbstractEntity
{
    /**
     * @var bool|null $allowSundaySorting
     *
     * @since 1.0.0
     */
    protected $allowSundaySorting;

    /**
     * @var string|null $city
     *
     * @since 1.0.0
     */
    protected $city;

    /**
     * @var string|null $countryCode
     *
     * @since 1.0.0
     */
    protected $countryCode;

    /**
     * @var string|null $deliveryDate
     *
     * @since 1.0.0
     */
    protected $deliveryDate;

    /**
     * @var string|null $houseNr
     *
     * @since 1.0.0
     */
    protected $houseNr;

    /**
     * @var string|null $houseNrExt
     *
     * @since 1.0.0
     */
    protected $houseNrExt;

    /**
     * @var string[]|null $options
     *
     * @since 1.0.0
     */
    protected $options;

    /**
     * @var string|null $postalCode
     *
     * @since 1.0.0
     */
    protected $postalCode;

    /**
     * @var string|null $shippingDuration
     *
     * @since 1.0.0
     */
    protected $shippingDuration;

    /**
     * @var string|null $street
     *
     * @since 1.0.0
     */
    protected $street;

    /**
     * GetSentDate constructor.
     *
     * @param bool|null   $allowSundaySorting
     * @param string|null $city
     * @param string|null $countryCode
     * @param string|null $houseNr
     * @param string|null $houseNrExt
     * @param array|null  $options
     * @param string|null $postalCode
     * @param string|null $deliveryDate
     * @param string|null $street
     * @param string|null $shippingDuration
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?bool $allowSundaySorting = false, ?string $city = null, ?string $countryCode = null, ?string $houseNr = null, ?string $houseNrExt = null, ?array $options = null, ?string $postalCode = null, ?string $deliveryDate = null, ?string $street = null, ?string $shippingDuration = null)
    {
        parent::__construct();

        $this->setAllowSundaySorting($allowSundaySorting);
        $this->setCity($city);
        $this->setCountryCode($countryCode);
        $this->setHouseNr($houseNr);
        $this->setHouseNrExt($houseNrExt);
        $this->setOptions($options);
        $this->setPostalCode($postalCode);
        $this->setDeliveryDate($deliveryDate);
        $this->setStreet($street);
        $this->setShippingDuration($shippingDuration);
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Set the postcode
     *
     * @param string|null $postcode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setPostalCode($postcode = null): GetSentDate
    {
        if (is_null($postcode)) {
            $this->postalCode = null;
        } else {
            $this->postalCode = strtoupper(str_replace(' ', '', $postcode));
        }

        return $this;
    }

    /**
     * @return bool|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getAllowSundaySorting(): ?bool
    {
        return $this->allowSundaySorting;
    }

    /**
     * @param bool|null $allowSundaySorting
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setAllowSundaySorting(?bool $allowSundaySorting): GetSentDate
    {
        $this->allowSundaySorting = $allowSundaySorting;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setCity(?string $city): GetSentDate
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get country code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @param string|null $countryCode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setCountryCode(?string $countryCode): GetSentDate
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
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
     * @param string|null $deliveryDate
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setDeliveryDate(?string $deliveryDate): GetSentDate
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getHouseNr(): ?string
    {
        return $this->houseNr;
    }

    /**
     * @param string|null $houseNr
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setHouseNr(?string $houseNr): GetSentDate
    {
        $this->houseNr = $houseNr;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getHouseNrExt(): ?string
    {
        return $this->houseNrExt;
    }

    /**
     * @param string|null $houseNrExt
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setHouseNrExt(?string $houseNrExt): GetSentDate
    {
        $this->houseNrExt = $houseNrExt;

        return $this;
    }

    /**
     * @return string[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * @param string[]|null $options
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setOptions(?array $options): GetSentDate
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getShippingDuration(): ?string
    {
        return $this->shippingDuration;
    }

    /**
     * @param string|null $shippingDuration
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setShippingDuration(?string $shippingDuration): GetSentDate
    {
        $this->shippingDuration = $shippingDuration;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setStreet(?string $street): GetSentDate
    {
        $this->street = $street;

        return $this;
    }
}
