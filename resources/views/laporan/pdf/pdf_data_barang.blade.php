<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Barang</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>

<body>
    <div style="text-align: center;">
        <img class="logo" src="{{ public_path('img/logo.webp') }}" alt="Logo">
    </div>
    <h3 class="title">Laporan Data Barang</h3>
    <p class="periode">Tanggal: {{ now()->format('d M Y') }}</p>

    <table class="table table-bordered mb-4">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stock</th>
                <th>Satuan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data['data'] as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kategori->nama }}</td>
                    <td class="to-currency">{{ $item->harga }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td class="to-currency">{{ $item->harga * $item->stock }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="6" class="font-weight-bold text-right">Grand Total Harga Barang</td>
                <td class="font-weight-bold to-currency">{{ $data['total'] }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
