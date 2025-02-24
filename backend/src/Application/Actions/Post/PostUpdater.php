<?php

namespace Src\Application\Actions\Post;

use Src\Domain\Contracts\Actions\UpdaterAction;
use Src\Domain\Contracts\DataTransferObject;
use Src\Domain\Contracts\Entities\Post;
use Src\Domain\Contracts\Repositories\PostRepository;
use Src\Domain\Entities\PostEntity;

class PostUpdater implements UpdaterAction
{
    private PostRepository $repository;

    private function __construct()
    {
        $this->repository = app()->make(PostRepository::class);
    }

    public static function update(int|string $key, DataTransferObject $data): Post
    {
        $instance = new self();
        $post = $instance->repository->update($key, $data->toArray());
        return PostEntity::new($post->toArray());
    }
}
