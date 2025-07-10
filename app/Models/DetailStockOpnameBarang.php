<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailStockOpnameBarang extends Model
{
    use HasFactory;
    protected $table="detail_stock_opname_barang";

    protected $fillable=[
        'selisih',
        'stok_fisik',
        'keterangan',
    ];

       public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
