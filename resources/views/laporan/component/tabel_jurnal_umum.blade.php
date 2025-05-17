<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Laporan Jurnal Umum</h4>
        <p class="font-italic mb-0">Periode: {{ $periode }}</p>
    </div>
    <div>
        <a href="{{ route('laporan.exportPdf', ['laporan' => $laporan, 'periode' => $periode]) }}" class="btn btn-info" target="_blank"><i class="fas fa-file-pdf"></i> Export PDF</a>
    </div>
</div>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th scope="col">No</th>
        <th scope="col">Tanggal</th>
        <th scope="col">Deskripsi</th>
        <th scope="col">Akun</th>
        <th scope="col">Kode</th>
        <th scope="col">Debet</th>
        <th scope="col">Kredit</th>
    </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->tanggal_transaksi->format('d/m/Y') }}</td>
                <td>{{ $item->deskripsi }}</td>
                <td>{{ $item->akun->nama }}</td>
                <td>{{ $item->akun->kode }}</td>
                @if($item->debit > 0)
                    <td class="to-currency">{{ $item->debit }}</td>
                @else
                    <td></td>
                @endif
                @if($item->kredit > 0)
                    <td class="to-currency">{{ $item->kredit }}</td>
                @else
                    <td></td>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data.</td>
            </tr>
        @endforelse
    </tbody>
</table>