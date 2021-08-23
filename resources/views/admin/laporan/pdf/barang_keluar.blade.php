@extends('admin.laporan.pdf.layouts')

@section('content-pdf')
    <div class="row">
        <img width=" auto" height="40" src="{{ asset('images/logo.png') }}" class="rounded float-left">
    </div>
    <header class="mb-3">
        <h1 class="text-bold text-center text-capitalize">{{ $title }}</h1>
        <div class="row mt-3 d-flex justify-content-center">
            <table class="float-left mx-2">
                <tr>
                    <th>Periode</th>
                    <th>:</th>
                    <td> {{ $periode }}</td>
                </tr>
                <tr>
                    <th>Total Item</th>
                    <th>:</th>
                    <td> {{ formatAngka($total_item) }} Item</td>
                </tr>
                <tr>
                    <th>Total Harga</th>
                    <th>:</th>
                    <td>Rp. {{ formatAngka($total_harga) }}</td>
                </tr>
            </table>
            {{-- <table class="float-right mx-2">
            <tr>
                <th>Tanggal</th>
                <th>:</th>
                <td> {{ $pr->created_at->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <th>:</th>
                <td class="text-capitalize"> {{ $pr->status }} Diterima</td>
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
                        <th>Request By</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($item->jenis_permintaan == 'pr')
                                    {{ $item->pr->user->name }}
                                @endif
                                @if ($item->jenis_permintaan == 'pb')
                                    {{ $item->pb->user->name }}
                                @endif
                            </td>
                            <td>{{ $item->product->nama_produk }}</td>
                            <td>{{ $item->product->category->kategori }}</td>
                            <td>{{ formatAngka($item->product->harga) }}</td>
                            <td>{{ formatAngka($item->qty) }} {{ $item->product->satuan }}</td>
                            <td>{{ formatAngka($item->subtotal) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>TOTAL</th>
                        <th>{{ formatAngka($total_item) }} Item</th>
                        <th>Rp {{ formatAngka($total_harga) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

@stop
