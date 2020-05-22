<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\ValidateAndFix;

/**
 * Class RetrieveShipmentByKgidRequest
 */
class RetrieveShipmentByKgidRequest extends AbstractEntity
{
    /**
     * Kennisgeving ID
     *
     * @pattern ^.{0,35}$
     *
     * @example KG112233
     *
     * @var string|null $kgid
     *
     * @since   2.0.0
     */
    protected $kgid;

    /**
     * Detail
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var bool|null $detail
     *
     * @since   2.0.0
     */
    protected $detail;

    /**
     * Language
     *
     * @pattern ^[A-Z]{2}$
     *
     * @example NL
     *
     * @var string|null $language
     *
     * @since   2.0.0
     */
    protected $language;

    /**
     * Max amount of days
     *
     * @pattern ^\d{1,10}$
     *
     * @example 1
     *
     * @var int|null $maxDays
     *
     * @since   2.0.0
     */
    protected $maxDays;

    /**
     * RetrieveShipmentByKgidRequest constructor.
     *
     * @param string|null           $kgid
     * @param bool|null             $detail
     * @param string|null           $language
     * @param int|string|float|null $maxDays
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $kgid = null, ?bool $detail = null, ?string $language = null, $maxDays = null)
    {
        parent::__construct();

        $this->setKgid($kgid);
        $this->setDetail($detail);
        $this->setLanguage($language);
        $this->setMaxDays($maxDays);
    }

    /**
     * Get kennisgeving ID
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     *
     * @see   RetrieveShipmentByKgidRequest::$kgid
     */
    public function getKgid(): ?string
    {
        return $this->kgid;
    }

    /**
     * Set kennisgeving ID
     *
     * @pattern ^.{0,35}$
     *
     * @example 112233
     *
     * @param string|null $kgid
     *
     * @return static
     *
     * @since   2.0.0 Strict typing
     *
     * @see     RetrieveShipmentByKgidRequest::$kgid
     */
    public function setKgid(?string $kgid): RetrieveShipmentByKgidRequest
    {
        $this->kgid = $kgid;

        return $this;
    }

    /**
     * Get detail
     *
     * @return bool|null
     *
     * @since 2.0.0 Strict typing
     *
     * @see   RetrieveShipmentByKgidRequest::$detail
     */
    public function getDetail(): ?bool
    {
        return $this->detail;
    }

    /**
     * Set detail
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param bool|null $detail
     *
     * @return static
     *
     * @since   2.0.0 Strict typing
     *
     * @see     RetrieveShipmentByKgidRequest::$detail
     */
    public function setDetail(?bool $detail): RetrieveShipmentByKgidRequest
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get language
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     *
     * @see   RetrieveShipmentByKgidRequest::$language
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * Set language
     *
     * @pattern ^[A-Z]{2}$
     *
     * @example NL
     *
     * @param string|null $language
     *
     * @return static
     *
     * @since   2.0.0 Strict typing
     *
     * @see     RetrieveShipmentByKgidRequest::$language
     */
    public function setLanguage(?string $language): RetrieveShipmentByKgidRequest
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get max days
     *
     * @return int|null
     *
     * @since 2.0.0 Strict typing
     *
     * @see   RetrieveShipmentByKgidRequest::$maxDays
     */
    public function getMaxDays(): ?int
    {
        return $this->maxDays;
    }

    /**
     * Set max days
     *
     * @pattern ^\d{1,10}$
     *
     * @example 1
     *
     * @param int|string|float|null $maxDays
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0 Strict typing
     *
     * @see     RetrieveShipmentByKgidRequest::$maxDays
     */
    public function setMaxDays($maxDays): RetrieveShipmentByKgidRequest
    {
        $this->maxDays = ValidateAndFix::integer($maxDays);

        return $this;
    }
}
