<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Laporan Buku Besar</h4>
        <p class="font-italic mb-0">Periode: {{ $periode }}</p>
    </div>
    <div>
        <a href="{{ route('laporan.exportPdf', ['laporan' => $laporan, 'periode' => $periode]) }}" class="btn btn-info" target="_blank"><i class="fas fa-file-pdf"></i> Export PDF</a>
    </div>
</div>

<table class="table table-bordered mb-4">
    @foreach ($data as $akun => $entries)
        <thead>
            <tr class="table-active">
                <th colspan="6" class="font-weight-bold mb-2">{{ $akun }}</th>
            </tr>
            <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">Deskripsi</th>
                <th scope="col">Debet</th>
                <th scope="col">Kredit</th>
                <th scope="col">Saldo Debet</th>
                <th scope="col">Saldo Kredit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entries as $item)
                <tr>
                    <td>{{ $item['tanggal_transaksi']->format('d/m/Y') }}</td>
                    <td>{{ $item['deskripsi'] }}</td>
                    <td class="to-currency">{{ $item['debet'] }}</td>
                    <td class="to-currency">{{ $item['kredit'] }}</td>
                    <td class="to-currency">{{ $item['saldo_debet'] }}</td>
                    <td class="to-currency">{{ $item['saldo_kredit'] }}</td>
                </tr>
            @endforeach
        </tbody>
    @endforeach
</table>
