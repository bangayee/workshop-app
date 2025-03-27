<?php

namespace Database\Seeders;

use App\Models\Setting;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Setting::factory()->create([
            'setting_name' => 'logo',
            'value' => '1742982177_logo.png',
            'type' => 'image',
            'status' => 1,
        ]);

        Setting::factory()->create([
            'setting_name' => 'site_name',
            'value' => 'Workshop App',
            'type' => 'text',
            'status' => 1,
        ]);
    }
}
