<?php

namespace Src\Infrastructure\Persistences\Repositories;

use Src\Domain\Contracts\Repositories\StatusRepository;
use Src\Infrastructure\Persistences\Models\Status;

class StatusEloquentRepository extends EloquentRepository implements StatusRepository
{

    public function setModel(): string
    {
        return Status::class;
    }
}
