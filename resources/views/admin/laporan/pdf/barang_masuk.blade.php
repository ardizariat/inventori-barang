@extends('admin.laporan.pdf.layouts')

@section('content-pdf')
    <header class="mb-3">
        <h1 class="text-bold text-center">{{ $title }}</h1>
        <div class="row mt-2 d-flex justify-content-center">
            <table class="float-left mx-2">
                <tr>
                    <th>Periode</th>
                    <th>:</th>
                    <td> {{ $tgl_awal }} - {{ $tgl_akhir }}</td>
                </tr>
                <tr>
                    <th>Dibuat Oleh</th>
                    <th>:</th>
                    <td> {{ auth()->user()->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <th>:</th>
                    <td> {{ auth()->user()->email }}</td>
                </tr>
            </table>
            {{-- <table class="float-right mx-2">
                <tr>
                    <th>Tanggal</th>
                    <th>:</th>
                    <td> {{ $pb->created_at->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <th>:</th>
                    <td class="text-capitalize"> {{ $pb->status_confirm_barang_keluar }} diterima</td>
                </tr>
                <tr>
                    <th>Total Item</th>
                    <th>:</th>
                    <td> {{ formatAngka($pb->total_item) }}</td>
                </tr>
            </table> --}}
        </div>
    </header>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Pemberi</th>
                        <th>Penerima</th>
                        <th>Qty</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->nama_produk }}</td>
                            <td>{{ $item->pemberiBarang->name }}</td>
                            <td>{{ $item->penerimaBarang->name }}</td>
                            <td>{{ formatAngka($item->qty) }} {{ $item->product->satuan }}</td>
                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
