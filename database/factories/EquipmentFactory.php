<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $equipmentTypes = [
            'Koper' => ['Koper ukuran besar untuk perjalanan umroh', 100],
            'Tas Tenteng' => ['Tas tenteng untuk keperluan sehari-hari', 200],
            'Seragam Ihram' => ['Pakaian ihram untuk jamaah pria', 150],
            'Mukena' => ['Mukena untuk jamaah wanita', 120],
            'Sajadah' => ['Sajadah portable untuk sholat', 300],
            'Sandal' => ['Sandal untuk perjalanan umroh', 180],
            'Tas Pinggang' => ['Tas pinggang untuk dokumen penting', 80],
            'Tasbih' => ['Tasbih untuk dzikir', 500],
        ];

        $equipment = $this->faker->randomElement(array_keys($equipmentTypes));
        $details = $equipmentTypes[$equipment];

        $stockQuantity = $details[1] + $this->faker->numberBetween(-20, 50);
        $distributedQuantity = $this->faker->numberBetween(0, min($stockQuantity, 50));

        return [
            'name' => $equipment,
            'description' => $details[0],
            'stock_quantity' => $stockQuantity,
            'distributed_quantity' => $distributedQuantity,
            'status' => $stockQuantity > 0 ? 'available' : 'out_of_stock',
        ];
    }
}