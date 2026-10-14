<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $password = env('ADMIN_DEFAULT_PASSWORD');
        
        if (empty($password)) {
            throw new \RuntimeException(
                'ADMIN_DEFAULT_PASSWORD not set in .env. ' .
                'Set it before running this seeder.'
            );
        }
        
        User::updateOrCreate(
            ['email' => 'admin@perpustakaan.com'],
            [
                'name' => 'Admin Perpustakaan',
                'password' => Hash::make($password),
                'role' => 'admin',
            ]
        );
    }
}
