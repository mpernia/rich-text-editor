<?php

namespace Src\Domain\Exceptions;

use Src\Infrastructure\Exceptions\InvalidResponseException;
use Symfony\Component\HttpFoundation\Response;

class StatusNotFoundException extends InvalidResponseException
{
    public function __construct(string|int $id)
    {
        parent::__construct(
            message: sprintf('The Status ID (%s) not found', $id),
            code: Response::HTTP_NOT_FOUND);
    }
}
