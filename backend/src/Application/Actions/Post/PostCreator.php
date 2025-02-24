<?php

namespace Src\Application\Actions\Post;

use Src\Domain\Contracts\Actions\CreatorAction;
use Src\Domain\Contracts\DataTransferObject;
use Src\Domain\Contracts\Entities\Post;
use Src\Domain\Contracts\Repositories\PostRepository;
use Src\Domain\Entities\PostEntity;

class PostCreator implements CreatorAction
{
    private PostRepository $repository;

    private function __construct()
    {
        $this->repository = app()->make(PostRepository::class);
    }

    public static function create(DataTransferObject $data): Post
    {
        $instance = new self();
        $post = $instance->repository->create($data->toArray());
        return PostEntity::new($post->toArray());
    }
}
