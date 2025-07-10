<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Jalan</title>
    <style>
        @page {
            size: A5;
            margin: 5mm;
        }
        body { 
            font-family: Arial, sans-serif; 
            font-size: 10pt; /* Standar untuk dokumen */
            margin: 0;
            padding: 2mm;
        }
        img { 
            width: 120pt; /* ~42mm */
            height: auto;
        }
        .title { 
            margin: 0;
            font-size: 14pt; /* Judul utama */
            font-weight: bold; 
        }
        .line { 
            border-top: 0.5pt solid black; 
            margin: 4pt 0; 
        }
        .table-barang { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 6pt; 
            font-size: 9pt; /* Lebih kecil untuk tabel */
        }
        .table-barang th, 
        .table-barang td { 
            border: 0.5pt solid black; 
            padding: 4pt; 
            text-align: center; 
        }
        .table-barang .empty-cell {
            border: none; 
            text-align: left; 
            vertical-align: top;
            padding: 0;
        }
        .informasi-pengiriman-title {
            font-weight: bold; 
            font-size: 11pt; /* Subjudul */
            margin: 12pt 0 0 0;
        }
        .informasi-pengiriman-text {
            margin: 2pt 0 0 0;
            font-size: 9pt;
        }
    </style>
</head>
<body>
    <table style="width: 100%; margin-bottom: 10px; border: none;">
        <tr>
            <td style="width: 50%; vertical-align: top; text-align: left;">
                <img class="logo" src="{{ public_path('img/logo.webp') }}" alt="Logo">
            </td>
        </tr>
    </table>
    <div class="line"></div>

    <table style="width: 100%; margin-bottom: 10px; border: none;">
        <tr>
            <td style="width: 50%; vertical-align: top; text-align: center;">
                <h2><strong>SURAT JALAN BARANG</strong></h2>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; vertical-align: top; text-align: left;">
                <strong>Informasi Pengirim:</strong> UD Nadin Jaya Utama<br>
                <strong>Informasi Penerima:</strong> {{ $transaksi->customer->nama }}<br>
            </td>
        </tr>
    </table>

    <table class="table-barang">
        <thead>
            <tr>
                <th class="nowarp">No</th>
                <th class="nowarp">Nama Barang</th>
                <th class="nowarp">Kategori</th>
                <th class="nowarp">Kuantitas</th>
                <th class="nowarp">Satuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->transaksiMasukDetail as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->barang->nama }}</td>
                    <td>{{ $item->barang->kategori->nama }}</td>
                    <td>{{ $item->qty_barang }}</td>
                    <td>{{ $item->barang->satuan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

<table style="width: 100%; margin-top: 20pt; text-align: center; table-layout: fixed;">
    <tr>
        <td style="vertical-align: top; width: 33%;">
            <p class="informasi-pengiriman-title">Dikeluarkan Oleh,</p>
            <p class="informasi-pengiriman-text">UD Nadin Jaya Utama</p>
        </td>
        <td style="vertical-align: top; width: 33%;">
            <p class="informasi-pengiriman-title">Diterima Oleh,</p>
            <p class="informasi-pengiriman-text">{{ $transaksi->customer->nama }}</p>
        </td>
        <td style="vertical-align: top; width: 33%;">
            <p class="informasi-pengiriman-title">Mengetahui Oleh,</p>
            <p class="informasi-pengiriman-text">Management</p>
            <p class="informasi-pengiriman-text">UD Nadin Jaya Utama</p>
        </td>
    </tr>
</table>




</body>
</html>
