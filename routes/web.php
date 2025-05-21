<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransaksiKeluarController;
use App\Http\Controllers\TransaksiMasukController;
use App\Http\Controllers\LaporanController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// -- auth
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate')->middleware('guest');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// -- dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::middleware(['auth', RoleMiddleware::class . ':superadmin,admin,kasir'])->group(function () {
    // -- transaksi-masuk
    Route::resource('/transaksi-masuk', TransaksiMasukController::class)->middleware('auth');
    Route::get('/transaksi-masuk/harga_jasa/{id}', [TransaksiMasukController::class, 'harga_jasa'])->name('transaksi-masuk.harga_jasa')->middleware('auth');
    Route::get('/transaksi-masuk/nota/{transaksiMasuk}', [TransaksiMasukController::class, 'nota'])->name('transaksi-masuk.nota')->middleware('auth');

    // -- kasir
    Route::resource('/kasir', KasirController::class);
});

Route::middleware(['auth', RoleMiddleware::class . ':superadmin,owner'])->group(function () {
    // -- user
    Route::get('/user', [UserController::class, 'list'])->name('user.list')->middleware('auth');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create')->middleware('auth');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store')->middleware('auth');
    Route::get('/user/detail/{user}', [UserController::class, 'detail'])->name('user.detail')->middleware('auth');
    Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('user.edit')->middleware('auth');
    Route::post('/user/update/{user}', [UserController::class, 'update'])->name('user.update')->middleware('auth');
    Route::delete('/user/delete/{user}', [UserController::class, 'destroy'])->name('user.delete')->middleware('auth');
});

Route::middleware(['auth', RoleMiddleware::class . ':superadmin,kasir,admin'])->group(function () {
    // -- transaksi-keluar
    Route::resource('/transaksi-keluar', TransaksiKeluarController::class)->middleware('auth');
    Route::get('/transaksi-keluar/harga_barang/{id}', [TransaksiKeluarController::class, 'harga_barang'])->name('transaksi-keluar.harga_barang')->middleware('auth');

    // -- supplier
    Route::resource('/supplier', SupplierController::class)->middleware('auth');

    // -- kategori barang
    Route::resource('/kategori-barang', KategoriBarangController::class)->middleware('auth');

    // -- barang
    Route::resource('/barang', BarangController::class)->middleware('auth');


    // -- customer
    Route::resource('/customer', CustomerController::class)->middleware('auth');
});


Route::middleware(['auth', RoleMiddleware::class . ':superadmin,owner,admin'])->group(function () {
    //laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index')->middleware('auth');
    Route::get('/laporan/exportPdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf')->middleware('auth');
});
