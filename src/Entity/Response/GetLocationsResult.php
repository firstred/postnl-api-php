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

use Firstred\PostNL\Attribute\SerializableEntityArrayProperty;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\ServiceNotSetException;
use Sabre\Xml\Writer;

/**
 * @since 1.0.0
 */
class GetLocationsResult extends AbstractEntity
{
    /** @var ResponseLocation[]|null $ResponseLocation */
    #[SerializableEntityArrayProperty(namespace: SoapNamespace::Domain, entityFqcn: ResponseLocation::class)]
    protected ?array $ResponseLocation = null;

    /**
     * @param array|null $ResponseLocation
     */
    public function __construct(
        /** @param ResponseLocation[]|null $ResponseLocation */
        ?array $ResponseLocation = null,
    ) {
        parent::__construct();

        $this->setResponseLocation(ResponseLocation: $ResponseLocation);
    }

    /**
     * @return ResponseLocation[]|null
     */
    public function getResponseLocation(): ?array
    {
        return $this->ResponseLocation;
    }

    /**
     * @param ResponseLocation[]|null $ResponseLocation
     *
     * @return static
     */
    public function setResponseLocation(?array $ResponseLocation): static
    {
        if (is_array(value: $ResponseLocation)) {
            foreach ($ResponseLocation as $location) {
                if (!$location instanceof ResponseLocation) {
                    throw new \TypeError(message: 'Expected instance of `ResponseLocation`');
                }
            }
        }

        $this->ResponseLocation = $ResponseLocation;

        return $this;
    }

    /**
     * @param Writer $writer
     *
     * @return void
     */
    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        if (!isset($this->currentService)) {
            throw new ServiceNotSetException(message: 'Service not set before serialization');
        }

        foreach ($this->getSerializableProperties() as $propertyName => $namespace) {
            if (!isset($this->$propertyName)) {
                continue;
            }

            if ('ResponseLocation' === $propertyName) {
                $locations = [];
                foreach ($this->ResponseLocation as $location) {
                    $locations[] = $location;
                }
                $xml["{{$namespace}}ResponseLocation"] = $locations;
            } else {
                $xml["{{$namespace}}{$propertyName}"] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write(value: $xml);
    }
}
