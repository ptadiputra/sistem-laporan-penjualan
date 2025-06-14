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
        Schema::create('stock_opname', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->nullable()->constrained('barangs')->onDelete('cascade');
            $table->integer('ref_id');
            $table->string('ref_type',50);
            $table->integer('prev_qty');
            $table->integer('trx_qty');
            $table->integer('curr_qty');
            $table->timestamps();
        });

        Schema::table('transaksi_masuks', function (Blueprint $table) {
            $table->dropColumn('akun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_opname');
    }
};
