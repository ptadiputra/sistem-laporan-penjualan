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
                <li class="breadcrumb-item"><a href="{{ route('pengiriman.index') }}">List</a></li>
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
                    <div class="container">

                        <h4 class="mb-4">Detail Pengiriman</h4>
                    
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">Daerah Pengiriman</th>
                                    <td>{{ $pengiriman->daerah_pengiriman }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Harga Pengiriman</th>
                                    <td>{{ $pengiriman->harga_pengiriman }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-right p-3">
                        <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> Kembali</a>
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