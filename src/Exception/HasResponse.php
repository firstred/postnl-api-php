<?php

declare(strict_types=1);

namespace Firstred\PostNL\Exception;

use Psr\Http\Message\ResponseInterface;

interface HasResponse
{
    public function getResponse(): ResponseInterface|null;
}
