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
                <li class="breadcrumb-item"><a href="{{ route('transaksi-keluar.index') }}">List</a></li>
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
                                <td>: {{ $transaksi_keluar->kode }}</td>
                            </tr>
                            <tr>
                                <td><b>Tanggal</b></td>
                                <td>: {{ $transaksi_keluar->tanggal->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><b>User</b></td>
                                <td>: {{ $transaksi_keluar->user->name }}</td>
                            </tr>
                            <tr>
                                <td><b>Supplier</b></td>
                                <td>: {{ $transaksi_keluar->supplier->nama }}</td>
                            </tr>
                            <tr>
                                <td><b>Barang</b></td>
                                <td>: {{ $transaksi_keluar->barang->nama }}</td>
                            </tr>
                            <tr>
                                <td><b>Satuan</b></td>
                                <td>: {{ $transaksi_keluar->satuan }}</td>
                            </tr>
                            <tr>
                                <td><b>Jumlah</b></td>
                                <td>: {{ $transaksi_keluar->qty }}</td>
                            </tr>
                            <tr>
                                <td><b>Harga Satuan</b></td>
                                <td>: <span class="to-currency">{{ $transaksi_keluar->harga_satuan }}</span></td>
                            </tr>
                            <tr>
                                <td><b>Harga Total</b></td>
                                <td>: <span class="to-currency">{{ $transaksi_keluar->harga_total }}</span></td>
                            </tr>
                            <tr>
                                <td><b>Keterangan</b></td>
                                <td>: {{ $transaksi_keluar->keterangan }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-right p-3">
                        <a href="{{ route('transaksi-keluar.index') }}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->
@endsection