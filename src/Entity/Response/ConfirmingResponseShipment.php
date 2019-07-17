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

use Error;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Warning;

/**
 * Class ConfirmingResponseShipment
 */
class ConfirmingResponseShipment extends AbstractEntity
{
    /** @var string|null $barcode */
    protected $barcode;
    /** @var Warning[]|null $warnings */
    protected $warnings;
    /** @var Error[]|null */
    protected $errors;

    /**
     * @param string|null    $barcode
     * @param Warning[]|null $warnings
     * @param Error[]|null   $errors
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $barcode = null, ?array $warnings = null, ?array $errors = null)
    {
        parent::__construct();

        $this->setBarcode($barcode);
        $this->setWarnings($warnings);
        $this->setErrors($errors);
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
    public function setBarcode(?string $barcode): ConfirmingResponseShipment
    {
        $this->barcode = $barcode;

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
    public function setWarnings(?array $warnings): ConfirmingResponseShipment
    {
        $this->warnings = $warnings;

        return $this;
    }

    /**
     * @return Error[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * @param Error[]|null $errors
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setErrors(?array $errors): ConfirmingResponseShipment
    {
        $this->errors = $errors;

        return $this;
    }
}
