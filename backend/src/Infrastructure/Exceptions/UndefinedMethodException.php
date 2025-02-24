<?php

namespace Src\Infrastructure\Exceptions;

class UndefinedMethodException extends InvalidResponseException
{
    public function __construct(string $method, string $class)
    {
        parent::__construct(
            jsonEncode([
                'error'   => ' Undefined method',
                'message' => "Call to undefined method {$method}::{$class}()"
            ])
        );
    }
}
