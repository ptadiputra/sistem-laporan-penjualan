<?php

namespace App\Http\Controllers;

use App\Models\JurnalEntry;
use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;

class JurnalEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('jurnal_entry/index', [
            "title" => "Jurnal Entry",
            "jurnal_entrys" => JurnalEntry::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jurnal_entry/create', [
            "title" => "Jurnal Entry",
            "akuns" => Akun::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'akun_id' => 'required',
            'tanggal_transaksi' => 'required',
            'debit' => 'required|numeric|min:0',
            'kredit' => 'required|numeric|min:0',
            'deskripsi' => 'required',
        ]);

        JurnalEntry::create($validatedData);
        return redirect()->route('jurnal-entry.index')->with('success', 'Selamat, data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JurnalEntry $jurnalEntry)
    {
        return view('jurnal_entry/show', [
            "title" => "Jurnal Entry",
            "jurnal_entry" => $jurnalEntry
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JurnalEntry $jurnalEntry)
    {
        return view('jurnal_entry/edit', [
            "title" => "Jurnal Entry",
            "jurnal_entry" => $jurnalEntry,
            "akuns" => Akun::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JurnalEntry $jurnalEntry)
    {
        $validatedData = $request->validate([
            'akun_id' => 'required',
            'tanggal_transaksi' => 'required',
            'debit' => 'required|numeric|min:0',
            'kredit' => 'required|numeric|min:0',
            'deskripsi' => 'required',
        ]);

        $jurnalEntry->update($validatedData);
        return redirect()->route('jurnal-entry.index')->with('success', 'Selamat, data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JurnalEntry $jurnalEntry)
    {
        $jurnalEntry->delete();

        session()->flash('success', 'Selamat, data berhasil dihapus.');
        return response()->json(['status' => 'success']);
    }
}
