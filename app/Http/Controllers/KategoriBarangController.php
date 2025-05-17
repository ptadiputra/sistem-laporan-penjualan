<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKategoriBarangRequest;
use App\Http\Requests\UpdateKategoriBarangRequest;

class KategoriBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kategori-barang/index', [
            "title" => "Kategori Barang",
            "kategori_barangs" => KategoriBarang::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori-barang/create', [
            "title" => "Kategori Barang",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKategoriBarangRequest $request)
    {
        KategoriBarang::create($request->validated());

        return redirect()
            ->route('kategori-barang.index')
            ->with('success', 'Selamat, data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriBarang $kategoriBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriBarang $kategoriBarang)
    {
        return view('kategori-barang/edit', [
            "title" => "Kategori Barang",
            "kategori_barang" => $kategoriBarang,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriBarangRequest $request, KategoriBarang $kategoriBarang)
    {
        $kategoriBarang->update($request->validated());

        return redirect()
            ->route('kategori-barang.index')
            ->with('success', 'Data kategori barang berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriBarang $kategoriBarang)
    {
        $kategoriBarang->delete();

        session()->flash('success', 'Selamat, data berhasil dihapus.');
        return response()->json(['status' => 'success']);
    }
}
