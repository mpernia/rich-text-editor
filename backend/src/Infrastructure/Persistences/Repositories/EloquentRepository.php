<?php

namespace Src\Infrastructure\Persistences\Repositories;

use Illuminate\Support\Facades\DB;
use Src\Domain\Contracts\Repositories\EloquentRepository as EloquentRepositoryInterface;
use Src\Domain\Contracts\Repositories\Repository;
use Src\Infrastructure\Exceptions\ModelNotDefinedException;
use Src\Infrastructure\Exceptions\ModelNotFoundException;

abstract class EloquentRepository extends AbstractRepository implements Repository, EloquentRepositoryInterface
{
    protected string $routeKeyName = 'id';

    /** Set the FQN of the Model class, example: User::class */
    abstract public function setModel(): string;

    protected function getModelClass(): mixed
    {
        if (!method_exists($this, 'setModel')) {
            throw new ModelNotDefinedException;
        }
        return app()->make($this->setModel());
    }

    public function setRouteKeyName(string $name) : void
    {
        $this->routeKeyName = $name;
    }

    public static function sqlRaw(string $query) : array
    {
        return DB::select($query);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find(int|string $id)
    {
        return $this->model->where($this->routeKeyName, $id)->first();
    }

    public function findWhere(string $column, mixed $value)
    {
        return $this->model->where($column, $value)->get();
    }

    public function findWhereFirst(string $column, mixed $value)
    {
        return $this->model->where($column, $value)->firstOrFail();
    }

    public function findWithParams(int|string $id, array $params)
    {

    }

    public function pluck(string $column, string $key = 'id')
    {
        return $this->model->pluck($column, $key);
    }

    public function paginate(int $perPage = 10)
    {
        return $this->model->paginate($perPage);
    }

    public function with(array $data)
    {
        return $this->model->with($data);
    }

    public function load(array $data)
    {
        return $this->model->load($data);
    }

    public function create(array $data)
    {
        return $this->model::create($data);
    }

    public function update(int|string $id, array $data)
    {
        $record = $this->find($id);
        if (!$record) {
            throw new ModelNotFoundException(get_class($this->model), $id);
        }
        $record->update($data);
        return $record;
    }

    public function delete(int|string $id)
    {
        $record = $this->find($id);
        if (!$record) {
            throw new ModelNotFoundException(get_class($this->model), $id);
        }
        return $record->delete();
    }
}
