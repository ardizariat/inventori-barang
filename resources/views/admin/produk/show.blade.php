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
                        <p class="text-capitalize">{{ $produk->nama_produk }}</p>
                    </li>
                </ul>
            </div>
            <div class="card shadow animate__animated animate__zoomInDown">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ $produk->getGambar() }}" class="gambar d-block w-100">
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
                                        <td>{!! $produk->kode !!}</td>
                                    </tr>
                                    <tr>
                                        <td align="left">Nama Produk</td>
                                        <td align="left">:</td>
                                        <td>{!! $produk->nama_produk !!}</td>
                                    </tr>
                                    <tr>
                                        <td align="left">Kategori Produk</td>
                                        <td align="left">:</td>
                                        <td>{!! $produk->kategori->kategori !!}</td>
                                    </tr>
                                    <tr>
                                        <td align="left">Merek</td>
                                        <td align="left">:</td>
                                        <td>{!! $produk->merek !!}</td>
                                    </tr>
                                    <tr>
                                        <td align="left">Minimal Stok</td>
                                        <td align="left">:</td>
                                        <td>{!! $produk->minimal_stok !!} {!! $produk->satuan !!}</td>
                                    </tr>
                                    <tr class="{{ $produk->stok < $produk->minimal_stok ? 'bg-danger' : '' }}">
                                        <td align="left">Stok Tersedia</td>
                                        <td align="left">:</td>
                                        <td>{!! $produk->stok !!} {!! $produk->satuan !!}</td>
                                    </tr>
                                    <tr>
                                        <td align="left">Letak Barang</td>
                                        <td align="left">:</td>
                                        <td>{!! $produk->gudang->nama !!}</td>
                                    </tr>
                                    <tr>
                                        <td align="left">Keterangan</td>
                                        <td align="left">:</td>
                                        <td>{!! $produk->keterangan !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row justify-content-center">
                        {!! $qrcode !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/zoom/medium-zoom.min.js') }}"></script>
    <script>
        mediumZoom('.gambar', {
            margin: 50,
            scrollOffset: 200
        });
    </script>
@endpush
