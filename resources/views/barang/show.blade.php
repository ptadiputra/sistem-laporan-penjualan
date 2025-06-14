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
                <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">List</a></li>
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

                        <h4 class="mb-4">Detail Barang</h4>
                    
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">Nama</th>
                                    <td>{{ $barang->nama }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Kategori</th>
                                    <td>{{ $barang->kategori->nama }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Satuan</th>
                                    <td>{{ $barang->satuan }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Harga</th>
                                    <td><span class="to-currency">{{ $barang->harga }}</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Stock</th>
                                    <td>{{ $barang->stock }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Dibuat Tanggal</th>
                                    <td>{{ $barang->created_at->format('d/m/Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    
                        <h5 class="mt-5 mb-3">Riwayat Stock Opname</h5>
                    
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Prev Qty</th>
                                        <th scope="col">Trx Qty</th>
                                        <th scope="col">Curr Qty</th>
                                        <th scope="col">Tipe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($stock_opname as $item)
                                        <tr>
                                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $item->prev_qty }}</td>
                                            <td>{{ $item->trx_qty }}</td>
                                            <td>{{ $item->curr_qty }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $item->ref_type)) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Belum ada data stock opname.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            {{ $stock_opname->links('pagination::bootstrap-5') }}
                        </div>
                    
                    </div>
                    
                    <div class="text-right p-3">
                        <a href="{{ route('barang.index') }}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> Kembali</a>
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