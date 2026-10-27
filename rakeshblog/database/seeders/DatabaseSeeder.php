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
            AdminSeeder::class,
            StatsSeeder::class,
            BlogSeeder::class,
            ProjectSeeder::class,
            ResearchSeeder::class,
            SiteSettingsSeeder::class,
        ]);
    }
}
