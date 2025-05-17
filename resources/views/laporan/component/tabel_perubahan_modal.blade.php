<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Laporan Perubahan Modal</h4>
        <p class="font-italic mb-0">Periode: {{ $periode }}</p>
    </div>
    <div>
        <a href="{{ route('laporan.exportPdf', ['laporan' => $laporan, 'periode' => $periode]) }}" class="btn btn-info" target="_blank"><i class="fas fa-file-pdf"></i> Export PDF</a>
    </div>
</div>

<table class="table table-bordered mb-4">
    <tbody>
        <tr>
            <td class="font-weight-bold">Modal Awal</td>
            <td class="to-currency">{{ $data['modal_awal'] }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Laba Bersih</td>
            <td class="to-currency">{{ $data['laba_bersih'] }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Penambahan Modal</td>
            <td class="to-currency">{{ $data['penambahan_modal'] }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Pengambilan Pribadi (Prive)</td>
            <td class="to-currency">{{ $data['prive'] }}</td>
        </tr>
        <tr class="table-active">
            <td class="font-weight-bold">Modal Akhir</td>
            <td class="to-currency">{{ $data['modal_akhir'] }}</td>
        </tr>
    </tbody>
</table>
