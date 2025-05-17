<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalEntry extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal_transaksi' => 'date',
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class);
    }
}
