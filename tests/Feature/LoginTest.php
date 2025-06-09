<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Umkaem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test password salah */
    public function login_dengan_password_salah()
    {
        $user = User::factory()->create([
            'email' => 'tespasswordsalah@example.com',
            'password' => Hash::make('benar123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'tespasswordsalah@example.com',
            'password' => 'salah',
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                     'message' => 'Email atau password salah!'
                 ]);
    }

    /** @test email salah */
    public function login_dengan_email_salah()
    {
        User::factory()->create([
            'email' => 'tesemailsalah@example.com',
            'password' => Hash::make('benar123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'salah@example.com',
            'password' => 'benar123',
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                     'message' => 'Email atau password salah!'
                 ]);
    }

    /** @test admin(not umkm) login*/
    public function user_bukan_umkm_berhasil_login()
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'admin123',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Login successful'
                 ]);
    }

    /** @test verif umkm login */
    public function umkm_terverifikasi_berhasil_login()
    {
        $user = User::factory()->create([
            'email' => 'umkmverif@example.com',
            'password' => Hash::make('toko123'),
            'role' => 'umkm'
        ]);

        Umkaem::factory()->create([
            'user_id' => $user->id,
            'is_verified' => 1
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'umkmverif@example.com',
            'password' => 'toko123',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Login successful'
                 ]);
    }

    /** @test not verif can't login */
    public function umkm_belum_terverifikasi_gagal_login()
    {
        $user = User::factory()->create([
            'email' => 'umkmnotverif@example.com',
            'password' => Hash::make('toko123'),
            'role' => 'umkm'
        ]);

        Umkaem::factory()->create([
            'user_id' => $user->id,
            'is_verified' => 0
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'umkmnotverif@example.com',
            'password' => 'toko123',
        ]);

        $response->assertStatus(403)
                 ->assertJson([
                     'message' => 'UMKM belum diverifikasi! Silahkan tunggu konfirmasi pada email Anda'
                 ]);
    }
}
