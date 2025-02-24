<?php

namespace Src\Infrastructure\Persistences\Repositories;

use Src\Domain\Contracts\Repositories\UserRepository;
use Src\Infrastructure\Persistences\Models\User;

class UserEloquentRepository extends EloquentRepository implements UserRepository
{

    public function setModel(): string
    {
        return User::Class;
    }
}
