<?php

namespace Src\Shared\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domain\Contracts\{
    Entities\Post,
    Entities\Status,
    Entities\User,
    Repositories\PostRepository,
    Repositories\StatusRepository,
    Repositories\UserRepository
};
use Src\Infrastructure\Persistences\Repositories\{
    PostEloquentRepository,
    StatusEloquentRepository,
    UserEloquentRepository
};
use Src\Domain\Entities\{
    PostEntity,
    StatusEntity,
    UserEntity
};

class DependencyInjectionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Post::class, function () {
            return new PostEntity;
        });
        $this->app->bind(Status::class, function () {
            return new StatusEntity;
        });
        $this->app->bind(User::class, function () {
            return new UserEntity;
        });
        $this->app->bind(PostRepository::class, function () {
            return new PostEloquentRepository;
        });
        $this->app->bind(StatusRepository::class, function () {
            return new StatusEloquentRepository;
        });
        $this->app->bind(UserRepository::class, function () {
            return new UserEloquentRepository;
        });
    }
}
