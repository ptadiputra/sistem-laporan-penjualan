@extends('base')


@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection


@section('breadcrumb')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $title }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Laporan</li>
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
                <div class="card-body">
                    <form action="" method="GET">
                        <div class="form-group">
                            <label for="laporan">Laporan</label>
                            <select id="laporan" name="laporan" class="form-control @error('laporan') is-invalid @enderror">
                                <option value="">Pilih Laporan</option>
                                <option value="transaksi-masuk" @selected(old('laporan') == 'transaksi-masuk')>Laporan Transaksi Masuk</option>
                                <option value="transaksi-keluar" @selected(old('laporan') == 'transaksi-keluar')>Laporan Transaksi Keluar</option>
                                <option value="jurnal-umum" @selected(old('laporan') == 'jurnal-umum')>Laporan Jurnal Umum</option>
                                <option value="buku-besar" @selected(old('laporan') == 'buku-besar')>Laporan Buku Besar</option>
                                <option value="neraca" @selected(old('laporan') == 'neraca')>Laporan Neraca</option>
                                <option value="laba-rugi" @selected(old('laporan') == 'laba-rugi')>Laporan Laba Rugi</option>
                                <option value="perubahan-modal" @selected(old('laporan') == 'perubahan-modal')>Laporan Perubahan Modal</option>
                                <option value="arus-kas" @selected(old('laporan') == 'arus-kas')>Laporan Arus Kas</option>
                            </select>
                            @error('laporan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="periode">Periode</label>
                            <input type="text" id="periode" name="periode" class="form-control @error('periode') is-invalid @enderror" value="{{ old('periode') }}"/>
                            @error('periode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="fas fa-search"></i> Preview
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        @if (!empty($tableHtml))
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {!! $tableHtml !!}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection


@section('script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(document).ready(function () {
        $('select').select2({width: '100%'});

        $('#periode').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            },
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month')
        });

        $('#periode').on('keydown', function(e) {
            e.preventDefault();
        });
    })
</script>
@endsection
