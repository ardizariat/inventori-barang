@extends('admin.laporan.pdf.layouts')

@section('content-pdf')
<h1>Laporan Barang Masuk</h1>

<div class="table100 ver1 m-b-110">
  <table data-vertable="ver1">
    <thead>
      <tr class="row100 head">
        <th class="column100 column1" data-column="column1">No</th>
        <th class="column100 column2" data-column="column2">Nama Produk</th>
        <th class="column100 column3" data-column="column3">Kategori</th>
        <th class="column100 column4" data-column="column4">Tanggal</th>
        <th class="column100 column5" data-column="column5">Jumlah</th>
      </tr>
    </thead>
      <tbody>
        @foreach ($data as $in)
        <tr class="row100">
              <td class="column100 column1">{{ $loop->iteration }}</td>
              <td class="column100 column2">{{ $in->product->nama_produk }}</td>
              <td class="column100 column3">{{ $in->product->category->kategori }}</td>
              <td class="column100 column4">{{ tanggal($in->tanggaln ) }}</td>
              <td class="column100 column5">{{ $in->jumlah }}</td>
            </tr>
        @endforeach
      </tbody>
  </table>
</div>
@endsection