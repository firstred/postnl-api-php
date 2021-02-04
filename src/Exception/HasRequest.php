<?php

declare(strict_types=1);

namespace Firstred\PostNL\Exception;

use Psr\Http\Message\RequestInterface;

interface HasRequest
{
    public function getRequest(): RequestInterface|null;
}
