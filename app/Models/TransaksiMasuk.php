<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiMasuk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal' => 'date',
        'tanggal_pengiriman' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // public function barang()
    // {
    //     return $this->belongsTo(Barang::class);
    // }

    public function transaksiMasukDetail()
    {
        return $this->hasMany(TransaksiMasukDetail::class);
    }

}
