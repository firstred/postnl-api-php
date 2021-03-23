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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ConfirmingServiceInterface;
use Firstred\PostNL\Service\LabellingServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Label.
 */
class Label extends SerializableObject
{
    public const FORMAT_A4 = 'A4';
    public const FORMAT_A6 = 'A6';
    public const FORMATS = [self::FORMAT_A4, self::FORMAT_A6];

    public const POSITION_BOTTOM_LEFT = 1;
    public const POSITION_BOTTOM_RIGHT = 3;
    public const POSITION_TOP_LEFT = 2;
    public const POSITION_TOP_RIGHT = 4;
    public const POSITIONS = [
        self::POSITION_BOTTOM_LEFT,
        self::POSITION_BOTTOM_RIGHT,
        self::POSITION_TOP_LEFT,
        self::POSITION_TOP_RIGHT,
    ];

    public const ORIENTATION_LANDSCAPE = 'L';
    public const ORIENTATION_PORTRAIT = 'P';
    public const ORIENTATIONS = [self::ORIENTATION_LANDSCAPE, self::ORIENTATION_PORTRAIT];

    public const PRINTER_TYPE_GRAPHIC_FILE_GIF_200_DPI = 'GraphicFile|GIF 200 dpi';
    public const PRINTER_TYPE_GRAPHIC_FILE_GIF_300_DPI = 'GraphicFile|GIF 300 dpi';
    public const PRINTER_TYPE_GRAPHIC_FILE_GIF_600_DPI = 'GraphicFile|GIF 600 dpi';
    public const PRINTER_TYPE_GRAPHIC_FILE_JPG_200_DPI = 'GraphicFile|JPG 200 dpi';
    public const PRINTER_TYPE_GRAPHIC_FILE_JPG_300_DPI = 'GraphicFile|JPG 300 dpi';
    public const PRINTER_TYPE_GRAPHIC_FILE_JPG_600_DPI = 'GraphicFile|JPG 600 dpi';
    public const PRINTER_TYPE_GRAPHIC_FILE_PDF = 'GraphicFile|PDF';
    public const PRINTER_TYPE_GRAPHIC_FILE_PDF_MERGE_A = 'GraphicFile|PDF|MergeA';
    public const PRINTER_TYPE_GRAPHIC_FILE_PDF_MERGE_B = 'GraphicFile|PDF|MergeB';
    public const PRINTER_TYPE_GRAPHIC_FILE_PDF_MERGE_C = 'GraphicFile|PDF|MergeC';
    public const PRINTER_TYPE_GRAPHIC_FILE_PDF_MERGE_D = 'GraphicFile|PDF|MergeD';
    public const PRINTER_TYPE_ZEBRA_GENERIC_ZPL_II_200_DPI = 'Zebra|Generic ZPL II 200 dpi';
    public const PRINTER_TYPE_ZEBRA_GENERIC_ZPL_II_300_DPI = 'Zebra|Generic ZPL II 300 dpi';
    public const PRINTER_TYPE_ZEBRA_GENERIC_ZPL_II_600_DPI = 'Zebra|Generic ZPL II 600 dpi';
    public const PRINTER_TYPES = [
        self::PRINTER_TYPE_GRAPHIC_FILE_GIF_200_DPI,
        self::PRINTER_TYPE_GRAPHIC_FILE_GIF_300_DPI,
        self::PRINTER_TYPE_GRAPHIC_FILE_GIF_600_DPI,
        self::PRINTER_TYPE_GRAPHIC_FILE_JPG_200_DPI,
        self::PRINTER_TYPE_GRAPHIC_FILE_JPG_300_DPI,
        self::PRINTER_TYPE_GRAPHIC_FILE_JPG_600_DPI,
        self::PRINTER_TYPE_GRAPHIC_FILE_PDF,
        self::PRINTER_TYPE_GRAPHIC_FILE_PDF_MERGE_A,
        self::PRINTER_TYPE_GRAPHIC_FILE_PDF_MERGE_B,
        self::PRINTER_TYPE_GRAPHIC_FILE_PDF_MERGE_C,
        self::PRINTER_TYPE_GRAPHIC_FILE_PDF_MERGE_D,
        self::PRINTER_TYPE_ZEBRA_GENERIC_ZPL_II_200_DPI,
        self::PRINTER_TYPE_ZEBRA_GENERIC_ZPL_II_300_DPI,
        self::PRINTER_TYPE_ZEBRA_GENERIC_ZPL_II_600_DPI,
    ];

    /**
     * Base 64 encoded content.
     *
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LabellingServiceInterface::class, ConfirmingServiceInterface::class])]
    protected string|null $Content = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LabellingServiceInterface::class, ConfirmingServiceInterface::class])]
    protected string|null $Contenttype = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LabellingServiceInterface::class, ConfirmingServiceInterface::class])]
    protected string|null $Labeltype = null;

    /**
     * Label constructor.
     *
     * @param string      $service
     * @param string      $propType
     * @param string|null $Content
     * @param string|null $Contenttype
     * @param string|null $Labeltype
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType,

        string|null $Content = null,
        string|null $Contenttype = null,
        string|null $Labeltype = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setContent(Content: $Content);
        $this->setContenttype(Contenttype: $Contenttype);
        $this->setLabeltype(Labeltype: $Labeltype);
    }

    /**
     * @return string|null
     */
    public function getContent(): string|null
    {
        return $this->Content;
    }

    /**
     * @param string|null $Content
     *
     * @return static
     */
    public function setContent(string|null $Content = null): static
    {
        $this->Content = $Content;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContenttype(): string|null
    {
        return $this->Contenttype;
    }

    /**
     * @param string|null $Contenttype
     *
     * @return static
     */
    public function setContenttype(string|null $Contenttype = null): static
    {
        $this->Contenttype = $Contenttype;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabeltype(): string|null
    {
        return $this->Labeltype;
    }

    /**
     * @param string|null $Labeltype
     *
     * @return static
     */
    public function setLabeltype(string|null $Labeltype = null): static
    {
        $this->Labeltype = $Labeltype;

        return $this;
    }
}
