@extends('layouts.admin.master')
@section('title')
    {{ $title }}
@endsection

@push('css')
@endpush

@section('admin-content')
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">{{ $title }}</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="#">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ $url }}">Data Barang</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <p class="text-capitalize">{{ $data->nama_produk }}</p>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__zoomInDown">
                        <div class="card-header">
                            <h4 class="card-title">Detail Produk {!! $data->nama_produk !!}</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills nav-secondary nav-pills-no-bd" id="pills-tab-without-border"
                                role="tablist">
                                <li class="nav-item submenu">
                                    <a class="nav-link active show" id="pills-home-tab-nobd" data-toggle="pill"
                                        href="#pills-home-nobd" role="tab" aria-controls="pills-home-nobd"
                                        aria-selected="false">Detail Barang</a>
                                </li>
                                <li class="nav-item submenu">
                                    <a class="nav-link" id="pills-profile-tab-nobd" data-toggle="pill"
                                        href="#riwayat-barang-masuk" role="tab" aria-controls="riwayat-barang-masuk"
                                        aria-selected="false">Riwayat Barang Masuk</a>
                                </li>
                                <li class="nav-item submenu">
                                    <a class="nav-link" id="pills-contact-tab-nobd" data-toggle="pill"
                                        href="#riwayat-barang-keluar" role="tab" aria-controls="riwayat-barang-keluar"
                                        aria-selected="true">Riwayat Barang Keluar</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                                <div class="tab-pane fade active show" id="pills-home-nobd" role="tabpanel"
                                    aria-labelledby="pills-home-tab-nobd">
                                    <div class="row my-3">
                                        <div class="col-md-4">
                                            <img src="{{ $data->getGambar() }}" class=" mb-4 gambar d-block w-100">
                                            <div class="row justify-content-center">
                                                {!! $qrcode !!}
                                                <p class="mt-2">Scan QR Code untuk melihat kode produk</p>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <table class="table table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td align="left">Barcode</td>
                                                        <td align="left">:</td>
                                                        <td>{!! $barcode !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">Kode Produk</td>
                                                        <td align="left">:</td>
                                                        <td>{!! $data->kode !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">Nama Produk</td>
                                                        <td align="left">:</td>
                                                        <td>{!! $data->nama_produk !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">Kategori Produk</td>
                                                        <td align="left">:</td>
                                                        <td>{!! $data->category->kategori !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">Merek</td>
                                                        <td align="left">:</td>
                                                        <td>{!! $data->merek !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">Minimal Stok</td>
                                                        <td align="left">:</td>
                                                        <td>{!! $data->minimal_stok !!} {!! $data->satuan !!}</td>
                                                    </tr>
                                                    <tr
                                                        class="{{ $data->stok < $data->minimal_stok ? 'bg-danger' : '' }}">
                                                        <td align="left">Stok Tersedia</td>
                                                        <td align="left">:</td>
                                                        <td>{!! $data->stok !!} {!! $data->satuan !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">Letak Barang</td>
                                                        <td align="left">:</td>
                                                        <td>{!! $data->warehouse->nama ?? '' !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">Keterangan</td>
                                                        <td align="left">:</td>
                                                        <td>{!! $data->keterangan !!}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="riwayat-barang-masuk" role="tabpanel"
                                    aria-labelledby="pills-profile-tab-nobd">
                                    <div class="row my-3">
                                        <div class="col-md-12">
                                            <table class="show_barangmasuk-table table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th witdh="24%">Supplier</th>
                                                        <th witdh="24%">Penerima Barang</th>
                                                        <th witdh="24%">Qty</th>
                                                        <th witdh="24%">Tanggal</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="riwayat-barang-keluar" role="tabpanel"
                                    aria-labelledby="pills-contact-tab-nobd">
                                    <div class="row my-3">
                                        <div class="col-md-12">
                                            <table class="show_barangkeluar-table table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th witdh="24%">Penerima Barang</th>
                                                        <th witdh="24%">Qty</th>
                                                        <th witdh="24%">Tanggal</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/zoom/medium-zoom.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
    <script>
        mediumZoom('.gambar', {
            margin: 50,
            scrollOffset: 200
        });

        barang_masuk();
        barang_keluar();

        function barang_masuk() {
            $('.show_barangmasuk-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: "{{ route('produk.barang-masuk', $data->id) }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: "supplier",
                        name: "supplier"
                    },
                    {
                        data: "penerima",
                        name: "penerima"
                    },
                    {
                        data: "qty",
                        name: "qty"
                    },
                    {
                        data: "tanggal",
                        name: "tanggal"
                    },
                ],
                pageLength: 15,
                "lengthMenu": [15, 25, 50, 75, 100],
                "language": {
                    "emptyTable": "Data tidak ada"
                },
            });
        }

        function barang_keluar() {
            $('.show_barangkeluar-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: "{{ route('produk.barang-keluar', $data->id) }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: "penerima",
                        name: "penerima"
                    },
                    {
                        data: "qty",
                        name: "qty"
                    },
                    {
                        data: "tanggal",
                        name: "tanggal"
                    },
                ],
                pageLength: 15,
                "lengthMenu": [15, 25, 50, 75, 100],
                "language": {
                    "emptyTable": "Data tidak ada"
                },
            });
        }
    </script>
@endpush
