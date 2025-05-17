<!DOCTYPE html>
<html>
<head>
    <title>Laporan Perubahan Modal</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>
<body>
    <div style="text-align: center;">
        <img class="logo" src="{{ public_path('img/logo.webp') }}" alt="Logo">
    </div>
    <h3 class="title">Laporan Perubahan Modal</h3>
    <p class="periode">Periode: {{ $periode }}</p>
    
    <table class="table table-bordered mb-4">
        <tbody>
            <tr>
                <td class="font-weight-bold">Modal Awal</td>
                <td class="to-currency">{{ $data['modal_awal'] }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Laba Bersih</td>
                <td class="to-currency">{{ $data['laba_bersih'] }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Penambahan Modal</td>
                <td class="to-currency">{{ $data['penambahan_modal'] }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Pengambilan Pribadi (Prive)</td>
                <td class="to-currency">{{ $data['prive'] }}</td>
            </tr>
            <tr class="table-active">
                <td class="font-weight-bold">Modal Akhir</td>
                <td class="to-currency">{{ $data['modal_akhir'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
