@extends('layouts.admin.master')
@section('title')
    {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('admin/js/plugin/file-input/css/fileinput.min.css') }}">
<link href="{{ asset('admin/js/plugin/date-time-pickers/css/flatpicker-airbnb.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('admin/js/plugin/selectpicker/css/bootstrap-select.min.css') }}">
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
                      <a href="#">Laporan Data Barang Masuk</a>
                  </li>
              </ul>
          </div>
          <div class="row">
              <div class="col-md-12">
                <div class="card shadow animate__animated animate__bounceInRight">
                  <form target="_blank" action="{{ route('laporan.produk.pdf') }}" method="post">
                    <select title="Pilih menu" data-live-search="true" name="opsi" class="selectpicker form-control kategori opsi">
                      <option value="all">Semua Produk</option>
                      <option value="byDate">Rentang Waktu</option>
                    </select>
                    <select title="Pilih kategori" data-live-search="true" name="kategori" class="selectpicker form-control kategori">
                      <option value="all">Semua Produk</option>
                      <option value="byDate">Rentang Waktu</option>
                      @foreach ($daftar_kategori as $kategori)
                          <option value="{{ $kategori->id }}">{{ $kategori->kategori }}
                          </option>
                      @endforeach
                    </select>
                    <div class="row my-4 byDate d-none">
                      <div class="col-md-5">
                        <input type="text" placeholder="Tanggal Awal" name="awal" class="max-date kategori form-control">
                      </div>
                      <div class="col-md-5">
                        <input type="text" placeholder="Tanggal Akhir" name="akhir" class="max-date kategori form-control">
                      </div>
                    </div>
                    <div class="justify-content-center d-none ekspor row my-2 animate__animated animate__bounceInUp">
                      <button type="submit" data-toggle="tooltip" data-placement="top"
                      title="Download file" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Ekpor
                      </button>
                    </div>
                  </form>
                </div>
                  <div class="d-none card shadow animate__animated animate__bounceInRight">
                      <div class="card-body">
                        <form target="_blank" action="{{ route('laporan.produk.pdf') }}" method="post">
                          <div class="row my-4">
                            <div class="col-md-4">
                              <input type="text" placeholder="Tanggal Awal" name="awal" class="max-date form-control">
                            </div>
                            <div class="col-md-4">
                              <input type="text" placeholder="Tanggal Akhir" name="akhir" class="max-date form-control">
                            </div>
                            <div class="col-md-4">
                              <button type="submit" data-toggle="tooltip" data-placement="top"
                              title="Download file" class="btn btn-danger">
                                <i class="fas fa-file-pdf"></i> Ekpor
                              </button>
                            </div>
                          </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection

@push('js')

<script src="{{ asset('admin/js/plugin/selectpicker/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/date-time-pickers/js/flatpickr.js') }}"></script>
<script src="{{ asset('admin/js/plugin/date-time-pickers/js/date-time-picker-script.js') }}"></script>

<script>
  $(document).ready(function(){
    $('form').on('change','.kategori', function(e){
      e.preventDefault();
      $('.ekspor').removeClass('d-none');
      if($('.opsi [name=opsi]').val() == 'byDate'){        
        $('.byDate').removeClass('d-none');
      }else{
        ($('.opsi [name=opsi]').val() == 'all')      
        $('.byDate').addClass('d-none');
      }
    });
  });
</script>
@endpush
