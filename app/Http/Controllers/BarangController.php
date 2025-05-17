<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Controllers\Controller;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('barang/index', [
            "title" => "Barang",
            "barangs" => Barang::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang/create', [
            "title" => "Barang",
            "kategoris" => KategoriBarang::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'kategori_id' => 'required',
            'satuan' => 'required|max:255',
            'harga' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
        ]);


        Barang::create($validatedData);
        return redirect()->route('barang.index')->with('success', 'Selamat, data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        return view('barang/show', [
            "title" => "Barang",
            "barang" => $barang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        return view('barang/edit', [
            "title" => "Barang",
            "barang" => $barang,
            "kategoris" => KategoriBarang::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'kategori_id' => 'required',
            'satuan' => 'required|max:255',
            'harga' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
        ]);

        $barang->update($validatedData);

        return redirect()->route('barang.index')->with('success', 'Selamat, data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();

        session()->flash('success', 'Selamat, data berhasil dihapus.');
        return response()->json(['status' => 'success']);
    }
}
