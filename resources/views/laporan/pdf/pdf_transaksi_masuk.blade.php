<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi Masuk</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>
<body>
    <div style="text-align: center;">
        <img class="logo" src="{{ public_path('img/logo.webp') }}" alt="Logo">
    </div>
    <h3 class="title">Laporan Transaksi Masuk</h3>
    <p class="periode">Periode: {{ $periode }}</p>
    
    <table class="table table-bordered mb-4">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                {{-- <th>Kode Akun</th> --}}
                {{-- <th>Akun</th> --}}
                <th>Sub Total</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data['data'] as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                    {{-- <td>{{ $item->akun->kode }}</td> --}}
                    {{-- <td>{{ $item->akun->nama }}</td> --}}
                    <td class="to-currency">{{ $item->sub_total }}</td>
                    <td class="to-currency">{{ $item->total }}</td>
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
