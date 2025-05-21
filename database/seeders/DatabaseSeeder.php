<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Barang;
use App\Models\KategoriBarang;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(5)->create();
        // Supplier::factory(5)->create();
        // Barang::factory(5)->create();
        // Jasa::factory(5)->create();
        // TransaksiKeluar::factory(5)->create();
        // TransaksiMasuk::factory(3)->tipeBarang()->create();
        // TransaksiMasuk::factory(3)->tipeJasa()->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // -- create superadmin
        User::create([
            'name' => 'Superadmin',
            'username' => 'superadmin',
            'password' => bcrypt('superpassword'),
            'no_tlp_user' => '-',
            'email' => 'superadmin@mail.com',
            'role' => 'superadmin',
        ]);

        KategoriBarang::create([
            'nama' => 'Paku',
        ]);

        Barang::create([
            'nama' => 'Paku Payung',
            'satuan' => 'kg',
            'harga' => 10000,
            'stock' => 2000,
            'kategori_id' => 1
        ]);
        Barang::create([
            'nama' => 'Paku Beton',
            'satuan' => 'kg',
            'harga' => 15000,
            'stock' => 2000,
            'kategori_id' => 1
        ]);
    }
}
