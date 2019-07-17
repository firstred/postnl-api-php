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
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\Message\Message;

/**
 * Class GetDeliveryDate
 *
 * This class is both the container and can be the actual GetDeliveryDate object itself!
 */
class GetDeliveryDate extends AbstractEntity
{
    /** @var bool|null $allowSundaySorting */
    protected $allowSundaySorting;
    /** @var string|null $city */
    protected $city;
    /** @var string|null $countryCode */
    protected $countryCode;
    /** @var CutOffTime[]|null $cutOffTimes */
    protected $cutOffTimes;
    /** @var string|null $houseNr */
    protected $houseNr;
    /** @var string|null $houseNrExt */
    protected $houseNrExt;
    /** @var string[]|null $options */
    protected $options;
    /** @var string|null $originCountryCode */
    protected $originCountryCode;
    /** @var string|null $postalCode */
    protected $postalCode;
    /** @var string|null $ShippingDate */
    protected $shippingDate;
    /** @var int|null $shippingDuration */
    protected $shippingDuration;
    /** @var string|null $street */
    protected $street;
    /** @var GetDeliveryDate|null $getDeliveryDate */
    protected $getDeliveryDate;
    /** @var Message|null $message */
    protected $message;

    /**
     * GetDeliveryDate constructor.
     *
     * @param bool|null            $allowSundaySorting
     * @param string|null          $city
     * @param string|null          $countryCode
     * @param array|null           $cutOffTimes
     * @param string|null          $houseNr
     * @param string|null          $houseNrExt
     * @param array|null           $options
     * @param string|null          $originCountryCode
     * @param string|null          $postalCode
     * @param string|null          $shippingDate
     * @param string|null          $shippingDuration
     * @param string|null          $street
     * @param GetDeliveryDate|null $getDeliveryDate
     * @param Message|null         $message
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?bool $allowSundaySorting = null, ?string $city = null, ?string $countryCode = null, ?array $cutOffTimes = null, ?string $houseNr = null, ?string $houseNrExt = null, ?array $options = null, ?string $originCountryCode = null, ?string $postalCode = null, ?string $shippingDate = null, ?string $shippingDuration = null, ?string $street = null, ?GetDeliveryDate $getDeliveryDate = null, ?Message $message = null)
    {
        parent::__construct();

        $this->setAllowSundaySorting($allowSundaySorting);
        $this->setCity($city);
        $this->setCountryCode($countryCode);
        $this->setCutOffTimes($cutOffTimes);
        $this->setHouseNr($houseNr);
        $this->setHouseNrExt($houseNrExt);
        $this->setOptions($options);
        $this->setOriginCountryCode($originCountryCode);
        $this->setPostalCode($postalCode);
        $this->setShippingDate($shippingDate);
        $this->setShippingDuration($shippingDuration);
        $this->setStreet($street);
        $this->setGetDeliveryDate($getDeliveryDate);
        $this->setMessage($message);
    }

    /**
     * @return string|null
     *
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
     * @since 2.0.0 Strict typing
     */
    public function setPostalCode(?string $postcode = null): GetDeliveryDate
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
     * @since 2.0.0 Strict typing
     */
    public function setAllowSundaySorting(?bool $allowSundaySorting = null): GetDeliveryDate
    {
        $this->allowSundaySorting = $allowSundaySorting;

        return $this;
    }

    /**
     * @return string|null
     *
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
     * @since 2.0.0 Strict typing
     */
    public function setCity(?string $city): GetDeliveryDate
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     *
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
     * @since 2.0.0 Strict typing
     */
    public function setCountryCode(?string $countryCode): GetDeliveryDate
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * @return CutOffTime[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCutOffTimes(): ?array
    {
        return $this->cutOffTimes;
    }

    /**
     * @param CutOffTime[]|null $cutOffTimes
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCutOffTimes(?array $cutOffTimes): GetDeliveryDate
    {
        $this->cutOffTimes = $cutOffTimes;

        return $this;
    }

    /**
     * @return string|null
     *
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
     * @since 2.0.0 Strict typing
     */
    public function setHouseNr(?string $houseNr): GetDeliveryDate
    {
        $this->houseNr = $houseNr;

        return $this;
    }

    /**
     * @return string|null
     *
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
     * @since 2.0.0 Strict typing
     */
    public function setHouseNrExt(?string $houseNrExt): GetDeliveryDate
    {
        $this->houseNrExt = $houseNrExt;

        return $this;
    }

    /**
     * @return string[]|null
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
     * @since 2.0.0 Strict typing
     */
    public function setOptions(?array $options): GetDeliveryDate
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOriginCountryCode(): ?string
    {
        return $this->originCountryCode;
    }

    /**
     * @param string|null $originCountryCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setOriginCountryCode(?string $originCountryCode): GetDeliveryDate
    {
        $this->originCountryCode = $originCountryCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingDate(): ?string
    {
        return $this->shippingDate;
    }

    /**
     * @param string|null $shippingDate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setShippingDate(?string $shippingDate): GetDeliveryDate
    {
        $this->shippingDate = $shippingDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingDuration(): ?string
    {
        return $this->shippingDuration;
    }

    /**
     * @param int|null $shippingDuration
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setShippingDuration(?int $shippingDuration): GetDeliveryDate
    {
        $this->shippingDuration = $shippingDuration;

        return $this;
    }

    /**
     * @return string|null
     *
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
     * @since 2.0.0 Strict typing
     */
    public function setStreet(?string $street): GetDeliveryDate
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return GetDeliveryDate|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getGetDeliveryDate(): ?GetDeliveryDate
    {
        return $this->getDeliveryDate;
    }

    /**
     * @param GetDeliveryDate|null $getDeliveryDate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setGetDeliveryDate(?GetDeliveryDate $getDeliveryDate): GetDeliveryDate
    {
        $this->getDeliveryDate = $getDeliveryDate;

        return $this;
    }

    /**
     * @return Message|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getMessage(): ?Message
    {
        return $this->message;
    }

    /**
     * @param Message|null $message
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setMessage(?Message $message): GetDeliveryDate
    {
        $this->message = $message;

        return $this;
    }
}
