<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Laporan Neraca</h4>
        <p class="font-italic mb-0">Periode: {{ $periode }}</p>
    </div>
    <div>
        <a href="{{ route('laporan.exportPdf', ['laporan' => $laporan, 'periode' => $periode]) }}" class="btn btn-info" target="_blank"><i class="fas fa-file-pdf"></i> Export PDF</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered mb-4">
            <thead>
                <tr class="table-active">
                    <th colspan="3" class="text-center">Aktiva</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['aktiva']['data'] as $item)
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
                    <td colspan="2" class="font-weight-bold">Total Aktiva</td>
                    <td class="font-weight-bold to-currency">{{ $data['aktiva']['total'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-bordered mb-4">
            <thead>
                <tr class="table-active">
                    <th colspan="3" class="text-center">Pasiva</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['pasiva']['data'] as $item)
                    <tr>
                        @if ($item['nama'] == 'Total Modal')
                            <td colspan="2">{{ $item['nama'] }}</td>
                            <td class="to-currency">{{ $item['total'] }}</td>
                        @else
                            <td>{{ $item['kode'] }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td class="to-currency">{{ $item['total'] }}</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data.</td>
                    </tr>
                @endforelse
                <tr>
                    <td colspan="2" class="font-weight-bold">Total Pasiva</td>
                    <td class="font-weight-bold to-currency">{{ $data['pasiva']['total'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>