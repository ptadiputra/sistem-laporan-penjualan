<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Laporan Transaksi Masuk</h4>
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
            <th>Tanggal</th>
            {{-- <th>Kode Akun</th> --}}
            {{-- <th>Akun</th> --}}
            <th>Sub Total</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data['data'] as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                {{-- <td>{{ $item->akun->kode }}</td> --}}
                {{-- <td>{{ $item->akun->nama }}</td> --}}
                <td class="to-currency">{{ $item->sub_total }}</td>
                <td class="to-currency">{{ $item->total }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data.</td>
            </tr>
        @endforelse
        <tr>
            <td colspan="3" class="font-weight-bold text-right">Total</td>
            <td class="font-weight-bold to-currency">{{ $data['total'] }}</td>
        </tr>
    </tbody>
</table>