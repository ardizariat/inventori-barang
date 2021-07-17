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
                        <p class="text-capitalize">{{ $data->nama_produk }}</p>
                    </li>
                </ul>
            </div>

            {{-- Table detail produk --}}
            <div class="card shadow animate__animated animate__zoomInDown">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ $data->getGambar() }}" class=" mb-4 gambar d-block w-100">
                            <div class="row justify-content-center">
                                {!! $qrcode !!}
                                <p class="mt-2">Scan QR Code untuk melihat kode produk</p>
                            </div>
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
                                        <td>{!! $data->kode !!}</td>
                                    </tr>
                                    <tr>
                                        <td align="left">Nama Produk</td>
                                        <td align="left">:</td>
                                        <td>{!! $data->nama_produk !!}</td>
                                    </tr>
                                    <tr>
                                        <td align="left">Kategori Produk</td>
                                        <td align="left">:</td>
                                        <td>{!! $data->category->kategori !!}</td>
                                    </tr>
                                    <tr>
                                        <td align="left">Merek</td>
                                        <td align="left">:</td>
                                        <td>{!! $data->merek !!}</td>
                                    </tr>
                                    <tr>
                                        <td align="left">Minimal Stok</td>
                                        <td align="left">:</td>
                                        <td>{!! $data->minimal_stok !!} {!! $data->satuan !!}</td>
                                    </tr>
                                    <tr class="{{ $data->stok < $data->minimal_stok ? 'bg-danger' : '' }}">
                                        <td align="left">Stok Tersedia</td>
                                        <td align="left">:</td>
                                        <td>{!! $data->stok !!} {!! $data->satuan !!}</td>
                                    </tr>
                                    <tr>
                                        <td align="left">Letak Barang</td>
                                        <td align="left">:</td>
                                        <td>{!! $data->warehouse->nama !!}</td>
                                    </tr>
                                    <tr>
                                        <td align="left">Keterangan</td>
                                        <td align="left">:</td>
                                        <td>{!! $data->keterangan !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                  <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                      <div class="btn-group">
                        <button class="btn btn-success btn-barang-masuk" id="btn-barang-masuk">
                          <i class="fas fa-history"></i> Lihat Riwayat Barang Masuk
                        </button>
                        <button class="btn btn-danger btn-barang-keluar">
                          <i class="fas fa-history"></i> Lihat Riwayat Barang Keluar
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>

            {{-- Table barang masuk --}}
            <div class="card shadow animate__animated animate__zoomInUp">
              <div class="card-header">
                <h2>Riwayat Barang Masuk</h2>
              </div>
              <div class="card-body">
                <div class="row my-4">
                  <div class="col-md-12">
                    <table id="show_barangmasuk-table" class="table table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Penerima Barang</th>
                          <th>Pemberi Barang</th>
                          <th>Qty</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="{{ asset('admin/js/plugin/zoom/medium-zoom.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
<script>
    mediumZoom('.gambar', {
        margin: 50,
        scrollOffset: 200
    });
</script>
<script>
  load_data_barang_masuk();

  // Function datatables barang masuk
  function load_data_barang_masuk(){
    $('#show_barangmasuk-table').DataTable({
      serverSide  : true,
      processing  : true,
      url         : "{{ route('produk.show') }}",
      columns : [
        {data : "DT_RowIndex",name : "DT_RowIndex"},
        {data : "tanggal",name : "tanggal"},
        {data : "penerima",name : "penerima"},
        {data : "pemberi",name : "pemberi"},
        {data : "jumlah",name : "jumlah"}
      ], 
      pageLength : 10,
      "lengthMenu": [ 10, 25, 50, 75, 100 ],
      "language": {
        "emptyTable": "Data tidak ada"
      },
    });
  }


  $('#btn-barang-masuk').on('click', function(e){
    e.preventDefault();
    alert('ok')
  })
</script>
@endpush
