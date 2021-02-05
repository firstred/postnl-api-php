<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Signature.
 */
class Signature extends SerializableObject
{
    /**
     * Signature constructor.
     *
     * @param string                             $service
     * @param string                             $propType
     * @param GetSignatureResponseSignature|null $GetSignatureResponseSignature
     * @param array|null                         $Warnings
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        protected GetSignatureResponseSignature|null $GetSignatureResponseSignature = null,
        protected array|null $Warnings = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

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
     * @return $this
     */
    public function setGetSignatureResponseSignature(?GetSignatureResponseSignature $GetSignatureResponseSignature = null): static
    {
        $this->GetSignatureResponseSignature = $GetSignatureResponseSignature;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getWarnings(): array|null
    {
        return $this->Warnings;
    }

    /**
     * @param array|null $Warnings
     *
     * @return $this
     */
    public function setWarnings(array|null $Warnings = null): static
    {
        $this->Warnings = $Warnings;

        return $this;
    }
}
