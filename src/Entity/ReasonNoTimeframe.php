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
 * Class ReasonNoTimeframe
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string   getCode()
 * @method string   getDate()
 * @method string   getDescription()
 * @method string[] getOptions()
 *
 * @method ReasonNoTimeframe setCode(string $code)
 * @method ReasonNoTimeframe setDate(string $date)
 * @method ReasonNoTimeframe setDescription(string $desc)
 * @method ReasonNoTimeframe setOptions(string [] $options)
 */
class ReasonNoTimeframe extends AbstractEntity
{
    /** @var string $defaultProperties */
    public static $defaultProperties = [
        'Barcode'    => [
            'Code'        => BarcodeService::DOMAIN_NAMESPACE,
            'Date'        => BarcodeService::DOMAIN_NAMESPACE,
            'Description' => BarcodeService::DOMAIN_NAMESPACE,
            'Options'     => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Code'        => ConfirmingService::DOMAIN_NAMESPACE,
            'Date'        => ConfirmingService::DOMAIN_NAMESPACE,
            'Description' => ConfirmingService::DOMAIN_NAMESPACE,
            'Options'     => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'  => [
            'Code'        => LabellingService::DOMAIN_NAMESPACE,
            'Date'        => LabellingService::DOMAIN_NAMESPACE,
            'Description' => LabellingService::DOMAIN_NAMESPACE,
            'Options'     => LabellingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string $Code */
    protected $Code = null;
    /** @var string $Date */
    protected $Date = null;
    /** @var string $Description */
    protected $Description = null;
    /** @var string[] $Options */
    protected $Options = null;
    // @codingStandardsIgnoreEnd

    /**
     * @param string   $code
     * @param string   $date
     * @param string   $desc
     * @param string[] $options
     */
    public function __construct($code, $date, $desc, array $options)
    {
        parent::__construct();

        $this->setCode($code);
        $this->setDate($date);
        $this->setDescription($desc);
        $this->setOptions($options);
    }
}
