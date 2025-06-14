<?php

namespace App\Services;

use App\Models\Barang;

class StockOpnameService
{
    public const BARANG_MASUK = 'barang_masuk';
    public const CANCEL_BARANG_MASUK = 'cancel_barang_masuk';
    public const BARANG_KELUAR = 'barang_keluar';
    public const CANCEL_BARANG_KELUAR = 'cancel_barang_keluar';

    private Barang $stock;
    private string $ref_id;
    private string $ref_type;
    public function __construct($stock, $ref_id, $ref_type)
    {
        $this->ref_id = $ref_id;
        $this->ref_type = $ref_type;
        $this->stock = $stock;
    }

    public function updateQty(int $qty)
    {
        if (0 === $qty) {
            return;
        }

        if (
            StockOpnameService::BARANG_KELUAR == $this->ref_type ||
            StockOpnameService::CANCEL_BARANG_MASUK == $this->ref_type
        ) {
            $qty *= -1;
        } else {
            $qty *= 1;
        }

        $this->stock->stockOpname()->create([
            'ref_type'     => $this->ref_type,
            'ref_id'       => $this->ref_id,
            'prev_qty'     => $this->stock->stock,
            'trx_qty'      => $qty,
            'curr_qty'     => $this->stock->stock + $qty,
        ]);

        $this->stock->increment('stock', $qty);
    }

}