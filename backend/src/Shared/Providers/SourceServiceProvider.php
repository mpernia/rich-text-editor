<?php

namespace Src\Shared\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Infrastructure\Commands\GenerateSwaggerDocsCommand;

class SourceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadViewsFrom(base_path('src/Infrastructure/Resources/views/'), 'views');
    }

    public function boot(): void
    {
        $migrationPath = base_path('src/Shared/Database/Migrations/');
        $seederPath = base_path('src/Shared/Database/Seeders/DatabaseSeeder.php');
        //$factoriesPath = base_path('src/Shared/Database/Factories');
        $configPaths = [
            'l5-swagger' => base_path('src/Shared/Config/l5-swagger.php'),
            'redoc' => base_path('src/Shared/Config/redoc.php'),
            'setting' => base_path('src/Shared/Config/setting.php'),
            'views' => base_path('src/Shared/Config/views.php')
        ];

        $this->publishes([$seederPath => database_path('seeders/DatabaseSeeder.php')], 'rich-editor.Seeders');
        //$this->publishes([$factoriesPath => database_path('factories')], 'rich-editor.factories');
        foreach ($configPaths as $name => $path) {
            $this->publishes([$path => config_path("$name.php")], 'rich-editor.config');
            $this->mergeConfigFrom($path, $name);
        }

        $this->loadMigrationsFrom($migrationPath);


        $this->commands([
            GenerateSwaggerDocsCommand::class,
        ]);
    }
}
