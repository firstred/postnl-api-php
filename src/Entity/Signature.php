<?php
declare(strict_types=1);
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\SerializableEntityArrayProperty;
use Firstred\PostNL\Attribute\SerializableEntityProperty;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * @since 1.0.0
 */
class Signature extends AbstractEntity
{
    /** @var GetSignatureResponseSignature|null $GetSignatureResponseSignature */
    #[SerializableEntityProperty(namespace: SoapNamespace::Domain)]
    protected ?GetSignatureResponseSignature $GetSignatureResponseSignature = null;

    /** @var Warning[]|null $Warnings */
    #[SerializableEntityArrayProperty(namespace: SoapNamespace::Domain, entityFqcn: Warning::class)]
    protected ?array $Warnings = null;

    /**
     * @param GetSignatureResponseSignature|null $GetSignatureResponseSignature
     * @param array|null                         $Warnings
     */
    public function __construct(
        ?GetSignatureResponseSignature $GetSignatureResponseSignature = null,
        /** @param Warning[]|null $Warnings */
        ?array                         $Warnings = null
    ) {
        parent::__construct();

        $this->setGetSignatureResponseSignature(GetSignatureResponseSignature: $GetSignatureResponseSignature);
        $this->setWarnings(Warnings: $Warnings);
    }

    /**
     * @return GetSignatureResponseSignature|null
     */
    public function getGetSignatureResponseSignature(): ?GetSignatureResponseSignature
    {
        return $this->GetSignatureResponseSignature;
    }

    /**
     * @param GetSignatureResponseSignature|null $GetSignatureResponseSignature
     *
     * @return static
     */
    public function setGetSignatureResponseSignature(?GetSignatureResponseSignature $GetSignatureResponseSignature): static
    {
        $this->GetSignatureResponseSignature = $GetSignatureResponseSignature;

        return $this;
    }

    /**
     * @return Warning|null
     */
    public function getWarnings(): ?array
    {
        return $this->Warnings;
    }

    /**
     * @param Warning[]|null $Warnings
     *
     * @return static
     */
    public function setWarnings(?array $Warnings): static
    {
        $this->Warnings = $Warnings;

        return $this;
    }
}
