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

declare(strict_types=1);

namespace Firstred\PostNL\ResponseProcessor;

use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\DTO\Response\GenerateBarcodeResponseDTO;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use function json_decode;
use Psr\Http\Message\ResponseInterface;

class BarcodeServiceResponseProcessor extends ResponseProcessorBase implements BarcodeServiceResponseProcessorInterface
{
    /**
     * @throws ResponseException
     * @throws InvalidArgumentException
     */
    public function processGenerateBarcodeResponse(ResponseInterface $response): GenerateBarcodeResponseDTO
    {
        $json = @json_decode(json: (string) $response->getBody(), associative: true);

        if (!isset($json['Barcode'])) {
            throw new ResponseException(message: 'Invalid API Response', response: $response);
        }

        $json['service'] = BarcodeServiceInterface::class;
        $json['propType'] = ResponseProp::class;

        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        return new GenerateBarcodeResponseDTO(...$json);
    }
}
