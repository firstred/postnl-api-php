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

namespace Firstred\PostNL\Service\ResponseProcessor\Rest;

use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\ResponseProcessor\AbstractResponseProcessor;
use JsonException;
use Psr\Http\Message\ResponseInterface;

/**
 * @since 2.0.0
 *
 * @internal
 */
abstract class AbstractRestResponseProcessor extends AbstractResponseProcessor
{
    /**
     * @throws CifDownException
     * @throws CifException
     * @throws InvalidConfigurationException
     * @throws ResponseException
     *
     * @since 2.0.0
     */
    protected function validateResponse(ResponseInterface $response): bool
    {
        try {
            $body = json_decode(json: (string) $response->getBody(), flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new ResponseException(message: 'Invalid response from server', previous: $e, response: $response);
        }

        if (!empty($body->fault->faultstring) && 'Invalid ApiKey' === $body->fault->faultstring) {
            throw new InvalidConfigurationException();
        }
        if (isset($body->Envelope->Body->Fault->Reason->Text)) {
            $vars = get_object_vars(object: $body->Envelope->Body->Fault->Reason->Text);
            throw new CifDownException(message: $vars[''] ?? 'Unknown');
        }

        if (!empty($body->Errors->Error)) {
            $exceptionData = [];
            foreach ($body->Errors->Error as $error) {
                if (isset($error->ErrorMsg)) {
                    $exceptionData[] = [
                        'description' => $error->ErrorMsg ?? '',
                        'message'     => $error->ErrorMsg ?? '',
                        'code'        => isset($error->ErrorNumber) ? (int) $error->ErrorNumber : 0,
                    ];
                } else {
                    $exceptionData[] = [
                        'description' => isset($error->Description) ? (string) $error->Description : '',
                        'message'     => null,
                        'code'        => isset($error->ErrorNumber) ? (int) $error->ErrorNumber : 0,
                    ];
                }
            }
            throw new CifException(message: $exceptionData);
        } elseif (!empty($body->Errors)) {
            $exceptionData = [];
            foreach ($body->Errors as $error) {
                if (isset($error->ErrorMsg)) {
                    $exceptionData[] = [
                        'description' => $error->ErrorMsg ?? '',
                        'message'     => $error->ErrorMsg ?? '',
                        'code'        => isset($error->ErrorNumber) ? (int) $error->ErrorNumber : 0,
                    ];
                } else {
                    $exceptionData[] = [
                        'description' => isset($error->Description) ? (string) $error->Description : '',
                        'message'     => isset($error->Error) ? (string) $error->Error : '',
                        'code'        => isset($error->Code) ? (int) $error->Code : 0,
                    ];
                }
            }
            throw new CifException(message: $exceptionData);
        } elseif (!empty($body->Array->Item->ErrorMsg)) {
            // {"Array":{"Item":{"ErrorMsg":"Unknown option GetDeliveryDate.Options='DayTime' specified","ErrorNumber":26}}}
            $exceptionData = [
                [
                    'description' => isset($body->Array->Item->ErrorMsg) ? (string) $body->Array->Item->ErrorMsg : '',
                    'message'     => isset($body->Array->Item->ErrorMsg) ? (string) $body->Array->Item->ErrorMsg : '',
                    'code'        => 0,
                ],
            ];
            throw new CifException(message: $exceptionData);
        } elseif (isset($body->ResponseShipments)
            && is_array(value: $body->ResponseShipments)
            && isset($body->ResponseShipments[0]->Errors)
            && is_array(value: $body->ResponseShipments[0]->Errors)
            && !empty($body->ResponseShipments[0]->Errors)
        ) {
            $error = $body->ResponseShipments[0]->Errors[0];

            $exceptionData = [
                [
                    'message'     => isset($error->message) ? (string) $error->message : '',
                    'description' => isset($error->description) ? (string) $error->description : '',
                    'code'        => isset($error->code) ? (int) $error->code : 0,
                ],
            ];
            throw new CifException(message: $exceptionData);
        }

        return true;
    }
}
