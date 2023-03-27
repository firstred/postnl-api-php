<?php
declare(strict_types=1);
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

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Timeframe;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\ServiceNotSetException;
use Firstred\PostNL\Service\LabellingServiceRestAdapter;
use Firstred\PostNL\Service\LocationServiceRestAdapter;
use Firstred\PostNL\Service\Rest\BarcodeServiceMessageProcessor;
use Firstred\PostNL\Service\TimeframeServiceRestAdapter;
use http\Exception\InvalidArgumentException;
use Sabre\Xml\Writer;

/**
 * @since 1.0.0
 */
class GetTimeframes extends AbstractEntity
{
    /** @var Message|null $Message */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?Message $Message = null;

    /** @var Timeframe[]|null $Timeframe */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Timeframe = null;

    /**
     * @param Message|null $Message
     * @param array|null   $Timeframes
     */
    public function __construct(
        ?Message $Message = null,
        /** @param $Timeframes Timeframe[]|null */
        ?array   $Timeframes = null,
    ) {
        parent::__construct();

        $this->setMessage(Message: $Message ?: new Message());
        $this->setTimeframe(timeframes: $Timeframes);
    }

    /**
     * @since 1.0.0
     * @since 1.2.0 Accept singular timeframe object
     */
    public function setTimeframe($timeframes): static
    {
        return $this->setTimeframes(timeframes: $timeframes);
    }

    /**
     * @param $timeframes TimeFrame|Timeframe[]|null
     *
     * @since 1.2.0
     */
    public function setTimeframes(TimeFrame|array|null $timeframes): static
    {
        if ($timeframes instanceof Timeframe) {
            $timeframes = [$timeframes];
        } elseif (is_array(value: $timeframes)) {
            foreach ($timeframes as $timeframe) {
                if (!$timeframe instanceof Timeframe) {
                    throw new InvalidArgumentException(message: 'Expected a Timeframe entity in the array');
                }
            }
        }

        $this->Timeframe = $timeframes;

        return $this;
    }

    /**
     * @return Timeframe[]|null
     *
     * @since 1.0.0
     */
    public function getTimeframe(): ?array
    {
        return $this->getTimeframes();
    }

    /**
     * @return Timeframe[]|null
     *
     * @since 1.2.0
     */
    public function getTimeframes(): ?array
    {
        return $this->Timeframe;
    }

    /**
     * @return Message|null
     */
    public function getMessage(): ?Message
    {
        return $this->Message;
    }

    /**
     * @param Message|null $Message
     *
     * @return $this
     */
    public function setMessage(?Message $Message): static
    {
        $this->Message = $Message;

        return $this;
    }

    /**
     * @param Writer $writer
     *
     * @return void
     * @throws ServiceNotSetException
     */
    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        if (!isset($this->currentService)) {
            throw new ServiceNotSetException(message: 'Service not set before serialization');
        }

        foreach ($this->getSerializableProperties() as $propertyName => $namespace) {
            if (!isset($this->$propertyName)) {
                continue;
            }

            if ('Timeframe' === $propertyName) {
                $timeframes = [];
                foreach ($this->Timeframe as $timeframe) {
                    $timeframes[] = $timeframe;
                }
                $xml["{{$namespace}}Timeframe"] = $timeframes;
            } else {
                $xml["{{$namespace}}{$propertyName}"] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write(value: $xml);
    }
}
