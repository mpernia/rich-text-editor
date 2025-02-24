<?php

use Src\Shared\Providers\{DependencyInjectionServiceProvider,
    EventServiceProvider,
    RouteServiceProvider,
    SourceServiceProvider,
    SwaggerServiceProvider
};

return [
    DependencyInjectionServiceProvider::class,
    EventServiceProvider::class,
    RouteServiceProvider::class,
    SourceServiceProvider::class,
    SwaggerServiceProvider::class,
];

