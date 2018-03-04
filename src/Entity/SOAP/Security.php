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
 * @copyright 2017-2018 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Entity\SOAP;

use ThirtyBees\PostNL\Entity\AbstractEntity;

/**
 * Class Security
 *
 * @package ThirtyBees\PostNL\Entity\SOAP
 *
 * @method UsernameToken getUsernameToken()
 *
 * @method Security setUserNameToken(UsernameToken $token)
 */
class Security extends AbstractEntity
{
    const SECURITY_NAMESPACE = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';

    /** @var string[] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'UsernameToken' => self::SECURITY_NAMESPACE,
        ],
        'Confirming'     => [
            'UsernameToken' => self::SECURITY_NAMESPACE,
        ],
        'Labelling'      => [
            'UsernameToken' => self::SECURITY_NAMESPACE,
        ],
        'ShippingStatus' => [
            'UsernameToken' => self::SECURITY_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'UsernameToken' => self::SECURITY_NAMESPACE,
        ],
        'Location'       => [
            'UsernameToken' => self::SECURITY_NAMESPACE,
        ],
        'Timeframe'      => [
            'UsernameToken' => self::SECURITY_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var UsernameToken $UsernameToken */
    public $UsernameToken;
    // @codingStandardsIgnoreEnd

    /**
     * Security constructor.
     *
     * @param UsernameToken $token
     */
    public function __construct(UsernameToken $token)
    {
        parent::__construct();

        $this->setUsernameToken($token);
    }
}
