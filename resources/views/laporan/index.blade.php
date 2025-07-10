@extends('base')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('breadcrumb')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Laporan</li>
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
                    <div class="card-body">
                        <form action="" method="GET">
                            <div class="form-group">
                                <label for="laporan">Laporan</label>
                                <select id="laporan" name="laporan"
                                    class="form-control @error('laporan') is-invalid @enderror">
                                    <option value="">Pilih Laporan</option>
                                    <option value="transaksi-masuk" @selected(old('laporan') == 'transaksi-masuk')>Laporan Penjulan
                                    </option>
                                    <option value="transaksi-keluar" @selected(old('laporan') == 'transaksi-keluar')>Laporan Pembelian
                                    </option>
                                    <option value="data-barang" @selected(old('laporan') == 'data-barang')>Laporan Data Barang</option>
                                    <option value="data-supplier" @selected(old('laporan') == 'data-supplier')>Laporan Data Supplier
                                    </option>
                                    <option value="pareto-produk" @selected(old('laporan') == 'pareto-produk')>Laporan Pareto Produk
                                    </option>
                                    <option value="stock-opname" @selected(old('laporan') == 'stock-opname')>Laporan Stock Opname
                                    </option>
                                    <option value="data-pengiriman" @selected(old('laporan') == 'data-pengiriman')>Laporan Pengiriman
                                    </option>
                                </select>
                                @error('laporan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Periode --}}
                            <div class="form-group" id="form-periode">
                                <label for="periode">Periode</label>
                                <input type="text" id="periode" name="periode"
                                    class="form-control @error('periode') is-invalid @enderror"
                                    value="{{ old('periode') }}" />
                                @error('periode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Hari Ini --}}
                            <div class="form-group d-none" id="tanggal-hari-ini">
                                <label>Tanggal</label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}" readonly>
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
        $(document).ready(function() {
            $('select').select2({
                width: '100%'
            });

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

            function togglePeriodeField() {
                let laporan = $('#laporan').val();
                if (laporan === 'data-barang' || laporan === 'data-supplier'||laporan === 'stock-opname') {
                    $('#form-periode').addClass('d-none');
                    $('#tanggal-hari-ini').removeClass('d-none');
                } else {
                    $('#form-periode').removeClass('d-none');
                    $('#tanggal-hari-ini').addClass('d-none');
                }
            }

            // Panggil saat pertama kali halaman dimuat
            togglePeriodeField();

            // Panggil saat pilihan laporan berubah
            $('#laporan').on('change', function() {
                togglePeriodeField();
            });
        });
    </script>
@endsection
