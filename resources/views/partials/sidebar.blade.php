<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    {{-- <a href="index3.html" class="brand-link">
        <img src="img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a> --}}

    <!-- Brand Logo -->
    <div class="" style="padding: 1rem 0 1rem 0;">
        <a href="{{ route('dashboard') }}" class="brand-link logo-switch d-flex justify-content-center" style="border-bottom: none;">
            <div class="logo-xs">
                <img src="{{ asset('img/logo-sm.webp') }}" alt="Logo Small" class="" style="width: 40px;">
            </div>
            <div class="d-flex logo-xl">
                <img src="{{ asset('img/logo.webp') }}" alt="Logo Big" class="mr-3" style="height: 50px;">
            </div>
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div> --}}

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                {{-- <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li> --}}
                @if (auth()->user()->hasRole(['superadmin', 'kasir']))
                <li class="nav-item">
                    <a href="{{ route('kasir.index') }}" class="nav-link {{ Request::routeIs('kasir.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Kasir
                        </p>
                    </a>
                </li>
                @endif

                @if (auth()->user()->hasRole(['superadmin', 'kasir']))
                <li class="nav-item">
                    <a href="{{ route('transaksi-masuk.index') }}" class="nav-link {{ Request::routeIs('transaksi-masuk.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder-plus"></i>
                        <p>
                            Pemasukan
                        </p>
                    </a>
                </li>
                @endif

                @if (auth()->user()->hasRole(['superadmin', 'admin']))
                <li class="nav-item">
                    <a href="{{ route('transaksi-keluar.index') }}" class="nav-link {{ Request::routeIs('transaksi-keluar.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder-minus"></i>
                        <p>
                            Pengeluaran
                        </p>
                    </a>
                </li>
                @endif

                @if (auth()->user()->hasRole(['superadmin', 'admin']))
                <li class="nav-item {{ Request::routeIs(['user.*', 'supplier.*', 'barang.*', 'jasa.*', 'akun.*','kategori-akun.*','kategori-barang.*','customer.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs(['user.*', 'supplier.*', 'barang.*', 'jasa.*', 'akun.*', 'kategori-akun.*','kategori-barang.*','customer.*']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (auth()->user()->hasRole(['superadmin']))
                        <li class="nav-item">
                            <a href="{{ route('user.list') }}" class="nav-link {{ Request::routeIs('user.*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>
                                    User
                                </p>
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('kategori-barang.index') }}" class="nav-link {{ Request::routeIs('kategori-barang.*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>
                                    Kategori Barang
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('barang.index') }}" class="nav-link {{ Request::routeIs('barang.*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>
                                    Barang
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('supplier.index') }}" class="nav-link {{ Request::routeIs('supplier.*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>
                                    Supplier
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customer.index') }}" class="nav-link {{ Request::routeIs('customer.*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>
                                    Customer
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('akun.index') }}" class="nav-link {{ Request::routeIs('akun.*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>
                                    Akun
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('jurnal-entry.index') }}" class="nav-link {{ Request::routeIs('jurnal-entry.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Jurnal Entry
                        </p>
                    </a>
                </li>
                @endif

                @if (auth()->user()->hasRole(['superadmin', 'admin', 'owner']))
                <li class="nav-item {{ Request::routeIs(['laporan.*']) ? 'menu-open' : '' }}">
                    <a href="{{ route('laporan.index') }}" class="nav-link {{ Request::routeIs(['laporan.*']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Laporan
                        </p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
