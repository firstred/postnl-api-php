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

use Firstred\PostNL\Attribute\SerializableEntityProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\ServiceNotSetException;

/**
 * @since 1.0.0
 */
class GetLocationsInAreaResponse extends AbstractEntity
{
    /** @var GetLocationsResult|null $GetLocationsResult */
    #[SerializableEntityProperty(namespace: SoapNamespace::Domain)]
    protected ?GetLocationsResult $GetLocationsResult = null;

    /**
     * @param GetLocationsResult|null $GetLocationsResult
     */
    public function __construct(
        /** @param GetLocationsResult|null $GetLocationsResult */
        GetLocationsResult $GetLocationsResult = null,
    ) {
        parent::__construct();

        $this->setGetLocationsResult(GetLocationsResult: $GetLocationsResult);
    }

    /**
     * @return GetLocationsResult|null
     */
    public function getGetLocationsResult(): ?GetLocationsResult
    {
        return $this->GetLocationsResult;
    }

    /**
     * @param GetLocationsResult|null $GetLocationsResult
     *
     * @return static
     */
    public function setGetLocationsResult(?GetLocationsResult $GetLocationsResult): static
    {
        $this->GetLocationsResult = $GetLocationsResult;

        return $this;
    }

    /**
     * @return array
     * @throws ServiceNotSetException
     */
    public function jsonSerialize(): array
    {
        $json = [];
        if (!isset($this->currentService)) {
            throw new ServiceNotSetException(message: 'Service not set before serialization');
        }

        foreach (array_keys(array: $this->getSerializableProperties()) as $propertyName) {
            if (!isset($this->$propertyName)) {
                continue;
            }

            if ('GetLocationsResult' === $propertyName) {
                $locations = [];
                foreach ($this->GetLocationsResult as $location) {
                    $locations[] = $location;
                }
                $json[$propertyName] = ['ResponseLocation' => $locations];
            } else {
                $json[$propertyName] = $this->$propertyName;
            }
        }

        return $json;
    }
}
