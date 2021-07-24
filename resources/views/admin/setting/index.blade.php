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
          <a href="">Pengaturan</a>
        </li>
        <li class="separator">
          <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
        </li>
      </ul>
    </div>

    <div class="card card-post card-round">
      <div class="card-body">
        <form class="form-setting" enctype="multipart/form-data" action="{{ route('setting.update') }}" method="post">
          @csrf
          <div class="row my-3">
            <div class="col-md-3">
              <label>Nama Aplikasi</label>
            </div>
            <div class="col-md-9 form-group">
              <input type="text" name="nama_aplikasi" class="form-control nama_aplikasi">
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-3">
              <label>Nomor Telepon</label>
            </div>
            <div class="col-md-9 form-group">
              <input type="text" name="telepon" class="telepon form-control">
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-3">
              <label>Logo</label>
            </div>
            <div class="col-md-9 form-group">
              <input type="file" onchange="preview('.show-logo', this.files[0])" class="form-control-file" name="logo">
              <br>
              <div class="show-logo"></div>
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-3">
              <label>Alamat</label>
            </div>
            <div class="col-md-9 form-group">
              <textarea rows="5" name="alamat" class="form-control alamat"></textarea>
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-3">
              <label>Deskripsi Aplikasi</label>
            </div>
            <div class="col-md-9 form-group">
              <textarea rows="5" name="deskripsi" class="form-control deskripsi"></textarea>
            </div>
          </div>
          <div class="row my-3 d-flex justify-content-center">
            <button type="submit" class="btn btn-success btn-update">Ubah</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection

@push('js')
<script>
  $(function(){
    showData();
    $('form').on('click','.btn-update', function (e) {
      e.preventDefault();
      let form  = $('.card-body .form-setting');
      form.find('.invalid-feedback').remove();
      form.find('.form-control').removeClass('is-invalid');

      $.ajax({
        url   : $('.form-setting').attr('action'),
        type  : $('.form-setting').attr('method'),
        data  : new FormData($('.form-setting')[0]),
        async : false,
        processData: false,
        contentType : false,
      })
      .done(response => {
        showData();
        alert_success('success', response.text);

      })
      .fail(errors => {
        if(errors.status == 422){
          loopErrors(errors.responseJSON.errors);
        }else{
        alert_error('error', 'Gagal ubah pengaturan');
        return;
      }
      });

    })
  });

  function showData() {
    $.get(`{{ route('setting.index') }}`)
    .done(response => {
      $('[name=nama_aplikasi]').val(response.nama_aplikasi);
      $('[name=telepon]').val(response.telepon);
      $('[name=alamat]').val(response.alamat);
      $('[name=deskripsi]').val(response.deskripsi);

      $('.show-logo').html(`<img src="{{ asset('/storage/setting') }}/${response.logo}" class="" width="200"/>`);
      $('[rel=icon]').attr(`href`, `{{ asset('/storage/setting') }}/${response.logo}`);
      $('[rel=icon]').attr(`href`, `{{ asset('/storage/setting') }}/${response.logo}`);
      $('title').text(response.nama_aplikasi + ' | Pengaturan');
    })
    .fail(errors => {
      alert_error('error', message.errors.message);
      return;
    })
  }
</script>
@endpush