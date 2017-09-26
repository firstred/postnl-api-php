<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
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
 * @author    Michael Dekker <michael@thirtybees.com>
 * @copyright 2017 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Entity;

use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\LabellingService;

/**
 * Class Barcode
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string getType()
 * @method string getRange()
 * @method string getSerie()
 *
 * @method Barcode setType(string $type)
 * @method Barcode setRange(string $range)
 * @method Barcode setSerie(string $serie)
 */
class Barcode extends AbstractEntity
{
    /** @var string[] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'    => [
            'Type'  => BarcodeService::DOMAIN_NAMESPACE,
            'Range' => BarcodeService::DOMAIN_NAMESPACE,
            'Serie' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Type'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Range' => ConfirmingService::DOMAIN_NAMESPACE,
            'Serie' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'  => [
            'Type'  => LabellingService::DOMAIN_NAMESPACE,
            'Range' => LabellingService::DOMAIN_NAMESPACE,
            'Serie' => LabellingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string $Type */
    protected $Type = null;
    /** @var string $Range */
    protected $Range = null;
    /** @var string $Serie */
    protected $Serie = null;
    // @codingStandardsIgnoreEnd

    /**
     * @param string $type
     * @param string $range
     * @param string $serie
     */
    public function __construct($type, $range, $serie = '000000000-999999999')
    {
        parent::__construct();

        $this->setType($type);
        $this->setRange($range);
        $this->setSerie($serie);
    }
}
