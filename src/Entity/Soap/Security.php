<?php

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

declare(strict_types=1);

namespace Firstred\PostNL\Entity\Soap;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * @since 1.0.0
 * @deprecated 2.0.0
 */
class Security extends AbstractEntity
{
    /** @deprecated 2.0.0 */
    public const SECURITY_NAMESPACE = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';

    /** @var UsernameToken $UsernameToken */
    #[SerializableProperty(namespace: SoapNamespace::Security, type: UsernameToken::class)]
    protected UsernameToken $UsernameToken;

    /**
     * Security constructor.
     *
     * @param UsernameToken $UsernameToken
     */
    public function __construct(UsernameToken $UsernameToken)
    {
        parent::__construct();

        $this->setUsernameToken(UsernameToken: $UsernameToken);
    }

    /**
     * @return UsernameToken
     */
    public function getUsernameToken(): UsernameToken
    {
        return $this->UsernameToken;
    }

    /**
     * @param UsernameToken $UsernameToken
     *
     * @return static
     */
    public function setUsernameToken(UsernameToken $UsernameToken): static
    {
        $this->UsernameToken = $UsernameToken;

        return $this;
    }
}