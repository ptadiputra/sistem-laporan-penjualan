<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKeluar;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\User;
use App\Services\StockOpnameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransaksiKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transaksi_keluar/index', [
            "title" => "Transaksi Keluar",
            "transaksi_keluars" => TransaksiKeluar::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaksi_keluar/create', [
            "title" => "Transaksi Keluar",
            "users" => User::all(),
            "suppliers" => Supplier::all(),
            "barangs" => Barang::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'tanggal' => 'required',
            'supplier_id' => 'required',
            'barang_id' => 'required',
            'satuan' => 'required',
            'qty' => 'required|numeric|min:1',
            'harga_satuan' => 'required',
            'harga_total' => 'required',
            'keterangan' => 'nullable|string',
        ]);

        // -- set kode
        $kode = 1;
        $last_data = TransaksiKeluar::orderBy('id', 'desc')->first();
        if ($last_data) {
            $kode = $last_data->id + 1;
        }
        $kode = str_pad($kode, 4, '0', STR_PAD_LEFT);

        // -- save data
        $validatedData['kode'] = "TK-" . $kode;
        try {
            DB::beginTransaction();
            $transaksiKeluar = TransaksiKeluar::create($validatedData);

            // -- change stock barang
            $barang = Barang::find($transaksiKeluar->barang_id);
            $stockOpnameService = new StockOpnameService($barang, $transaksiKeluar->kode, StockOpnameService::BARANG_MASUK);
            $stockOpnameService->updateQty($transaksiKeluar->qty);
            DB::commit();

            return redirect()->route('transaksi-keluar.index')->with('success', 'Selamat, data berhasil disimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);

            return response()->json([
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TransaksiKeluar $transaksiKeluar)
    {
        return view('transaksi_keluar/show', [
            "title" => "Transaksi Keluar",
            "transaksi_keluar" => $transaksiKeluar
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransaksiKeluar $transaksiKeluar)
    {
        return view('transaksi_keluar/edit', [
            "title" => "Transaksi Keluar",
            "users" => User::all(),
            "suppliers" => Supplier::all(),
            "barangs" => Barang::all(),
            "transaksi_keluar" => $transaksiKeluar,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransaksiKeluar $transaksiKeluar)
    {
        $old_transaksiKeluar = clone $transaksiKeluar;
        $old_barang = $transaksiKeluar->barang;

        $validatedData = $request->validate([
            'tanggal' => 'required',
            'supplier_id' => 'required',
            'barang_id' => 'required',
            'satuan' => 'required',
            'qty' => 'required|numeric|min:1',
            'harga_satuan' => 'required',
            'harga_total' => 'required',
            'keterangan' => 'nullable|string',
        ]);
        try {
            DB::beginTransaction();
            $transaksiKeluar->update($validatedData);
            $transaksiKeluar->refresh();

            if ($transaksiKeluar->barang->id == $old_barang->id) {
                $barang = Barang::find($transaksiKeluar->barang_id);
                $stockOpnameService = new StockOpnameService($barang, $transaksiKeluar->kode, StockOpnameService::CANCEL_BARANG_MASUK);
                $stockOpnameService->updateQty($old_transaksiKeluar->qty);

                $stockOpnameService = new StockOpnameService($barang, $transaksiKeluar->kode, StockOpnameService::BARANG_MASUK);
                $stockOpnameService->updateQty($transaksiKeluar->qty);
            } else {
                // -- kurangi stock pada barang lama
                $barang = Barang::find($old_barang->id);
                $stockOpnameService = new StockOpnameService($barang, $transaksiKeluar->id, StockOpnameService::CANCEL_BARANG_MASUK);
                $stockOpnameService->updateQty($old_transaksiKeluar->qty);

                // -- tambahkan stock pada barang baru
                $barang = Barang::find($transaksiKeluar->barang_id);
                $stockOpnameService = new StockOpnameService($barang, $transaksiKeluar->id, StockOpnameService::BARANG_MASUK);
                $stockOpnameService->updateQty($transaksiKeluar->qty);
            }
            DB::commit();
            return redirect()->route('transaksi-keluar.index')->with('success', 'Selamat, data berhasil diubah.');
        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);

            return response()->json([
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiKeluar $transaksiKeluar)
    {
        try {
            DB::beginTransaction();
            // -- kurangi stock barang
            $barang = Barang::find($transaksiKeluar->barang_id);
            $stockOpnameService = new StockOpnameService($barang, $transaksiKeluar->kode, StockOpnameService::CANCEL_BARANG_MASUK);
            $stockOpnameService->updateQty($transaksiKeluar->qty);

            $transaksiKeluar->delete();
            DB::commit();
            session()->flash('success', 'Selamat, data berhasil dihapus.');
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);

            return response()->json([
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function harga_barang($id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return response()->json(['harga' => 0]);
        }
        return response()->json(['harga' => $barang->harga]);
    }
}
