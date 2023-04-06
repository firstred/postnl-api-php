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

use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Response\CompleteStatusResponse;
use Firstred\PostNL\Entity\Response\CompleteStatusResponseEvent;
use Firstred\PostNL\Entity\Response\CompleteStatusResponseOldStatus;
use Firstred\PostNL\Entity\Response\CurrentStatusResponse;
use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use Firstred\PostNL\Entity\Response\UpdatedShipmentsResponse;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\ResponseProcessor\ShippingStatusServiceResponseProcessorInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;

use function json_decode;

/**
 * @since 2.0.0
 * @internal
 */
class ShippingStatusServiceRestResponseProcessor extends AbstractRestResponseProcessor implements ShippingStatusServiceResponseProcessorInterface
{
    /**
     * Process CurrentStatus Response REST.
     *
     * @param ResponseInterface $response
     *
     * @return CurrentStatusResponse
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws ResponseException
     * @since 2.0.0
     */
    public function processCurrentStatusResponse(ResponseInterface $response): CurrentStatusResponse
    {
        $body = json_decode(json: static::getResponseText(response: $response));

        /** @var CurrentStatusResponse $object */
        return CurrentStatusResponse::jsonDeserialize(json: (object) [
            'CurrentStatusResponse' => (object) [
                'Shipments' => $body->CurrentStatus->Shipment ?? null,
                'Warnings'  => $body->Warnings ?? null,
            ],
        ]);
    }

    /**
     * Process CompleteStatus Response REST.
     *
     * @param ResponseInterface $response
     *
     * @return CompleteStatusResponse
     *
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws ResponseException
     * @throws CifDownException
     * @throws CifException
     * @throws InvalidConfigurationException
     * @throws ReflectionException
     * @since 2.0.0
     */
    public function processCompleteStatusResponse(ResponseInterface $response): CompleteStatusResponse
    {
        $this->validateResponse(response: $response);
        $body = json_decode(json: static::getResponseText(response: $response));

        if (isset($body->CompleteStatus->Shipment)) {
            $body->CompleteStatus->Shipments = $body->CompleteStatus->Shipment;
        }
        unset($body->CompleteStatus->Shipment);

        if (isset($body->CompleteStatus->Shipments) && !is_array(value: $body->CompleteStatus->Shipments)) {
            $body->CompleteStatus->Shipments = [$body->CompleteStatus->Shipments];
        }

        if (isset($body->CompleteStatus->Shipments)) {
            foreach ($body->CompleteStatus->Shipments as &$shipment) {
                $shipment->Customer = Customer::jsonDeserialize(json: (object) ['Customer' => $shipment->Customer]);
            }
            unset($shipment);

            foreach ($body->CompleteStatus->Shipments as &$shipment) {
                if (isset($shipment->Address)) {
                    $shipment->Addresses = $shipment->Address;
                    unset($shipment->Address);
                }

                if (!isset($shipment->Addresses)) {
                    $shipment->Addresses = [];
                }

                if (!is_array(value: $shipment->Addresses)) {
                    $shipment->Addresses = [$shipment->Addresses];
                }

                if (isset($shipment->Event)) {
                    $shipment->Events = $shipment->Event;
                    unset($shipment->Event);
                }

                if (!is_array(value: $shipment->Events)) {
                    $shipment->Events = [$shipment->Events];
                }

                foreach ($shipment->Events as &$event) {
                    $event = CompleteStatusResponseEvent::jsonDeserialize(
                        json: (object) ['CompleteStatusResponseEvent' => $event]
                    );
                }

                if (isset($shipment->OldStatus)) {
                    $shipment->OldStatuses = $shipment->OldStatus;
                    unset($shipment->OldStatus);
                }
                if (!is_array(value: $shipment->OldStatuses)) {
                    $shipment->OldStatuses = [$shipment->OldStatuses];
                }

                foreach ($shipment->OldStatuses as &$oldStatus) {
                    $oldStatus = CompleteStatusResponseOldStatus::jsonDeserialize(
                        json: (object) ['CompleteStatusResponseOldStatus' => $oldStatus]
                    );
                }
            }
        }

        /** @var CompleteStatusResponse $object */
        return CompleteStatusResponse::jsonDeserialize(json: (object) [
            'CompleteStatusResponse' => (object) [
                'Shipments' => isset($body->CompleteStatus->Shipments) ? $body->CompleteStatus->Shipments : null,
                'Warnings'  => isset($body->Warnings) ? $body->Warnings : null,
            ]
        ]);
    }

    /**
     * Process GetSignature Response REST.
     *
     * @param ResponseInterface $response
     *
     * @return GetSignatureResponseSignature
     *
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws ResponseException
     * @since 2.0.0
     */
    public function processGetSignatureResponse(ResponseInterface $response): GetSignatureResponseSignature
    {
        $body = json_decode(json: static::getResponseText(response: $response));

        /** @var GetSignatureResponseSignature $object */
        return GetSignatureResponseSignature::jsonDeserialize(json: (object) ['GetSignatureResponseSignature' => $body->Signature]);
    }

    /**
     * Process updated shipments response REST.
     *
     * @param ResponseInterface $response
     *
     * @return UpdatedShipmentsResponse[]
     *
     * @throws DeserializationException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws ResponseException
     * @throws EntityNotFoundException
     * @since 2.0.0
     */
    public function processGetUpdatedShipmentsResponse(ResponseInterface $response): array
    {
        $body = json_decode(json: static::getResponseText(response: $response));
        if (!is_array(value: $body)) {
            return [];
        }

        foreach ($body as &$item) {
            $item = UpdatedShipmentsResponse::jsonDeserialize(json: (object) ['UpdatedShipmentsResponse' => $item]);
        }

        return $body;
    }
}
