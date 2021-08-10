@extends('admin.laporan.pdf.layouts')

@section('content-pdf')
    <header>
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <img height="100px" src="{{ asset('images/default/avatar-1.png') }}"
                    class="rounded mx-auto d-block float-right">
                <h1 class="text-bold text-center">Laporan Barang Keluar</h1>
                <table>
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
                    <tr>
                        <th>Total Item Produk</th>
                        <th>:</th>
                        <td> {{ number_format($totalItemProduk, 0, ',', '.') }} Item</td>
                    </tr>
                    <tr>
                        <th>Total Produk Keluar</th>
                        <th>:</th>
                        <td> {{ number_format($totalProdukKeluar, 0, ',', '.') }} Item</td>
                    </tr>
                </table>
            </div>
        </div>
    </header>

    <hr class="bg-dark">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
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
@endsection
