<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $role = Auth::user()->role;

        return match ($role) {
            'kasir' => redirect()->route('kasir.index'),
            'owner' => redirect()->route('laporan.index'),
            'admin' => redirect()->route('transaksi-keluar.index'),
            'superadmin' => redirect()->route('transaksi-masuk.index'),
            default => abort(403, 'Role not authorized.')
        };
    }
}
