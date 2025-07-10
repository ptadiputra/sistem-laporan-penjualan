<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Controllers\Controller;
use App\Models\KategoriBarang;
use App\Models\Pengiriman;
use App\Models\StockOpname;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pengiriman/index', [
            "title" => "Pengiriman",
            "pengirimans" => Pengiriman::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengiriman/create', [
            "title" => "Pengiriman",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'daerah_pengiriman' => 'required',
            'harga_pengiriman' => 'required',
        ]);

        Pengiriman::create($validatedData);
        return redirect()->route('pengiriman.index')->with('success', 'Selamat, data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengiriman $pengiriman)
    {
        return view('pengiriman/show', [
            "title" => "Pengiriman",
            "pengiriman" => $pengiriman,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengiriman $pengiriman)
    {
        return view('pengiriman/edit', [
            "title" => "pengiriman",
            "pengiriman" => $pengiriman,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengiriman $pengiriman)
    {
        $validatedData = $request->validate([
            'daerah_pengiriman' => 'required',
            'harga_pengiriman' => 'required',
        ]);

        $pengiriman->update($validatedData);

        return redirect()->route('pengiriman.index')->with('success', 'Selamat, data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengiriman $pengiriman)
    {
        $pengiriman->delete();

        session()->flash('success', 'Selamat, data berhasil dihapus.');
        return response()->json(['status' => 'success']);
    }
}
