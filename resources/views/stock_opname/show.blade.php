@extends('base')

@section('breadcrumb')
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-light p-2 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('stock_opname.index') }}">Stock Opname</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <h5 class="mb-0"><i class="far fa-folder-open"></i> Detail Stock Opname</h5>
                        <a href="{{ route('stock_opname.index') }}" class="btn btn-secondary btn-sm ml-auto">
                            <i class="fas fa-chevron-circle-left"></i> Kembali
                        </a>
                    </div>

                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="myTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" width="50px">No</th>
                                        <th>Barang</th>
                                        <th class="text-center">Stok Sistem</th>
                                        <th class="text-center">Stok Fisik</th>
                                        <th class="text-center">Selisih</th>
                                        <th>Keterangan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $item->barang->nama }}</td>
                                            <td class="text-center">{{ $item->stok_sistem }}</td>
                                            <td class="text-center">{{ $item->stok_fisik ?? '-' }}</td>
                                            <td class="text-center">{{ $item->selisih }}</td>
                                            <td>{{ $item->keterangan ?? '-' }}</td>
                                            <td class="text-center">   
                                            <a href="{{ route('stock_opname.edit_item', $item->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a> 
                                           
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
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: true,
                autoWidth: false,
                ordering: true,
                paging: true,
                searching: true,
                lengthChange: true,
                info: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/id.json'
                }
            });
        });
    </script>
@endsection
