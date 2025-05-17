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
                <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">List</a></li>
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
                                <td><b>Nama</b></td>
                                <td>: {{ $supplier->nama }}</td>
                            </tr>
                            <tr>
                                <td><b>No Handphone</b></td>
                                <td>: {{ $supplier->no_tlp }}</td>
                            </tr>
                            <tr>
                                <td><b>Alamat</b></td>
                                <td>: {{ $supplier->alamat }}</td>
                            </tr>
                            <tr>
                                <td><b>Dibuat Tanggal</b></td>
                                <td>: {{ $supplier->created_at->format('d/m/Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-right p-3">
                        <a href="{{ route('supplier.index') }}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> Kembali</a>
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
    })
</script>
@endsection