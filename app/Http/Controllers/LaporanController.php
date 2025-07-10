<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StockOpnameBarang;
use App\Services\StockOpnameService;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\TransaksiKeluar;
use App\Models\TransaksiMasuk;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has(['laporan', 'periode'])) {
            try {
                // Validasi input
                $validatedData = $request->validate([
                    'laporan' => 'required',
                    'periode' => 'required',
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return redirect()->route('laporan.index')->withErrors($e->validator)->withInput();
            }

            // Proses data berdasarkan input
            $laporan = $validatedData['laporan'];
            $periode = $validatedData['periode'];

            // Konversi string tanggal ke format yang sesuai
            [$startDate, $endDate] = explode(' - ', $periode);
            $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', $endDate)->endOfDay();

            switch ($laporan) {
                case 'transaksi-masuk':
                    $data = $this->dataTransaksiMasuk($startDate, $endDate);
                    $partialView = 'laporan/component/tabel_transaksi_masuk';
                    break;

                case 'transaksi-keluar':
                    $data = $this->dataTransaksiKeluar($startDate, $endDate);
                    $partialView = 'laporan/component/tabel_transaksi_keluar';
                    break;

                case 'data-barang':
                    $data = $this->dataBarang($startDate, $endDate);
                    $partialView = 'laporan/component/tabel_data_barang';
                    break;

                case 'data-supplier':
                    $data = $this->dataSupplier($startDate, $endDate);
                    $partialView = 'laporan/component/tabel_data_supplier';
                    break;

                case 'pareto-produk':
                    $data = $this->paretoProduk($startDate, $endDate);
                    $partialView = 'laporan/component/tabel_pareto_produk';
                    break;

                case 'stock-opname':
                    $data = $this->stockOpname($startDate, $endDate);
                    $partialView = 'laporan/component/tabel_stock_opname';
                    break;

                default:
                    return redirect()->route('laporan.index')->withErrors(['laporan' => 'Laporan tidak valid.']);
            }

            $tableHtml = view($partialView, compact('data', 'periode', 'laporan'))->render();

            return view('laporan/index', [
                "title" => "Laporan",
                "tableHtml" => $tableHtml
            ]);
        }

        return view('laporan/index', [
            "title" => "Laporan",
        ]);
    }

    public function exportPdf(Request $request)
    {
        // Proses data berdasarkan input
        $laporan = $request->query('laporan');
        $periode = $request->query('periode');

        // Konversi string tanggal ke format yang sesuai
        [$startDate, $endDate] = explode(' - ', $periode);
        $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', $endDate)->endOfDay();

        switch ($laporan) {
            case 'transaksi-masuk':
                $data = $this->dataTransaksiMasuk($startDate, $endDate);
                $partialView = 'laporan/pdf/pdf_transaksi_masuk';
                break;

            case 'transaksi-keluar':
                $data = $this->dataTransaksiKeluar($startDate, $endDate);
                $partialView = 'laporan/pdf/pdf_transaksi_keluar';
                break;

            case 'data-barang':
                $data = $this->dataBarang();
                $partialView = 'laporan/pdf/pdf_data_barang';
                break;

            case 'data-supplier':
                $data = $this->dataSupplier();
                $partialView = 'laporan/pdf/pdf_data_supplier';
                break;

            case 'pareto-produk':
                $data = $this->paretoProduk($startDate, $endDate);
                $partialView = 'laporan/pdf/pdf_pareto_produk';
                break;
            case 'stock-opname':
                $data = $this->stockOpname($startDate, $endDate);
                $partialView = 'laporan/pdf/pdf_stok_opname';
                break;
            default:
                return redirect()->route('laporan.index')->withErrors(['laporan' => 'Laporan tidak valid.']);
        }

        // export pdf
        $pdf = Pdf::loadView($partialView, compact('data', 'periode'));
        if ($laporan === 'stock-opname') {
            $pdf->setPaper('a4', 'landscape');
        }
        return $pdf->stream('laporan-' . $laporan . '.pdf');
    }

    private function dataTransaksiMasuk($startDate, $endDate)
    {
        $data = TransaksiMasuk::whereBetween('transaksi_masuks.tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();
        $total = $data->sum('total');

        return [
            "data" => $data,
            "total" => $total,
        ];
    }

    private function dataTransaksiKeluar($startDate, $endDate)
    {
        $data = TransaksiKeluar::whereBetween('transaksi_keluars.tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();
        $total = $data->sum('harga_total');

        return [
            "data" => $data,
            "total" => $total,
        ];
    }

    private function dataBarang()
    {
        $data = Barang::orderBy('stock', 'desc')->get();
        $total = $data->sum(function ($item) {
            return $item->stock * $item->harga;
        });

        return [
            "data" => $data,
            "total" => $total,
        ];
    }

    private function dataSupplier()
    {
        $data = Supplier::get();

        return [
            "data" => $data
        ];
    }

    private function paretoProduk($startDate, $endDate)
    {
        $data = DB::table('transaksi_masuks')
            ->select(
                'barangs.nama',
                DB::raw('SUM(transaksi_masuk_details.qty_barang) as total_qty'),
                DB::raw('SUM(transaksi_masuk_details.harga_total) as total_harga')
            )
            ->join('transaksi_masuk_details', 'transaksi_masuk_details.transaksi_masuk_id', '=', 'transaksi_masuks.id')
            ->join('barangs', 'transaksi_masuk_details.barang_id', '=', 'barangs.id')
            ->whereBetween('transaksi_masuks.tanggal', [$startDate, $endDate])
            ->groupBy('transaksi_masuk_details.barang_id', 'barangs.nama')
            ->orderByDesc('transaksi_masuk_details.harga_total')
            ->get();

        $total = $data->sum('total_harga');

        return [
            "data" => $data,
            "total" => $total,
        ];
    }

    private function stockOpname2($start_date, $end_date)
    {
        $start = Carbon::parse($start_date)->startOfDay();
        $end = Carbon::parse($end_date)->endOfDay();

        // Ambil data barang dengan relasi stockOpname
        $barangs = Barang::with('stockOpname')->get();

        // Hitung laporan per barang
        $data = $barangs->map(function ($barang) use ($start, $end) {
            $opnames = $barang->stockOpname;

            // Cari stok awal sebelum periode
            $before = $opnames->where('created_at', '<', $start)->sortByDesc('created_at')->first();
            $stok_awal = $before ? $before->curr_qty : 0;

            // Ambil transaksi dalam periode
            $filtered = $opnames->filter(
                fn($item) =>
                $item->created_at >= $start && $item->created_at <= $end
            );

            $masuk = $filtered->whereIn('ref_type', [StockOpnameService::BARANG_MASUK, StockOpnameService::CANCEL_BARANG_KELUAR])->sum('trx_qty');
            $keluar = $filtered
                ->whereIn('ref_type', [StockOpnameService::BARANG_KELUAR, StockOpnameService::CANCEL_BARANG_MASUK])
                ->map(fn($item) => abs($item->trx_qty))
                ->sum();
            $akhir = $stok_awal + $masuk - $keluar;

            return [
                'nama' => $barang->nama,
                'satuan' => $barang->satuan,
                'harga' => $barang->harga,
                'stok_awal' => $stok_awal,
                'nilai_awal' => $stok_awal * $barang->harga,
                'masuk' => $masuk,
                'nilai_masuk' => $masuk * $barang->harga,
                'keluar' => $keluar,
                'nilai_keluar' => $keluar * $barang->harga,
                'stok_akhir' => $akhir,
                'nilai_akhir' => $akhir * $barang->harga,
            ];
        });

        return [
            "data" => $data,
        ];
    }

    private function stockOpname($start_date, $end_date)
    {
        $data = StockOpnameBarang::select(
            'barangs.nama',
            'kategori_barangs.nama as kategori',
            'barangs.satuan',
            'detail_stock_opname_barang.stok_sistem',
            'detail_stock_opname_barang.stok_fisik',
            'detail_stock_opname_barang.selisih',
            'detail_stock_opname_barang.keterangan'
        )
            ->join('detail_stock_opname_barang', 'stock_opname_barang.id', '=', 'detail_stock_opname_barang.stock_opname_barang_id')
            ->join('barangs', 'detail_stock_opname_barang.barang_id', 'barangs.id')
            ->join('kategori_barangs', 'barangs.kategori_id', 'kategori_barangs.id')
            ->whereBetween('stock_opname_barang.tanggal', [$start_date, $end_date])
            ->get();

        return [
            "data" => $data,
        ];
    }

}
