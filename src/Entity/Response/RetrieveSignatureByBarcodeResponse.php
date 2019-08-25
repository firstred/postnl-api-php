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

use Firstred\PostNL\Entity\Signature;

/**
 * Class RetrieveSignatureByBarcodeResponse
 */
class RetrieveSignatureByBarcodeResponse extends AbstractResponse
{
    /**
     * Signature
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var Signature|null $signature
     *
     * @since   1.0.0
     */
    protected $signature;

    /**
     * RetrieveSignatureByBarcodeResponse constructor.
     *
     * @param Signature|null $signature
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(Signature $signature = null)
    {
        parent::__construct();

        $this->setSignature($signature);
    }

    /**
     * Get signature
     *
     * @return Signature|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Signature
     */
    public function getSignature(): ?Signature
    {
        return $this->signature;
    }

    /**
     * Set signature
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param Signature|null $signature
     *
     * @return static
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Signature
     */
    public function setSignature(?Signature $signature): RetrieveSignatureByBarcodeResponse
    {
        $this->signature = $signature;

        return $this;
    }
}