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

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;
use function is_string;

/**
 * @since 1.0.0
 */
class Expectation extends AbstractEntity
{
    /** @var DateTimeInterface|null $ETAFrom */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $ETAFrom = null;

    /** @var DateTimeInterface|null $ETATo */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $ETATo = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        DateTimeInterface|string|null $ETAFrom = null,
        DateTimeInterface|string|null $ETATo = null,
    ) {
        parent::__construct();

        $this->setETAFrom(ETAFrom: $ETAFrom);
        $this->setETATo(ETATo: $ETATo);
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setETAFrom(DateTimeInterface|string|null $ETAFrom = null): static
    {
        if (is_string(value: $ETAFrom)) {
            try {
                $ETAFrom = new DateTimeImmutable(datetime: $ETAFrom, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->ETAFrom = $ETAFrom;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setETATo(DateTimeInterface|string|null $ETATo = null): static
    {
        if (is_string(value: $ETATo)) {
            try {
                $ETATo = new DateTimeImmutable(datetime: $ETATo, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->ETATo = $ETATo;

        return $this;
    }
}
