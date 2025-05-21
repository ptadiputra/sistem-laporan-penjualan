<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKeluar;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

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
        $validatedData['kode'] =  "TK-".$kode;
        $transaksiKeluar =  TransaksiKeluar::create($validatedData);

        // -- change stock barang
        $qty = $transaksiKeluar->qty;
        $barang = $transaksiKeluar->barang;
        $barang->stock += $qty;
        $barang->save();

        return redirect()->route('transaksi-keluar.index')->with('success', 'Selamat, data berhasil disimpan.');
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

        $transaksiKeluar->update($validatedData);
        $transaksiKeluar->refresh();

        if ($transaksiKeluar->barang->id == $old_barang->id) {
            $qty_diff = $transaksiKeluar->qty - $old_transaksiKeluar->qty;
            $barang = $transaksiKeluar->barang;
            $barang->stock += $qty_diff;
            $barang->save();
        } else {
            // -- kurangi stock pada barang lama
            $qty = $old_transaksiKeluar->qty;
            $old_barang->stock -= $qty;
            $old_barang->save();

            // -- tambahkan stock pada barang baru
            $qty = $transaksiKeluar->qty;
            $barang = $transaksiKeluar->barang;
            $barang->stock += $qty;
            $barang->save();
        }

        return redirect()->route('transaksi-keluar.index')->with('success', 'Selamat, data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiKeluar $transaksiKeluar)
    {
        // -- kurangi stock barang
        $qty = $transaksiKeluar->qty;
        $barang = $transaksiKeluar->barang;
        $barang->stock -= $qty;
        $barang->save();

        $transaksiKeluar->delete();

        session()->flash('success', 'Selamat, data berhasil dihapus.');
        return response()->json(['status' => 'success']);
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
