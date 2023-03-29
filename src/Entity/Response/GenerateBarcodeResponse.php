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

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Attribute\SerializableScalarProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * @since 1.0.0
 */
class GenerateBarcodeResponse extends AbstractEntity
{
    /** @var string|null $Barcode */
    #[SerializableScalarProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Barcode = null;

    /**
     * @param string|null $Barcode
     */
    public function __construct(?string $Barcode = null)
    {
        parent::__construct();

        $this->setBarcode(Barcode: $Barcode);
    }

    /**
     * @return string|null
     */
    public function getBarcode(): ?string
    {
        return $this->Barcode;
    }

    /**
     * @param string|null $Barcode
     *
     * @return static
     */
    public function setBarcode(?string $Barcode): static
    {
        $this->Barcode = $Barcode;

        return $this;
    }
}
