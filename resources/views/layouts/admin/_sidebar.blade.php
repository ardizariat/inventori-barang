<div class="sidebar sidebar-style-2 animate__animated animate__bounceInLeft">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                @role('sect_head|dept_head|direktur')
                <li class="nav-item {{ request()->routeIs('produk.index') ? 'active' : '' }}">
                    <a href="{{ route('produk.index') }}">
                        <i class="fas fa-tasks"></i>
                        <p>Produk</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('barang-keluar.index') ? 'active' : '' }}">
                    <a href="{{ route('barang-keluar.index') }}">
                        <i class="fas fa-truck-loading"></i>
                        <p>Barang Keluar</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('barang-masuk.index') ? 'active' : '' }}">
                    <a href="{{ route('barang-masuk.index') }}">
                        <i class="fas fa-truck-moving"></i>
                        <p>Barang Masuk</p>
                    </a>
                </li>
                @endrole
                @role('super-admin|admin')
                <li class="nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li
                    class="nav-item {{ request()->routeIs('kategori.index') ? 'active' : '' }} {{ request()->routeIs('supplier.index') ? 'active' : '' }} {{ request()->routeIs('gudang.index') ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#tables">
                        <i class="fas fa-table"></i>
                        <p>Master Data</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="tables">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('kategori.index') ? 'active' : '' }}">
                                <a href="{{ route('kategori.index') }}">
                                    <span class="sub-item">Kategori</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('supplier.index') ? 'active' : '' }}">
                                <a href="{{ route('supplier.index') }}">
                                    <span class="sub-item">Supplier</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('gudang.index') ? 'active' : '' }}">
                                <a href="{{ route('gudang.index') }}">
                                    <span class="sub-item">Gudang</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li
                    class="nav-item {{ request()->routeIs('produk.index') ? 'active' : '' }} {{ request()->routeIs('produk.create') ? 'active' : '' }} {{ request()->routeIs('produk.show') ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#base">
                        <i class="fas fa-tasks"></i>
                        <p>Produk</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('produk.index') ? 'active' : '' }}">
                                <a href="{{ route('produk.index') }}">
                                    <span class="sub-item">Semua produk</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('produk.create') ? 'active' : '' }}">
                                <a href="{{ route('produk.create') }}">
                                    <span class="sub-item">Tambah produk</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ request()->routeIs('po.index') ? 'active' : '' }}">
                    <a href="{{ route('po.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <p>Purchase Order</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}">
                        <i class="fas fa-users"></i>
                        <p>Pengguna</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('activity-log.index') ? 'active' : '' }}">
                    <a href="{{ route('activity-log.index') }}">
                        <i class="fas fa-history"></i>
                        <p>Riwayat Pengguna</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#forms">
                        <i class="far fa-clipboard"></i>
                        <p>Laporan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="forms">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('laporan.barang-masuk') }}">
                                    <i class="fas fa-truck-moving"></i>Barang Masuk
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('laporan.barang-keluar') }}">
                                    <i class="fas fa-truck-loading"></i>Barang Keluar
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('laporan.produk') }}">
                                    <i class="fas fa-tasks"></i>Produk
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ request()->routeIs('setting.index') ? 'active' : '' }}">
                    <a href="{{ route('setting.index') }}">
                        <i class="fas fa-cogs"></i>
                        <p>Pengaturan</p>
                    </a>
                </li>
                @endrole
                <li class="nav-item {{ request()->routeIs('pb.index') ? 'active' : '' }}">
                    <a href="{{ route('pb.index') }}">
                        <i class="fab fa-adn"></i>
                        <p>Request PB</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('pr.index') ? 'active' : '' }}">
                    <a href="{{ route('pr.index') }}">
                        <i class="fab fa-r-project"></i>
                        <p>Request PR</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>ss
