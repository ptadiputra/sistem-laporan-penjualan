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
                <li class="breadcrumb-item active">Form</li>
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
                    <h5 class="m-0"><i class="far fa-file-alt"></i> Form</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengiriman.update', $pengiriman->id) }}" method="post">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="nama">Daerah Pengiriman</label>
                            <input type="text" class="form-control @error('daerah_pengiriman') is-invalid @enderror" id="nama" name="daerah_pengiriman" value="{{ old('daerah_pengiriman', $pengiriman->daerah_pengiriman) }}">
                            @error('daerah_pengiriman')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="satuan">Harga Pengiriman</label>
                            <input type="number" class="form-control @error('harga_pengiriman') is-invalid @enderror" id="harga_pengiriman" name="harga_pengiriman" value="{{ old('harga_pengiriman', $pengiriman->harga_pengiriman) }}">
                            @error('harga_pengiriman')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-right pt-3">
                            <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Simpan</button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('select').select2({width: '100%'});
    })
</script>
@endsection