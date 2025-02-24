<?php

namespace Src\Infrastructure\Persistences\Repositories;

use Src\Domain\Contracts\Repositories\PostRepository;
use Src\Infrastructure\Persistences\Models\Post;

class PostEloquentRepository extends EloquentRepository implements PostRepository
{

    public function setModel(): string
    {
        return Post::class;
    }

    public function search(string $search, int $limit = 50, bool $sortDesc = true): array
    {
        $search = trim($search);
        $search = str_replace(['%', '_'], ['\%', '\_'], $search);
        $searchTerm = str_replace(' ', '%', $search);
        return $this->model
            ->where(function($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('summary', 'like', "%{$searchTerm}%")
                    ->orWhere('content', 'like', "%{$searchTerm}%");
            })
            ->orderBy('created_at', $sortDesc ? 'desc' : 'asc')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
