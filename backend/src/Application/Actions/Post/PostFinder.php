<?php

namespace Src\Application\Actions\Post;

use Src\Domain\Contracts\Actions\FinderAction;
use Src\Domain\Contracts\Entities\Post;
use Src\Domain\Contracts\Repositories\PostRepository;
use Src\Domain\Entities\PostEntity;
use Src\Domain\Exceptions\PostNotFoundException;

class PostFinder implements FinderAction
{
    private PostRepository $repository;

    private function __construct()
    {
        $this->repository = app()->make(PostRepository::class);
    }


    public static function find(int|string $value, string $column = 'id'): Post
    {
        $instance = new self();
        $post = $instance->repository->find($value);
        if (!$post) {
            throw new PostNotFoundException($value);
        }
        return PostEntity::new($post->toArray());
    }

    /** @return Post[] */
    public static function all(?string $search = null): array
    {
        $result = [];
        $instance = new self();
        $posts = is_null($search)
            ? $instance->repository->all()
            : $instance->repository->search($search);
        foreach ($posts as $post) {
            $result[] = PostEntity::new(
                is_array($post) ? $post : $post->toArray()
            );
        }
        return $result;
    }
}
