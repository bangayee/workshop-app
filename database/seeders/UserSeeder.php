<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole('admin');

        $operator = User::create([
            'name' => 'Operator',
            'email' => 'operator@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $operator->assignRole('operator');
    }
}
