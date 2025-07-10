<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Laporan Stock Opname</h4>
        <p class="font-italic mb-0">Periode: {{ $periode }}</p>
    </div>
    <div>
        <a href="{{ route('laporan.exportPdf', ['laporan' => $laporan, 'periode' => $periode]) }}" class="btn btn-info" target="_blank"><i class="fas fa-file-pdf"></i> Export PDF</a>
    </div>
</div>

<table class="table table-bordered mb-4">
    <thead>
        <tr>
            <th>No</th>
                   <th>Nama</th>
            <th>Kategori</th>
            <th>Satuan</th>
            <th>Jumlah di Catatan</th>
            <th>Jumlah Fisik</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data['data'] as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama}}</td>
                <td>{{ $item->kategori}}</td>
                <td>{{ $item->satuan}}</td>
                <td>{{ $item->stok_sistem}}</td>
                <td>{{ $item->stok_fisik}}</td>
                <td>{{ $item->keterangan}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data.</td>
            </tr>
        @endforelse
        <tr>
            {{-- <td colspan="3" class="font-weight-bold text-right">Total</td>
            <td class="font-weight-bold to-currency">{{ $data['total'] }}</td> --}}
        </tr>
    </tbody>
</table>