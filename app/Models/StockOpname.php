<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;
    protected $table="stock_opname";
    protected $fillable = [
        "barang_id",
        "ref_id",
        "ref_type",
        "prev_qty",
        "trx_qty",
        "curr_qty"
    ];
}
