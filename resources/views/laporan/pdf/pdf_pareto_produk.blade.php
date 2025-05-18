<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pareto Produk</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>

<body>
    <div style="text-align: center;">
        <img class="logo" src="{{ public_path('img/logo.webp') }}" alt="Logo">
    </div>
    <h3 class="title">Laporan Pareto Produk</h3>
    <p class="periode">Periode: {{ $periode }}</p>

    <table class="table table-bordered mb-4">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Qty Barang</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data['data'] as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->total_qty }}</td>
                    <td class="to-currency">{{ $item->total_harga }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="3" class="font-weight-bold text-right">Total</td>
                <td class="font-weight-bold to-currency">{{ $data['total'] }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
