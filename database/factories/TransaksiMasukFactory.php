<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransaksiMasuk>
 */
class TransaksiMasukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    // -- State untuk tipe barang
    public function tipeBarang(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'user_id' => fake()->numberBetween(1, 5),
                'barang_id' => fake()->numberBetween(1, 5),
                'kode' => fake()->numerify('TM-####'),
                'tanggal' => now(),
                'keterangan' => fake()->sentence(6),
                'tipe' => 'barang',
                'qty_barang' => fake()->randomNumber(2, false),
                'harga_satuan_barang' => fake()->randomNumber(2, false) * 1000,
                'harga_total' => fake()->randomNumber(3, false) * 1000,
            ];
        });
    }

    // -- State untuk tipe Jasa
    public function tipeJasa(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'user_id' => fake()->numberBetween(1, 5),
                'jasa_id' => fake()->numberBetween(1, 5),
                'kode' => fake()->numerify('TM-####'),
                'tanggal' => now(),
                'keterangan' => fake()->sentence(6),
                'tipe' => 'jasa',
                'harga_total' => fake()->randomNumber(3, false) * 1000,
            ];
        });
    }
}
