<?php

namespace Src\Domain\Exceptions;

use Src\Infrastructure\Exceptions\InvalidResponseException;
use Symfony\Component\HttpFoundation\Response;

class PostNotFoundException extends InvalidResponseException
{
    public function __construct(string|int $id)
    {
        parent::__construct(
            message: sprintf('The Post ID (%s) not found', $id),
            code: Response::HTTP_NOT_FOUND);
    }
}
