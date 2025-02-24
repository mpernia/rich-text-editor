<?php

namespace Src\Infrastructure\Persistences\Repositories;

abstract class AbstractRepository
{
    protected mixed $model;
    public function __construct()
    {
        $this->model = $this->getModelClass();
    }

    abstract protected function getModelClass(): mixed;
}
