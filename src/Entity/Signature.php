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

/**
 * Class Signature
 */
class Signature extends AbstractEntity
{
    /** @var GetSignatureResponseSignature|null $getSignatureResponseSignature */
    protected $getSignatureResponseSignature;
    /** @var Warning[]|null $warnings */
    protected $warnings;

    /**
     * Signature constructor.
     *
     * @param GetSignatureResponseSignature|null $signature
     * @param array|null                         $warnings
     *
     * @since 1.0.0
     */
    public function __construct(?GetSignatureResponseSignature $signature = null, ?array $warnings = null)
    {
        parent::__construct();

        $this->setGetSignatureResponseSignature($signature);
        $this->setWarnings($warnings);
    }

    /**
     * @return GetSignatureResponseSignature|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getGetSignatureResponseSignature(): ?GetSignatureResponseSignature
    {
        return $this->getSignatureResponseSignature;
    }

    /**
     * @param GetSignatureResponseSignature|null $getSignatureResponseSignature
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setGetSignatureResponseSignature(?GetSignatureResponseSignature $getSignatureResponseSignature): Signature
    {
        $this->getSignatureResponseSignature = $getSignatureResponseSignature;

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
    public function setWarnings(?array $warnings): Signature
    {
        $this->warnings = $warnings;

        return $this;
    }
}
