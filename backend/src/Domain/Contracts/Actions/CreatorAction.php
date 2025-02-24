<?php

namespace Src\Domain\Contracts\Actions;

use Src\Domain\Contracts\DataTransferObject;

interface CreatorAction
{
    public static function create(DataTransferObject $data);
}
