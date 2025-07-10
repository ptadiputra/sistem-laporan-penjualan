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
                        @if (request('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> {{ request('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <div class="text-center">
                                <form action="{{ route('stock_opname.store') }}" method="POST" class="text-center mb-4">
                                    @csrf
                                    <button type="submit" class="add-data-button btn btn-outline-primary btn-md ml-1 mr-1">
                                        <i class="fas fa-plus"></i> Tambah Data
                                    </button>
                                </form>
                            </div>
                            <table class="table table-striped" id="myTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="table-header">
                                        <th class="text-center" width="20px">No</th>
                                        <th>Stok Opname</th>
                                        <th data-priority="10001" class="text-center" style="width: 20%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($opnames as $opname)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($opname->tanggal)->translatedFormat('F Y') }}</td>
                                            <td class="col-action text-center">
                                                <a href="{{ route('stock_opname.show', $opname->id) }}"
                                                    class="btn btn-primary btn-sm mr-1"><i class="far fa-folder-open"></i>
                                                    Detail</a>
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
        $(document).ready(function() {
            $('#myTable').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
            });

            $('#myTable').DataTable().on('click', '.delete-confirm', function(e) {
                deleteData(e, $(this))
            });
        })
    </script>
@endsection
