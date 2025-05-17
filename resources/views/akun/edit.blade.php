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
                    <form action="{{ route('akun.update', $akun->id) }}" method="post">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="kode">Kode</label>
                            <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{ old('kode', $akun->kode) }}">
                            @error('kode')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $akun->nama) }}">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kelompok">Kelompok</label>
                            <select class="form-control @error('kelompok') is-invalid @enderror" id="kelompok" name="kelompok">
                                <option value="Aset/Aktiva" @selected(old('kelompok', $akun->kelompok) == 'Aset/Aktiva')>Aset/Aktiva</option>
                                <option value="Liabilitas" @selected(old('kelompok', $akun->kelompok) == 'Liabilitas')>Liabilitas</option>
                                <option value="Ekuitas" @selected(old('kelompok', $akun->kelompok) == 'Ekuitas')>Ekuitas</option>
                                <option value="Beban" @selected(old('kelompok', $akun->kelompok) == 'Beban')>Beban</option>
                                <option value="Pendapatan" @selected(old('kelompok', $akun->kelompok) == 'Pendapatan')>Pendapatan</option>
                                <option value="Modal" @selected(old('kelompok', $akun->kelompok) == 'Modal')>Modal</option>
                                <option value="Prive" @selected(old('kelompok', $akun->kelompok) == 'Prive')>Prive</option>
                                <option value="Kas" @selected(old('kelompok', $akun->kelompok) == 'Kas')>Kas</option>
                                <option value="Other" @selected(old('kelompok', $akun->kelompok) == 'Other')>Other</option>
                            </select>
                            @error('kelompok')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="normal_post">Normal Post</label>
                            <select class="form-control @error('normal_post') is-invalid @enderror" id="normal_post" name="normal_post">
                                <option value="debit" @selected(old('normal_post', $akun->normal_post) == 'debit')>debit</option>
                                <option value="kredit" @selected(old('normal_post', $akun->normal_post) == 'kredit')>kredit</option>
                            </select>
                            @error('normal_post')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label for="kategori_akun_id">Kategori</label>
                            <select class="form-control @error('kategori_akun_id') is-invalid @enderror" id="kategori_akun_id" name="kategori_akun_id">
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" @selected(old('normal_post', $akun->kategori->id) == $kategori->id)>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_akun_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                        {{-- <div class="form-group">
                            <label for="user">Tipe</label>
                            <select class="form-control @error('tipe') is-invalid @enderror" id="user" name="tipe">
                                <option value="{{ $akun->tipe }}">{{$akun->tipe}}</option>
                                <option value="debit">debit</option>
                                <option value="kredit">kredit</option>
                            </select>
                            @error('tipe')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="text-right pt-3">
                            <a href="{{ route('akun.index') }}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> Kembali</a>
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
