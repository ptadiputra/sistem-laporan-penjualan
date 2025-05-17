<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Laporan Laba Rugi</h4>
        <p class="font-italic mb-0">Periode: {{ $periode }}</p>
    </div>
    <div>
        <a href="{{ route('laporan.exportPdf', ['laporan' => $laporan, 'periode' => $periode]) }}" class="btn btn-info" target="_blank"><i class="fas fa-file-pdf"></i> Export PDF</a>
    </div>
</div>

<table class="table table-bordered mb-4">
    <tbody>
        <tr>
            <td colspan="3" class="font-weight-bold">PENDAPATAN</td>
        </tr>
        @forelse ($data['pendapatan']['data'] as $item)
            <tr>
                <td>{{ $item['kode'] }}</td>
                <td>{{ $item['nama'] }}</td>
                <td class="to-currency">{{ $item['total'] }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">Tidak ada data.</td>
            </tr>
        @endforelse
        <tr>
            <td colspan="2" class="font-weight-bold">TOTAL PENDAPATAN</td>
            <td class="to-currency">{{ $data['pendapatan']['total'] }}</td>
        </tr>
        
        <tr>
            <td colspan="3" class="font-weight-bold">BEBAN</td>
        </tr>
        @forelse ($data['beban']['data'] as $item)
            <tr>
                <td>{{ $item['kode'] }}</td>
                <td>{{ $item['nama'] }}</td>
                <td class="to-currency">{{ $item['total'] }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">Tidak ada data.</td>
            </tr>
        @endforelse
        <tr>
            <td colspan="2" class="font-weight-bold">TOTAL BEBAN</td>
            <td class="to-currency">{{ $data['beban']['total'] }}</td>
        </tr>

        <tr class="table-active">
            <td colspan="2" class="font-weight-bold">TOTAL LABA</td>
            <td class="to-currency">{{ $data['laba'] }}</td>
        </tr>
    </tbody>
</table>
