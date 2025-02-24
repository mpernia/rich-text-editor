<?php

namespace Src\Domain\Contracts\Repositories;

interface EloquentRepository
{
    public function pluck(string $column, string $key = 'id');
    public function paginate(int $perPage = 10);
    public function with(array $data);
    public function load(array $data);
}
