<?php

namespace Database\Seeders;

use App\Models\Setting;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {

        Setting::create([
            'setting_name' => 'logo',
            'value' => '1742982177_logo.png',
            'type' => 'image',
            'status' => 1,
        ]);

        Setting::create([
            'setting_name' => 'site_name',
            'value' => 'Workshop App',
            'type' => 'text',
            'status' => 1,
        ]);
    }
}
