<?php

namespace Src\Domain\Exceptions;

use Src\Infrastructure\Exceptions\InvalidResponseException;
use Symfony\Component\HttpFoundation\Response;

class ErrorGeneratingPdfException extends InvalidResponseException
{
    public function __construct()
    {
        parent::__construct(
            message: 'Error generating PDF',
            code: Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
