<?php

namespace Database\Factories;

use App\Models\Umkaem;
use App\Models\User; 
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Umkaem>
 */
class UmkaemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            'npwp_no' => $this->faker->numerify(str_repeat('#', 16)),
            'izin_usaha_path' => $this->faker->optional()->filePath(),
            'profile_picture' => $this->faker->optional()->imageUrl(),
            'forecasting_demand' => false,
            'buffer_stock' => false,
            'is_verified' => false, 
            'durasi' => $this->faker->numberBetween(1, 12),
        ];
    }
}
