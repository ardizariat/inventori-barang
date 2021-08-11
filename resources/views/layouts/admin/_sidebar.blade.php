<div class="sidebar sidebar-style-2 animate__animated animate__bounceInLeft">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            {{-- <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('admin/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
        </div>
        <div class="info">
            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                <span>
                    Hizrian
                    <span class="user-level">Administrator</span>
                    <span class="caret"></span>
                </span>
            </a>
            <div class="clearfix"></div>

            <div class="collapse in" id="collapseExample">
                <ul class="nav">
                    <li>
                        <a href="#profile">
                            <span class="link-collapse">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="#edit">
                            <span class="link-collapse">Edit Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="#settings">
                            <span class="link-collapse">Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div> --}}
            <ul class="nav nav-primary">
                <li class="nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
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
                            <li>
                                <a href="{{ route('produk.create') }}">
                                    <span class="sub-item">Tambah produk</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ request()->routeIs('kategori.index') ? 'active' : '' }}">
                    <a href="{{ route('kategori.index') }}">
                        <i class="fas fa-layer-group"></i>
                        <p>Kategori</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('supplier.index') ? 'active' : '' }}">
                    <a href="{{ route('supplier.index') }}">
                        <i class="fas fa-truck"></i>
                        <p>Supplier</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('gudang.index') ? 'active' : '' }}">
                    <a href="{{ route('gudang.index') }}">
                        <i class="fas fa-hotel"></i>
                        <p>Gudang</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('barang-masuk.index') ? 'active' : '' }}">
                    <a href="{{ route('barang-masuk.index') }}">
                        <i class="fas fa-truck-moving"></i>
                        <p>Barang Masuk</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('barang-keluar.index') ? 'active' : '' }}">
                    <a href="{{ route('barang-keluar.index') }}">
                        <i class="fas fa-truck-loading"></i>
                        <p>Barang Keluar</p>
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
                <li class="nav-item {{ request()->routeIs('setting.index') ? 'active' : '' }}">
                    <a href="{{ route('setting.index') }}">
                        <i class="fas fa-cogs"></i>
                        <p>Pengaturan</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>ss
