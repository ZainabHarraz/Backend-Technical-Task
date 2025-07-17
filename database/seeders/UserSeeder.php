<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::create([
            'name' => 'Ali Ahmed',
            'email' => 'ali@example.com',
            'password' => Hash::make('password'),
            'verification_code' => null,
            'is_verified' => true,
        ]);

        User::create([
            'name' => 'Sara Ibrahim',
            'email' => 'sara@example.com',
            'password' => Hash::make('password'),
            'verification_code' => null,
            'is_verified' => true,
        ]);

        User::create([
            'name' => 'Mohamed Said',
            'email' => 'mohamed@example.com',
            'password' => Hash::make('password'),
            'verification_code' => '111111',
            'is_verified' => false,
        ]);

        User::create([
            'name' => 'Nada Kamal',
            'email' => 'nada@example.com',
            'password' => Hash::make('password'),
            'verification_code' => '222222',
            'is_verified' => false,
        ]);

        User::create([
            'name' => 'Youssef Adel',
            'email' => 'youssef@example.com',
            'password' => Hash::make('password'),
            'verification_code' => null,
            'is_verified' => true,
        ]);
    }
}
