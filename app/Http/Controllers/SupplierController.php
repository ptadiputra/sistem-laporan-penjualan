<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('supplier/index', [
            "title" => "Supplier",
            "suppliers" => Supplier::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier/create', [
            "title" => "Supplier",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'no_tlp' => 'required|min:5|max:255|unique:suppliers',
            'alamat' => 'required',
        ]);

        Supplier::create($validatedData);
        return redirect()->route('supplier.index')->with('success', 'Selamat, data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('supplier/show', [
            "title" => "Supplier",
            "supplier" => $supplier
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier/edit', [
            "title" => "Supplier",
            "supplier" => $supplier,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $rules = [
            'nama' => 'required|max:255',
            'no_tlp' => [
                'required', 'min:5', 'max:255', 
                Rule::unique('suppliers')->ignore($supplier->id)
            ],
            'alamat' => 'required',
        ];
        $validatedData = $request->validate($rules);

        $supplier->update($validatedData);

        return redirect()->route('supplier.index')->with('success', 'Selamat, data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        session()->flash('success', 'Selamat, data berhasil dihapus.');
        return response()->json(['status' => 'success']);
    }
}
