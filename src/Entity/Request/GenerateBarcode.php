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
use Firstred\PostNL\Entity\Barcode;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * @since 1.0.0
 */
class GenerateBarcode extends AbstractEntity
{
    /** @var Message|null $Message */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: Message::class)]
    protected ?Message $Message = null;

    /** @var Customer|null $Customer */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: Customer::class)]
    protected ?Customer $Customer = null;

    /** @var Barcode|null $Barcode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: Barcode::class)]
    protected ?Barcode $Barcode = null;

    /**
     * @param Barcode|null  $Barcode
     * @param Customer|null $Customer
     * @param Message|null  $Message
     */
    public function __construct(?Barcode $Barcode = null, ?Customer $Customer = null, ?Message $Message = null)
    {
        parent::__construct();

        $this->setBarcode(Barcode: $Barcode);
        $this->setCustomer(Customer: $Customer);
        $this->setMessage(Message: $Message ?: new Message());
    }

    /**
     * @return Message|null
     * @deprecated 2.0.0
     */
    public function getMessage(): ?Message
    {
        return $this->Message;
    }

    /**
     * @param Message|null $Message
     *
     * @return static
     * @deprecated 2.0.0
     */
    public function setMessage(?Message $Message): static
    {
        $this->Message = $Message;

        return $this;
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->Customer;
    }

    /**
     * @param Customer|null $Customer
     *
     * @return static
     */
    public function setCustomer(?Customer $Customer): static
    {
        $this->Customer = $Customer;

        return $this;
    }

    /**
     * @return Barcode|null
     */
    public function getBarcode(): ?Barcode
    {
        return $this->Barcode;
    }

    /**
     * @param Barcode|null $Barcode
     *
     * @return static
     */
    public function setBarcode(?Barcode $Barcode): static
    {
        $this->Barcode = $Barcode;

        return $this;
    }
}
