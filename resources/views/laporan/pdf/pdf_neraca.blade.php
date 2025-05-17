<!DOCTYPE html>
<html>
<head>
    <title>Laporan Neraca</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>
<body>
    <div style="text-align: center;">
        <img class="logo" src="{{ public_path('img/logo.webp') }}" alt="Logo">
    </div>
    <h3 class="title">Laporan Neraca</h3>
    <p class="periode">Periode: {{ $periode }}</p>
    
    <table class="table table-bordered mb-4">
        <thead>
            <tr class="table-active">
                <th colspan="3" class="text-center">Aktiva</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data['aktiva']['data'] as $item)
                <tr>
                    <td>{{ $item['kode'] }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td class="to-currency">{{ $item['total'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="2" class="font-weight-bold">Total Aktiva</td>
                <td class="font-weight-bold to-currency">{{ $data['aktiva']['total'] }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered mb-4">
        <thead>
            <tr class="table-active">
                <th colspan="3" class="text-center">Pasiva</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data['pasiva']['data'] as $item)
                <tr>
                    <td>{{ $item['kode'] }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td class="to-currency">{{ $item['total'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="2" class="font-weight-bold">Total Pasiva</td>
                <td class="font-weight-bold to-currency">{{ $data['pasiva']['total'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
