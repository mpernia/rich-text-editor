<?php

namespace Src\Infrastructure\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class ModelNotFoundException extends InvalidResponseException
{
    public function __construct(string $className, string|int $id)
    {
        $className = basename(str_replace('\\', '/', $className));
        parent::__construct(
            message: sprintf('The %s ID (%s) not found', $className, $id),
            code: Response::HTTP_NOT_FOUND);
    }
}
