<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            DirectionSeeder::class,
            DepartementSeeder::class,
            PosteSeeder::class,
            EmployeSeeder::class,
            PresenceSeeder::class,
            CarriereSeeder::class,
            CongeSeeder::class,
            DocumentSeeder::class,
            CritereSeeder::class,
        ]);
    }
}
