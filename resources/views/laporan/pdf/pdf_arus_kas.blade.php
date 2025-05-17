<!DOCTYPE html>
<html>
<head>
    <title>Laporan Arus Kas</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>
<body>
    <div style="text-align: center;">
        <img class="logo" src="{{ public_path('img/logo.webp') }}" alt="Logo">
    </div>
    <h3 class="title">Laporan Arus Kas</h3>
    <p class="periode">Periode: {{ $periode }}</p>
    
    <table class="table table-bordered mb-4">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Akun</th>
                <th>Akun</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data['data'] as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal_transaksi->format('d/m/Y') }}</td>
                    <td>{{ $item->akun->kode }}</td>
                    <td>{{ $item->akun->nama }}</td>
                    <td class="to-currency">{{ $item->jumlah }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="4" style="font-weight: bold; text-align: right;">Total</td>
                <td class="to-currency" style="font-weight: bold; text-align: right;">{{ $data['total'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
