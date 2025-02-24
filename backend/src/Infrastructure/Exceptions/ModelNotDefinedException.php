<?php

namespace Src\Infrastructure\Exceptions;

class ModelNotDefinedException extends InvalidResponseException
{
    public function __construct()
    {
        parent::__construct('No model defined');
    }
}
