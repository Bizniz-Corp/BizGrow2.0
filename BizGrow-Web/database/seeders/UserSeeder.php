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
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('123'), // Custom password
            'role' => 'admin',
            'status' => 'active',
        ]);
        User::factory()->create([
            'name' => 'UMKM User 1',
            'email' => 'umkm1@example.com',
            'password' => bcrypt('password1'),
            'role' => 'umkm',
            'status' => 'active',
        ]);
        User::factory()->create([
            'name' => 'UMKM User 2',
            'email' => 'umkm2@example.com',
            'password' => bcrypt('umkmpassword2024'),  // Custom password
            'role' => 'umkm',
            'status' => 'active',
        ]);
        User::factory()->create([
            'name' => 'Inactive User',
            'email' => 'inactive@example.com',
            'password' => bcrypt('inactivepassword!@#'),  // Custom password
            'role' => 'umkm',
            'status' => 'deleted',
        ]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('testpassword999'),  // Custom password
            'role' => 'umkm',
            'status' => 'active',
        ]);
        User::factory()->create([
            'name' => 'umkm super',
            'email' => 'aaa@example.com',
            'password' => bcrypt('aaaa'),  // Custom password
            'role' => 'umkm',
            'status' => 'active',
        ]);
    }
}
