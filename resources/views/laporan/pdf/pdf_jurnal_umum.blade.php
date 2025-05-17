<!DOCTYPE html>
<html>
<head>
    <title>Laporan Jurnal Umum</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>
<body>
    <div style="text-align: center;">
        <img class="logo" src="{{ public_path('img/logo.webp') }}" alt="Logo">
    </div>
    <h3 class="title">Laporan Jurnal Umum</h3>
    <p class="periode">Periode: {{ $periode }}</p>
    
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Deskripsi</th>
            <th scope="col">Akun</th>
            <th scope="col">Kode</th>
            <th scope="col">Debet</th>
            <th scope="col">Kredit</th>
        </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal_transaksi->format('d/m/Y') }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td>{{ $item->akun->nama }}</td>
                    <td>{{ $item->akun->kode }}</td>
                    @if($item->debit > 0)
                        <td class="to-currency">{{ $item->debit }}</td>
                    @else
                        <td></td>
                    @endif
                    @if($item->kredit > 0)
                        <td class="to-currency">{{ $item->kredit }}</td>
                    @else
                        <td></td>
                    @endif
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
