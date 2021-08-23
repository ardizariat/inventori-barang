@extends('admin.laporan.pdf.layouts')

@section('content-pdf')
    @php
    use Carbon\Carbon;
    @endphp
    <div class="row">
        <img width=" auto" height="40" src="{{ asset('images/logo.png') }}" class="rounded float-left">
    </div>
    <header class="mb-3">
        <h1 class="text-bold text-center text-capitalize">{{ $title }}</h1>
        <div class="row mt-3 d-flex justify-content-center">
            <table class="float-left mx-2">
                <tr>
                    <th>Diekspor berdasarkan</th>
                    <th>:</th>
                    <td> {{ $typeExport }}</td>
                </tr>
                @if ($awal && $akhir)
                    <tr>
                        <th>Periode</th>
                        <th>:</th>
                        <td> {{ Carbon::parse($awal)->format('d-m-Y') }} - {{ Carbon::parse($akhir)->format('d-m-Y') }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>Tanggal Ekspor</th>
                    <th>:</th>
                    <td> {{ date('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Total Item</th>
                    <th>:</th>
                    <td>{{ formatAngka($totalItemProduk) }}</td>
                </tr>
            </table>
        </div>
    </header>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Minimal Stok</th>
                        <th>Stok Saat Ini</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_produk }}</td>
                            <td>{{ $item->category->kategori }}</td>
                            <td>{{ formatAngka($item->minimal_stok) }} {{ $item->satuan }}</td>
                            <td>{{ formatAngka($item->stok) }} {{ $item->satuan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
