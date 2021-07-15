@extends('admin.laporan.pdf.layouts')

@section('content-pdf')
<header class="lv-bg">
  <h1 class="site-title">Laporan Barang Masuk</h1>
</header>
<table class="periode col-md-6">
  <thead>
    <tr>
      <th>Periode</th>
      <th>:</th>
      <th>{{ tanggal($awal) }} - {{ tanggal($akhir) }}</th>
    </tr>
    <tr>
      <th>Tanggal Ekspor Data</th>
      <th>:</th>
      <th>{{ $now }}</th>
    </tr>
    <tr>
      <th>Pembuat</th>
      <th>:</th>
      <th>Ardi</th>
    </tr>
  </thead>
  <table class="periode col-md-6">
    <thead>
      <tr>
        <th>Total Item Produk</th>
        <th>:</th>
        <th>{{ $totalItemProduk }}</th>
      </tr>
      <tr>
        <th>Total Produk Masuk</th>
        <th>:</th>
        <th>{{ $totalProdukMasuk }}</th>
      </tr>
      <tr>
        <th>Pembuat</th>
        <th>:</th>
        <th>Ardi</th>
      </tr>
    </thead>
</table>
<hr class="black">
<div class="container-fluid inner">
  <table class="tableizer-table">
    <thead>
      <tr class="tableizer-firstrow">
        <th class="red">No</th>
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
              <td class="no">{{ $loop->iteration }}</td>
              <td>{{ $in->product->nama_produk }}</td>
              <td>{{ $in->product->category->kategori }}</td>
              <td>{{ tanggal($in->tanggal ) }}</td>
              <td>{{ $in->penerima }}</td>
              <td>{{ $in->pemberi }}</td>
              <td class="jumlah">{{ $in->jumlah }} {{ $in->product->satuan }}</td>
            </tr>
        @endforeach
      </tbody>
  </table>
@endsection