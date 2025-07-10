<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Laporan Data Pengiriman</h4>
        <p class="font-italic mb-0">Periode: {{ $periode }}</p>
    </div>
    <div>
        <a href="{{ route('laporan.exportPdf', ['laporan' => $laporan, 'periode' => $periode]) }}" class="btn btn-info" target="_blank"><i class="fas fa-file-pdf"></i> Export PDF</a>
    </div>
</div>

<table class="table table-bordered mb-4">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Tanggal Pengiriman</th>
            <th>Customer</th>
            <th>Daerah pengiriman</th>
            <th>Barang</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Harga Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data['data'] as $item)
            <tr>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->tanggal_pengiriman->format('d/m/Y') }}</td>
                <td>{{ $item->customer }}</td>
                <td>{{ $item->daerah_pengiriman }}</td>
                <td>{{ $item->barang }}</td>
                <td>{{ $item->qty_barang }}</td>
                <td>{{ $item->harga_satuan_barang }}</td>
                <td class="to-currency">{{ $item->harga_total }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data.</td>
            </tr>
        @endforelse
    </tbody>
</table>