<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiMasukDetail;
use App\Services\StockOpnameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index()
    {
        return view('kasir/index', [
            "title" => "Kasir",
            "barangs" => Barang::all(),
            "customers" => Customer::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // field TransaksiMasuk
            'tanggal' => 'required',
            'user_id' => 'required',
            'customer_id' => 'required',
            'sub_total' => 'required',
            'diskon' => 'required',
            'biaya_pengiriman' => 'required',
            'total' => 'required',
            'tanggal_pengiriman' => 'required',
            'alamat_pengiriman' => 'required',
            'catatan_pengiriman' => 'nullable|string',

            // field TransaksiMasukDetail
            'barang_id' => 'required|array',
            'qty_barang' => 'required|array',
            'harga_satuan_barang' => 'required|array',
            'harga_total' => 'required|array',
        ]);

        // -- set kode
        $kode = 1;
        $last_data = TransaksiMasuk::orderBy('id', 'desc')->first();
        if ($last_data) {
            $kode = $last_data->id + 1;
        }
        $kode = str_pad($kode, 4, '0', STR_PAD_LEFT);
        $validatedData['kode'] = "TM-" . $kode;

        try {
            // -- save TransaksiMasuk
            DB::beginTransaction();
            $transaksiMasuk = TransaksiMasuk::create([
                'kode' => $validatedData['kode'],
                'tanggal' => $validatedData['tanggal'],
                'user_id' => $validatedData['user_id'],
                'customer_id' => $validatedData['customer_id'],
                'sub_total' => $validatedData['sub_total'],
                'diskon' => $validatedData['diskon'],
                'biaya_pengiriman' => $validatedData['biaya_pengiriman'],
                'total' => $validatedData['total'],
                'tanggal_pengiriman' => $validatedData['tanggal_pengiriman'],
                'alamat_pengiriman' => $validatedData['alamat_pengiriman'],
                'catatan_pengiriman' => $validatedData['catatan_pengiriman'] ?? null,
            ]);

            // Simpan detail barang
            foreach ($validatedData['barang_id'] as $i => $barangId) {
                // Optional: lewati jika data barang kosong
                if (!$barangId || !$validatedData['qty_barang'][$i]) {
                    continue;
                }

                $transaksiMasukDetail = TransaksiMasukDetail::create([
                    'transaksi_masuk_id' => $transaksiMasuk->id,
                    'barang_id' => $barangId,
                    'qty_barang' => $validatedData['qty_barang'][$i],
                    'harga_satuan_barang' => $validatedData['harga_satuan_barang'][$i],
                    'harga_total' => $validatedData['harga_total'][$i],
                ]);

                 // -- change stock barang
                $barang = Barang::find($barangId);
                $stockOpnameService = new StockOpnameService($barang,$transaksiMasuk->kode,StockOpnameService::BARANG_KELUAR);
                $stockOpnameService->updateQty($transaksiMasukDetail->qty_barang);
            }

            DB::commit();

            return redirect()->route('kasir.index')->with('success', 'Selamat, data berhasil disimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);

            return response()->json([
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
