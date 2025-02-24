<?php

namespace Src\Domain\Contracts\Repositories;

interface PostRepository
{
    public function search(string $search, int $limit = 50, bool $sortDesc = true): array;
}
