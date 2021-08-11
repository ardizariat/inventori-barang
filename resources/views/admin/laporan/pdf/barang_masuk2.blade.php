@extends('admin.laporan.pdf.layouts')

@section('content-pdf')

    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4>Laporan Barang Masuk</h4>
                </div>
                <div class="row mt--2">
                    <div class="col-md-6">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tanggal Ekspor Data</th>
                                    <th>:</th>
                                    <td> {{ $now }}</td>
                                </tr>
                                <tr>
                                    <th>Periode</th>
                                    <th>:</th>
                                    <td> {{ tanggal($awal) . '-' . tanggal($akhir) }}</td>
                                </tr>
                                <tr>
                                    <th>Pembuat</th>
                                    <th>:</th>
                                    <td> {{ auth()->user()->name }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table>
                            <thead>
                                <tr>
                                    <th>Total Item Produk</th>
                                    <th>:</th>
                                    <td> {{ number_format($totalItemProduk, 0, ',', '.') }} Item</td>
                                </tr>
                                <tr>
                                    <th>Total Produk Keluar</th>
                                    <th>:</th>
                                    <td> {{ number_format($totalProdukMasuk, 0, ',', '.') }} Item</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <hr class="bg-dark">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Tanggal</th>
                                    <th>Penerima</th>
                                    <th>Pemberi</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $in)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $in->product->nama_produk }}</td>
                                        <td>{{ $in->product->category->kategori }}</td>
                                        <td>{{ tanggal($in->tanggal) }}</td>
                                        <td>{{ $in->penerima }}</td>
                                        <td>{{ $in->pemberi }}</td>
                                        <td>{{ $in->jumlah }} {{ $in->product->satuan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
