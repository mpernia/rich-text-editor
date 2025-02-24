<?php

namespace Src\Application\Actions\Status;

use Src\Domain\Contracts\Actions\FinderAction;
use Src\Domain\Contracts\Entities\Status;
use Src\Domain\Contracts\Repositories\StatusRepository;
use Src\Domain\Entities\StatusEntity;
use Src\Domain\Exceptions\StatusNotFoundException;

class StatusFinder implements FinderAction
{
    private StatusRepository $repository;
    private function __construct()
    {
        $this->repository = app()->make(StatusRepository::class);
    }

    public static function find(int|string $value, string $column = 'id'): Status
    {
         $instance = new self();
         $status = $instance->repository->find($value);
         if (!$status) {
             throw new StatusNotFoundException($value);
         }
         return StatusEntity::new($status->toArray());
    }

    /** @return Status[] */
    public static function all(): array
    {
        $result = [];
        $instance = new self();
        $statuses = $instance->repository->all();
        foreach ($statuses as $status) {
            $result[] = StatusEntity::new($status->toArray());
        }
        return $result;
    }
}
