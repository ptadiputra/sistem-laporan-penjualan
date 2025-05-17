<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JurnalEntry>
 */
class JurnalEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'akun_id' => fake()->numberBetween(1, 5),
            'tanggal_transaksi' => now(),
            'debit' => fake()->randomNumber(2, false) * 1000,
            'kredit' => fake()->randomNumber(2, false) * 1000,
        ];
    }
}
