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
                <li class="breadcrumb-item"><a href="{{ route('jurnal-entry.index') }}">List</a></li>
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
                    <form action="{{ route('jurnal-entry.update', $jurnal_entry->id) }}" method="post">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="akun">Akun</label>
                            <select class="form-control @error('akun_id') is-invalid @enderror" id="akun" name="akun_id">
                                <option value="">Pilih Akun</option>
                                @foreach($akuns as $akun)
                                    <option value="{{ $akun->id }}" {{ old('akun_id', $jurnal_entry->akun_id) == $akun->id ? 'selected' : '' }}>
                                        {{ $akun->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('akun_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_transaksi">Tanggal Transaksi</label>
                            <input type="date" class="form-control @error('tanggal_transaksi') is-invalid @enderror" id="tanggal_transaksi" name="tanggal_transaksi" value="{{ old('tanggal_transaksi', $jurnal_entry->tanggal_transaksi->format('Y-m-d')) }}">
                            @error('tanggal_transaksi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="debit">Debit</label>
                            <input type="number" class="form-control @error('debit') is-invalid @enderror" id="debit" name="debit" value="{{ old('debit', $jurnal_entry->debit) }}">
                            @error('debit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kredit">Kredit</label>
                            <input type="number" class="form-control @error('kredit') is-invalid @enderror" id="kredit" name="kredit" value="{{ old('kredit', $jurnal_entry->kredit) }}">
                            @error('kredit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" cols="30" rows="5">{{ old('deskripsi', $jurnal_entry->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-right pt-3">
                            <a href="{{ route('jurnal-entry.index') }}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> Kembali</a>
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