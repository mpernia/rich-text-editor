<?php

namespace Src\Domain\Contracts\Actions;

use Src\Domain\Contracts\DataTransferObject;

interface FinderAction
{
    public static function find(int|string $value, string $column = 'id');

    public static function all() : array;
}
