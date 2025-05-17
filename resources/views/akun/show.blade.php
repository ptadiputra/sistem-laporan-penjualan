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
                <li class="breadcrumb-item"><a href="{{ route('akun.index') }}">List</a></li>
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
                                <td>: {{ $akun->kode }}</td>
                            </tr>
                            <tr>
                                <td><b>Nama</b></td>
                                <td>: {{ $akun->nama }}</td>
                            </tr>
                            <tr>
                                <td><b>Kelompok</b></td>
                                <td>: {{ $akun->kelompok }}</td>
                            </tr>
                            <tr>
                                <td><b>Normal Post</b></td>
                                <td>: {{ $akun->normal_post }}</td>
                            </tr>
                            {{-- <tr>
                                <td><b>Kategori</b></td>
                                <td>: {{ $akun->kategori?->nama }}</td>
                            </tr> --}}
                            {{-- <tr>
                                <td><b>Tipe</b></td>
                                <td>: {{ $akun->tipe }}</td>
                            </tr> --}}
                            <tr>
                                <td><b>Dibuat Tanggal</b></td>
                                <td>: {{ $akun->created_at->format('d/m/Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-right p-3">
                        <a href="{{ route('akun.index') }}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> Kembali</a>
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
