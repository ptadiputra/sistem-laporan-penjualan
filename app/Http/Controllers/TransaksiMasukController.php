<?php

namespace App\Http\Controllers;

use App\Models\TransaksiMasuk;
use App\Models\User;
use App\Models\Jasa;
use App\Models\Barang;
use App\Http\Controllers\Controller;
use App\Models\Akun;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TransaksiMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transaksi_masuk/index', [
            "title" => "Transaksi Masuk",
            "transaksi_masuks" => TransaksiMasuk::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaksi_masuk/create', [
            "title" => "Transaksi Masuk",
            "barangs" => Barang::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required',
            'user_id' => 'required',
            'barang_id' => 'required',
            'qty_barang' => 'required|numeric|min:1',
            'harga_satuan_barang' => 'required',
            'harga_total' => 'required',
            'akun' => 'required',
            'tanggal_pengiriman' => 'required',
            'catatan_pengiriman' => 'nullable|string',
        ]);

        // -- set kode
        $kode = 1;
        $last_data = TransaksiMasuk::orderBy('id', 'desc')->first();
        if ($last_data) {
            $kode = $last_data->id + 1;
        }
        $kode = str_pad($kode, 4, '0', STR_PAD_LEFT);
        
        // -- save data
        $validatedData['kode'] =  "TM-".$kode;
        $transaksiMasuk =  TransaksiMasuk::create($validatedData);

        // -- change stock barang
        $qty = $transaksiMasuk->qty_barang;
        $barang = $transaksiMasuk->barang;
        $barang->stock -= $qty;
        $barang->save();

        return redirect()->route('transaksi-masuk.index')->with('success', 'Selamat, data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TransaksiMasuk $transaksiMasuk)
    {
        return view('transaksi_masuk/show', [
            "title" => "Transaksi Masuk",
            "transaksi_masuk" => $transaksiMasuk
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransaksiMasuk $transaksiMasuk)
    {
        return view('transaksi_masuk/edit', [
            "title" => "Transaksi Masuk",
            "barangs" => Barang::all(),
            "transaksi_masuk" => $transaksiMasuk,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransaksiMasuk $transaksiMasuk)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required',
            'barang_id' => 'required',
            'qty_barang' => 'required|numeric|min:1',
            'harga_satuan_barang' => 'required',
            'harga_total' => 'required',
            'tanggal_pengiriman' => 'required',
            'catatan_pengiriman' => 'nullable|string',
        ]);

        $transaksiMasuk->update($validatedData);

        return redirect()->route('transaksi-masuk.index')->with('success', 'Selamat, data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiMasuk $transaksiMasuk)
    {
        $transaksiMasuk->delete();

        session()->flash('success', 'Selamat, data berhasil dihapus.');
        return response()->json(['status' => 'success']);
    }

    public function nota(TransaksiMasuk $transaksiMasuk)
    {
        // export pdf
        $transaksi = $transaksiMasuk;
        $partialView = 'transaksi_masuk/pdf/pdf_nota';
        $pdf = Pdf::loadView($partialView, compact('transaksi'))
            ->setPaper('a5', 'portrait');
        return $pdf->stream('nota-' . $transaksi->kode . '.pdf');

        // return view('transaksi_masuk/pdf/pdf_nota', [
        //     "title" => "Transaksi Masuk",
        //     "transaksi" => $transaksiMasuk
        // ]);
    }
}
