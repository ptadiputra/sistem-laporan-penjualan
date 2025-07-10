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
        Schema::create('stock_opname_barang', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('detail_stock_opname_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_opname_barang_id');
            $table->foreignId('barang_id');
            $table->integer('stok_sistem')->default(0);
            $table->integer('stok_fisik')->default(0);
            $table->string('selisih')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_opname_barang');
        Schema::dropIfExists('detail_stock_opname_barang');
    }
};
