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
use Firstred\PostNL\Entity\Message;
use Firstred\PostNL\Exception\InvalidTypeException;
use ReflectionClass;
use ReflectionException;
use TypeError;

/**
 * Class GetDeliveryDate
 *
 * This class is both the container and can be the actual GetDeliveryDate object itself!
 */
class GetDeliveryDate extends AbstractEntity
{
    /**
     * Allow Sunday sorting
     *
     * @var bool|null $allowSundaySorting
     *
     * @since 1.0.0
     */
    protected $allowSundaySorting;

    /**
     * City
     *
     * @pattern
     *
     * @example
     *
     * @var string|null $city
     *
     * @since 1.0.0
     */
    protected $city;

    /**
     * Country code
     *
     * @pattern ^.[A-Z]{2}$
     *
     * @example
     *
     * @var string|null $countryCode
     *
     * @since 1.0.0
     */
    protected $countryCode;

    /**
     * Cut-off times
     *
     * @var CutOffTime[]|null $cutOffTimes
     *
     * @since 1.0.0
     */
    protected $cutOffTimes;

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
     * @var string|null $originCountryCode
     *
     * @since 1.0.0
     */
    protected $originCountryCode;

    /**
     * @var string|null $postalCode
     *
     * @since 1.0.0
     */
    protected $postalCode;

    /**
     * @var string|null $ShippingDate
     *
     * @since 1.0.0
     */
    protected $shippingDate;

    /**
     * @var int|null $shippingDuration
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
     * @var GetDeliveryDate|null $getDeliveryDate
     *
     * @since 1.0.0
     */
    protected $getDeliveryDate;

    /**
     * @var Message|null $message
     *
     * @since 1.0.0
     */
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
     * @throws ReflectionException
     * @throws TypeError
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
     * Get zip / postal code
     *
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
     * Set the zip / postcode
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
     * Get allow sunday sorting status
     *
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
     * Set allow sunday sorting status
     *
     * @param bool|null $allowSundaySorting
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setAllowSundaySorting(?bool $allowSundaySorting = null): GetDeliveryDate
    {
        $this->allowSundaySorting = $allowSundaySorting;

        return $this;
    }

    /**
     * Get city
     *
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
     * Set city
     *
     * @param string|null $city
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setCity(?string $city): GetDeliveryDate
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
     * Set country code
     *
     * @param string|null $countryCode
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setCountryCode(?string $countryCode): GetDeliveryDate
    {
        static $length = 2;
        if (is_string($countryCode) && mb_strlen($countryCode) !== $length) {
            throw new InvalidTypeException(sprintf('%s::%s - Invalid country code given, must be exactly %d characters long', (new ReflectionClass($this))->getShortName(), __METHOD__, $length));
        }

        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get cut-off times
     *
     * @return CutOffTime[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see CutOffTime
     */
    public function getCutOffTimes(): ?array
    {
        return $this->cutOffTimes;
    }

    /**
     * Set cut-off times
     *
     * @param CutOffTime[]|null $cutOffTimes
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see CutOffTime
     */
    public function setCutOffTimes(?array $cutOffTimes): GetDeliveryDate
    {
        $this->cutOffTimes = $cutOffTimes;

        return $this;
    }

    /**
     * Get house number
     *
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
     * Set house number
     *
     * @param string|null $houseNr
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setHouseNr(?string $houseNr): GetDeliveryDate
    {
        $this->houseNr = $houseNr;

        return $this;
    }

    /**
     * Get house number extension
     *
     * Get house number extension
     *
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
     * Set house number extension
     *
     * @param string|null $houseNrExt
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setHouseNrExt(?string $houseNrExt): GetDeliveryDate
    {
        $this->houseNrExt = $houseNrExt;

        return $this;
    }

    /**
     * Get options
     *
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
     * Set options
     *
     * @param string[]|null $options
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setOptions(?array $options): GetDeliveryDate
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get origin country code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getOriginCountryCode(): ?string
    {
        return $this->originCountryCode;
    }

    /**
     * Set origin country code
     *
     * @param string|null $originCountryCode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setOriginCountryCode(?string $originCountryCode): GetDeliveryDate
    {
        $this->originCountryCode = $originCountryCode;

        return $this;
    }

    /**
     * Get shipping date
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getShippingDate(): ?string
    {
        return $this->shippingDate;
    }

    /**
     * Set shipping date
     *
     * @param string|null $shippingDate
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setShippingDate(?string $shippingDate): GetDeliveryDate
    {
        $this->shippingDate = $shippingDate;

        return $this;
    }

    /**
     * Get shipping duration
     *
     * @return int|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getShippingDuration(): ?int
    {
        return $this->shippingDuration;
    }

    /**
     * Set shipping duration
     *
     * @param int|null $shippingDuration
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setShippingDuration(?int $shippingDuration): GetDeliveryDate
    {
        $this->shippingDuration = $shippingDuration;

        return $this;
    }

    /**
     * Get street
     *
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
     * Set street
     *
     * @param string|null $street
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setStreet(?string $street): GetDeliveryDate
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get GetDeliveryDate
     *
     * @return GetDeliveryDate|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getGetDeliveryDate(): ?GetDeliveryDate
    {
        return $this->getDeliveryDate;
    }

    /**
     * Set GetDeliveryDate
     *
     * @param GetDeliveryDate|null $getDeliveryDate
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setGetDeliveryDate(?GetDeliveryDate $getDeliveryDate): GetDeliveryDate
    {
        $this->getDeliveryDate = $getDeliveryDate;

        return $this;
    }

    /**
     * Get message
     *
     * @return Message|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getMessage(): ?Message
    {
        return $this->message;
    }

    /**
     * Set message
     *
     * @param Message|null $message
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setMessage(?Message $message): GetDeliveryDate
    {
        $this->message = $message;

        return $this;
    }
}
