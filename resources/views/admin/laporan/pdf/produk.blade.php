@extends('admin.laporan.pdf.layouts')

@section('content-pdf')
    @php
    use Carbon\Carbon;
    @endphp
    <header class="mb-3">
        <h1 class="text-bold text-center">{{ $title }}</h1>
        <div class="row mt-2 d-flex justify-content-center">
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
                    <th>Total Item</th>
                    <th>:</th>
                    <td> {{ $totalItemProduk }}</td>
                </tr>
            </table>
            <table class="float-right mx-2">
                <tr>
                    <th>Tanggal</th>
                    <th>:</th>
                    <td> {{ tanggal(date('Y-m-d')) }}</td>
                </tr>
                {{-- <tr>
                    <th>Status</th>
                    <th>:</th>
                    <td class="text-capitalize"> {{ $pb->status_confirm_barang_keluar }} diterima</td>
                </tr>
                <tr>
                    <th>Total Item</th>
                    <th>:</th>
                    <td> {{ formatAngka($pb->total_item) }}</td>
                </tr> --}}
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
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_produk }}</td>
                            <td>{{ $item->category->kategori }}</td>
                            <td>{{ formatAngka($item->minimal_stok) }}</td>
                            <td>{{ formatAngka($item->stok) }} {{ $item->satuan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
