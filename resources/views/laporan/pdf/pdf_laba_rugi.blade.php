<!DOCTYPE html>
<html>
<head>
    <title>Laporan Laba Rugi</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>
<body>
    <div style="text-align: center;">
        <img class="logo" src="{{ public_path('img/logo.webp') }}" alt="Logo">
    </div>
    <h3 class="title">Laporan Laba Rugi</h3>
    <p class="periode">Periode: {{ $periode }}</p>
    
    <table class="table table-bordered mb-4">
        <tbody>
            <tr>
                <td colspan="3" class="font-weight-bold">PENDAPATAN</td>
            </tr>
            @forelse ($data['pendapatan']['data'] as $item)
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
                <td colspan="2" class="font-weight-bold">TOTAL PENDAPATAN</td>
                <td class="to-currency">{{ $data['pendapatan']['total'] }}</td>
            </tr>
            
            <tr>
                <td colspan="3" class="font-weight-bold">BEBAN</td>
            </tr>
            @forelse ($data['beban']['data'] as $item)
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
                <td colspan="2" class="font-weight-bold">TOTAL BEBAN</td>
                <td class="to-currency">{{ $data['beban']['total'] }}</td>
            </tr>
    
            <tr class="table-active">
                <td colspan="2" class="font-weight-bold">TOTAL LABA</td>
                <td class="to-currency">{{ $data['laba'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
