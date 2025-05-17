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
                <li class="breadcrumb-item active">List</li>
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
                    <h5 class="m-0"><i class="fas fa-list-ul"></i> List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="text-center">
                            <a href="{{ route('kasir.index') }}" class="add-data-button btn btn-outline-primary btn-md mb-4 ml-1 mr-1">
                                <i class="fas fa-plus"></i> Tambah Data
                            </a>
                        </div>
                        <table class="table table-striped" id="myTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="table-header">
                                    <th class="text-center" width="20px">No</th>
                                    <th>Kode</th>
                                    <th>Tanggal</th>
                                    <th>Kasir</th>
                                    <th>Total</th>
                                    <th data-priority="10001" class="text-center" style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi_masuks as $transaksi_masuk)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transaksi_masuk->kode }}</td>
                                        <td>{{ $transaksi_masuk->tanggal->format('d/m/Y') }}</td>
                                        <td>{{ $transaksi_masuk->user->nama ?? $transaksi_masuk->user->username }}</td>
                                        <td class="to-currency">{{ $transaksi_masuk->total }}</td>
                                        <td class="col-action">
                                            {{-- <a href="{{ route('transaksi-masuk.show', $transaksi_masuk->id) }}" class="btn btn-primary btn-sm mr-1"><i class="far fa-folder-open"></i> Detail</a> --}}
                                            <a href="{{ route('transaksi-masuk.nota', $transaksi_masuk->id) }}" class="btn btn-primary btn-sm mr-1" target="_blank"><i class="fas fa-receipt"></i> Nota</a>
                                            {{-- <a href="{{ route('transaksi-masuk.edit', $transaksi_masuk->id) }}" class="btn btn-warning btn-sm mr-1"><i class="fas fa-edit"></i> Edit</a> --}}
                                            <a href="{{ route('transaksi-masuk.destroy', $transaksi_masuk->id) }}" class="btn btn-danger btn-sm mr-1 delete-confirm"><i class="fas fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->
@endsection


@section('script')
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
        });

        $('#myTable').DataTable().on('click', '.delete-confirm', function (e) {
            deleteData(e, $(this))
        });
    })
</script>
@endsection