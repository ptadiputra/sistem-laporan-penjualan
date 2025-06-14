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
        Schema::table('stock_opname', function (Blueprint $table) {
            $table->string('ref_id')->change();
        });

        Schema::table('transaksi_masuks', function (Blueprint $table) {
            $table->softDeletes(); 
        });

        Schema::table('transaksi_keluars', function (Blueprint $table) {
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_opname', function (Blueprint $table) {
            $table->integer('ref_id')->change();
        });

        Schema::table('transaksi_masuks', function (Blueprint $table) {
            $table->dropSoftDeletes(); 
        });

        Schema::table('transaksi_keluars', function (Blueprint $table) {
            $table->dropSoftDeletes(); 
        });
    }
};
