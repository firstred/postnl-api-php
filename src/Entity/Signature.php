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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use TypeError;

/**
 * Class Signature
 */
class Signature extends AbstractEntity
{
    /**
     * GetSignatureResponseSignature;
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var GetSignatureResponseSignature|null $getSignatureResponseSignature
     *
     * @since 1.0.0
     */
    protected $getSignatureResponseSignature;

    /**
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var Warning[]|null $warnings
     *
     * @since 1.0.0
     */
    protected $warnings;

    /**
     * Signature constructor.
     *
     * @param GetSignatureResponseSignature|null $signature
     * @param array|null                         $warnings
     *
     * @throws TypeError
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?GetSignatureResponseSignature $signature = null, ?array $warnings = null)
    {
        parent::__construct();

        $this->setGetSignatureResponseSignature($signature);
        $this->setWarnings($warnings);
    }

    /**
     * @pattern N/A
     *
     * @return GetSignatureResponseSignature|null
     *
     * @example N/A
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     GetSignatureResponseSignature
     */
    public function getGetSignatureResponseSignature(): ?GetSignatureResponseSignature
    {
        return $this->getSignatureResponseSignature;
    }

    /**
     * @pattern N/A
     *
     * @param GetSignatureResponseSignature|null $getSignatureResponseSignature
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
     * @see     GetSignatureResponseSignature
     */
    public function setGetSignatureResponseSignature(?GetSignatureResponseSignature $getSignatureResponseSignature): Signature
    {
        $this->getSignatureResponseSignature = $getSignatureResponseSignature;

        return $this;
    }

    /**
     * Get warnings
     *
     * @pattern N/A
     *
     * @return Warning[]|null
     *
     * @example N/A
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     Warning
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
     * @param Warning[]|null $warnings
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
     * @see     Warning
     */
    public function setWarnings(?array $warnings): Signature
    {
        $this->warnings = $warnings;

        return $this;
    }
}
