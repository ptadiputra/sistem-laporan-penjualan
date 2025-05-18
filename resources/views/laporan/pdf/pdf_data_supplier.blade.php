<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Supplier</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>

<body>
    <div style="text-align: center;">
        <img class="logo" src="{{ public_path('img/logo.webp') }}" alt="Logo">
    </div>
    <h3 class="title">Laporan Data Supplier</h3>
    <p class="periode">Tanggal: {{ now()->format('d M Y') }}</p>

    <table class="table table-bordered mb-4">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No Tlp</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data['data'] as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->no_tlp }}</td>
                    <td>{{ $item->alamat }}</td>
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
