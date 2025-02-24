<?php

namespace Src\Domain\Contracts\Actions;

use Src\Domain\Contracts\DataTransferObject;

interface UpdaterAction
{
    public static function update(int|string $key, DataTransferObject $data);
}
