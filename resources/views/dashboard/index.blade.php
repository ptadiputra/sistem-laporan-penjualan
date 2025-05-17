@extends('base')

@section('breadcrumb')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $title }}</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-body" style="background-color: white;">
                    <h5 class="card-title d-flex flex-column justify-content-center">
                        <div style="font-size: 2rem;"><span style="font-weight: 600;">Selamat Datang, </span>{{auth()->user()->username}}</div>
                    </h5>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-white">
                <div class="inner">
                    <h3>{{ $total_pengeluaran }}</h3>
                    <h5>Total Pengeluaran</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-folder-minus"></i>
                </div>
                <a href="{{ route('transaksi-keluar.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-white">
                <div class="inner">
                    <h3>{{ $total_pemasukan }}</h3>
                    <h5>Total Pemasukan</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-folder-plus"></i>
                </div>
                <a href="{{ route('transaksi-masuk.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-white">
                <div class="inner">
                    <h3>{{ $total_jurnal_entry }}</h3>
                    <h5>Total Jurnal Entry</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <a href="{{ route('jurnal-entry.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
@endsection