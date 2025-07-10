<aside class="main-sidebar sidebar-light-primary elevation-4">


    <!-- Brand Logo -->
    <div class="" style="padding: 1rem 0 1rem 0;">
        <a href="{{ route('dashboard') }}" class="brand-link logo-switch d-flex justify-content-center"
            style="border-bottom: none;">
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

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @if (auth()->user()->hasRole(['superadmin', 'kasir']))
                    <li class="nav-item">
                        <a href="{{ route('kasir.index') }}"
                            class="nav-link {{ Request::routeIs('kasir.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Kasir
                            </p>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasRole(['superadmin', 'admin','kasir']))
                    <li class="nav-item">
                        <a href="{{ route('transaksi-masuk.index') }}"
                            class="nav-link {{ Request::routeIs('transaksi-masuk.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-folder-plus"></i>
                            <p>
                                Penjualan
                            </p>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasRole(['superadmin','admin']))
                    <li class="nav-item">
                        <a href="{{ route('transaksi-keluar.index') }}"
                            class="nav-link {{ Request::routeIs('transaksi-keluar.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-folder-minus"></i>
                            <p>
                                Pembelian
                            </p>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasRole(['superadmin', 'admin','owner','kasir']))
                    <li
                        class="nav-item {{ Request::routeIs(['user.*', 'supplier.*', 'barang.*', 'jasa.*',   'kategori-barang.*', 'customer.*']) ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::routeIs(['user.*', 'supplier.*', 'barang.*', 'jasa.*',   'kategori-barang.*', 'customer.*']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                Master Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (auth()->user()->hasRole(['superadmin','owner']))
                                <li class="nav-item">
                                    <a href="{{ route('user.list') }}"
                                        class="nav-link {{ Request::routeIs('user.*') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            User
                                        </p>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->hasRole(['superadmin','admin']))
                            <li class="nav-item">
                                <a href="{{ route('kategori-barang.index') }}"
                                    class="nav-link {{ Request::routeIs('kategori-barang.*') ? 'active' : '' }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Kategori Barang
                                    </p>
                                </a>
                            </li>
                            @endif
                            @if (auth()->user()->hasRole(['superadmin','admin']))
                            <li class="nav-item">
                                <a href="{{ route('barang.index') }}"
                                    class="nav-link {{ Request::routeIs('barang.*') ? 'active' : '' }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Barang
                                    </p>
                                </a>
                            </li>
                            @endif
                            @if (auth()->user()->hasRole(['superadmin','admin']))
                            <li class="nav-item">
                                <a href="{{ route('supplier.index') }}"
                                    class="nav-link {{ Request::routeIs('supplier.*') ? 'active' : '' }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Supplier
                                    </p>
                                </a>
                            </li>
                            @endif
                            @if (auth()->user()->hasRole(['superadmin','kasir']))
                            <li class="nav-item">
                                <a href="{{ route('customer.index') }}"
                                    class="nav-link {{ Request::routeIs('customer.*') ? 'active' : '' }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Customer
                                    </p>
                                </a>
                            </li>
                            @endif
                            @if (auth()->user()->hasRole(['superadmin','admin']))
                            <li class="nav-item">
                                <a href="{{ route('pengiriman.index') }}"
                                    class="nav-link {{ Request::routeIs('pengiriman.*') ? 'active' : '' }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Pengiriman
                                    </p>
                                </a>
                            </li>
                            @endif
                            @if (auth()->user()->hasRole(['superadmin','admin']))
                            <li class="nav-item">
                                <a href="{{ route('stock_opname.index') }}"
                                    class="nav-link {{ Request::routeIs('stock_opname.*') ? 'active' : '' }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Stock Opname
                                    </p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->hasRole(['superadmin', 'admin', 'owner']))
                    <li class="nav-item {{ Request::routeIs(['laporan.*']) ? 'menu-open' : '' }}">
                        <a href="{{ route('laporan.index') }}"
                            class="nav-link {{ Request::routeIs(['laporan.*']) ? 'active' : '' }}">
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
