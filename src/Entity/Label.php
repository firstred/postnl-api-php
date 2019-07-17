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

/**
 * Class Label
 */
class Label extends AbstractEntity
{
    const FORMAT_A4 = 1;
    const FORMAT_A6 = 2;

    /**
     * @var string|null $content
     *
     * Base 64 encoded content
     */
    protected $content;
    /** @var string|null $contenttype */
    protected $contenttype;
    /** @var string|null $labeltype */
    protected $labeltype;

    /**
     * @param string|null $content
     * @param string|null $contentType
     * @param string|null $labelType
     */
    public function __construct($content = null, $contentType = null, $labelType = null)
    {
        parent::__construct();

        $this->setContent($content);
        $this->setContenttype($contentType);
        $this->setLabeltype($labelType);
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setContent(?string $content): Label
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getContenttype(): ?string
    {
        return $this->contenttype;
    }

    /**
     * @param string|null $contenttype
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setContenttype(?string $contenttype): Label
    {
        $this->contenttype = $contenttype;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getLabeltype(): ?string
    {
        return $this->labeltype;
    }

    /**
     * @param string|null $labeltype
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLabeltype(?string $labeltype): Label
    {
        $this->labeltype = $labeltype;

        return $this;
    }
}
