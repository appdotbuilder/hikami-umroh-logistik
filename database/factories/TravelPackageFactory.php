<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TravelPackage>
 */
class TravelPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departureDate = $this->faker->dateTimeBetween('now', '+6 months');
        $returnDate = clone $departureDate;
        $returnDate->modify('+' . $this->faker->numberBetween(10, 21) . ' days');

        return [
            'name' => 'Paket Umroh ' . $this->faker->randomElement(['Premium', 'Reguler', 'Ekonomi', 'VIP']) . ' ' . $this->faker->monthName(),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->randomFloat(2, 15000000, 50000000), // 15M - 50M IDR
            'duration_days' => $this->faker->numberBetween(10, 21),
            'departure_date' => $departureDate->format('Y-m-d'),
            'return_date' => $returnDate->format('Y-m-d'),
            'capacity' => $this->faker->numberBetween(20, 50),
            'registered_count' => $this->faker->numberBetween(0, 30),
            'status' => $this->faker->randomElement(['draft', 'open']),
        ];
    }
}