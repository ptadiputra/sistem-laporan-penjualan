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
            <th>Kategori</th>
            <th>Satuan</th>
            <th>Jumlah di Catatan</th>
            <th>Jumlah Fisik</th>
            <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data['data'] as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama}}</td>
                <td>{{ $item->kategori}}</td>
                <td>{{ $item->satuan}}</td>
                <td>{{ $item->stok_sistem}}</td>
                <td>{{ $item->stok_fisik}}</td>
                <td>{{ $item->keterangan}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
