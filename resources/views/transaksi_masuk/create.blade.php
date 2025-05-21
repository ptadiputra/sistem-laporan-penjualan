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
                <li class="breadcrumb-item"><a href="{{ route('transaksi-masuk.index') }}">List</a></li>
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
                    <form action="{{ route('transaksi-masuk.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal') }}">
                            @error('tanggal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="barang">Barang</label>
                            <select class="form-control @error('barang_id') is-invalid @enderror" id="barang" name="barang_id">
                                <option value="">Pilih Barang</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                        {{ $barang->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="qty_barang">Jumlah</label>
                            <input type="number" class="form-control @error('qty_barang') is-invalid @enderror" id="qty_barang" name="qty_barang" value="{{ old('qty_barang', 0) }}">
                            @error('qty_barang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="harga_satuan_barang">Harga Satuan</label>
                            <input type="number" class="form-control @error('harga_satuan_barang') is-invalid @enderror" id="harga_satuan_barang" name="harga_satuan_barang" value="{{ old('harga_satuan_barang', 0) }}" readonly>
                            @error('harga_satuan_barang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="harga_total">Harga Total</label>
                            <input type="number" class="form-control @error('harga_total') is-invalid @enderror" id="harga_total" name="harga_total" value="{{ old('harga_total', 0) }}" readonly>
                            @error('harga_total')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pengiriman">Tanggal Pengiriman</label>
                            <input type="date" class="form-control @error('tanggal_pengiriman') is-invalid @enderror" id="tanggal_pengiriman" name="tanggal_pengiriman" value="{{ old('tanggal_pengiriman') }}">
                            @error('tanggal_pengiriman')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="catatan_pengiriman">Catatan Pengiriman</label>
                            <textarea class="form-control @error('catatan_pengiriman') is-invalid @enderror" name="catatan_pengiriman" id="catatan_pengiriman" cols="30" rows="5">{{ old('catatan_pengiriman') }}</textarea>
                            @error('catatan_pengiriman')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-right pt-3">
                            <a href="{{ route('transaksi-masuk.index') }}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> Kembali</a>
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
        $('#tipe').select2({
            placeholder: 'Pilih Tipe',
            allowClear: false,
            width: '100%',
        })
        handleSelectBarang();
        handlChangeJumlah();
    })
    
    handleSelectBarang = function(){
        $('[name="barang_id"]').change(function(){
            const id = $(this).val()
            $('#qty_barang').val(0)
            $('#harga_total').val(0)

            $.ajax({
                url: "{{ route('transaksi-keluar.harga_barang', -1) }}".replace('-1', id || 0),
                type: 'GET',
                success: function(response) {
                    $('#harga_satuan_barang').val(response.harga)
                },
                error: function(xhr) {
                    toastr.error('Terjadi suatu kesalahan!, silahkan hubungi developer.');
                    console.log(error);
                }
            });
        })
    }

    handlChangeJumlah = function(){
        $('#qty_barang').on('input', function() {
            var qty = $(this).val();
            var harga_satuan_barang = $('#harga_satuan_barang').val()
            $('#harga_total').val(qty*harga_satuan_barang)
        });
    }
</script>
@endsection