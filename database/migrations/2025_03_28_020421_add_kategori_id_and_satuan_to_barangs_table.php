<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->foreignId('kategori_id')
                  ->after('nama') // Menempatkan kategori_id setelah nama
                  ->constrained('kategori_barangs')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->string('satuan')->after('harga'); // Menambahkan field satuan setelah harga
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn(['kategori_id', 'satuan']);
        });
    }
};
