<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransaksiKeluar>
 */
class TransaksiKeluarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 5),
            'supplier_id' => fake()->numberBetween(1, 5),
            'barang_id' => fake()->numberBetween(1, 5),
            'kode' => fake()->numerify('TK-####'),
            'tanggal' => now(),
            'keterangan' => fake()->sentence(6),
            'qty' => fake()->randomNumber(2, false),
            'harga_satuan' => fake()->randomNumber(2, false) * 1000,
            'harga_total' => fake()->randomNumber(3, false) * 1000,
        ];
    }
}
