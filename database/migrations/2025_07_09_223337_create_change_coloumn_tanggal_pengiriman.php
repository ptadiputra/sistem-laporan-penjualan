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
       Schema::table('transaksi_masuks', function (Blueprint $table) {
            $table->string('alamat_pengiriman')->nullable()->change();
            $table->foreignId('pengiriman_id')->nullable()->change();
            $table->dateTime('tanggal_pengiriman')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_masuks', function (Blueprint $table) {
            // $table->date('tanggal_pengiriman')->nullable(false)->change();
            // $table->string('alamat_pengiriman')->nullable(false)->change();
        });
    }
};
