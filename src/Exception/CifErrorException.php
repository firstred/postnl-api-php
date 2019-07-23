<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Exception;

use Firstred\PostNL\Exception\Request\WithRequestInterface;
use Firstred\PostNL\Exception\Request\WithRequestTrait;
use Firstred\PostNL\Exception\Response\WithResponseInterface;
use Firstred\PostNL\Exception\Response\WithResponseTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Class CifErrorException
 */
class CifErrorException extends AbstractException implements WithRequestInterface, WithResponseInterface
{
    use WithRequestTrait;
    use WithResponseTrait;

    /**
     * CifDownException constructor.
     *
     * @param string|string[]        $message  The fault string
     * @param int|string             $code     The error code
     * @param Throwable|null         $previous The previous exception
     * @param RequestInterface|null  $request  PSR(1)7 request object
     * @param ResponseInterface|null $response PSR(1)7 response object
     */
    public function __construct(string $message = '', $code = 0, ?Throwable $previous = null, ?RequestInterface $request = null, ?ResponseInterface $response = null)
    {
        parent::__construct($message, $code, $previous);

        $this->response = $response;
        $this->request = $request;
    }
}
