<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Pengiriman</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>
<body>
    <div style="text-align: center;">
        <img class="logo" src="{{ public_path('img/logo.webp') }}" alt="Logo">
    </div>
    <h3 class="title">Laporan Data Pengiriman</h3>
    <p class="periode">Periode: {{ $periode }}</p>
    
    <table class="table table-bordered mb-4">
        <thead>
            <tr>
                    <th>Kode</th>
            <th>Tanggal Pengiriman</th>
            <th>Customer</th>
            <th>Daerah pengiriman</th>
            <th>Barang</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Harga Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data['data'] as $item)
                <tr>
                    <td>{{ $item->kode }}</td>
                <td>{{ $item->tanggal_pengiriman->format('d/m/Y') }}</td>
                <td>{{ $item->customer }}</td>
                <td>{{ $item->daerah_pengiriman }}</td>
                <td>{{ $item->barang }}</td>
                <td>{{ $item->qty_barang }}</td>
                <td>{{ $item->harga_satuan_barang }}</td>
                <td class="to-currency">{{ $item->harga_total }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
