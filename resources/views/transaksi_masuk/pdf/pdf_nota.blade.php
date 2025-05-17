<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Transaksi</title>
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
            <td style="width: 50%; vertical-align: middle; text-align: right;">
                <h4 class="title">Nota Transaksi</h4>
            </td>
        </tr>
    </table>
    <div class="line"></div>

    <table style="width: 100%; margin-bottom: 10px; border: none;">
        <tr>
            <td style="width: 50%; vertical-align: top; text-align: left;">
                <strong>Nomor Nota:</strong> {{ $transaksi->kode }}<br>
                <strong>Tanggal Nota:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y') }}<br>
                <strong>Kasir:</strong> {{ $transaksi->user->username }}
            </td>
            <td style="width: 50%; vertical-align: top; text-align: right;">
                <strong>Customer</strong><br>
                {{ $transaksi->customer->nama ?? '-' }}<br>
                {{ $transaksi->customer->no_hp ?? '-' }}<br>
                {{ $transaksi->customer->alamat ?? '-' }}<br>
            </td>
        </tr>
    </table>

    <table class="table-barang">
        <thead>
            <tr>
                <th class="nowarp">No</th>
                <th class="nowarp">Nama Barang</th>
                <th class="nowarp">Jumlah</th>
                <th class="nowarp">Harga</th>
                <th class="nowarp">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->transaksiMasukDetail as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->barang->nama }}</td>
                    <td>{{ $item->qty_barang }}</td>
                    <td class="nowarp">Rp {{ number_format($item->harga_satuan_barang, 0, ',', '.') }}</td>
                    <td class="nowarp">Rp {{ number_format($item->harga_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="empty-cell" colspan="3" rowspan="5"></td>
            </tr>
            <tr>
                <td class="nowarp" style="text-align: center;"><strong>Sub Total</strong></td>
                <td class="nowarp">Rp {{ number_format($transaksi->sub_total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="nowarp" style="text-align: center;"><strong>Biaya Pengiriman</strong></td>
                <td class="nowarp">Rp {{ number_format($transaksi->biaya_pengiriman ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="nowarp" style="text-align: center;"><strong>Diskon</strong></td>
                <td class="nowarp">Rp {{ number_format($transaksi->diskon ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="nowarp" style="text-align: center;"><strong>Total</strong></td>
                <td class="nowarp"><strong>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <p class="informasi-pengiriman-title">Informasi Pengiriman</p>
    <p class="informasi-pengiriman-text">
        <strong>Tanggl:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal_pengiriman)->format('d/m/Y') }}
    </p>
    <p class="informasi-pengiriman-text">
        <strong>Alamat:</strong> {!! nl2br(e($transaksi->alamat_pengiriman ?? '-')) !!}
    </p>
    <p class="informasi-pengiriman-text">
        <strong>Catatan:</strong> {!! nl2br(e($transaksi->catatan_pengiriman ?? '-')) !!}
    </p>

</body>
</html>
