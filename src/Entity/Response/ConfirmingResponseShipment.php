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
use Firstred\PostNL\Entity\Error;
use Firstred\PostNL\Entity\Warning;
use TypeError;

/**
 * Class ConfirmingResponseShipment
 */
class ConfirmingResponseShipment extends AbstractEntity
{
    /**
     * @var string|null $barcode
     *
     * @since 1.0.0
     */
    protected $barcode;

    /**
     * @var Warning[]|null $warnings
     *
     * @since 1.0.0
     */
    protected $warnings;

    /**
     * @var Error[]|null
     *
     * @since 1.0.0
     */
    protected $errors;

    /**
     * ConfirmingResponseShipment constructor.
     *
     * @param string|null    $barcode
     * @param Warning[]|null $warnings
     * @param Error[]|null   $errors
     *
     * @throws TypeError
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
     * Get barcode
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   GenerateBarcodeRequest
     */
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * Set barcode
     *
     * @pattern N/A
     *
     * @param string|null $barcode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example N/A
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     GenerateBarcodeRequest
     */
    public function setBarcode(?string $barcode): ConfirmingResponseShipment
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get warnings
     *
     * @return Warning[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Warning
     */
    public function getWarnings(): ?array
    {
        return $this->warnings;
    }

    /**
     * Set warnings
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param Warning[]|null $warnings
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Warning
     */
    public function setWarnings(?array $warnings): ConfirmingResponseShipment
    {
        $this->warnings = $warnings;

        return $this;
    }

    /**
     * Get errors
     *
     * @return Error[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Error
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Set errors
     *
     * @param Error[]|null $errors
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Error
     */
    public function setErrors(?array $errors): ConfirmingResponseShipment
    {
        $this->errors = $errors;

        return $this;
    }
}
