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

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * @since 1.0.0
 */
class Content extends AbstractEntity
{
    /** @var string|null $CountryOfOrigin */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $CountryOfOrigin = null;

    /** @var string|null $Description */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Description = null;

    /** @var string|null $HSTariffNr */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $HSTariffNr = null;

    /** @var string|null $Quantity */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Quantity = null;

    /** @var string|null $Value */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Value = null;

    /** @var string|null $Weight */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Weight = null;

    /** @var Content[]|null $Content */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: Content::class, isArray: true)]
    protected ?array $Content = null;

    /**
     * @param string|null $CountryOfOrigin
     * @param string|null $Description
     * @param string|null $HSTariffNr
     * @param string|null $Quantity
     * @param string|null $Value
     * @param string|null $Weight
     * @param array|null  $Content
     */
    public function __construct(
        ?string $CountryOfOrigin = null,
        ?string $Description = null,
        ?string $HSTariffNr = null,
        ?string $Quantity = null,
        ?string $Value = null,
        ?string $Weight = null,
        ?array  $Content = null
    ) {
        parent::__construct();

        $this->setCountryOfOrigin(CountryOfOrigin: $CountryOfOrigin);
        $this->setDescription(Description: $Description);
        $this->setHSTariffNr(HSTariffNr: $HSTariffNr);
        $this->setQuantity(Quantity: $Quantity);
        $this->setValue(Value: $Value);
        $this->setWeight(Weight: $Weight);
        $this->setContent(Content: $Content);
    }

    /**
     * @return string|null
     */
    public function getCountryOfOrigin(): ?string
    {
        return $this->CountryOfOrigin;
    }

    /**
     * @param string|null $CountryOfOrigin
     *
     * @return static
     */
    public function setCountryOfOrigin(?string $CountryOfOrigin): static
    {
        $this->CountryOfOrigin = $CountryOfOrigin;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->Description;
    }

    /**
     * @param string|null $Description
     *
     * @return static
     */
    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHSTariffNr(): ?string
    {
        return $this->HSTariffNr;
    }

    /**
     * @param string|null $HSTariffNr
     *
     * @return static
     */
    public function setHSTariffNr(?string $HSTariffNr): static
    {
        $this->HSTariffNr = $HSTariffNr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getQuantity(): ?string
    {
        return $this->Quantity;
    }

    /**
     * @param string|null $Quantity
     *
     * @return static
     */
    public function setQuantity(?string $Quantity): static
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->Value;
    }

    /**
     * @param string|null $Value
     *
     * @return static
     */
    public function setValue(?string $Value): static
    {
        $this->Value = $Value;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWeight(): ?string
    {
        return $this->Weight;
    }

    /**
     * @param string|null $Weight
     *
     * @return static
     */
    public function setWeight(?string $Weight): static
    {
        $this->Weight = $Weight;

        return $this;
    }

    /**
     * @return Content|null
     */
    public function getContent(): ?array
    {
        return $this->Content;
    }

    /**
     * @param array|null $Content
     *
     * @return static
     */
    public function setContent(?array $Content): static
    {
        $this->Content = $Content;

        return $this;
    }
}
