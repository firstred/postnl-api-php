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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\ValidateAndFix;
use ReflectionException;
use TypeError;

/**
 * Class Label
 */
class Label extends AbstractEntity
{
    const FORMAT_A4 = 1;
    const FORMAT_A6 = 2;

    /**
     * Base 64 encoded content
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $content
     *
     * @since 1.0.0
     */
    protected $content;

    /**
     * Content type of the label, e.g. zebra of pdf. See Guidelines
     * Note: It is not recommended to send .PDF files/labels directly to a Zebra printer. See Guidelines
     *
     * @pattern ^.{0,35}$
     *
     * @example PDF
     *
     * @var string|null $contenttype
     *
     * @since 1.0.0
     */
    protected $contenttype;

    /**
     * Label type
     *
     * The Label type helps you to determine what document is returned. In most cases, only a Label is returned. The following label types are possible:
     * | Labeltype                        | Description                                                   |
     * |----------------------------------|---------------------------------------------------------------|
     * | Label (A6)                       | normal shipping label for all shipments except for GlobalPack |
     * | BusPakjeExtra (A6)               | shipping label for parcels that fit in a mailbox              |
     * | CODcard (Kabinet (21 x 10,16 cm) | COD card as required for Dutch domestic COD shipments         |
     * | CN23 form (A5)                   | customs form for GlobalPack shipments                         |
     * | CP71 form (A5)                   | customs form for GlobalPack shipments                         |
     * | Commercialinvoice (A4)           | commercial invoice for GlobalPack shipments                   |
     * | Return Label (A6)                | normal shipping label for reverse logistics                   |
     *
     * @pattern ^.{0,35}$
     *
     * @example Label (A6)
     *
     * @var string|null $labeltype
     *
     * @since 1.0.0
     */
    protected $labeltype;

    /**
     * Label constructor.
     *
     * @param string|null $content
     * @param string|null $contentType
     * @param string|null $labelType
     *
     * @throws TypeError
     * @throws ReflectionException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct($content = null, $contentType = null, $labelType = null)
    {
        parent::__construct();

        $this->setContent($content);
        $this->setContenttype($contentType);
        $this->setLabeltype($labelType);
    }

    /**
     * Get content
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Label::$content
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set content
     *
     * @pattern N/A
     *
     * @param string|null $content
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example N/A
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     Label::$content
     */
    public function setContent(?string $content): Label
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content type
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Label::$contenttype
     */
    public function getContenttype(): ?string
    {
        return $this->contenttype;
    }


    /**
     * Set content type
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $contenttype
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     * @throws InvalidArgumentException
     *
     * @example PDF
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Label::$contenttype
     */
    public function setContenttype(?string $contenttype): Label
    {
        $this->contenttype = ValidateAndFix::genericString($contenttype);

        return $this;
    }

    /**
     * Get label type
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Label::$labeltype
     */
    public function getLabeltype(): ?string
    {
        return $this->labeltype;
    }

    /**
     * Set label type
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $labeltype
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     * @throws InvalidArgumentException
     *
     * @example Label (A6)
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Label::$labeltype
     */
    public function setLabeltype(?string $labeltype): Label
    {
        $this->labeltype = ValidateAndFix::genericString($labeltype);

        return $this;
    }
}
