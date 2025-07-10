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
        <form action="{{ route('kasir.store') }}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="sub_total" id="sub_total" value="0">
            <input type="hidden" name="total" id="total" value="0">

            <div class="row">

                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0"><i class="fas fa-layer-group"></i> Daftar Barang</h5>
                        </div>
                        <div class="card-body">
                            <div id="barang-wrapper">
                                @if (old('barang_id'))
                                    @foreach (old('barang_id') as $i => $barangId)
                                        <div class="barang-row row mb-3">
                                            <div class="col-md-3 mb-2">
                                                <label>Barang</label>
                                                <select
                                                    class="form-control barang-select @error("barang_id.$i") is-invalid @enderror"
                                                    name="barang_id[]">
                                                    <option value="">Pilih Barang</option>
                                                    @foreach ($barangs as $barang)
                                                        <option value="{{ $barang->id }}"
                                                            data-harga="{{ $barang->harga }}"
                                                            {{ $barangId == $barang->id ? 'selected' : '' }}>
                                                            {{ $barang->nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error("barang_id.$i")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-2 mb-2">
                                                <label>Jumlah</label>
                                                <input type="number"
                                                    class="form-control qty-input @error("qty_barang.$i") is-invalid @enderror"
                                                    name="qty_barang[]" value="{{ old('qty_barang')[$i] ?? 0 }}">
                                                @error("qty_barang.$i")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <label>Harga Satuan</label>
                                                <input type="number" class="form-control harga-satuan"
                                                    name="harga_satuan_barang[]"
                                                    value="{{ old('harga_satuan_barang')[$i] ?? 0 }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <label>Harga Total</label>
                                                <input type="number" class="form-control harga-total" name="harga_total[]"
                                                    value="{{ old('harga_total')[$i] ?? 0 }}" readonly>
                                            </div>

                                            <div class="col-md-1 mb-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger remove-barang"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Default 1 row --}}
                                    <div class="barang-row row mb-3">
                                        <div class="col-md-3 mb-2">
                                            <label>Barang</label>
                                            <select class="form-control barang-select" name="barang_id[]">
                                                <option value="">Pilih Barang</option>
                                                @foreach ($barangs as $barang)
                                                    <option value="{{ $barang->id }}" data-harga="{{ $barang->harga }}">
                                                        {{ $barang->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2 mb-2">
                                            <label>Jumlah</label>
                                            <input type="number" class="form-control qty-input" name="qty_barang[]"
                                                value="0">
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label>Harga Satuan</label>
                                            <input type="number" class="form-control harga-satuan"
                                                name="harga_satuan_barang[]" value="0" readonly>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label>Harga Total</label>
                                            <input type="number" class="form-control harga-total" name="harga_total[]"
                                                value="0" readonly>
                                        </div>

                                        <div class="col-md-1 mb-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger remove-barang"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <button type="button" id="add-barang" class="btn btn-primary mb-3"><i class="fas fa-plus"></i>
                                Tambah Barang</button>
                            <hr>

                            <h4 class="font-weight-bold text-right mb-0">Sub Total</h4>
                            <h1 class="font-weight-bold text-right sub-total-text">Rp 0</h1>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0"><i class="fas fa-cash-register"></i> Transaksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Transaksi</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                    id="tanggal" name="tanggal" value="{{ old('tanggal') }}">
                                @error('tanggal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customer">Customer</label>
                                <select class="form-control @error('customer_id') is-invalid @enderror" id="customer"
                                    name="customer_id">
                                    <option value="">Pilih customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customer">Pengiriman</label>
                                <select class="form-control @error('pengiriman_id') is-invalid @enderror" id="pengiriman"
                                    name="pengiriman_id">
                                    <option value="">Pilih pengiriman</option>
                                    @foreach ($pengirimans as $pengiriman)
                                        <option value="{{ $pengiriman->id }}"
                                            data-biaya="{{ $pengiriman->harga_pengiriman }}"
                                            {{ old('pengiriman_id') == $pengiriman->id ? 'selected' : '' }}>
                                            {{ $pengiriman->daerah_pengiriman }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pengiriman_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="biaya_pengiriman">Biaya Pengiriman</label>
                                <input type="number" class="form-control @error('biaya_pengiriman') is-invalid @enderror"
                                    id="biaya_pengiriman" name="biaya_pengiriman"
                                    value="{{ old('biaya_pengiriman', 0) }}" readonly>
                                @error('biaya_pengiriman')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="diskon">Diskon</label>
                                <input type="number" class="form-control @error('diskon') is-invalid @enderror"
                                    id="diskon" name="diskon" value="{{ old('diskon', 0) }}">
                                @error('diskon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <hr>

                            <h4 class="font-weight-bold text-right mb-0">Total</h4>
                            <h1 class="font-weight-bold text-right total-text">Rp 0</h1>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0"><i class="fas fa-truck"></i> Pengiriman</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="tanggal_pengiriman">Tanggal Pengiriman</label>
                                <input type="datetime-local"
                                    class="form-control @error('tanggal_pengiriman') is-invalid @enderror"
                                    id="tanggal_pengiriman" name="tanggal_pengiriman"
                                    value="{{ old('tanggal_pengiriman') }}">
                                @error('tanggal_pengiriman')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat_pengiriman">Alamat Pengiriman</label>
                                <textarea class="form-control @error('alamat_pengiriman') is-invalid @enderror" name="alamat_pengiriman"
                                    id="alamat_pengiriman" cols="30" rows="3">{{ old('alamat_pengiriman') }}</textarea>
                                @error('alamat_pengiriman')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="catatan_pengiriman">Catatan Pengiriman</label>
                                <textarea class="form-control @error('catatan_pengiriman') is-invalid @enderror" name="catatan_pengiriman"
                                    id="catatan_pengiriman" cols="30" rows="5">{{ old('catatan_pengiriman') }}</textarea>
                                @error('catatan_pengiriman')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-body text-right">
                            <button type="submit" class="btn btn-success btn-block"><i class="far fa-save"></i>
                                Simpan</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div><!-- /.container-fluid -->
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            $('select').select2({
                width: '100%'
            });
            handleDaftarBarang();
        })

        handleDaftarBarang = function() {
            // Add row
            $('#add-barang').on('click', function() {
                const newRowHtml = `
                <div class="barang-row row mb-3">
                    <div class="col-md-3 mb-2">
                        <label>Barang</label>
                        <select class="form-control barang-select" name="barang_id[]">
                            <option value="">Pilih Barang</option>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang->id }}" data-harga="{{ $barang->harga }}">{{ $barang->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label>Jumlah</label>
                        <input type="number" class="form-control qty-input" name="qty_barang[]" value="0">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>Harga Satuan</label>
                        <input type="number" class="form-control harga-satuan" name="harga_satuan_barang[]" value="0" readonly>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>Harga Total</label>
                        <input type="number" class="form-control harga-total" name="harga_total[]" value="0" readonly>
                    </div>
                    <div class="col-md-1 mb-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-barang"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>`;

                const newRow = $(newRowHtml);
                $('#barang-wrapper').append(newRow);
                $('select').select2({
                    width: '100%'
                });
            });

            // Remove row
            $(document).on('click', '.remove-barang', function() {
                if ($('.barang-row').length > 1) {
                    $(this).closest('.barang-row').remove();
                    updateSubTotal();
                }
            });

            // Update harga satuan on select change
            $(document).on('change', '.barang-select', function() {
                var harga = $(this).find(':selected').data('harga') || 0;
                var row = $(this).closest('.barang-row');
                row.find('.harga-satuan').val(harga);
                updateHargaTotalBarang(row);
            });

            // Update harga total barang on qty change
            $(document).on('input', '.qty-input', function() {
                var row = $(this).closest('.barang-row');
                updateHargaTotalBarang(row);
            });

            function updateHargaTotalBarang(row) {
                var qty = parseFloat(row.find('.qty-input').val()) || 0;
                var harga = parseFloat(row.find('.harga-satuan').val()) || 0;
                var total = qty * harga;
                row.find('.harga-total').val(total);
                updateSubTotal();
            }

            function updateSubTotal() {
                var subTotal = 0;
                $('.harga-total').each(function() {
                    subTotal += parseFloat($(this).val()) || 0;
                });

                // Format angka ke dalam format Rupiah
                const formatted = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(subTotal);

                $('.sub-total-text').text(formatted);
                $('#sub_total').val(subTotal);

                updateTotalAkhir();
            }

            function updateTotalAkhir() {
                let totalHarga = parseFloat($('#sub_total').val()) || 0;
                let biaya_pengiriman = parseFloat($('#biaya_pengiriman').val()) || 0;
                let diskon = parseFloat($('#diskon').val()) || 0;

                let finalTotal = totalHarga + biaya_pengiriman - diskon;
                if (finalTotal < 0) finalTotal = 0;

                // Format angka ke dalam format Rupiah
                const formatted = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(finalTotal);

                $('.total-text').text(formatted);
                $('#total').val(finalTotal);
            }

            $(document).on('input', '#biaya_pengiriman, #diskon', function() {
                updateTotalAkhir();
            });

            updateSubTotal();
        }

        // Saat pengiriman berubah, update input biaya_pengiriman
        $(document).on('change', '#pengiriman', function() {
            const selected = $(this).find(':selected');
            const biaya = parseFloat(selected.data('biaya')) || 0;

            $('#biaya_pengiriman').val(biaya);
        });
    </script>
@endsection
