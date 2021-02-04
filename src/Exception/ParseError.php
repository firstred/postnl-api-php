<?php

declare(strict_types=1);

namespace Firstred\PostNL\Exception;

use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ParseError extends PostNLClientException implements HasResponse
{
    #[Pure]
    public function __construct(
        mixed $message = '',
        mixed $code = 0,
        Throwable $previous = null,
        protected ResponseInterface|null $response = null,
    ) {
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        parent::__construct($message, $code, $previous);
    }

    public function getResponse(): ResponseInterface|null
    {
        return $this->response;
    }
}
