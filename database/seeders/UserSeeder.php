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
        User::firstOrCreate(
            ['email' => 'mindspaceadmin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'sakshi@gmail.com'],
            [
                'name' => 'Sakshi',
                'password' => bcrypt('password'),
                
            ]
        );
    }
}
