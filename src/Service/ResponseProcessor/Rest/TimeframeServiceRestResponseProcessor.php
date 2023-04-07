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

use Firstred\PostNL\Entity\ReasonNoTimeframe;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Entity\Timeframe;
use Firstred\PostNL\Entity\TimeframeTimeFrame;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\ResponseProcessor\TimeframeServiceResponseProcessorInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @since 2.0.0
 *
 * @internal
 */
class TimeframeServiceRestResponseProcessor extends AbstractRestResponseProcessor implements TimeframeServiceResponseProcessorInterface
{
    /**
     * Process GetTimeframes Response REST.
     *
     * @param mixed $response
     *
     * @return ResponseTimeframes
     *
     * @throws CifDownException
     * @throws CifException
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws InvalidConfigurationException
     * @throws NotSupportedException
     * @throws ResponseException
     * @throws \ReflectionException
     *
     * @since 2.0.0
     */
    public function processGetTimeframesResponse(ResponseInterface $response): ResponseTimeframes
    {
        $this->validateResponse(response: $response);
        $body = json_decode(json: static::getResponseText(response: $response));
        // Standardize the object here
        if (isset($body->ReasonNoTimeframes)) {
            if (!isset($body->ReasonNoTimeframes->ReasonNoTimeframe)) {
                $body->ReasonNoTimeframes->ReasonNoTimeframe = [];
            }

            if (!is_array(value: $body->ReasonNoTimeframes->ReasonNoTimeframe)) {
                $body->ReasonNoTimeframes->ReasonNoTimeframe = [$body->ReasonNoTimeframes->ReasonNoTimeframe];
            }

            $newNotimeframes = [];
            foreach ($body->ReasonNoTimeframes->ReasonNoTimeframe as $reasonNotimeframe) {
                $newNotimeframes[] = ReasonNoTimeframe::jsonDeserialize(json: (object) ['ReasonNoTimeframe' => $reasonNotimeframe]);
            }

            $body->ReasonNoTimeframes = $newNotimeframes;
        } else {
            $body->ReasonNoTimeframes = [];
        }

        if (isset($body->Timeframes)) {
            if (!isset($body->Timeframes->Timeframe)) {
                $body->Timeframes->Timeframe = [];
            }

            if (!is_array(value: $body->Timeframes->Timeframe)) {
                $body->Timeframes->Timeframe = [$body->Timeframes->Timeframe];
            }

            $newTimeframes = [];
            foreach ($body->Timeframes->Timeframe as $timeframe) {
                $newTimeframeTimeframe = [];
                if (!is_array(value: $timeframe->Timeframes->TimeframeTimeFrame)) {
                    $timeframe->Timeframes->TimeframeTimeFrame = [$timeframe->Timeframes->TimeframeTimeFrame];
                }
                foreach ($timeframe->Timeframes->TimeframeTimeFrame as $timeframetimeframe) {
                    $newTimeframeTimeframe[] = TimeframeTimeFrame::jsonDeserialize(
                        json: (object) ['TimeframeTimeFrame' => $timeframetimeframe]
                    );
                }
                $timeframe->Timeframes = $newTimeframeTimeframe;

                $newTimeframes[] = Timeframe::jsonDeserialize(json: (object) ['Timeframe' => $timeframe]);
            }
            $body->Timeframes = $newTimeframes;
        } else {
            $body->Timeframes = [];
        }

        $object = ResponseTimeframes::create();
        $object->setReasonNoTimeframes(ReasonNoTimeframes: $body->ReasonNoTimeframes);
        $object->setTimeframes(Timeframes: $body->Timeframes);

        return $object;
    }
}
