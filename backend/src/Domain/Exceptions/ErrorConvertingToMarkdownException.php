<?php

namespace Src\Domain\Exceptions;

use Src\Infrastructure\Exceptions\InvalidResponseException;
use Symfony\Component\HttpFoundation\Response;

class ErrorConvertingToMarkdownException extends InvalidResponseException
{
    public function __construct()
    {
        parent::__construct(
            message: 'Error converting HTML to Markdown',
            code: Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
