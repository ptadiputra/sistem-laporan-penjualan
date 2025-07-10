<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Controllers\Controller;
use App\Models\DetailStockOpnameBarang;
use App\Models\KategoriBarang;
use App\Models\StockOpname;
use App\Models\StockOpnameBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;

class StokOpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('stock_opname/index', [
            "title" => "Stok Opname",
            "opnames" => StockOpnameBarang::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $tanggalHariIni = now()->startOfDay();

            $sudahAda = StockOpnameBarang::whereYear('tanggal', $tanggalHariIni->year)
                ->whereMonth('tanggal', $tanggalHariIni->month)
                ->exists();

            if ($sudahAda) {
          return redirect()->route('stock_opname.index', ['error' => 'Stock Opname untuk bulan ini sudah dibuat.']);


            }

            $opname = StockOpnameBarang::create([
                'tanggal' => $tanggalHariIni,
            ]);

            $barangs = Barang::all();
            $items = [];

            foreach ($barangs as $barang) {
                $items[] = [
                    'stock_opname_barang_id' => $opname->id,
                    'barang_id' => $barang->id,
                    'stok_sistem' => $barang->stock,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DetailStockOpnameBarang::insert($items);

            DB::commit();

            return redirect()->route('stock_opname.index')->with('success', 'Stock Opname berhasil disimpan untuk bulan ini.');
        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);

            return response()->json([
                'error' => $th->getMessage(),
            ], 500);
        }
    }


    public function show($id)
    {
        $detailStockOpname = DetailStockOpnameBarang::where('stock_opname_barang_id', $id)->get();
        $opname = StockOpnameBarang::where('id', $id)->first();

        return view('stock_opname/show', [
            "title" => "Stock Opname",
            "items" => $detailStockOpname,
            "opname" => $opname,
        ]);
    }

    public function edit_item($id)
    {
        return view('stock_opname/edit', [
            "title" => "Stock Opname",
            "item" => DetailStockOpnameBarang::where('id',$id)->first(),
        ]);
    }

   public function update_item(Request $request, $id)
{
    $item = DetailStockOpnameBarang::findOrFail($id);

    $validatedData = $request->validate([
        'stok_fisik' => 'required|numeric',
        'keterangan' => 'nullable',
    ]);

    $stokSistem = $item->stok_sistem;
    $stokFisik = $validatedData['stok_fisik'];

    if ($stokFisik > $stokSistem) {
        $selisih = 'lebih ' . ($stokFisik - $stokSistem) . ' unit';
    } elseif ($stokFisik < $stokSistem) {
        $selisih = 'kurang ' . ($stokSistem - $stokFisik) . ' unit';
    } else {
        $selisih = '0';
    }

    $item->update([
        'stok_fisik' => $stokFisik,
        'keterangan' => $validatedData['keterangan'],
        'selisih' => $selisih,
    ]);

  return redirect()->route('stock_opname.show', $item->stock_opname_barang_id)->with('success', 'Selamat, data berhasil diubah.');


}



}
