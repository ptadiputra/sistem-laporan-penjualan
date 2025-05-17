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
        Schema::create('transaksi_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('akun');
            $table->string('kode');
            $table->date('tanggal');
            $table->integer('sub_total');
            $table->integer('biaya_pengiriman');
            $table->integer('diskon');
            $table->integer('total');
            $table->date('tanggal_pengiriman');
            $table->text('alamat_pengiriman');
            $table->text('catatan_pengiriman')->nullable();
            $table->timestamps();
            
            // $table->integer('qty_barang')->nullable();
            // $table->integer('harga_satuan_barang')->nullable();
            // $table->integer('harga_total');
            // $table->foreignId('barang_id')->nullable()->constrained('barangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_masuks');
    }
};
