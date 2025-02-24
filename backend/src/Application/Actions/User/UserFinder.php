<?php

namespace Src\Application\Actions\User;

use Src\Domain\Contracts\Actions\FinderAction;
use Src\Domain\Contracts\Entities\User;
use Src\Domain\Contracts\Repositories\UserRepository;
use Src\Domain\Entities\UserEntity;
use Src\Domain\Exceptions\UserNotFoundException;

class UserFinder implements FinderAction
{
    private UserRepository $repository;

    private function __construct()
    {
        $this->repository = app()->make(UserRepository::class);
    }

    public static function find(int|string $value, string $column = 'id'): User
    {
        $instance = new self();
        $user = $instance->repository->find($value);
        if (!$user) {
            throw new UserNotFoundException($value);
        }
        return UserEntity::new($user->toArray());
    }

    public static function all(): array
    {
        $result = [];
        $instance = new self();
        $users = $instance->repository->all();
        foreach ($users as $user) {
            $result[] = UserEntity::new($user->toArray());
        }
        return $result;
    }
}
