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
                    <form action="{{ route('laporan.export') }}" method="GET">
                        <div class="form-group">
                            <label for="categorySelect">Pilih Laporan</label>
                            <select id="categorySelect" name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="transaksi-masuk">Laporan Transaksi Masuk</option>
                                <option value="transaksi-keluar">Laporan Transaksi Keluar</option>
                                <option value="jurnal-umum">Laporan Jurnal Umum</option>
                                <option value="buku-besar">Laporan Buku Besar</option>
                                <option value="neraca">Laporan Neraca</option>
                                <option value="laba-rugi">Laporan Laba Rugi</option>
                                <option value="perubahan-modal">Laporan Perubahan Modal</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="monthSelect">Pilih Bulan</label>
                            <select id="monthSelect" name="bulan"  class="form-control @error('bulan') is-invalid @enderror">
                                <option value="">-- Pilih Bulan --</option>
                                @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}">{{ DateTime::createFromFormat('!m', $month)->format('F') }}</option>
                                @endforeach
                                @error('bulan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label for="tahun">Tahun</label>
                            <input type="number"
                                   class="form-control @error('tahun') is-invalid @enderror"
                                   id="tahun"
                                   name="tahun"
                                   value="{{ old('tahun', date('Y')) }}"
                                   placeholder="{{ date('Y') }}">
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="fas fa-search"></i> Export Laporan
                        </button>
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
        $('#myTable').DataTable({
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
        });

        $('#myTable').DataTable().on('click', '.delete-confirm', function (e) {
            deleteData(e, $(this))
        });
    })
</script>
@endsection
