<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('123'), // Custom password
            'role' => 'admin',
            'status' => 'active',
        ]);

        // UMKM Inactive
        User::factory()->create([
            'name' => 'Inactive User',
            'email' => 'inactive@example.com',
            'password' => bcrypt('inactivepassword!@#'),  // Custom password
            'role' => 'umkm',
            'status' => 'deleted',
        ]);

        // UMKM Users
        $umkmUsers = [
            [
                'name' => 'Toko Jaya Abadi',
                'email' => 'umkm1@example.com',
                'password' => bcrypt('password1'),
                'role' => 'umkm',
                'status' => 'active',
            ],
            [
                'name' => 'Toko Makmur Sentosa',
                'email' => 'umkm2@example.com',
                'password' => bcrypt('umkmpassword2024'),
                'role' => 'umkm',
                'status' => 'active',
            ],
            [
                'name' => 'Toko Sahabat Bersama',
                'email' => 'toko3@example.com',
                'password' => bcrypt('testpassword999'),
                'role' => 'umkm',
                'status' => 'active',
            ],
            [
                'name' => 'Toko Inspirasi Bangsa',
                'email' => 'inspirasi@example.com',
                'password' => bcrypt('toko4'),
                'role' => 'umkm',
                'status' => 'active',
            ],
            [
                'name' => 'Toko Harmoni Nusantara',
                'email' => 'harmoni@example.com',
                'password' => bcrypt('harmoni123'),
                'role' => 'umkm',
                'status' => 'active',
            ],
        ];

        foreach ($umkmUsers as $userData) {
            User::factory()->create($userData);
        }
    }
}
