<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiMasukExport;
use App\Exports\TransaksiKeluarExport;
use App\Exports\JurnalUmumExport;
use App\Exports\BukuBesarExport;
use App\Exports\NeracaExport;
use App\Exports\LabaRugiExport;
use App\Exports\PerubahanModalExport;
use App\Models\JurnalEntry;
use App\Models\TransaksiKeluar;
use App\Models\TransaksiMasuk;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request) {
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
                case 'jurnal-umum':
                    $data = $this->dataJurnalUmum($startDate, $endDate);
                    $partialView = 'laporan/component/tabel_jurnal_umum';
                    break;
                
                case 'buku-besar':
                    $data = $this->dataBukuBesar($startDate, $endDate);
                    $partialView = 'laporan/component/tabel_buku_besar';
                    break;
                
                case 'laba-rugi':
                    $data = $this->dataLabaRugi($startDate, $endDate);
                    $partialView = 'laporan/component/tabel_laba_rugi';
                    break;
                
                case 'perubahan-modal':
                    $data = $this->dataPerubahanModal($startDate, $endDate);
                    $partialView = 'laporan/component/tabel_perubahan_modal';
                    break;
                
                case 'neraca':
                    $data = $this->dataNeraca($startDate, $endDate);
                    $partialView = 'laporan/component/tabel_neraca';
                    break;
                
                case 'transaksi-masuk':
                    $data = $this->dataTransaksiMasuk($startDate, $endDate);
                    $partialView = 'laporan/component/tabel_transaksi_masuk';
                    break;
                
                case 'transaksi-keluar':
                    $data = $this->dataTransaksiKeluar($startDate, $endDate);
                    $partialView = 'laporan/component/tabel_transaksi_keluar';
                    break;
                
                case 'arus-kas':
                    $data = $this->dataArusKas($startDate, $endDate);
                    $partialView = 'laporan/component/tabel_arus_kas';
                    break;

                default:
                    return redirect()->route('laporan.index')->withErrors(['laporan' => 'Laporan tidak valid.']);
            }
            
            $tableHtml = view($partialView, compact('data','periode','laporan'))->render();

            return view('laporan/index', [
                "title" => "Laporan",
                "tableHtml" => $tableHtml
            ]);
        }

        return view('laporan/index', [
            "title" => "Laporan",
        ]);
    }

    public function exportPdf(Request $request) {
        // Proses data berdasarkan input
        $laporan = $request->query('laporan');
        $periode = $request->query('periode');
        
        // Konversi string tanggal ke format yang sesuai
        [$startDate, $endDate] = explode(' - ', $periode);
        $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', $endDate)->endOfDay();

        switch ($laporan) {
            case 'jurnal-umum':
                $data = $this->dataJurnalUmum($startDate, $endDate);
                $partialView = 'laporan/pdf/pdf_jurnal_umum';
                break;
            
            case 'buku-besar':
                $data = $this->dataBukuBesar($startDate, $endDate);
                $partialView = 'laporan/pdf/pdf_buku_besar';
                break;
            
            case 'laba-rugi':
                $data = $this->dataLabaRugi($startDate, $endDate);
                $partialView = 'laporan/pdf/pdf_laba_rugi';
                break;
            
            case 'perubahan-modal':
                $data = $this->dataPerubahanModal($startDate, $endDate);
                $partialView = 'laporan/pdf/pdf_perubahan_modal';
                break;
            
            case 'neraca':
                $data = $this->dataNeraca($startDate, $endDate);
                $partialView = 'laporan/pdf/pdf_neraca';
                break;
            
            case 'transaksi-masuk':
                $data = $this->dataTransaksiMasuk($startDate, $endDate);
                $partialView = 'laporan/pdf/pdf_transaksi_masuk';
                break;
            
            case 'transaksi-keluar':
                $data = $this->dataTransaksiKeluar($startDate, $endDate);
                $partialView = 'laporan/pdf/pdf_transaksi_keluar';
                break;
            
            case 'arus-kas':
                $data = $this->dataArusKas($startDate, $endDate);
                $partialView = 'laporan/pdf/pdf_arus_kas';
                break;

            default:
                return redirect()->route('laporan.index')->withErrors(['laporan' => 'Laporan tidak valid.']);
        }

        // export pdf
        $pdf = Pdf::loadView($partialView, compact('data','periode'));
        return $pdf->stream('laporan-' . $laporan . '.pdf');
    }

    private function dataJurnalUmum($startDate, $endDate) {
        return JurnalEntry::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();
    }

    private function dataBukuBesar($startDate, $endDate) {
        $data = [];
        $entries = JurnalEntry::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->orderBy('tanggal_transaksi', 'desc')
            ->get()
            ->groupBy('akun_id');

        foreach ($entries as $entry) {
            $akun = $entry->first()->akun;
            $saldoDebit=0;
            $saldoKredit=0;
            $data[$akun->nama] = [];
            
            foreach ($entry as $item) {
                $data_entry = [];
                $data_entry['tanggal_transaksi'] = $item->tanggal_transaksi;
                $data_entry['deskripsi'] = $item->deskripsi;
                $data_entry['debet'] = $item->debit ? $item->debit : '';
                $data_entry['kredit'] = $item->kredit ? $item->kredit : '';
                $data_entry['saldo_debet'] = '';
                $data_entry['saldo_kredit'] = '';

                if ($akun->normal_post=='debit') {
                    $currentSaldo = $saldoDebit + ($item->debit - $item->kredit);
                    $data_entry['saldo_debet'] = $currentSaldo;
                    $saldoDebit = $currentSaldo;
                }else{
                    $currentSaldo = $saldoKredit + ($item->kredit - $item->debit);
                    $data_entry['saldo_kredit'] = $currentSaldo;
                    $saldoKredit = $currentSaldo;
                }

                $data[$akun->nama][] = $data_entry;
            }
        }
        
        return $data;
    }

    private function dataLabaRugi($startDate, $endDate) {
        $pendapatan = $this->getTotalLabaRugi($startDate, $endDate, 'Pendapatan');
        $beban = $this->getTotalLabaRugi($startDate, $endDate, 'Beban');
        return [
            'pendapatan' => $pendapatan,
            'beban' => $beban,
            'laba' => $pendapatan['total'] - $beban['total'],
        ];
    }

    private function getTotalLabaRugi($startDate, $endDate, string $kelompok) {
        $data = [];
        $total = 0;
        $entries = JurnalEntry::join('akuns', 'jurnal_entries.akun_id', '=', 'akuns.id')
            ->whereBetween('jurnal_entries.tanggal_transaksi', [$startDate, $endDate])
            ->where('akuns.kelompok', $kelompok)
            ->get(['jurnal_entries.*'])
            ->groupBy('akun_id');
        
        foreach ($entries as $entry) {
            $akun = $entry->first()->akun;
            $total_debit = $entry->sum('debit');
            $total_kredit = $entry->sum('kredit');
            $total_akun = abs($total_debit - $total_kredit);
            $data[$akun->nama] = [
                "kode" => $akun->kode,
                "nama" => $akun->nama,
                "total" => $total_akun,
            ];
            $total += $total_akun;
        }

        return [
            "data" => $data,
            "total" => $total,
        ];
    }

    private function dataPerubahanModal($startDate, $endDate) {
        $modalAwal = DB::table('jurnal_entries')
            ->select('jurnal_entries.debit', 'jurnal_entries.kredit', 'jurnal_entries.id')
            ->join('akuns', 'jurnal_entries.akun_id', '=', 'akuns.id')
            ->where('akuns.kelompok', 'Modal')
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->first();
        
        $penambahanModal = DB::table('jurnal_entries')
            ->join('akuns', 'jurnal_entries.akun_id', '=', 'akuns.id')
            ->where('akuns.kelompok', 'Modal')
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('jurnal_entries.id', '!=', $modalAwal->id??0)
            ->sum(DB::raw('jurnal_entries.debit - jurnal_entries.kredit'));
        
        $prive = DB::table('jurnal_entries')
            ->join('akuns', 'jurnal_entries.akun_id', '=', 'akuns.id')
            ->where('akuns.kelompok', 'Prive')
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->sum(DB::raw('jurnal_entries.debit - jurnal_entries.kredit'));

        $labaBersih = DB::table('jurnal_entries')
            ->join('akuns', 'jurnal_entries.akun_id', '=', 'akuns.id')
            ->whereIn('akuns.kelompok', ['Beban', 'Pendapatan'])
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->sum(DB::raw('jurnal_entries.debit - jurnal_entries.kredit'));

        $modalAwalValue = ($modalAwal->debit??0)-($modalAwal->kredit ?? 0);
        $labaBersihValue = $labaBersih ?? 0;
        $modalAkhir = abs($modalAwalValue) + abs($penambahanModal) + abs($labaBersihValue) - abs($prive);

        return [
            "modal_awal" => abs($modalAwalValue),
            "laba_bersih" => abs($labaBersihValue),
            "penambahan_modal" => abs($penambahanModal),
            "prive" => abs($prive),
            "modal_akhir" => $modalAkhir,
        ];
    }

    private function dataNeraca($startDate, $endDate) {
        return [
            "aktiva" => $this->getDataNeracaAktiva($startDate, $endDate, ['Aset/Aktiva']),
            "pasiva" => $this->getDataNeracaPasiva($startDate, $endDate),
        ];
    }

    private function getDataNeracaAktiva($startDate, $endDate, array $kelompok) {
        $data = [];
        $total = 0;
        $entries = JurnalEntry::join('akuns', 'jurnal_entries.akun_id', '=', 'akuns.id')
            ->whereBetween('jurnal_entries.tanggal_transaksi', [$startDate, $endDate])
            ->whereIn('akuns.kelompok', $kelompok)
            ->get(['jurnal_entries.*'])
            ->groupBy('akun_id');
        
        foreach ($entries as $entry) {
            $akun = $entry->first()->akun;
            $total_debit = $entry->sum('debit');
            $total_kredit = $entry->sum('kredit');
            $total_akun = abs($total_debit - $total_kredit);
            $data[$akun->nama] = [
                "kode" => $akun->kode,
                "nama" => $akun->nama,
                "total" => $total_akun,
            ];
            $total += $total_akun;
        }

        return [
            "data" => $data,
            "total" => $total,
        ];
    }
    
    private function getDataNeracaPasiva($startDate, $endDate) {
        $data = [];
        $total = 0;
        $entries = JurnalEntry::join('akuns', 'jurnal_entries.akun_id', '=', 'akuns.id')
            ->whereBetween('jurnal_entries.tanggal_transaksi', [$startDate, $endDate])
            ->whereIn('akuns.kelompok', ['Liabilitas', 'Ekuitas'])
            ->where('akuns.nama', '!=', 'modal')
            ->get(['jurnal_entries.*'])
            ->groupBy('akun_id');
        
        foreach ($entries as $entry) {
            $akun = $entry->first()->akun;
            $total_debit = $entry->sum('debit');
            $total_kredit = $entry->sum('kredit');
            $total_akun = abs($total_debit - $total_kredit);
            $data[$akun->nama] = [
                "kode" => $akun->kode,
                "nama" => $akun->nama,
                "total" => $total_akun,
            ];
            $total += $total_akun;
        }

        // -- get total perubahan modal
        $modal_akhir = $this->dataPerubahanModal($startDate, $endDate);
        $data['modal'] = [
            "kode" => '',
            "nama" => 'Total Modal',
            "total" => $modal_akhir['modal_akhir'],
        ];
        $total += $modal_akhir['modal_akhir'];

        return [
            "data" => $data,
            "total" => $total,
        ];
    }

    private function dataTransaksiMasuk($startDate, $endDate) {
        // $data = TransaksiMasuk::join('akuns', 'transaksi_masuks.akun_id', '=', 'akuns.id')
        $data = TransaksiMasuk::whereBetween('transaksi_masuks.tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();
        $total = $data->sum('total');

        return [
            "data" => $data,
            "total" => $total,
        ];
    }
    
    private function dataTransaksiKeluar($startDate, $endDate) {
        // $data = TransaksiKeluar::join('akuns', 'transaksi_keluars.akun_id', '=', 'akuns.id')
        $data = TransaksiKeluar::whereBetween('transaksi_keluars.tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();
        $total = $data->sum('harga_total');

        return [
            "data" => $data,
            "total" => $total,
        ];
    }
    
    private function dataArusKas($startDate, $endDate) {
        $data = JurnalEntry::join('akuns', 'jurnal_entries.akun_id', '=', 'akuns.id')
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('akuns.kelompok', 'Kas')
            ->orderBy('tanggal_transaksi', 'desc')
            ->select(
                'jurnal_entries.*', 'akuns.*', 
                DB::raw('jurnal_entries.debit - jurnal_entries.kredit as jumlah')
            )
            ->get();
        $total = $data->sum('jumlah');

        return [
            "data" => $data,
            "total" => $total,
        ];
    }

    public function export(Request $request) {
        $validatedData = $request->validate([
            'kategori' => 'required',
            'bulan' => 'required',
            'tahun' => 'required',
        ]);

        switch ($request->input('kategori')) {
            case 'transaksi-masuk':
                return $this->exportTransaksiMasuk($request);

            case 'transaksi-keluar':
                return $this->exportTransaksiKeluar($request);

            case 'jurnal-umum':
                return $this->exportJurnalUmum($request);

            case 'buku-besar':
                return $this->exportBukuBesar($request);

            case 'neraca':
                return $this->exportNeraca($request);

            case 'laba-rugi':
                return $this->exportLabaRugi($request);

            case 'perubahan-modal':
                return $this->exportPerubahanModal($request);

            // case 'arus-kas':
            //     return $this->exportArusKas($request);

            default:
                return response()->json(['error' => 'Kategori tidak valid'], 400);
        }
    }

    private function exportTransaksiMasuk(Request $request)
    {
        $export = new TransaksiMasukExport($request->bulan, $request->tahun);

        return Excel::download($export, 'transaksi_masuk.xlsx');
    }

    private function exportTransaksiKeluar(Request $request)
    {
        $export = new TransaksiKeluarExport($request->bulan, $request->tahun);

        return Excel::download($export, 'transaksi_keluar.xlsx');
    }

    private function exportJurnalUmum(Request $request)
    {
        $export = new JurnalUmumExport($request->bulan, $request->tahun);

        return Excel::download($export, 'jurnal-umum.xlsx');
    }

    private function exportBukuBesar(Request $request)
    {
        $export = new BukuBesarExport($request->bulan, $request->tahun);

        return Excel::download($export, 'buku-besar.xlsx');
    }

    private function exportNeraca(Request $request)
    {
        $export = new NeracaExport($request->bulan, $request->tahun);

        return Excel::download($export, 'neraca.xlsx');
    }

    private function exportLabaRugi(Request $request)
    {
        $export = new LabaRugiExport($request->bulan, $request->tahun);

        return Excel::download($export, 'laba-rugi.xlsx');
    }

    private function exportPerubahanModal(Request $request)
    {
        $export = new PerubahanModalExport($request->bulan, $request->tahun);

        return Excel::download($export, 'perubahan-modal.xlsx');
    }
}
