<?php

namespace Src\Shared\Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Infrastructure\Persistences\Models\Status;

class StatusTableSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['id' => 1, 'name' => 'Draft'],
            ['id' => 2, 'name' => 'Published'],
            ['id' => 3, 'name' => 'Protected']
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
