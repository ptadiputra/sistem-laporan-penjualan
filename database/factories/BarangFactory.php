<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->word(),
            'kategori' => fake()->sentence(2),
            'harga' => fake()->randomNumber(3, false) * 1000,
            'stock' => fake()->randomNumber(2, false),
        ];
    }
}
