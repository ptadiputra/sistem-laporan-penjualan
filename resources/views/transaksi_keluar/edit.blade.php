@extends('base')

@section('breadcrumb')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $title }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('transaksi-keluar.index') }}">List</a></li>
                <li class="breadcrumb-item active">Form</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0"><i class="far fa-file-alt"></i> Form Edit</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksi-keluar.update', $transaksi_keluar->id) }}" method="post">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="kode">Kode</label>
                            <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{ old('kode', $transaksi_keluar->kode) }}" readonly>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $transaksi_keluar->tanggal->format('Y-m-d')) }}">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="supplier">Supplier</label>
                            <select class="form-control @error('supplier_id') is-invalid @enderror" id="supplier" name="supplier_id">
                                <option value="">Pilih Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $transaksi_keluar->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="barang">Barang</label>
                            <select class="form-control @error('barang_id') is-invalid @enderror" id="barang" name="barang_id">
                                <option value="">Pilih Barang</option>
                                @foreach($barangs as $barang)
                                    <option 
                                        value="{{ $barang->id }}"
                                        data-harga="{{ $barang->harga }}"
                                        data-satuan="{{ $barang->satuan }}"
                                        {{ old('barang_id', $transaksi_keluar->barang_id) == $barang->id ? 'selected' : '' }}>
                                        {{ $barang->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan', $transaksi_keluar->satuan) }}" readonly>
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="qty">Jumlah</label>
                            <input type="number" class="form-control @error('qty') is-invalid @enderror" id="qty" name="qty" value="{{ old('qty', $transaksi_keluar->qty) }}">
                            @error('qty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="harga_satuan">Harga Satuan</label>
                            <input type="number" class="form-control @error('harga_satuan') is-invalid @enderror" id="harga_satuan" name="harga_satuan" value="{{ old('harga_satuan', $transaksi_keluar->harga_satuan) }}" readonly>
                            @error('harga_satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="harga_total">Harga Total</label>
                            <input type="number" class="form-control @error('harga_total') is-invalid @enderror" id="harga_total" name="harga_total" value="{{ old('harga_total', $transaksi_keluar->harga_total) }}" readonly>
                            @error('harga_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" cols="30" rows="5">{{ old('keterangan', $transaksi_keluar->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-right pt-3">
                            <a href="{{ route('transaksi-keluar.index') }}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('select').select2({ width: '100%' });

        handleSelectBarang();
        handleChangeJumlah();

        $('#barang').trigger('change'); // isi satuan dan harga saat load
    });

    function handleSelectBarang() {
        $('#barang').on('change', function () {
            const selected = $(this).find(':selected');
            const harga = selected.data('harga') || 0;
            const satuan = selected.data('satuan') || '';

            $('#harga_satuan').val(harga);
            $('#satuan').val(satuan);
            $('#harga_total').val(0);

            hitungTotal();
        });
    }

    function handleChangeJumlah() {
        $('#qty').on('input', function () {
            hitungTotal();
        });
    }

    function hitungTotal() {
        const qty = parseFloat($('#qty').val()) || 0;
        const harga = parseFloat($('#harga_satuan').val()) || 0;
        $('#harga_total').val(qty * harga);
    }
</script>
@endsection
