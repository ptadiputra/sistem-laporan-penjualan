<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('akun/index', [
            "title" => "Akun",
            "akuns" => Akun::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('akun/create', [
            "title" => "Akun",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode' => 'required|max:255|unique:akuns',
            'nama' => 'required|max:255',
            'kelompok' => 'required|max:255',
            'normal_post' => 'required',
            // 'kategori_akun_id'=>'required',
        ]);
        Akun::create($validatedData);
        return redirect()->route('akun.index')->with('success', 'Selamat, data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Akun $akun)
    {
        return view('akun/show', [
            "title" => "Akun",
            "akun" => $akun
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Akun $akun)
    {
        return view('akun/edit', [
            "title" => "Akun",
            "akun" => $akun,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Akun $akun)
    {
        $validatedData = $request->validate([
            'kode' =>  [
                'required', 'max:255',
                Rule::unique('akuns')->ignore($akun->id)
            ],
            'nama' => 'required|max:255',
            'kelompok' => 'required|max:255',
            'normal_post' => 'required',
            // 'kategori_akun_id'=>'required',
        ]);

        $akun->update($validatedData);

        return redirect()->route('akun.index')->with('success', 'Selamat, data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Akun $akun)
    {
        $akun->delete();

        session()->flash('success', 'Selamat, data berhasil dihapus.');
        return response()->json(['status' => 'success']);
    }
}
