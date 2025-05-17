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
                <li class="breadcrumb-item"><a href="{{ route('jurnal-entry.index') }}">List</a></li>
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
                                <td><b>Akun</b></td>
                                <td>: {{ $jurnal_entry->akun->nama }}</td>
                            </tr>
                            <tr>
                                <td><b>Tanggal Transaksi</b></td>
                                <td>: {{ $jurnal_entry->tanggal_transaksi->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><b>Debit</b></td>
                                <td>: <span class="to-currency">{{ $jurnal_entry->debit }}</span></td>
                            </tr>
                            <tr>
                                <td><b>Kredit</b></td>
                                <td>: <span class="to-currency">{{ $jurnal_entry->kredit }}</span></td>
                            </tr>
                            <tr>
                                <td><b>Deskripsi</b></td>
                                <td>: {{ $jurnal_entry->deskripsi }}</td>
                            </tr>
                            <tr>
                                <td><b>Dibuat Tanggal</b></td>
                                <td>: {{ $jurnal_entry->created_at->format('d/m/Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-right p-3">
                        <a href="{{ route('jurnal-entry.index') }}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->
@endsection