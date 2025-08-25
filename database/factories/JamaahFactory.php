<?php

namespace Database\Factories;

use App\Models\Jamaah;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jamaah>
 */
class JamaahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(['role' => 'jamaah']),
            'nik' => $this->faker->numerify('################'),
            'full_name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'place_of_birth' => $this->faker->city(),
            'date_of_birth' => $this->faker->dateTimeBetween('-60 years', '-17 years')->format('Y-m-d'),
            'nationality' => 'Indonesia',
            'occupation' => $this->faker->jobTitle(),
            'emergency_contact_name' => $this->faker->name(),
            'emergency_contact_phone' => $this->faker->phoneNumber(),
            'medical_notes' => $this->faker->optional()->sentence(),
            'status' => $this->faker->randomElement(['registered', 'documents_pending', 'documents_complete', 'ready_to_depart']),
        ];
    }
}