@extends('base')


@section('breadcrumb')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $title }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('transaksi-masuk.index') }}">List</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0"><i class="far fa-folder-open"></i> Detail</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td><b>Kode</b></td>
                                <td>: {{ $transaksi_masuk->kode }}</td>
                            </tr>
                            <tr>
                                <td><b>Tanggal Transaksi</b></td>
                                <td>: {{ $transaksi_masuk->tanggal->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><b>Kasir</b></td>
                                <td>: {{ $transaksi_masuk->user->name }}</td>
                            </tr>
                            <tr>
                                <td><b>Total Harga</b></td>
                                <td>: <span class="to-currency">{{ $transaksi_masuk->total_harga }}</span></td>
                            </tr>
                            <tr>
                                <td><b>Tanggal Pengiriman</b></td>
                                <td>: {{ $transaksi_masuk->tanggal_pengiriman->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><b>Catatan Pengiriman</b></td>
                                <td>: {{ $transaksi_masuk->catatan_pengiriman }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-right p-3">
                        <a href="{{ route('transaksi-masuk.index') }}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0"><i class="far fa-folder-open"></i> Daftar Barang</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr class="table-header">
                                <th class="text-center" width="20px">No</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Harga Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi_masuk->transaksiMasukDetail as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->barang->nama }}</td>
                                    <td>{{ $item->qty_barang }}</td>
                                    <td><span class="to-currency">{{ $item->harga_satuan_barang }}</span></td>
                                    <td><span class="to-currency">{{ $item->harga_total }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div><!-- /.container-fluid -->
@endsection