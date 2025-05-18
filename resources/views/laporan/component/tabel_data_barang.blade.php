<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Laporan Data Barang</h4>
        <p class="font-italic mb-0">Tanggal: {{ now()->format('d M Y') }}</p>
    </div>
    <div>
        <a href="{{ route('laporan.exportPdf', ['laporan' => $laporan, 'periode' => $periode]) }}" class="btn btn-info"
            target="_blank"><i class="fas fa-file-pdf"></i> Export PDF</a>
    </div>
</div>

<table class="table table-bordered mb-4">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stock</th>
            <th>Satuan</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data['data'] as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->kategori->nama }}</td>
                <td class="to-currency">{{ $item->harga }}</td>
                <td>{{ $item->stock }}</td>
                <td>{{ $item->satuan }}</td>
                <td class="to-currency">{{ $item->harga * $item->stock }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data.</td>
            </tr>
        @endforelse
        <tr>
            <td colspan="6" class="font-weight-bold text-right">Grand Total Harga Barang</td>
            <td class="font-weight-bold to-currency">{{ $data['total'] }}</td>
        </tr>
    </tbody>
</table>
