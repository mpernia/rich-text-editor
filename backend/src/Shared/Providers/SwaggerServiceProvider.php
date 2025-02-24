<?php

namespace Src\Shared\Providers;

use Illuminate\Support\ServiceProvider;
use L5Swagger\L5SwaggerServiceProvider;

class SwaggerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(L5SwaggerServiceProvider::class);
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../Infrastructure/Resources/views', 'l5-swagger');
        
        $this->publishes([
            __DIR__ . '/../../../vendor/swagger-api/swagger-ui/dist' => public_path('swagger-ui-assets'),
        ], 'swagger-ui-assets');
    }
}
