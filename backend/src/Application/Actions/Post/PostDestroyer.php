<?php

namespace Src\Application\Actions\Post;

use Src\Domain\Contracts\Actions\DestroyerAction;
use Src\Domain\Contracts\Repositories\PostRepository;

class PostDestroyer implements DestroyerAction
{
    private PostRepository $repository;

    private function __construct()
    {
        $this->repository = app()->make(PostRepository::class);
    }

    public static function destroy(int|string $value): void
    {
        $instance = new self();
        $instance->repository->delete($value);
    }
}
