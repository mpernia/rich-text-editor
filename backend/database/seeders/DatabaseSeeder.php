<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Infrastructure\Persistences\Models\{Post, User};
use Src\Shared\Database\Seeders\StatusTableSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name' => 'John Doe Smith',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'),
        ]);
        $this->call([
            StatusTableSeeder::class,
        ]);
        Post::factory(10)->create();
    }
}
