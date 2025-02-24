<?php

namespace Src\Domain\Contracts\Repositories;

interface Repository
{
    public static function sqlRaw(string $query) : array;
    public function all();

    public function find(int|string $id);
    public function findWhere(string $column, mixed $value);
    public function findWhereFirst(string $column, mixed $value);

    public function findWithParams(int|string $id, array $params);

    public function create(array $data);

    public function update(int|string $id, array $data);

    public function delete(int|string $id);
}
