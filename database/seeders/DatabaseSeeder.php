<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            // MasterDataSeeder::class, (ini kita comment dulu karena baru akan dibuat di Milestone 3)
        ]);
    }
}