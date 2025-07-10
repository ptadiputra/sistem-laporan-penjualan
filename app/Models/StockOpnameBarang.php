<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpnameBarang extends Model
{
    use HasFactory;
    protected $table="stock_opname_barang";

    protected $fillable =[
        'tanggal',
    ];

   
}
