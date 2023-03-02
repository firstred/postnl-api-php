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

namespace Firstred\PostNL\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;
use function is_string;

/**
 * Class Expectation.
 *
 * @method DateTimeInterface|null getETAFrom()
 * @method DateTimeInterface|null getETATo()
 *
 * @since 1.0.0
 */
class Expectation extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'ETAFrom' => BarcodeService::DOMAIN_NAMESPACE,
            'ETATo'   => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'ETAFrom' => ConfirmingService::DOMAIN_NAMESPACE,
            'ETATo'   => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'ETAFrom' => LabellingService::DOMAIN_NAMESPACE,
            'ETATo'   => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'ETAFrom' => DeliveryDateService::DOMAIN_NAMESPACE,
            'ETATo'   => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'ETAFrom' => LocationService::DOMAIN_NAMESPACE,
            'ETATo'   => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'ETAFrom' => TimeframeService::DOMAIN_NAMESPACE,
            'ETATo'   => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var DateTimeInterface|null */
    protected $ETAFrom;
    /** @var DateTimeInterface|null */
    protected $ETATo;
    // @codingStandardsIgnoreEnd

    /**
     * @param DateTimeInterface|string|null $ETAFrom
     * @param DateTimeInterface|string|null $ETATo
     *
     * @throws InvalidArgumentException
     */
    public function __construct($ETAFrom = null, $ETATo = null)
    {
        parent::__construct();

        $this->setETAFrom($ETAFrom);
        $this->setETATo($ETATo);
    }

    /**
     * @param DateTimeInterface|string|null $ETAFrom
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setETAFrom($ETAFrom = null)
    {
        if (is_string($ETAFrom)) {
            try {
                $ETAFrom = new DateTimeImmutable($ETAFrom, new DateTimeZone('Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(),  0, $e);
            }
        }

        $this->ETAFrom = $ETAFrom;

        return $this;
    }

    /**
     * @param DateTimeInterface|string|null $ETATo
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setETATo($ETATo = null)
    {
        if (is_string($ETATo)) {
            try {
                $ETATo = new DateTimeImmutable($ETATo, new DateTimeZone('Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->ETATo = $ETATo;

        return $this;
    }
}
