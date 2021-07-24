@extends('admin.laporan.pdf.layouts')

@section('content-pdf')
{{-- <div class="container-fluid bg-white">
    <header>
      <div class="row d-flex justify-content-center">
        <div class="col-md-12">
          <img height="100px" src="{{ asset('images/default/avatar-1.png') }}"
class="rounded mx-auto d-block float-right">
<h1 class="text-bold text-center">Laporan Stok Barang</h1>
<table>
  <tr>
    <th>Tanggal Ekspor Data</th>
    <th>:</th>
    <td> {{ $now }}</td>
  </tr>
  <tr>
    <th>Tipe Ekspor</th>
    <th>:</th>
    <td> {{ $typeExport }}</td>
  </tr>
  <tr>
    <th>Pembuat</th>
    <th>:</th>
    <td> {{ auth()->user()->name }}</td>
  </tr>
  <tr>
    <th>Total Item Produk</th>
    <th>:</th>
    <td> {{ number_format($totalItemProduk,0,',','.') }} Item</td>
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
          <th>Stok</th>
          <th>Minimal Stok</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $in)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $in->nama_produk }}</td>
          <td>{{ $in->category->kategori }}</td>
          <td>{{ $in->created_at->format('d F Y') }}</td>
          <td @if ($in->stok <= $in->minimal_stok) class="text-danger" @endif>
              {{ $in->stok }} {{ $in->satuan }}
          </td>
          <td>{{ $in->minimal_stok }} {{ $in->satuan }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
</div> --}}


<div class="invoice-box">
  <table cellpadding="0" cellspacing="0">
    <tr class="top">
      <td colspan="2">
        <table>
          <tr>
            <td class="title">
              INVOICE LOGO
            </td>

            <td>
              Invoice #: 123<br>
              Created: January 1, 2015<br>
              Due: February 1, 2015
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <tr class="information">
      <td colspan="2">
        <table>
          <tr>
            <td>
              Sparksuite, Inc.<br>
              12345 Sunny Road<br>
              Sunnyville, CA 12345
            </td>

            <td>
              Acme Corp.<br>
              John Doe<br>
              john@example.com
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <tr class="heading">
      <td>
        Payment Method
      </td>

      <td>
        Check #
      </td>
    </tr>

    <tr class="details">
      <td>
        Check
      </td>

      <td>
        1000
      </td>
    </tr>

    <tr class="heading">
      <td>
        Item
      </td>

      <td>
        Price
      </td>
    </tr>

    <tr class="item">
      <td>
        Website design
      </td>

      <td>
        $300.00
      </td>
    </tr>

    <tr class="item">
      <td>
        Hosting (3 months)
      </td>

      <td>
        $75.00
      </td>
    </tr>

    <tr class="item last">
      <td>
        Domain name (1 year)
      </td>

      <td>
        $10.00
      </td>
    </tr>

    <tr class="total">
      <td></td>

      <td>
        Total: $385.00
      </td>
    </tr>
  </table>
</div>

@endsection