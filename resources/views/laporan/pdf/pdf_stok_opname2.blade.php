<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Opname</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>
<body>
    <div style="text-align: center;">
        <img class="logo" src="{{ public_path('img/logo.webp') }}" alt="Logo">
    </div>
    <h3 class="title">Laporan Stok Opname</h3>
    <p class="periode">Periode: {{ $periode }}</p>
    
    <table class="table table-bordered mb-4">
        <thead>
            <tr>
                <th>No</th>
            <th>Nama</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Stok Awal</th>
            <th>Nilai Awal</th>
            <th>Stock Masuk</th>
            <th>Nilai Masuk</th>
            <th>Stok Keluar</th>
            <th>Nili Keluar</th>
            <th>Stok Akhir</th>
            <th>Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data['data'] as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                <td>{{ $item['nama']}}</td>
                <td>{{ $item['satuan']}}</td>
                <td>{{ $item['harga']}}</td>
                <td>{{ $item['stok_awal']}}</td>
                <td class="to-currency">{{ $item['nilai_awal']}}</td>
                <td>{{ $item['masuk']}}</td>
                <td class="to-currency">{{ $item['nilai_masuk']}}</td>
                <td>{{ $item['keluar']}}</td>
                <td class="to-currency">{{ $item['nilai_keluar']}}</td>
                <td>{{ $item['stok_akhir']}}</td>
                <td class="to-currency">{{ $item['nilai_akhir']}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
