<!DOCTYPE html>
<html>
<head>
    <title>Laporan Buku Besar</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>
<body>
    <div style="text-align: center;">
        <img class="logo" src="{{ public_path('img/logo.webp') }}" alt="Logo">
    </div>
    <h3 class="title">Laporan Buku Besar</h3>
    <p class="periode">Periode: {{ $periode }}</p>
    
    <table class="table table-bordered">
        @foreach ($data as $akun => $entries)
            <thead>
                <tr style="background-color: #c6c6c6;">
                    <th colspan="6" style="font-weight: bold; margin-bottom: 0.5rem;">{{ $akun }}</th>
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
</body>
</html>
