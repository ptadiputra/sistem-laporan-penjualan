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
                      <form action="{{ route('stock_opname.update_item', $item->id) }}" method="POST">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Barang</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $item->barang->nama) }}" readonly>
                        </div>
                           <div class="form-group">
                            <label for="nama">Stok Sistem</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $item->stok_sistem) }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="harga">Stok Fisik</label>
                            <input type="number" class="form-control @error('stok_fisik') is-invalid @enderror" id="stok_fisik" name="stok_fisik" value="{{ old('stok_fisik', $item->stok_fisik) }}">
                            @error('stok_fisik')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                          <div class="form-group">
                            <label for="harga">Keterangan</label>
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ old('keterangan', $item->keterangan) }}">
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-right pt-3">
                           <a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-secondary">
    <i class="fas fa-chevron-circle-left"></i> Kembali
</a>
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